# laravel-iran-bank
BankAccountValidator (Laravel Service)

The BankAccountValidator class is a lightweight and practical service for validating Iranian banking information in PHP/Laravel projects. It provides a set of methods to validate card numbers, account numbers, IBANs (Sheba), and to identify the bank from a card or IBAN.

Features
✔️ Card Number Validation

Sanitizes input by removing non-digit characters

Supports card numbers from 13 to 19 digits

Uses the Luhn algorithm to verify card validity

✔️ Account Number Validation

Validates account numbers between 8 to 18 digits

Useful for basic checks before integrating with banking services

✔️ IBAN/Sheba Validation

Supports standard IRxxxxxxxxxxxxxxxxxxxxxxxx format

Rearranges the first 4 characters and converts letters to numbers

Uses BCMOD to calculate the IBAN checksum

Requires the PHP extension ext-bcmath

✔️ Bank Identification by Card Number

Retrieves bank information from the config/banks.php file

Detects the bank based on the card BIN (first 6 digits)

✔️ Bank Identification by IBAN

Extracts bank code from the BBAN section of the IBAN

Maps bank code to bank information using configuration

✔️ Full Iranian Sheba Validation (validateIranianSheba)

This method performs a complete validation:

Checks IBAN validity

Checks card number validity if provided

Checks account number validity if provided

Verifies that the account number matches the BBAN portion

Ensures that the card and IBAN belong to the same bank

Configuration

The service relies on a config/banks.php file containing:

bank_cards → bank info based on card numbers

iban_banks → bank info based on IBAN codes

Use Cases

This service is ideal for banking, finance, payment gateways, wallet systems, user bank verification, and more.
