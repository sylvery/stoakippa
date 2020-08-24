<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ItemRepository")
 */
class Item
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $measurement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $measurementunit;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ItemCategory", inversedBy="items")
     */
    private $category;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $itemCode;

    /**
     * @ORM\ManyToOne(targetEntity=ItemManufacturer::class, inversedBy="items")
     */
    private $manufacturer;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\ManyToOne(targetEntity=Sale::class, inversedBy="items")
     */
    private $sale;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="saleitem", cascade={"persist", "remove"})
     */
    private $transaction;

    public function __toString()
    {
        return $this->getItemCode();
        // return $this->getName() . ' - K' . number_format($this->getPrice()/100,2);
    }

    public function getNameDesc()
    {
        return $this->getName() . ' ' . $this->getMeasurement() . $this->getMeasurementunit();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getMeasurement(): ?int
    {
        return $this->measurement;
    }

    public function setMeasurement(int $measurement): self
    {
        $this->measurement = $measurement;

        return $this;
    }

    public function getMeasurementunit(): ?string
    {
        return $this->measurementunit;
    }

    public function setMeasurementunit(string $measurementunit): self
    {
        $this->measurementunit = $measurementunit;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCategory(): ?ItemCategory
    {
        return $this->category;
    }

    public function setCategory(?ItemCategory $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getItemCode(): ?string
    {
        return $this->itemCode;
    }

    public function setItemCode(?string $itemCode): self
    {
        $this->itemCode = $itemCode;

        return $this;
    }

    public function getManufacturer(): ?ItemManufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(?ItemManufacturer $manufacturer): self
    {
        $this->manufacturer = $manufacturer;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getSale(): ?Sale
    {
        return $this->sale;
    }

    public function setSale(?Sale $sale): self
    {
        $this->sale = $sale;

        return $this;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }

    public function setTransaction(?Transaction $transaction): self
    {
        $this->transaction = $transaction;

        // set (or unset) the owning side of the relation if necessary
        $newSaleitem = null === $transaction ? null : $this;
        if ($transaction->getSaleitem() !== $newSaleitem) {
            $transaction->setSaleitem($newSaleitem);
        }

        return $this;
    }
}
