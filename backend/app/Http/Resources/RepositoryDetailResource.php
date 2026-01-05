<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RepositoryDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this['id'],
            'name'         => $this['name'],
            'full_name'   => $this['full_name'],
            'description' => $this['description'],
            'owner'       => $this['owner']['login'],
            'stars'       => $this['stargazers_count'],
            'forks'       => $this['forks_count'],
            'language'    => $this['language'],
            'html_url'    => $this['html_url'],
            'created_at'  => $this['created_at'],
            'updated_at'  => $this['updated_at'],
        ];
    }
}
