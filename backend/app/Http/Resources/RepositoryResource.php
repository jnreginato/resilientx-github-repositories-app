<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * A resource class that transforms repository data into an array structure.
 */
final class RepositoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this['id'],
            'name' => $this['name'],
            'full_name' => $this['full_name'],
            'owner' => $this['owner']['login'],
            'stars' => $this['stargazers_count'],
            'language' => $this['language'],
            'html_url' => $this['html_url'],
        ];
    }
}
