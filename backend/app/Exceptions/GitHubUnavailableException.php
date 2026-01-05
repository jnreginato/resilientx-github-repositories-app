<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * Represents an exception thrown when the GitHub API is unavailable.
 * Typically occurs during periods of downtime or connectivity issues.
 */
final class GitHubUnavailableException extends GitHubApiException
{
}
