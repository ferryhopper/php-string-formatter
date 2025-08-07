<?php

namespace StringFormatter;

final class StringFormatter
{
    public static function apply(string $value, string $formatting): string
    {
        try {
            $pipeline = array_map('trim', \explode(';', $formatting));
            foreach ($pipeline as $formatStep) {
                $parts        = array_map('trim', \explode(':', $formatStep));
                $functionName = \array_shift($parts);
                $functionArgs = $parts;

                switch ($functionName) {
                    case 'padLeft':
                        $value = self::padLeft(...$functionArgs);
                        break;
                    case 'padRight':
                        $value = self::padRight(...$functionArgs);
                        break;
                    case 'replace':
                        $value = self::replace(...$functionArgs);
                        break;
                    case 'remove':
                        $value = self::remove(...$functionArgs);
                        break;
                    case 'insertAfterFirst':
                        $value = self::insertAfterFirst(...$functionArgs);
                        break;
                    case 'padAfterFirst':
                        $value = self::padAfterFirst(...$functionArgs);
                        break;
                }
            }

            return $value;
        } catch (\Throwable $e) {
            return $value;
        }
    }

    public static function padLeft(string $input, int $length, string $padChar = '0'): string
    {
        return \str_pad($input, $length, $padChar, STR_PAD_LEFT);
    }

    public static function padRight(string $input, int $length, string $padChar = '0'): string
    {
        return \str_pad($input, $length, $padChar, STR_PAD_RIGHT);
    }

    public static function replace(string $input, string $search, string $replace): string
    {
        if ($search === 'space') {
            $search = ' ';
        }
        if ($replace === 'space') {
            $replace = ' ';
        }

        return \str_replace($search, $replace, $input);
    }

    public static function remove(string $input, string $toRemove): string
    {
        if ($toRemove === 'space') {
            $toRemove = ' ';
        }

        return \str_replace($toRemove, '', $input);
    }

    public static function insertAfterFirst(string $input, string $char, int $times): string
    {
        if ($input === '') {
            return $input;
        }

        return $input[0] . \str_repeat($char, $times) . \substr($input, 1);
    }

    public static function padAfterFirst(string $input, int $length, string $char): string
    {
        if (empty($input)) {
            return $input;
        }

        return $input[0] . self::padLeft(\substr($input, 1), $length, $char);
    }
}