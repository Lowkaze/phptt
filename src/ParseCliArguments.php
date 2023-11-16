<?php

namespace Lowkaze\PHPtt;

class ParseCliArguments
{
    private array $errors = [];
    private array $aaa = ['data'];
    private array $requiredArguments = ['method', 'url'];
    private array $arguments;

    public function __construct()
    {
        $this->arguments = getopt(
            '',
            array_merge($this->aaa, array_map(fn (string $argument): string => "$argument:", $this->requiredArguments))
        );
    }

    public function __invoke(): array
    {
        array_walk($this->requiredArguments, function (string $argument): void {
            if (!array_key_exists($argument, $this->arguments)) {
                $this->errors[] = $argument;
            }
        });

        if (count($this->errors)) {
            $message =
                'Missing required parameter' . (count($this->errors) > 1 ? 's ' : ' ') . implode(', ', $this->errors) . '.';

            exit($message);
        }

        return $this->arguments;
    }
}
