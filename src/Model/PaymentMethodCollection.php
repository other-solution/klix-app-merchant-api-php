<?php declare(strict_types = 1);

namespace OtherSolution\Klix\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use JsonSerializable;

class PaymentMethodCollection implements JsonSerializable
{
    private Collection $paymentMethods;

    public function __construct()
    {
        $this->paymentMethods = new ArrayCollection();
    }

    public function getPaymentMethods(): Collection
    {
        return $this->paymentMethods;
    }

    public function setPaymentMethods(Collection $paymentMethods): self
    {
        $this->paymentMethods = $paymentMethods;

        return $this;
    }

    public function addPaymentMethod(PaymentMethod $paymentMethod): self
    {
        if (!$this->paymentMethods->contains($paymentMethod)) {
            $this->paymentMethods->add($paymentMethod);
        }

        return $this;
    }

    public function removePaymentMethod(PaymentMethod $paymentMethod): self
    {
        if ($this->paymentMethods->contains($paymentMethod)) {
            $this->paymentMethods->removeElement($paymentMethod);
        }

        return $this;
    }

    public function jsonSerialize(): array
    {
        return $this->getPaymentMethods()->toArray();
    }
}
