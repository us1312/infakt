<?php

namespace SCA\InFakt\Model;

class ProductModel
{
    private ?int $id;
    private string $name;
    private string $description;
    private float $netPrice;
    private float $taxRate;
    private float $grossPrice;
    private string $unit;
    private string $sku;
    private bool $active;

    public function isActive(): bool {
        return $this->active;
    }

    public function setActive(bool $active): void {
        $this->active = $active;
    }

    public function getSku(): string {
        return $this->sku;
    }

    public function setSku(string $sku): void {
        $this->sku = $sku;
    }

    public function getUnit(): string {
        return $this->unit;
    }

    public function setUnit(string $unit): void {
        $this->unit = $unit;
    }

    public function getGrossPrice(): float {
        return $this->grossPrice;
    }

    public function setGrossPrice(float $grossPrice): void {
        $this->grossPrice = $grossPrice;
    }

    public function getTaxRate(): float {
        return $this->taxRate;
    }

    public function setTaxRate(float $taxRate): void {
        $this->taxRate = $taxRate;
    }

    public function getNetPrice(): float {
        return $this->netPrice;
    }

    public function setNetPrice(float $netPrice): void {
        $this->netPrice = $netPrice;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function setDescription(string $description): void {
        $this->description = $description;
    }

    public function getName(): string {
        return $this->name;
    }

    public function setName(string $name): void {
        $this->name = $name;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(?int $id): void {
        $this->id = $id;
    }

    public function getAll(): array
    {
        return array_filter(
            [
                'id' => $this->id,
                'name' => $this->name,
                'description' => $this->description,
                'netPrice' => $this->netPrice,
                'taxRate' => $this->taxRate,
                'grossPrice' => $this->grossPrice,
                'unit' => $this->unit,
                'sku' => $this->sku,
                'active' => $this->active
            ],
            fn($value) => $value !== null && $value !== '' && $value !== false
        );
    }


}