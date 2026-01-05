<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * Represents an exception that is thrown when the GitHub API rate limit is exceeded.
 * This exception indicates that the client has made too many requests to the API
 * within a given time frame, as governed by GitHub's rate limiting policies.
 *
 * Extends the base GitHubApiException to differentiate rate-limiting errors
 * from other types of API-related exceptions.
 */
final class GitHubRateLimitException extends GitHubApiException
{
}
