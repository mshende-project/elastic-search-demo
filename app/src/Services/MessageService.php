<?php

namespace App\Services;

use App\Entity\Message;
use App\Repository\MessageRepository;
use http\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class MessageService {

    public function __construct(private MessageRepository $messageRepository, private EncryptionService $encryptionService, private ParameterBagInterface $params)
    {
    }
    public function saveMessage(Message $message): string
    {
        $identifier = bin2hex(random_bytes(16));

        $encryptionKey = $this->generateEncryptionKey($message->getRecipient());

        $encryptedText = $this->encryptionService->encrypt($message->getText(), $encryptionKey);
        $message->setText($encryptedText);
        $message->setCreatedAt(new \DateTime());
        $message->setIdentifier($identifier);

        $this->messageRepository->save($message);

        return "Please provide decryption key to your colleague: $encryptionKey and identifier : $identifier";
    }

    public function isMessageExpired(Message $message): bool
    {
        // Check if the message is expired
        if ($message->getExpiryAt() && $message->getExpiryAt() < new \DateTime()) {
            // Message has expired, delete it from the database
            $this->messageRepository->remove($message);
            return true;
        }

        return false;
    }

    public function decryptMessageAndDeleteAfterRead(Message $message, string $decryptionKey): string
    {
        if (empty($decryptionKey)) {
            throw new InvalidArgumentException('Decryption key cannot be empty.');
        }

        $decryptedMessage = $this->encryptionService->decrypt($message->getText(), $decryptionKey);

        // Delete message after reading
        $this->messageRepository->remove($message);

        return "Your decrypted message: $decryptedMessage";
    }

    private function generateEncryptionKey(string $recipient): string
    {
        $secretKey = $this->params->get('secret.encryption.key');
        $combined = $recipient . $secretKey;
        return hash('sha256', $combined);
    }
}