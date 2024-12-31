<?php

namespace SCA\InFakt\Model;

use SCA\InFakt\Util\ValidatorModel;

class VatInvoiceModel
{
    private ?int $id = null;
    private ?string $number = null;
    private string $country;
    private ?string $clientEmail = null;
    private string $clientFirstName;
    private string $clientLastName;
    private ?string $clientStreet = null;
    private ?string $clientFlatNumber = null;
    private ?string $clientPostCode = null;
    private ?string $serviceDate = null;
    private ?string $issueDate = null;
    private ?string $paymentDate = null;
    private ?int $advancePrice = null;
    private ?string $serviceType;
    private string $saleType;
    private string $servicePlacePrimary;
    private ?string $servicePlaceSecondary = null;
    private string $currency;
    private ?string $recipientSignature = null;
    private ?string $sellerSignature = null;
    private ?string $notes = null;
    private ?int $netPrice = null;
    private ?int $taxPrice = null;
    private ?int $grossPrice = null;
    private ?bool $checkDuplicateNumber = null;
    private array $services = [];


    public function validateRequiredFields(): bool|array {
        return ValidatorModel::validateRequiredFields($this);
    }
}