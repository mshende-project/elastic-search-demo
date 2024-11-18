<?php

namespace App\DTO;

class ReadMessageDTO
{
    private ?string $identifier = null;
    private ?string $decryption_key = null;

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(?string $identifier): void
    {
        $this->identifier = $identifier;
    }

    public function getDecryptionKey(): ?string
    {
        return $this->decryption_key;
    }

    public function setDecryptionKey(?string $decryption_key): void
    {
        $this->decryption_key = $decryption_key;
    }
}
