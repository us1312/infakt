<?php

namespace SCA\InFakt\Model;

use SCA\InFakt\Util\ModelUtil;
use SCA\InFakt\Util\ValidatorModel;

class CustomerModel
{
    public ?string $companyName = null;
    public ?string $street = null;
    public ?string $streetNumber = null;
    public ?string $flatNumber = null;
    public ?string $city = null;
    public string $country; // Required
    public ?string $postalCode = null;
    public ?string $nip = null;
    public ?string $cleanNip = null; // For searching only
    public ?string $phoneNumber = null;
    public ?bool $sameForwardAddress = true; // Default true
    public ?string $webSite = null;
    public ?string $email = null;
    public ?string $note = null;
    public ?string $receiver = null;
    public ?string $mailingCompanyName = null;
    public ?string $mailingStreet = null;
    public ?string $mailingCity = null;
    public ?string $mailingPostalCode = null;
    public ?int $daysToPayment = null;
    public ?string $invoiceNote = null;
    public ?string $paymentMethod = null; // Valid values as per the list
    public ?string $firstName = null; // Required for private_person or JDG
    public ?string $lastName = null; // Required for private_person or JDG
    public ?string $businessActivityKind = null;

    public function getCompanyName(): ?string {
        return $this->companyName;
    }

    public function setCompanyName(?string $companyName): void {
        $this->companyName = $companyName;
    }

    public function getStreet(): ?string {
        return $this->street;
    }

    public function setStreet(?string $street): void {
        $this->street = $street;
    }

    public function getStreetNumber(): ?string {
        return $this->streetNumber;
    }

    public function setStreetNumber(?string $streetNumber): void {
        $this->streetNumber = $streetNumber;
    }

    public function getFlatNumber(): ?string {
        return $this->flatNumber;
    }

    public function setFlatNumber(?string $flatNumber): void {
        $this->flatNumber = $flatNumber;
    }

    public function getCity(): ?string {
        return $this->city;
    }

    public function setCity(?string $city): void {
        $this->city = $city;
    }

    public function getCountry(): string {
        return $this->country;
    }

    public function setCountry(string $country): void {
        $this->country = $country;
    }

    public function getPostalCode(): ?string {
        return $this->postalCode;
    }

    public function setPostalCode(?string $postalCode): void {
        $this->postalCode = $postalCode;
    }

    public function getNip(): ?string {
        return $this->nip;
    }

    public function setNip(?string $nip): void {
        $this->nip = $nip;
    }

    public function getCleanNip(): ?string {
        return $this->cleanNip;
    }

    public function setCleanNip(?string $cleanNip): void {
        $this->cleanNip = $cleanNip;
    }

    public function getPhoneNumber(): ?string {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): void {
        $this->phoneNumber = $phoneNumber;
    }

    public function getSameForwardAddress(): ?bool {
        return $this->sameForwardAddress;
    }

    public function setSameForwardAddress(?bool $sameForwardAddress): void {
        $this->sameForwardAddress = $sameForwardAddress;
    }

    public function getWebSite(): ?string {
        return $this->webSite;
    }

    public function setWebSite(?string $webSite): void {
        $this->webSite = $webSite;
    }

    public function getEmail(): ?string {
        return $this->email;
    }

    public function setEmail(?string $email): void {
        $this->email = $email;
    }

    public function getNote(): ?string {
        return $this->note;
    }

    public function setNote(?string $note): void {
        $this->note = $note;
    }

    public function getReceiver(): ?string {
        return $this->receiver;
    }

    public function setReceiver(?string $receiver): void {
        $this->receiver = $receiver;
    }

    public function getMailingCompanyName(): ?string {
        return $this->mailingCompanyName;
    }

    public function setMailingCompanyName(?string $mailingCompanyName): void {
        $this->mailingCompanyName = $mailingCompanyName;
    }

    public function getMailingStreet(): ?string {
        return $this->mailingStreet;
    }

    public function setMailingStreet(?string $mailingStreet): void {
        $this->mailingStreet = $mailingStreet;
    }

    public function getMailingCity(): ?string {
        return $this->mailingCity;
    }

    public function setMailingCity(?string $mailingCity): void {
        $this->mailingCity = $mailingCity;
    }

    public function getMailingPostalCode(): ?string {
        return $this->mailingPostalCode;
    }

    public function setMailingPostalCode(?string $mailingPostalCode): void {
        $this->mailingPostalCode = $mailingPostalCode;
    }

    public function getDaysToPayment(): ?int {
        return $this->daysToPayment;
    }

    public function setDaysToPayment(?int $daysToPayment): void {
        $this->daysToPayment = $daysToPayment;
    }

    public function getInvoiceNote(): ?string {
        return $this->invoiceNote;
    }

    public function setInvoiceNote(?string $invoiceNote): void {
        $this->invoiceNote = $invoiceNote;
    }

    public function getPaymentMethod(): ?string {
        return $this->paymentMethod;
    }

    public function setPaymentMethod(?string $paymentMethod): void {
        $this->paymentMethod = $paymentMethod;
    }

    public function getFirstName(): ?string {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): void {
        $this->firstName = $firstName;
    }

    public function getLastName(): ?string {
        return $this->lastName;
    }

    public function setLastName(?string $lastName): void {
        $this->lastName = $lastName;
    }

    public function getBusinessActivityKind(): ?string {
        return $this->businessActivityKind;
    }

    public function setBusinessActivityKind(?string $businessActivityKind): void {
        $this->businessActivityKind = $businessActivityKind;
    }

    public function getAll($object): array {
        return ModelUtil::getAll($object);
    }

    public function validateRequiredFields(): bool|array {
        return ValidatorModel::validateRequiredFields($this);
    }
}