<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SearchRepositoryRequest;
use App\Http\Resources\RepositoryDetailResource;
use App\Http\Resources\RepositoryResource;
use App\Services\GitHubService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Throwable;

/**
 * Controller responsible for handling repository-related operations.
 */
final readonly class RepositoryController
{
    /**
     * Constructor method.
     *
     * @param GitHubService $gitHubService An instance of GitHubService.
     */
    public function __construct(private GitHubService $gitHubService)
    {
    }

    /**
     * Handles the index action for searching repositories.
     *
     * @param SearchRepositoryRequest $request The request instance containing validated search parameters.
     * @return AnonymousResourceCollection A collection of repository resources.
     * @throws Throwable If an error occurs while making the API request.
     */
    public function index(SearchRepositoryRequest $request): AnonymousResourceCollection
    {
        $result = $this->gitHubService->searchRepositories(
            query: $request->validated('query'),
            page: $request->validated('page', 1),
        );

        return RepositoryResource::collection($result);
    }

    /**
     * Retrieves and displays repository details.
     *
     * @param string $owner The username or organization name that owns the repository.
     * @param string $repo The name of the repository.
     * @return JsonResponse A JSON response containing the repository details.
     * @throws Throwable If an error occurs while making the API request.
     */
    public function show(string $owner, string $repo): JsonResponse
    {
        $repository = $this->gitHubService->getRepository($owner, $repo);

        return response()->json(new RepositoryDetailResource($repository));
    }
}
