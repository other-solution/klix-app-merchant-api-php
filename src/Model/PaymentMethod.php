<?php declare(strict_types = 1);

namespace OtherSolution\Klix\Model;

use JsonSerializable;
use function get_object_vars;

class PaymentMethod implements JsonSerializable
{
    private string $key;

    private string $name;

    private string $logo;

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

    public function getKey(): string
    {
        return $this->key;
    }

    public function setKey(string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function jsonSerialize(): array
    {
        return get_object_vars($this);
    }
}
