<?php

declare(strict_types=1);

namespace Tests\Feature\Services;

use App\Exceptions\GitHubRateLimitException;
use App\Exceptions\RepositoryNotFoundException;
use App\Services\GitHubService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use Throwable;

/**
 * Class for testing the GitHubService functionalities.
 *
 * This class contains test cases to verify the behavior of the `GitHubService`
 * when interacting with the GitHub API. It uses Laravel's HTTP mocking
 * capabilities to simulate API responses and test scenarios such as successful
 * responses, repository details, exceptions, and rate limits.
 */
final class GitHubServiceTest extends TestCase
{
    /**
     * Clear the cache before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Cache::clear();
    }

    /**
     * Scenario: Search for repositories.
     *
     * Given: A search query.
     * When: The search query is sent to the GitHub API.
     * Then: The API returns a successful response with a list of repositories.
     * @throws Throwable If an error occurs while making the API request.
     */
    public function testSearchRepositoriesSuccessfully(): void
    {
        Http::fake([
            'api.github.com/search/repositories*' => Http::response([
                'items' => [
                    [
                        'id' => 1,
                        'name' => 'laravel',
                        'full_name' => 'laravel/laravel',
                        'owner' => ['login' => 'laravel'],
                        'stargazers_count' => 100,
                        'language' => 'PHP',
                        'html_url' => 'https://github.com/laravel/laravel',
                    ],
                ],
            ], 200),
        ]);

        $service = app(GitHubService::class);

        $result = $service->searchRepositories('laravel');

        $this->assertCount(1, $result);
        $this->assertEquals('laravel', $result[0]['name']);
    }

    /**
     * Scenario: Fetch repository details.
     *
     * Given: A repository owner and name.
     * When: The repository details are requested from the GitHub API.
     * Then: The API returns a successful response with the repository details.
     * @throws Throwable If an error occurs while making the API request.
     */
    public function testFetchRepositoryDetails(): void
    {
        Http::fake([
            'api.github.com/repos/laravel/laravel' => Http::response([
                'id' => 1,
                'name' => 'laravel',
                'full_name' => 'laravel/laravel',
                'owner' => ['login' => 'laravel'],
                'stargazers_count' => 100,
                'forks_count' => 10,
                'language' => 'PHP',
                'html_url' => 'https://github.com/laravel/laravel',
                'created_at' => '2020-01-01T00:00:00Z',
                'updated_at' => '2026-01-01T00:00:00Z',
            ], 200),
        ]);

        $service = app(GitHubService::class);

        $result = $service->getRepository('laravel', 'laravel');

        $this->assertEquals('laravel/laravel', $result['full_name']);
    }

    /**
     * Scenario: Throw exception when the repository is not found.
     *
     * Given: A repository owner and name.
     * When: The repository details are requested from the GitHub API and the repository is not found.
     * Then: The API returns a 404 response and an exception is thrown.
     * @throws Throwable If an error occurs while making the API request.
     */
    public function testThrowExceptionWhenRepositoryNotFound(): void
    {
        Http::fake(['api.github.com/repos/*' => Http::response([], 404)]);

        $service = app(GitHubService::class);

        $this->expectException(RepositoryNotFoundException::class);

        $service->getRepository('foo', 'bar');
    }

    /**
     * Scenario: Throw exception on rate limit.
     *
     * Given: A search query.
     * When: The search query is sent to the GitHub API and the rate limit is exceeded.
     * Then: The API returns a 403 response and an exception is thrown.
     * @throws Throwable If an error occurs while making the API request.
     */
    public function testThrowExceptionOnRateLimit(): void
    {
        Http::fake([
            'api.github.com/search/repositories*' => Http::response(
                ['message' => 'API rate limit exceeded'],
                403
            ),
        ]);

        $service = app(GitHubService::class);

        $this->expectException(GitHubRateLimitException::class);

        $service->searchRepositories('laravel');
    }
}
