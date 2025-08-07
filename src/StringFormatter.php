<?php

namespace StringFormatter;

/**
 * Applies a sequence of formatting operations to a string.
 * The formatting string is a semicolon-separated pipeline of formatter calls.
 *
 * Supported functions:
 * - padLeft:<length>:<char>         → Left-pads the entire string to <length> using <char>
 * - padRight:<length>:<char>        → Right-pads the entire string to <length> using <char>
 * - replace:<search>:<replace>      → Replaces all occurrences of <search> with <replace>
 * - remove:<target>                 → Removes all occurrences of <target>
 * - padAfterFirst:<length>:<char>   → Pads the part after the first character to <length> using <char>
 *
 * Special keyword: "space" can be used in replace/remove/insert to represent a literal space character.
 *
 * Example usage:
 *   applyFormatting('K 563793', 'remove:space;replace:K:A;padAfterFirst:11:0') → returns "A00000563793"
 *
 * @param string $inputString The original string to be formatted
 * @param string $formatting  The formatting instructions as a semicolon-separated string
 *
 * @return string The formatted string (or the original input if an error occurs)
 */
final class StringFormatter
{
    private const SPACE_CHAR_INPUT = self::SPACE_CHAR_INPUT;

    public static function apply(string $inputString, string $formatting): string
    {
        try {
            $pipeline = array_map('trim', \explode(';', $formatting));
            foreach ($pipeline as $formatStep) {
                $parts        = array_map('trim', \explode(':', $formatStep));
                $functionName = \array_shift($parts);
                $functionArgs = $parts;

                if ($functionName === 'padAfterFirst') {
                    $inputString = self::padAfterFirst($inputString, ...$functionArgs);
                }

                if ($functionName === 'padLeft') {
                    $inputString = self::padLeft($inputString, ...$functionArgs);
                }

                if ($functionName === 'padRight') {
                    $inputString = self::padRight($inputString, ...$functionArgs);
                }

                if ($functionName === 'replace') {
                    $inputString = self::replace($inputString, ...$functionArgs);
                }

                if ($functionName === 'remove') {
                    $inputString = self::remove($inputString, ...$functionArgs);
                }
            }

            // Eventually trim the output to avoid residual spaces that might be a result of rules implementation
            return \trim($inputString);
        } catch (\Throwable $throwable) {
            return $inputString;
        }
    }

    /**
     * Pads the substring after the first character to a given length.
     * The first character is left untouched.
     * Example: padAfterFirst:5:0 → "K123" becomes "K00123"
     *
     * @param int $length Length of the substring AFTER the first character
     */
    public static function padAfterFirst(string $input, int $length, string $char): string
    {
        if (empty($input)) {
            return $input;
        }

        if ($char === self::SPACE_CHAR_INPUT) {
            $char = ' ';
        }

        return $input[0].self::padLeft(\substr($input, 1), $length, $char);
    }

    /**
     * Pad left of the input string to a specific length with a given character.
     * Example: padLeft:11:0 will make string 12345678 -> 00012345678
     */
    public static function padLeft(string $input, int $length, string $padChar = '0'): string
    {
        if ($padChar === self::SPACE_CHAR_INPUT) {
            $padChar = ' ';
        }

        return \str_pad($input, $length, $padChar, STR_PAD_LEFT);
    }

    /**
     * Pad right of the input string to a specific length with a given character.
     * Example: padRight:11:0 will make string 12345678 -> 12345678000
     */
    public static function padRight(string $input, int $length, string $padChar = '0'): string
    {
        if ($padChar === self::SPACE_CHAR_INPUT) {
            $padChar = ' ';
        }

        return \str_pad($input, $length, $padChar, STR_PAD_RIGHT);
    }

    /**
     * Replace all occurrences of a substring with another string.
     * Example: replace:_:space will make string test_123 -> test 123
     */
    public static function replace(string $input, string $search, string $replace): string
    {
        // Allow "space" keyword for clarity in config
        if ($replace === self::SPACE_CHAR_INPUT) {
            $replace = ' ';
        }

        if ($search === self::SPACE_CHAR_INPUT) {
            $search = ' ';
        }

        return \str_replace($search, $replace, $input);
    }

    /**
     * Remove all occurrences of a substring.
     * Example: remove:_ will make string test_123 -> test123
     */
    public static function remove(string $input, string $toRemove): string
    {
        if ($toRemove === self::SPACE_CHAR_INPUT) {
            $toRemove = ' ';
        }

        return \str_replace($toRemove, '', $input);
    }
}