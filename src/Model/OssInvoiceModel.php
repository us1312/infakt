<?php

namespace SCA\InFakt\Model;

use SCA\InFakt\Util\ValidatorModel;

class OssInvoiceModel
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
    private string $serviceType;
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

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getNumber(): string {
        return $this->number;
    }

    public function setNumber(string $number): void {
        $this->number = $number;
    }

    public function getCountry(): string {
        return $this->country;
    }

    public function setCountry(string $country): void {
        $this->country = $country;
    }

    public function getClientEmail(): string {
        return $this->clientEmail;
    }

    public function setClientEmail(string $clientEmail): void {
        $this->clientEmail = $clientEmail;
    }

    public function getClientFirstName(): string {
        return $this->clientFirstName;
    }

    public function setClientFirstName(string $clientFirstName): void {
        $this->clientFirstName = $clientFirstName;
    }

    public function getClientLastName(): string {
        return $this->clientLastName;
    }

    public function setClientLastName(string $clientLastName): void {
        $this->clientLastName = $clientLastName;
    }

    public function getClientStreet(): string {
        return $this->clientStreet;
    }

    public function setClientStreet(string $clientStreet): void {
        $this->clientStreet = $clientStreet;
    }

    public function getClientFlatNumber(): string {
        return $this->clientFlatNumber;
    }

    public function setClientFlatNumber(string $clientFlatNumber): void {
        $this->clientFlatNumber = $clientFlatNumber;
    }

    public function getClientPostCode(): string {
        return $this->clientPostCode;
    }

    public function setClientPostCode(string $clientPostCode): void {
        $this->clientPostCode = $clientPostCode;
    }

    public function getServiceDate(): string {
        return $this->serviceDate;
    }

    public function setServiceDate(string $serviceDate): void {
        $this->serviceDate = $serviceDate;
    }

    public function getIssueDate(): string {
        return $this->issueDate;
    }

    public function setIssueDate(string $issueDate): void {
        $this->issueDate = $issueDate;
    }

    public function getPaymentDate(): string {
        return $this->paymentDate;
    }

    public function setPaymentDate(string $paymentDate): void {
        $this->paymentDate = $paymentDate;
    }

    public function getAdvancePrice(): int {
        return $this->advancePrice;
    }

    public function setAdvancePrice(int $advancePrice): void {
        $this->advancePrice = $advancePrice;
    }

    public function getServiceType(): string {
        return $this->serviceType;
    }

    public function setServiceType(string $serviceType): void {
        $this->serviceType = $serviceType;
    }

    public function getSaleType(): string {
        return $this->saleType;
    }

    public function setSaleType(string $saleType): void {
        $this->saleType = $saleType;
    }

    public function getServicePlacePrimary(): string {
        return $this->servicePlacePrimary;
    }

    public function setServicePlacePrimary(string $servicePlacePrimary): void {
        $this->servicePlacePrimary = $servicePlacePrimary;
    }

    public function getServicePlaceSecondary(): string {
        return $this->servicePlaceSecondary;
    }

    public function setServicePlaceSecondary(string $servicePlaceSecondary): void {
        $this->servicePlaceSecondary = $servicePlaceSecondary;
    }

    public function getCurrency(): string {
        return $this->currency;
    }

    public function setCurrency(string $currency): void {
        $this->currency = $currency;
    }

    public function getRecipientSignature(): string {
        return $this->recipientSignature;
    }

    public function setRecipientSignature(string $recipientSignature): void {
        $this->recipientSignature = $recipientSignature;
    }

    public function getSellerSignature(): string {
        return $this->sellerSignature;
    }

    public function setSellerSignature(string $sellerSignature): void {
        $this->sellerSignature = $sellerSignature;
    }

    public function getNotes(): string {
        return $this->notes;
    }

    public function setNotes(string $notes): void {
        $this->notes = $notes;
    }

    public function getNetPrice(): int {
        return $this->netPrice;
    }

    public function setNetPrice(int $netPrice): void {
        $this->netPrice = $netPrice;
    }

    public function getTaxPrice(): int {
        return $this->taxPrice;
    }

    public function setTaxPrice(int $taxPrice): void {
        $this->taxPrice = $taxPrice;
    }

    public function getGrossPrice(): int {
        return $this->grossPrice;
    }

    public function setGrossPrice(int $grossPrice): void {
        $this->grossPrice = $grossPrice;
    }

    public function isCheckDuplicateNumber(): bool {
        return $this->checkDuplicateNumber;
    }

    public function setCheckDuplicateNumber(bool $checkDuplicateNumber): void {
        $this->checkDuplicateNumber = $checkDuplicateNumber;
    }

    public function getServices(): array {
        return $this->services;
    }

    public function setServices(array $services): void {
        $this->services = $services;
    }


    public function getAll(): array {
        return array_filter(
            [
                'id' => $this->id,
                'number' => $this->number,
                'country' => $this->country,
                'client_email' => $this->clientEmail,
                'client_first_name' => $this->clientFirstName,
                'client_last_name' => $this->clientLastName,
                'client_street' => $this->clientStreet,
                'client_flat_number' => $this->clientFlatNumber,
                'client_post_code' => $this->clientPostCode,
                'service_date' => $this->serviceDate,
                'issue_date' => $this->issueDate,
                'payment_date' => $this->paymentDate,
                'advance_price' => $this->advancePrice,
                'service_type' => $this->serviceType,
                'sale_type' => $this->saleType,
                'service_place_primary' => $this->servicePlacePrimary,
                'service_place_secondary' => $this->servicePlaceSecondary,
                'currency' => $this->currency,
                'recipient_signature' => $this->recipientSignature,
                'seller_signature' => $this->sellerSignature,
                'notes' => $this->notes,
                'net_price' => $this->netPrice,
                'tax_price' => $this->taxPrice,
                'gross_price' => $this->grossPrice,
                'check_duplicate_number' => $this->checkDuplicateNumber,
                'services' => $this->services,
            ],
            fn($value) => $value !== null && $value !== '' && $value !== false
        );
    }

    public function validateRequiredFields(): bool|array {
        return ValidatorModel::validateRequiredFields($this);
    }
}