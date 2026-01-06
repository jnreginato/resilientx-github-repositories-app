<?php

declare(strict_types=1);

namespace App\Exceptions;

/**
 * Represents an exception that is thrown when the GitHub search limit is exceeded.
 *
 * The GitHub API imposes an exhibition limit of the 1000 first search results.
 * Any attempt to retrieve more results will result in this exception being thrown.
 */
final class GitHubSearchLimitException extends GitHubApiException
{
}
