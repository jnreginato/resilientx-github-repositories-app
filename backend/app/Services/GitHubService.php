<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

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
     * @throws RequestException If the request fails due to an HTTP error.
     * @throws ConnectionException If the request fails due to a connection error.
     */
    public function searchRepositories(string $query, int $page = 1): array
    {
        $response = Http::acceptJson()
            ->get("$this->baseUrl/search/repositories", [
                'q' => $query,
                'page' => $page,
            ])
            ->throw();

        return $response->json('items');
    }

    /**
     * Retrieves details of a repository from GitHub.
     *
     * @param string $owner The username or organization name that owns the repository.
     * @param string $repo The name of the repository.
     * @return array<string, mixed> The repository details.
     * @throws RequestException If the request fails due to an HTTP error.
     * @throws ConnectionException If the request fails due to a connection error.
     */
    public function getRepository(string $owner, string $repo): array
    {
        return Http::acceptJson()
            ->get("$this->baseUrl/repos/$owner/$repo")
            ->throw()
            ->json();
    }
}
