<?php

namespace SCA\InFakt\Util;

use SCA\InFakt\Exception\ValidationException;

class ValidatorModel
{
    public static function validateRequiredFields(object $object): bool|array
    {
        $reflection = new \ReflectionClass($object);
        $properties = $reflection->getProperties();

        $missingFields = [];

        foreach ($properties as $property) {
            $type = $property->getType();

            if ($type && !$type->allowsNull()) {
                $property->setAccessible(true);

                if (!$property->isInitialized($object)) {
                    $missingFields[] = $property->getName();
                    continue;
                }

                $value = $property->getValue($object);

                if (empty($value)) {
                    $missingFields[] = $property->getName();
                }
            }
        }

        return empty($missingFields) ? true : $missingFields;
    }

    public static function validateAndThrow(object $object): void
    {
        $result = self::validateRequiredFields($object);
        if (is_array($result)) {
            throw new ValidationException($result, 'Missing required fields: ' . implode(', ', $result));
        }
    }

    public static function validateEmail(string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
    }

    public static function validateNip(string $nip): bool
    {
        $nip = preg_replace('/[^0-9]/', '', $nip);
        
        if (strlen($nip) !== 10) {
            return false;
        }

        $weights = [6, 5, 7, 2, 3, 4, 5, 6, 7];
        $sum = 0;

        for ($i = 0; $i < 9; $i++) {
            $sum += $nip[$i] * $weights[$i];
        }

        $checksum = $sum % 11;
        
        if ($checksum === 10) {
            return false;
        }

        return $checksum == $nip[9];
    }

    public static function validatePostalCode(string $postalCode, string $country = 'PL'): bool
    {
        switch (strtoupper($country)) {
            case 'PL':
                return preg_match('/^\d{2}-\d{3}$/', $postalCode);
            case 'DE':
                return preg_match('/^\d{5}$/', $postalCode);
            case 'US':
                return preg_match('/^\d{5}(-\d{4})?$/', $postalCode);
            default:
                return strlen($postalCode) >= 3 && strlen($postalCode) <= 10;
        }
    }

    public static function validateCurrency(string $currency): bool
    {
        $allowedCurrencies = ['PLN', 'EUR', 'USD', 'GBP', 'CHF', 'CZK', 'SEK', 'NOK', 'DKK'];
        return in_array(strtoupper($currency), $allowedCurrencies);
    }

    public static function validateCountryCode(string $countryCode): bool
    {
        $allowedCountries = [
            'PL', 'DE', 'FR', 'IT', 'ES', 'NL', 'BE', 'AT', 'CZ', 'SK', 
            'HU', 'SI', 'HR', 'BG', 'RO', 'LT', 'LV', 'EE', 'FI', 'SE', 
            'DK', 'IE', 'PT', 'GR', 'CY', 'MT', 'LU', 'US', 'GB', 'CH', 'NO'
        ];
        return in_array(strtoupper($countryCode), $allowedCountries);
    }

    public static function validateDate(string $date, string $format = 'Y-m-d'): bool
    {
        $dateTime = \DateTime::createFromFormat($format, $date);
        return $dateTime && $dateTime->format($format) === $date;
    }

    public static function validateModel(object $model): array
    {
        $errors = [];
        $reflection = new \ReflectionClass($model);
        
        // Sprawdź wymagane pola
        $requiredFieldsResult = self::validateRequiredFields($model);
        if (is_array($requiredFieldsResult)) {
            $errors['required_fields'] = $requiredFieldsResult;
        }

        // Sprawdź specyficzne walidacje dla różnych modeli
        $className = $reflection->getShortName();
        
        switch ($className) {
            case 'CustomerModel':
                $errors = array_merge($errors, self::validateCustomerModel($model));
                break;
            case 'VatInvoiceModel':
                $errors = array_merge($errors, self::validateVatInvoiceModel($model));
                break;
            case 'OssInvoiceModel':
                $errors = array_merge($errors, self::validateOssInvoiceModel($model));
                break;
        }

        return $errors;
    }

    private static function validateCustomerModel($model): array
    {
        $errors = [];
        
        if (!empty($model->email) && !self::validateEmail($model->email)) {
            $errors['email'] = 'Invalid email format';
        }
        
        if (!empty($model->nip) && !self::validateNip($model->nip)) {
            $errors['nip'] = 'Invalid NIP format';
        }
        
        if (!empty($model->postalCode) && !self::validatePostalCode($model->postalCode, $model->country ?? 'PL')) {
            $errors['postalCode'] = 'Invalid postal code format';
        }
        
        if (!self::validateCountryCode($model->country)) {
            $errors['country'] = 'Invalid country code';
        }

        return $errors;
    }

    private static function validateVatInvoiceModel($model): array
    {
        $errors = [];
        
        if (!empty($model->currency) && !self::validateCurrency($model->currency)) {
            $errors['currency'] = 'Invalid currency code';
        }
        
        if (!empty($model->invoiceDate) && !self::validateDate($model->invoiceDate)) {
            $errors['invoiceDate'] = 'Invalid invoice date format';
        }
        
        if (!empty($model->saleDate) && !self::validateDate($model->saleDate)) {
            $errors['saleDate'] = 'Invalid sale date format';
        }

        return $errors;
    }

    private static function validateOssInvoiceModel($model): array
    {
        $errors = [];
        
        if (!self::validateCountryCode($model->country)) {
            $errors['country'] = 'Invalid country code';
        }
        
        if (!empty($model->clientEmail) && !self::validateEmail($model->clientEmail)) {
            $errors['clientEmail'] = 'Invalid email format';
        }
        
        if (!empty($model->currency) && !self::validateCurrency($model->currency)) {
            $errors['currency'] = 'Invalid currency code';
        }

        return $errors;
    }
}
