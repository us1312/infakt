<?php

namespace SCA\InFakt\Model;

use SCA\InFakt\Util\ModelUtil;
use SCA\InFakt\Util\ValidatorModel;

class OssInvoiceProductModel {
    public ?int $additionalPrice = null;
    public ?string $flatRateTaxSymbol = null;
    public int $grossPrice;
    public string $name;
    public ?int $netPrice = null;
    public int $quantity;
    public int $taxRate;
    public ?int $unitNetPrice = null;
    public ?string $unit = null;

    public function getAdditionalPrice(): ?int {
        return $this->additionalPrice;
    }

    public function setAdditionalPrice(?int $additionalPrice): void {
        $this->additionalPrice = $additionalPrice;
    }

    public function getFlatRateTaxSymbol(): ?string {
        return $this->flatRateTaxSymbol;
    }

    public function setFlatRateTaxSymbol(?string $flatRateTaxSymbol): void {
        $this->flatRateTaxSymbol = $flatRateTaxSymbol;
    }

    public function getGrossPrice(): int {
        return $this->grossPrice;
    }

    public function setGrossPrice(int $grossPrice): void {
        $this->grossPrice = $grossPrice;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getNetPrice(): ?int {
        return $this->netPrice;
    }

    public function setNetPrice(?int $netPrice): void {
        $this->netPrice = $netPrice;
    }

    public function getQuantity(): int {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): void {
        $this->quantity = $quantity;
    }

    public function getTaxRate(): int {
        return $this->taxRate;
    }

    public function setTaxRate(int $taxRate): void {
        $this->taxRate = $taxRate;
    }

    public function getUnitNetPrice(): ?int {
        return $this->unitNetPrice;
    }

    public function setUnitNetPrice(?int $unitNetPrice): void {
        $this->unitNetPrice = $unitNetPrice;
    }

    public function getUnit(): ?string {
        return $this->unit;
    }

    public function setUnit(?string $unit): void {
        $this->unit = $unit;
    }

    public function getAll($object): array {
        return ModelUtil::getAll($object);
    }
    
    public function validateRequiredFields(): bool|array {
        return ValidatorModel::validateRequiredFields($this);
    }
}