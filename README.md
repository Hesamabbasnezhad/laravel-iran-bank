# BankAccountValidator (Laravel Service)

The **BankAccountValidator** class is a lightweight service for **validating Iranian banking information** in PHP/Laravel projects. It provides methods to validate **card numbers, account numbers, IBANs (Sheba)**, and identify the bank from a card or IBAN.

## Features

- **Card Number Validation:** Supports 13–19 digit cards, uses **Luhn algorithm**.
- **Account Number Validation:** Supports 8–18 digit account numbers.
- **IBAN/Sheba Validation:** Checks Iranian IBAN format (`IRxxxxxxxxxxxxxxxxxxxxxxxx`), uses **BCMOD** for checksum.
- **Bank Identification:** Detects bank from card BIN or IBAN code.
- **Full Iranian Sheba Validation:** Validates IBAN, optional card, optional account, ensures card and IBAN match the same bank.

## Installation

1. Clone the repository:

git clone git@github.com:Hesamabbasnezhad/laravel-iran-bank.git

2. Copy the class into your Laravel project, for example:
   
app/Services/BankAccountValidator.php

3. Configuration
Create a config file config/banks.php in your Laravel project:

<?php

return [

    'bank_cards' => [
        [
            'bank_name' => 'Melli Bank',
            'card_no'  => '603799',
            'nickname' => 'Melli'
        ],
        [
            'bank_name' => 'Tejarat Bank',
            'card_no'  => '627412',
            'nickname' => 'Tejarat'
        ],
        // Add more banks as needed
    ],

    'iban_banks' => [
        '017' => [
            'bank_name' => 'Melli Bank',
            'nickname'  => 'Melli',
        ],
        '004' => [
            'bank_name' => 'Tejarat Bank',
            'nickname'  => 'Tejarat',
        ],
        // Add more banks as needed
    ],

];

Usage : 

use App\Services\BankAccountValidator;

// Validate a card
$isValidCard = BankAccountValidator::validateCardNumber('6037991234567890');

// Validate an IBAN
$isValidIBAN = BankAccountValidator::validateIBAN('IR820540102680020817909002');

// Full validation with optional card and account
$isValid = BankAccountValidator::validateIranianSheba(
    'IR820540102680020817909002',
    '6037991234567890',
    '1234567890'
);

// Get bank info
$bankFromCard = BankAccountValidator::getBankFromCard('6037991234567890');
$bankFromIBAN = BankAccountValidator::getBankFromIBAN('IR820540102680020817909002');

Requirements : 

. PHP >= 7.4

. ext-bcmath enabled (required for IBAN validation)

. Laravel 8/9/10/11
