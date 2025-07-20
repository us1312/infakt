<?php

namespace SCA\InFakt\Model;

use SCA\InFakt\Util\ModelUtil;
use SCA\InFakt\Util\ValidatorModel;

class OssInvoiceModel
{
    public ?int $id = null;
    public ?string $number = null;
    public string $country;
    public ?string $clientEmail = null;
    public string $clientFirstName;
    public string $clientLastName;
    public ?string $clientStreet = null;
    public ?string $clientFlatNumber = null;
    public ?string $clientPostCode = null;
    public ?string $clientCity = null;
    public ?string $serviceDate = null;
    public ?string $issueDate = null;
    public ?string $paymentDate = null;
    public ?int $advancePrice = null;
    public ?string $serviceType;
    public string $saleType;
    public string $servicePlacePrimary;
    public ?string $servicePlaceSecondary = null;
    public string $currency;
    public ?string $recipientSignature = null;
    public ?string $sellerSignature = null;
    public ?string $notes = null;
    public ?int $netPrice = null;
    public ?int $taxPrice = null;
    public ?int $grossPrice = null;
    public ?bool $checkDuplicateNumber = null;
    public array $services = [];

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

    public function getClientCity(): ?string {
        return $this->clientCity;
    }

    public function setClientCity(?string $clientCity): void {
        $this->clientCity = $clientCity;
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
        $this->services[] = $services;
    }


    public function getAll($object): array {
        return ModelUtil::getAll($object);
    }

    public function validateRequiredFields(): bool|array {
    }

    public function validate(): array
    {
        return ValidatorModel::validateModel($this);
    }

    public function validateAndThrow(): bool|array
    {
        $errors = $this->validate();
        if (!empty($errors)) {
            throw new \SCA\InFakt\Exception\ValidationException($errors);
        }
        return ValidatorModel::validateRequiredFields($this);
    }
}