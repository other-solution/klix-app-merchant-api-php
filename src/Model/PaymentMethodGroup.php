<?php declare(strict_types = 1);

namespace OtherSolution\Klix\Model;

use JsonSerializable;

class PaymentMethodGroup implements JsonSerializable
{
    private string $name;
    private string $logo;
    private string $label;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getLogo(): string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getLabel(): string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return [];
    }
}
