<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

final class GitHubService
{
    private string $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.github.base_url');
    }

    /**
     * @return array<string, mixed>
     *
     * @throws RequestException
     * @throws ConnectionException
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
     * @return array<string, mixed>
     *
     * @throws RequestException
     * @throws ConnectionException
     */
    public function getRepository(string $owner, string $repo): array
    {
        return Http::acceptJson()
            ->get("$this->baseUrl/repos/$owner/$repo")
            ->throw()
            ->json();
    }
}
