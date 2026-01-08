<?php

/**
 * Example usage of VN Number to Words package
 * 
 * Run: php example.php
 */

require_once __DIR__ . '/src/NumberToWords.php';

use NhatMinh\VnNumberToWords\NumberToWords;

echo "=== VN Number to Words - Examples ===\n\n";

// Test cases
$testCases = [
    0,
    1,
    5,
    10,
    11,
    15,
    21,
    24,
    25,
    100,
    105,
    110,
    111,
    121,
    999,
    1000,
    1001,
    1010,
    1100,
    1234,
    10000,
    100000,
    1000000,
    1234567,
    1000000000,
    1234567890,
    -100,
    -1234,
    123.45,
    1000.99,
];

echo "📌 Basic Conversion:\n";
echo str_repeat("-", 80) . "\n";
printf("%-20s | %s\n", "Number", "Vietnamese");
echo str_repeat("-", 80) . "\n";

foreach ($testCases as $number) {
    $result = NumberToWords::convert($number);
    printf("%-20s | %s\n", $number, $result);
}

echo "\n\n📌 Currency Format:\n";
echo str_repeat("-", 80) . "\n";

$currencyTests = [
    1500000,
    2500000,
    10000000,
    123456789,
];

foreach ($currencyTests as $amount) {
    $result = NumberToWords::convertWithCurrency($amount);
    printf("%s => %s\n", number_format($amount), $result);
}

echo "\n✅ All examples completed!\n";
