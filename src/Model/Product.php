<?php

namespace App\Model;

class Product
{
    private string $number;

    private ?string $name = null;

    private ?int $availableStock = null;

    private ?float $priceGross = null;

    /**
     * @param array $data
     * @return self
     */
    public static function createFromApiArray(array $data): self
    {
        $product = new self();
        $product->setNumber($data['attributes']['productNumber']);
        $product->setName($data['attributes']['name'] ?? null);
        $product->setAvailableStock($data['attributes']['availableStock'] ?? null);
        $product->setPriceGross($data['attributes']['price'][0]['gross'] ?? null);

        return $product;
    }

    public function getNumber(): string
    {
        return $this->number;
    }

    public function setNumber(string $number): Product
    {
        $this->number = $number;
        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Product
    {
        $this->name = $name;
        return $this;
    }

    public function getAvailableStock(): ?int
    {
        return $this->availableStock;
    }

    public function setAvailableStock(?int $availableStock): Product
    {
        $this->availableStock = $availableStock;
        return $this;
    }

    public function getPriceGross(): ?float
    {
        return $this->priceGross;
    }

    public function setPriceGross(?float $priceGross): Product
    {
        $this->priceGross = $priceGross;
        return $this;
    }


}
