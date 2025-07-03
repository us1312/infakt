<?php

namespace SCA\InFakt\Model;

use SCA\InFakt\Util\ModelUtil;
use SCA\InFakt\Util\ValidatorModel;

class VatInvoiceModel
{
    public int $id; // Read-only
    public ?string $number = null;
    public ?string $currency = 'PLN';
    public ?int $paidPrice = null;
    public ?string $notes = null;
    public ?string $kind = null;
    public ?string $paymentMethod = null;
    public ?bool $splitPaymentAvailable = null;
    public ?string $splitPaymentType = null;
    public ?string $recipientSignature = null;
    public ?string $sellerSignature = null;
    public ?string $invoiceDate = null;
    public ?string $saleDate = null;
    public ?string $status = null;
    public ?string $paymentDate = null;
    public ?string $paidDate = null;
    public ?int $netPrice = null;
    public ?int $taxPrice = null;
    public ?int $grossPrice = null;
    public ?int $leftToPay = null;
    public ?int $clientId = null;
    public ?string $clientCompanyName = null;
    public ?string $clientFirstName = null;
    public ?string $clientLastName = null;
    public ?string $clientBusinessActivityKind = null;
    public ?string $clientStreet = null;
    public ?string $clientStreetNumber = null;
    public ?string $clientFlatNumber = null;
    public ?string $clientCity = null;
    public ?string $clientPostCode = null;
    public ?string $clientTaxCode = null;
    public ?string $cleanClientNip = null; // Read-only
    public ?string $clientCountry = null;
    public ?bool $checkDuplicateNumber = null;
    public ?string $bankName = null;
    public ?string $bankAccount = null;
    public ?string $swift = null;
    public ?string $saleType = null;
    public ?string $invoiceDateKind = null;
    public ?string $continuousServiceStartOn = null;
    public ?string $continuousServiceEndOn = null;
    public array $services;
    public ?int $vatExemptionReason = null;
    public ?array $extensions = null; // Read-only
    public ?string $bdoCode = null;
    public ?int $transactionKindId = null;
    public ?array $documentMarkingsIds = null;
    public ?string $receiptNumber = null;
    public ?bool $notIncome = null;
    public ?string $vatExchangeDateKind = null;
    public ?array $ksefData = null; // Read-only
    public ?array $localGovernmentRecipientAddress = null;
    public ?array $localGovernmentSellerAddress = null; // Read-only
    public ?string $createdAt = null;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getNumber(): ?string {
        return $this->number;
    }

    public function setNumber(?string $number): void {
        $this->number = $number;
    }

    public function getCurrency(): ?string {
        return $this->currency;
    }

    public function setCurrency(?string $currency): void {
        $this->currency = $currency;
    }

    public function getPaidPrice(): ?int {
        return $this->paidPrice;
    }

    public function setPaidPrice(?int $paidPrice): void {
        $this->paidPrice = $paidPrice;
    }

    public function getNotes(): ?string {
        return $this->notes;
    }

    public function setNotes(?string $notes): void {
        $this->notes = $notes;
    }

    public function getKind(): ?string {
        return $this->kind;
    }

    public function setKind(?string $kind): void {
        $this->kind = $kind;
    }

    public function getPaymentMethod(): ?string {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): void {
        $this->paymentMethod = $paymentMethod;
    }

    public function getSplitPaymentAvailable(): ?bool {
        return $this->splitPaymentAvailable;
    }

    public function setSplitPaymentAvailable(?bool $splitPaymentAvailable): void {
        $this->splitPaymentAvailable = $splitPaymentAvailable;
    }

    public function getSplitPaymentType(): ?string {
        return $this->splitPaymentType;
    }

    public function setSplitPaymentType(?string $splitPaymentType): void {
        $this->splitPaymentType = $splitPaymentType;
    }

    public function getRecipientSignature(): ?string {
        return $this->recipientSignature;
    }

    public function setRecipientSignature(?string $recipientSignature): void {
        $this->recipientSignature = $recipientSignature;
    }

    public function getSellerSignature(): ?string {
        return $this->sellerSignature;
    }

    public function setSellerSignature(?string $sellerSignature): void {
        $this->sellerSignature = $sellerSignature;
    }

    public function getInvoiceDate(): ?string {
        return $this->invoiceDate;
    }

    public function setInvoiceDate(?string $invoiceDate): void {
        $this->invoiceDate = $invoiceDate;
    }

    public function getSaleDate(): ?string {
        return $this->saleDate;
    }

    public function setSaleDate(?string $saleDate): void {
        $this->saleDate = $saleDate;
    }

    public function getStatus(): ?string {
        return $this->status;
    }

    public function setStatus(?string $status): void {
        $this->status = $status;
    }

    public function getPaymentDate(): ?string {
        return $this->paymentDate;
    }

    public function setPaymentDate(?string $paymentDate): void {
        $this->paymentDate = $paymentDate;
    }

    public function getPaidDate(): ?string {
        return $this->paidDate;
    }

    public function setPaidDate(?string $paidDate): void {
        $this->paidDate = $paidDate;
    }

    public function getNetPrice(): ?int {
        return $this->netPrice;
    }

    public function setNetPrice(?int $netPrice): void {
        $this->netPrice = $netPrice;
    }

    public function getTaxPrice(): ?int {
        return $this->taxPrice;
    }

    public function setTaxPrice(?int $taxPrice): void {
        $this->taxPrice = $taxPrice;
    }

    public function getGrossPrice(): ?int {
        return $this->grossPrice;
    }

    public function setGrossPrice(?int $grossPrice): void {
        $this->grossPrice = $grossPrice;
    }

    public function getLeftToPay(): ?int {
        return $this->leftToPay;
    }

    public function setLeftToPay(?int $leftToPay): void {
        $this->leftToPay = $leftToPay;
    }

    public function getClientId(): ?int {
        return $this->clientId;
    }

    public function setClientId(?int $clientId): void {
        $this->clientId = $clientId;
    }

    public function getClientCompanyName(): ?string {
        return $this->clientCompanyName;
    }

    public function setClientCompanyName(?string $clientCompanyName): void {
        $this->clientCompanyName = $clientCompanyName;
    }

    public function getClientFirstName(): ?string {
        return $this->clientFirstName;
    }

    public function setClientFirstName(?string $clientFirstName): void {
        $this->clientFirstName = $clientFirstName;
    }

    public function getClientLastName(): ?string {
        return $this->clientLastName;
    }

    public function setClientLastName(?string $clientLastName): void {
        $this->clientLastName = $clientLastName;
    }

    public function getClientBusinessActivityKind(): ?string {
        return $this->clientBusinessActivityKind;
    }

    public function setClientBusinessActivityKind(?string $clientBusinessActivityKind): void {
        $this->clientBusinessActivityKind = $clientBusinessActivityKind;
    }

    public function getClientStreet(): ?string {
        return $this->clientStreet;
    }

    public function setClientStreet(?string $clientStreet): void {
        $this->clientStreet = $clientStreet;
    }

    public function getClientStreetNumber(): ?string {
        return $this->clientStreetNumber;
    }

    public function setClientStreetNumber(?string $clientStreetNumber): void {
        $this->clientStreetNumber = $clientStreetNumber;
    }

    public function getClientFlatNumber(): ?string {
        return $this->clientFlatNumber;
    }

    public function setClientFlatNumber(?string $clientFlatNumber): void {
        $this->clientFlatNumber = $clientFlatNumber;
    }

    public function getClientCity(): ?string {
        return $this->clientCity;
    }

    public function setClientCity(?string $clientCity): void {
        $this->clientCity = $clientCity;
    }

    public function getClientPostCode(): ?string {
        return $this->clientPostCode;
    }

    public function setClientPostCode(?string $clientPostCode): void {
        $this->clientPostCode = $clientPostCode;
    }

    public function getClientTaxCode(): ?string {
        return $this->clientTaxCode;
    }

    public function setClientTaxCode(?string $clientTaxCode): void {
        $this->clientTaxCode = $clientTaxCode;
    }

    public function getCleanClientNip(): ?string {
        return $this->cleanClientNip;
    }

    public function setCleanClientNip(?string $cleanClientNip): void {
        $this->cleanClientNip = $cleanClientNip;
    }

    public function getClientCountry(): ?string {
        return $this->clientCountry;
    }

    public function setClientCountry(?string $clientCountry): void {
        $this->clientCountry = $clientCountry;
    }

    public function getCheckDuplicateNumber(): ?bool {
        return $this->checkDuplicateNumber;
    }

    public function setCheckDuplicateNumber(?bool $checkDuplicateNumber): void {
        $this->checkDuplicateNumber = $checkDuplicateNumber;
    }

    public function getBankName(): ?string {
        return $this->bankName;
    }

    public function setBankName(?string $bankName): void {
        $this->bankName = $bankName;
    }

    public function getBankAccount(): ?string {
        return $this->bankAccount;
    }

    public function setBankAccount(?string $bankAccount): void {
        $this->bankAccount = $bankAccount;
    }

    public function getSwift(): ?string {
        return $this->swift;
    }

    public function setSwift(?string $swift): void {
        $this->swift = $swift;
    }

    public function getSaleType(): ?string {
        return $this->saleType;
    }

    public function setSaleType(?string $saleType): void {
        $this->saleType = $saleType;
    }

    public function getInvoiceDateKind(): ?string {
        return $this->invoiceDateKind;
    }

    public function setInvoiceDateKind(?string $invoiceDateKind): void {
        $this->invoiceDateKind = $invoiceDateKind;
    }

    public function getContinuousServiceStartOn(): ?string {
        return $this->continuousServiceStartOn;
    }

    public function setContinuousServiceStartOn(?string $continuousServiceStartOn): void {
        $this->continuousServiceStartOn = $continuousServiceStartOn;
    }

    public function getContinuousServiceEndOn(): ?string {
        return $this->continuousServiceEndOn;
    }

    public function setContinuousServiceEndOn(?string $continuousServiceEndOn): void {
        $this->continuousServiceEndOn = $continuousServiceEndOn;
    }

    public function getServices(): ?array {
        return $this->services;
    }

    public function setServices(?array $services): void {
        $this->services[] = $services;
    }

    public function getVatExemptionReason(): ?int {
        return $this->vatExemptionReason;
    }

    public function setVatExemptionReason(?int $vatExemptionReason): void {
        $this->vatExemptionReason = $vatExemptionReason;
    }

    public function getExtensions(): ?array {
        return $this->extensions;
    }

    public function setExtensions(?array $extensions): void {
        $this->extensions = $extensions;
    }

    public function getBdoCode(): ?string {
        return $this->bdoCode;
    }

    public function setBdoCode(?string $bdoCode): void {
        $this->bdoCode = $bdoCode;
    }

    public function getTransactionKindId(): ?int {
        return $this->transactionKindId;
    }

    public function setTransactionKindId(?int $transactionKindId): void {
        $this->transactionKindId = $transactionKindId;
    }

    public function getDocumentMarkingsIds(): ?array {
        return $this->documentMarkingsIds;
    }

    public function setDocumentMarkingsIds(?array $documentMarkingsIds): void {
        $this->documentMarkingsIds = $documentMarkingsIds;
    }

    public function getReceiptNumber(): ?string {
        return $this->receiptNumber;
    }

    public function setReceiptNumber(?string $receiptNumber): void {
        $this->receiptNumber = $receiptNumber;
    }

    public function getNotIncome(): ?bool {
        return $this->notIncome;
    }

    public function setNotIncome(?bool $notIncome): void {
        $this->notIncome = $notIncome;
    }

    public function getVatExchangeDateKind(): ?string {
        return $this->vatExchangeDateKind;
    }

    public function setVatExchangeDateKind(?string $vatExchangeDateKind): void {
        $this->vatExchangeDateKind = $vatExchangeDateKind;
    }

    public function getKsefData(): ?array {
        return $this->ksefData;
    }

    public function setKsefData(?array $ksefData): void {
        $this->ksefData = $ksefData;
    }

    public function getLocalGovernmentRecipientAddress(): ?array {
        return $this->localGovernmentRecipientAddress;
    }

    public function setLocalGovernmentRecipientAddress(?array $localGovernmentRecipientAddress): void {
        $this->localGovernmentRecipientAddress = $localGovernmentRecipientAddress;
    }

    public function getLocalGovernmentSellerAddress(): ?array {
        return $this->localGovernmentSellerAddress;
    }

    public function setLocalGovernmentSellerAddress(?array $localGovernmentSellerAddress): void {
        $this->localGovernmentSellerAddress = $localGovernmentSellerAddress;
    }

    public function getCreatedAt(): ?string {
        return $this->createdAt;
    }

    public function setCreatedAt(?string $createdAt): void {
        $this->createdAt = $createdAt;
    }

    public function validateRequiredFields(): bool|array {
        return ValidatorModel::validateRequiredFields($this);
    }

    public function getAll($object): array {
        return ['invoice' => ModelUtil::getAll($object)];
    }
}