<?php

namespace Neat\Console\Exception;

use Neat\Console\ExitException;
use Throwable;

class CommandNotFoundException extends ExitException
{
    public function __construct(string $command, Throwable $previous = null)
    {
        parent::__construct("Command '{$command}' doesn't exist!", 1, $previous);
    }
}
