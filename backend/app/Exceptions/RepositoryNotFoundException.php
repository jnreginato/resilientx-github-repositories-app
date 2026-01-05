<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * Thrown to indicate that a requested repository could not be found.
 *
 * This exception is typically used when interacting with the GitHub API,
 * and a repository matching the provided criteria does not exist or
 * cannot be accessed.
 */
final class RepositoryNotFoundException extends GitHubApiException
{
}
