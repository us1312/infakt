<?php

namespace SCA\InFakt\Model;

class OssInvoiceModel
{
    private ?int $id;
    private string $number;
    private string $issueDate;
    private string $saleDate;
    private string $paymentDate;
    private string $clientName;
    private string $clientTaxNumber;
    private string $clientAddress;
    private string $clientCity;
    private string $clientZipCode;
    private string $clientCountry;
    private array $invoiceEntries;
    private float $totalNetAmount;
    private float $totalTaxAmount;
    private float $totalGrossAmount;
    private string $currency;
    private string $status;
    private array $services;

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

    public function getIssueDate(): string {
        return $this->issueDate;
    }

    public function setIssueDate(string $issueDate): void {
        $this->issueDate = $issueDate;
    }

    public function getSaleDate(): string {
        return $this->saleDate;
    }

    public function setSaleDate(string $saleDate): void {
        $this->saleDate = $saleDate;
    }

    public function getPaymentDate(): string {
        return $this->paymentDate;
    }

    public function setPaymentDate(string $paymentDate): void {
        $this->paymentDate = $paymentDate;
    }

    public function getClientName(): string {
        return $this->clientName;
    }

    public function setClientName(string $clientName): void {
        $this->clientName = $clientName;
    }

    public function getClientTaxNumber(): string {
        return $this->clientTaxNumber;
    }

    public function setClientTaxNumber(string $clientTaxNumber): void {
        $this->clientTaxNumber = $clientTaxNumber;
    }

    public function getClientAddress(): string {
        return $this->clientAddress;
    }

    public function setClientAddress(string $clientAddress): void {
        $this->clientAddress = $clientAddress;
    }

    public function getClientCity(): string {
        return $this->clientCity;
    }

    public function setClientCity(string $clientCity): void {
        $this->clientCity = $clientCity;
    }

    public function getClientZipCode(): string {
        return $this->clientZipCode;
    }

    public function setClientZipCode(string $clientZipCode): void {
        $this->clientZipCode = $clientZipCode;
    }

    public function getClientCountry(): string {
        return $this->clientCountry;
    }

    public function setClientCountry(string $clientCountry): void {
        $this->clientCountry = $clientCountry;
    }

    public function getInvoiceEntries(): array {
        return $this->invoiceEntries;
    }

    public function setInvoiceEntries(array $invoiceEntries): void {
        $this->invoiceEntries = $invoiceEntries;
    }

    public function getTotalNetAmount(): float {
        return $this->totalNetAmount;
    }

    public function setTotalNetAmount(float $totalNetAmount): void {
        $this->totalNetAmount = $totalNetAmount;
    }

    public function getTotalTaxAmount(): float {
        return $this->totalTaxAmount;
    }

    public function setTotalTaxAmount(float $totalTaxAmount): void {
        $this->totalTaxAmount = $totalTaxAmount;
    }

    public function getTotalGrossAmount(): float {
        return $this->totalGrossAmount;
    }

    public function setTotalGrossAmount(float $totalGrossAmount): void {
        $this->totalGrossAmount = $totalGrossAmount;
    }

    public function getCurrency(): string {
        return $this->currency;
    }

    public function setCurrency(string $currency): void {
        $this->currency = $currency;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
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
                'issueDate' => $this->issueDate,
                'saleDate' => $this->saleDate,
                'paymentDate' => $this->paymentDate,
                'clientName' => $this->clientName,
                'clientTaxNumber' => $this->clientTaxNumber,
                'clientAddress' => $this->clientAddress,
                'clientCity' => $this->clientCity,
                'clientZipCode' => $this->clientZipCode,
                'clientCountry' => $this->clientCountry,
                'invoiceEntries' => $this->invoiceEntries,
                'totalNetAmount' => $this->totalNetAmount,
                'totalTaxAmount' => $this->totalTaxAmount,
                'totalGrossAmount' => $this->totalGrossAmount,
                'currency' => $this->currency,
                'status' => $this->status,
                'services' => $this->services,
            ],
            fn($value) => $value !== null && $value !== '' && $value !== false
        );
   }
}