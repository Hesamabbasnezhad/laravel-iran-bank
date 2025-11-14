<?php

namespace App\Services;

class BankAccountValidator
{
    public static function validateCardNumber(string $cardNumber): bool
    {
        $sanitized = preg_replace('/\D/', '', $cardNumber);
        if (!preg_match('/^\d{13,19}$/', $sanitized)) return false;

        $sum = 0;
        $len = strlen($sanitized);

        for ($i = 0; $i < $len; $i++) {
            $digit = (int) $sanitized[$len - 1 - $i];
            if ($i % 2 === 1) {
                $digit *= 2;
                if ($digit > 9) $digit -= 9;
            }
            $sum += $digit;
        }

        return $sum % 10 === 0;
    }

    public static function validateAccountNumber(string $accountNumber): bool
    {
        return preg_match('/^\d{8,18}$/', $accountNumber);
    }

    public static function validateIBAN(string $iban): bool
    {
        $iban = strtoupper(str_replace(' ', '', $iban));
        if (!preg_match('/^IR\d{24}$/', $iban)) return false;

        $rearranged = substr($iban, 4) . substr($iban, 0, 4);
        $numeric = '';
        foreach (str_split($rearranged) as $c) {
            $numeric .= ctype_alpha($c) ? (ord($c) - 55) : $c;
        }

        return bcmod($numeric, '97') == 1;
    }

    public static function getBankFromCard(string $cardNumber): ?array
    {
        $cardNo = preg_replace('/\D/', '', $cardNumber);
        $bankCards = config('banks.bank_cards');
        foreach ($bankCards as $bank) {
            if (str_starts_with($cardNo, (string) $bank['card_no'])) return $bank;
        }
        return null;
    }

    public static function getBankFromIBAN(string $iban): ?array
    {
        $code = substr(str_replace(' ', '', $iban), 4, 3);
        $ibanBanks = config('banks.iban_banks');
        return $ibanBanks[$code] ?? null;
    }

    public static function validateIranianSheba(
        string $iban,
        string $cardNumber = null,
        string $accountNumber = null
    ): bool {
        $iban = strtoupper(str_replace(' ', '', $iban));
        if (!self::validateIBAN($iban)) return false;

        $isCardValid = $cardNumber ? self::validateCardNumber($cardNumber) : true;
        $isAccountValid = $accountNumber ? self::validateAccountNumber($accountNumber) : true;

        $matchesAccount = true;
        if ($accountNumber) {
            $bban = substr($iban, 4);
            $matchesAccount = substr($bban, -strlen($accountNumber)) === $accountNumber;
        }

        if ($cardNumber) {
            $cardBank = self::getBankFromCard($cardNumber);
            $ibanBank = self::getBankFromIBAN($iban);
            if ($cardBank && $ibanBank && $cardBank['bank_name'] !== $ibanBank['nickname']) return false;
        }

        return $isCardValid && $isAccountValid && $matchesAccount;
    }
}
