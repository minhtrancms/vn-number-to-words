<?php

declare(strict_types=1);

namespace MinhTranCms\VnNumberToWords;

/**
 * Convert numbers to Vietnamese words
 * Chuyển đổi số thành chữ tiếng Việt
 * 
 * @package NhatMinh\VnNumberToWords
 */
class NumberToWords
{
    /**
     * Vietnamese digits
     */
    private const DIGITS = [
        0 => 'không',
        1 => 'một',
        2 => 'hai',
        3 => 'ba',
        4 => 'bốn',
        5 => 'năm',
        6 => 'sáu',
        7 => 'bảy',
        8 => 'tám',
        9 => 'chín',
    ];

    /**
     * Vietnamese unit names for each group of 3 digits
     */
    private const UNITS = [
        0 => '',
        1 => 'nghìn',
        2 => 'triệu',
        3 => 'tỷ',
        4 => 'nghìn tỷ',
        5 => 'triệu tỷ',
    ];

    /**
     * Convert a number to Vietnamese words
     *
     * @param int|float|string $number The number to convert
     * @return string The number in Vietnamese words
     */
    public static function convert(int|float|string $number): string
    {
        // Handle string input
        if (is_string($number)) {
            $number = str_replace([',', ' '], '', $number);
            if (str_contains($number, '.')) {
                $number = (float) $number;
            } else {
                $number = (int) $number;
            }
        }

        // Handle negative numbers
        if ($number < 0) {
            return 'âm ' . self::convert(abs($number));
        }

        // Handle zero
        if ($number == 0) {
            return self::DIGITS[0];
        }

        // Handle decimal numbers
        if (is_float($number)) {
            return self::convertFloat($number);
        }

        return self::convertInteger((int) $number);
    }

    /**
     * Convert a number to Vietnamese words with currency
     *
     * @param int|float|string $number The number to convert
     * @param string $currency The currency unit (default: 'đồng')
     * @return string The number in Vietnamese words with currency
     */
    public static function convertWithCurrency(int|float|string $number, string $currency = 'đồng'): string
    {
        $words = self::convert($number);
        return $words . ' ' . $currency;
    }

    /**
     * Convert an integer to Vietnamese words
     *
     * @param int $number The integer to convert
     * @return string The number in Vietnamese words
     */
    private static function convertInteger(int $number): string
    {
        if ($number == 0) {
            return self::DIGITS[0];
        }

        // Split number into groups of 3 digits from right to left
        $groups = [];
        $temp = $number;
        
        while ($temp > 0) {
            $groups[] = $temp % 1000;
            $temp = intdiv($temp, 1000);
        }

        $result = [];
        $groupCount = count($groups);

        for ($i = $groupCount - 1; $i >= 0; $i--) {
            $group = $groups[$i];
            
            if ($group == 0) {
                continue;
            }

            // Determine if we need to add "không trăm" for groups after the first
            $needsHundredPrefix = false;
            if ($i < $groupCount - 1 && $group < 100 && !empty($result)) {
                $needsHundredPrefix = true;
            }

            $groupWords = self::convertGroup($group, $needsHundredPrefix);
            
            if (!empty($groupWords)) {
                $unit = self::UNITS[$i] ?? '';
                if (!empty($unit)) {
                    $groupWords .= ' ' . $unit;
                }
                $result[] = $groupWords;
            }
        }

        return implode(' ', $result);
    }

    /**
     * Convert a group of up to 3 digits to Vietnamese words
     *
     * @param int $group The group (0-999) to convert
     * @param bool $needsHundredPrefix Whether to add "không trăm" prefix
     * @return string The group in Vietnamese words
     */
    private static function convertGroup(int $group, bool $needsHundredPrefix = false): string
    {
        if ($group == 0) {
            return '';
        }

        $hundreds = intdiv($group, 100);
        $remainder = $group % 100;
        $tens = intdiv($remainder, 10);
        $ones = $remainder % 10;

        $result = [];

        // Hundreds
        if ($hundreds > 0) {
            $result[] = self::DIGITS[$hundreds] . ' trăm';
        } elseif ($needsHundredPrefix) {
            $result[] = 'không trăm';
        }

        // Tens
        if ($tens > 0) {
            if ($tens == 1) {
                $result[] = 'mười';
            } else {
                $result[] = self::DIGITS[$tens] . ' mươi';
            }
        } elseif ($ones > 0 && ($hundreds > 0 || $needsHundredPrefix)) {
            // Add "linh" or "lẻ" when tens is 0 but ones is not, and we have hundreds
            $result[] = 'linh';
        }

        // Ones
        if ($ones > 0) {
            if ($tens == 0) {
                // After "linh" or standalone
                $result[] = self::DIGITS[$ones];
            } elseif ($ones == 1) {
                // After tens: "hai mươi mốt", "mười một"
                if ($tens == 1) {
                    $result[] = 'một';
                } else {
                    $result[] = 'mốt';
                }
            } elseif ($ones == 4) {
                // "tư" instead of "bốn" after tens
                if ($tens >= 2) {
                    $result[] = 'tư';
                } else {
                    $result[] = self::DIGITS[$ones];
                }
            } elseif ($ones == 5) {
                // "lăm" instead of "năm" after tens
                $result[] = 'lăm';
            } else {
                $result[] = self::DIGITS[$ones];
            }
        }

        return implode(' ', $result);
    }

    /**
     * Convert a float to Vietnamese words
     *
     * @param float $number The float to convert
     * @return string The number in Vietnamese words
     */
    private static function convertFloat(float $number): string
    {
        // Split into integer and decimal parts
        $parts = explode('.', (string) $number);
        $integerPart = (int) $parts[0];
        $decimalPart = $parts[1] ?? '';

        $result = self::convertInteger($integerPart);
        
        if (!empty($decimalPart)) {
            $result .= ' phẩy';
            
            // Read each digit of the decimal part
            $decimalDigits = str_split($decimalPart);
            foreach ($decimalDigits as $digit) {
                $result .= ' ' . self::DIGITS[(int) $digit];
            }
        }

        return $result;
    }

    /**
     * Get the digit word for a single digit
     *
     * @param int $digit The digit (0-9)
     * @return string The Vietnamese word for the digit
     */
    public static function getDigit(int $digit): string
    {
        return self::DIGITS[$digit] ?? '';
    }
}
