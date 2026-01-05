<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SearchRepositoryRequest;
use App\Http\Resources\RepositoryDetailResource;
use App\Http\Resources\RepositoryResource;
use App\Services\GitHubService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

final class RepositoryController extends Controller
{
    public function __construct(
        private readonly GitHubService $gitHubService
    ) {}

    public function index(SearchRepositoryRequest $request): AnonymousResourceCollection
    {
        $result = $this->gitHubService->searchRepositories(
            query: $request->validated('query'),
            page: $request->validated('page', 1),
        );

        return RepositoryResource::collection($result);
    }

    public function show(string $owner, string $repo): JsonResponse
    {
        $repository = $this->gitHubService->getRepository($owner, $repo);

        return response()->json(
            new RepositoryDetailResource($repository)
        );
    }
}
