<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Validates and authorizes a user request to search repositories.
 *
 * This class extends the FormRequest class and provides
 * validation rules and authorization logic for handling
 * search repository requests.
 */
final class SearchRepositoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<string>>
     */
    public function rules(): array
    {
        return [
            'query' => ['required', 'string', 'min:2'],
            'page' => ['nullable', 'integer', 'min:1'],
        ];
    }
}
