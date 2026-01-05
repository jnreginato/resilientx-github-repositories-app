<?php

declare(strict_types=1);

namespace App\Exceptions;

use Exception;

/**
 * Represents a base class for exceptions specific to GitHub API interactions.
 * This abstract class is intended to be extended by more specific exceptions
 * related to GitHub API errors.
 */
abstract class GitHubApiException extends Exception
{
}
