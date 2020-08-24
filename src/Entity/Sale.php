<?php

namespace App\Entity;

use App\Repository\SaleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SaleRepository::class)
 */
class Sale
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $datetime;

    /**
     * @ORM\OneToMany(targetEntity=Transaction::class, mappedBy="sale", cascade={"persist"})
     */
    private $transactions;

    /**
     * @ORM\ManyToOne(targetEntity=Appuser::class, inversedBy="sales")
     */
    private $cashier;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $currentPlace = [];

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $payment;

    public function __construct()
    {
        $this->transactions = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatetime(): ?\DateTimeInterface
    {
        return $this->datetime;
    }

    public function setDatetime(\DateTimeInterface $datetime): self
    {
        $this->datetime = $datetime;

        return $this;
    }

    /**
     * @return Collection|Transaction[]
     */
    public function getTransactions(): Collection
    {
        return $this->transactions;
    }

    public function addTransaction(Transaction $transaction): self
    {
        if (!$this->transactions->contains($transaction)) {
            $this->transactions[] = $transaction;
            $transaction->setSale($this);
        }

        return $this;
    }

    public function removeTransaction(Transaction $transaction): self
    {
        if ($this->transactions->contains($transaction)) {
            $this->transactions->removeElement($transaction);
            // set the owning side to null (unless already changed)
            if ($transaction->getSale() === $this) {
                $transaction->setSale(null);
            }
        }

        return $this;
    }

    public function getCashier(): ?Appuser
    {
        return $this->cashier;
    }

    public function setCashier(?Appuser $cashier): self
    {
        $this->cashier = $cashier;

        return $this;
    }

    public function getCurrentPlace(): ?array
    {
        return $this->currentPlace;
    }

    public function setCurrentPlace(?array $currentPlace): self
    {
        $this->currentPlace = $currentPlace;

        return $this;
    }

    public function getPayment(): ?int
    {
        return $this->payment;
    }

    public function setPayment(?int $payment): self
    {
        $this->payment = $payment;

        return $this;
    }
}
