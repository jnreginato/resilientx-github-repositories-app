<?php

declare(strict_types=1);

namespace App\Services;

use App\Exceptions\GitHubRateLimitException;
use App\Exceptions\GitHubSearchLimitException;
use App\Exceptions\GitHubUnavailableException;
use App\Exceptions\RepositoryNotFoundException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Throwable;

use function md5;
use function sprintf;
use function str_contains;
use function strtolower;

/**
 * A service class for interacting with the GitHub API.
 */
final class GitHubService
{
    /**
     * The base URL of the GitHub API.
     */
    private string $baseUrl;

    /**
     * Constructor method.
     */
    public function __construct()
    {
        $this->baseUrl = config('services.github.base_url');
    }

    /**
     * Searches for repositories on GitHub.
     *
     * @param string $query The search query.
     * @param int $page The page number.
     * @return array<string, mixed> The list of repositories.
     * @throws Throwable If an error occurs while making the API request.
     */
    public function searchRepositories(string $query, int $page, int $perPage): array
    {
        $offset = ($page - 1) * $perPage;

        if ($offset >= 1000) {
            throw new GitHubSearchLimitException('Only the first 1000 search results are available.');
        }

        $cacheKey = sprintf('github.search.%s.page.%d.size.%d', md5($query), $page, $perPage);

        return Cache::remember($cacheKey, now()->addSeconds(60), function () use ($query, $page, $perPage) {
            $response = Http::acceptJson()->get(
                "$this->baseUrl/search/repositories",
                [
                    'q' => $query,
                    'page' => $page,
                    'per_page' => $perPage,
                ]
            );

            $this->handleErrors($response);

            $total = min(
                $response->json('total_count', 0),
                1000
            );

            return [
                'items' => $response->json('items'),
                'pagination' => [
                    'count' => count($response->json('items')),
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total_items' => $total,
                    'total_pages' => (int) ceil($total / $perPage),
                ],
            ];
        });
    }

    /**
     * Retrieves details of a repository from GitHub.
     *
     * @param string $owner The username or organization name that owns the repository.
     * @param string $repo The name of the repository.
     * @return array<string, mixed> The repository details.
     * @throws Throwable If an error occurs while making the API request.
     */
    public function getRepository(string $owner, string $repo): array
    {
        $cacheKey = sprintf('github.repo.%s.%s', strtolower($owner), strtolower($repo));

        return Cache::remember($cacheKey, now()->addSeconds(60), function () use ($owner, $repo) {
            $response = Http::acceptJson()->get("$this->baseUrl/repos/$owner/$repo");

            $this->handleErrors($response);

            return $response->json();
        });
    }

    /**
     * Handles errors in the GitHub API response and throws appropriate exceptions.
     *
     * @param Response $response The HTTP response received from the GitHub API.
     * @throws RepositoryNotFoundException If the repository is not found (HTTP 404 status).
     * @throws GitHubRateLimitException If the GitHub API rate limit is exceeded (HTTP 403 status with a rate limit message).
     * @throws GitHubUnavailableException If the GitHub API is unavailable (server error or unexpected failure).
     */
    private function handleErrors(Response $response): void
    {
        if ($response->status() === 404) {
            throw new RepositoryNotFoundException('Repository not found.');
        }

        if ($response->status() === 403 && str_contains(strtolower($response->body()), 'rate limit')) {
            throw new GitHubRateLimitException('GitHub API rate limit exceeded.');
        }

        if ($response->serverError()) {
            throw new GitHubUnavailableException('GitHub API is unavailable.');
        }

        if ($response->failed()) {
            throw new GitHubUnavailableException('Unexpected GitHub API error.');
        }
    }
}
