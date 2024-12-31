<?php

namespace SCA\InFakt\Model;

use SCA\InFakt\Util\ValidatorModel;

class ProductModel
{
    public ?int $id = null;
    public string $name;
    public ?string $symbol = null;
    public ?string $pkwiu = null;
    public ?string $cn = null;
    public ?string $pkob = null;
    public ?string $unit = null;
    public string $taxSymbol;
    public ?int $quantity = null;
    public ?int $netPrice = null;
    public ?int $taxPrice = null;
    public ?int $grossPrice = null;
    public ?int $unitNetPrice = null;
    public ?int $purchaseUnitNetPrice = null;
    public ?int $purchaseUnitGrossPrice = null;
    public ?string $flatRateTaxSymbol = null;
    public ?int $discount = null;
    public ?int $unitNetPriceBeforeDiscount = null;
    public ?int $gtuId = null;

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getSymbol(): ?string {
        return $this->symbol;
    }

    public function setSymbol(?string $symbol): void {
        $this->symbol = $symbol;
    }

    public function getPkwiu(): ?string {
        return $this->pkwiu;
    }

    public function setPkwiu(?string $pkwiu): void {
        $this->pkwiu = $pkwiu;
    }

    public function getCn(): ?string {
        return $this->cn;
    }

    public function setCn(?string $cn): void {
        $this->cn = $cn;
    }

    public function getPkob(): ?string {
        return $this->pkob;
    }

    public function setPkob(?string $pkob): void {
        $this->pkob = $pkob;
    }

    public function getUnit(): ?string {
        return $this->unit;
    }

    public function setUnit(?string $unit): void {
        $this->unit = $unit;
    }

    public function getTaxSymbol(): string {
        return $this->taxSymbol;
    }

    public function setTaxSymbol(string $taxSymbol): void {
        $this->taxSymbol = $taxSymbol;
    }

    public function getQuantity(): ?int {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void {
        $this->quantity = $quantity;
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

    public function getUnitNetPrice(): ?int {
        return $this->unitNetPrice;
    }

    public function setUnitNetPrice(?int $unitNetPrice): void {
        $this->unitNetPrice = $unitNetPrice;
    }

    public function getPurchaseUnitNetPrice(): ?int {
        return $this->purchaseUnitNetPrice;
    }

    public function setPurchaseUnitNetPrice(?int $purchaseUnitNetPrice): void {
        $this->purchaseUnitNetPrice = $purchaseUnitNetPrice;
    }

    public function getPurchaseUnitGrossPrice(): ?int {
        return $this->purchaseUnitGrossPrice;
    }

    public function setPurchaseUnitGrossPrice(?int $purchaseUnitGrossPrice): void {
        $this->purchaseUnitGrossPrice = $purchaseUnitGrossPrice;
    }

    public function getFlatRateTaxSymbol(): ?string {
        return $this->flatRateTaxSymbol;
    }

    public function setFlatRateTaxSymbol(?string $flatRateTaxSymbol): void {
        $this->flatRateTaxSymbol = $flatRateTaxSymbol;
    }

    public function getDiscount(): ?int {
        return $this->discount;
    }

    public function setDiscount(?int $discount): void {
        $this->discount = $discount;
    }

    public function getUnitNetPriceBeforeDiscount(): ?int {
        return $this->unitNetPriceBeforeDiscount;
    }

    public function setUnitNetPriceBeforeDiscount(?int $unitNetPriceBeforeDiscount): void {
        $this->unitNetPriceBeforeDiscount = $unitNetPriceBeforeDiscount;
    }

    public function getGtuId(): ?int {
        return $this->gtuId;
    }

    public function setGtuId(?int $gtuId): void {
        $this->gtuId = $gtuId;
    }


    public function getAll(): array {
        return array_filter(
            [
                'id' => $this->id,
                'name' => $this->name,
                'symbol' => $this->symbol,
                'pkwiu' => $this->pkwiu,
                'cn' => $this->cn,
                'pkob' => $this->pkob,
                'unit' => $this->unit,
                'tax_symbol' => $this->taxSymbol,
                'quantity' => $this->quantity,
                'net_price' => $this->netPrice,
                'tax_price' => $this->taxPrice,
                'gross_price' => $this->grossPrice,
                'unit_net_price' => $this->unitNetPrice,
                'purchase_unit_net_price' => $this->purchaseUnitNetPrice,
                'purchase_unit_gross_price' => $this->purchaseUnitGrossPrice,
                'flat_rate_tax_symbol' => $this->flatRateTaxSymbol,
                'discount' => $this->discount,
                'unit_net_price_before_discount' => $this->unitNetPriceBeforeDiscount,
                'gtu_id' => $this->gtuId,
            ],
            fn($value) => $value !== null && $value !== '' && $value !== false
        );
    }

    public function validateRequiredFields(): bool|array {
        return ValidatorModel::validateRequiredFields($this);
    }
}