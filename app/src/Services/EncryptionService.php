<?php

namespace App\Services;

class EncryptionService {
    private static string $METHOD = 'aes-256-cbc';

    public function encrypt(string $message, string $encryptionKey): string
    {
        $ivlen = openssl_cipher_iv_length(self::$METHOD);
        $iv = openssl_random_pseudo_bytes($ivlen);

        // Encrypt the message
        $encrypted = openssl_encrypt($message, self::$METHOD, $encryptionKey, OPENSSL_RAW_DATA, $iv);

        if ($encrypted === false) {
            throw new \Exception('Encryption failed');
        }

        return base64_encode($iv . $encrypted);
    }

    public function decrypt(string $encryptedMessage, string $encryptionKey): string
    {
        $data = base64_decode($encryptedMessage);

        $ivlen = openssl_cipher_iv_length(self::$METHOD);
        $iv = substr($data, 0, $ivlen);
        $encrypted = substr($data, $ivlen);

        // Decrypt the message
        $decrypted = openssl_decrypt($encrypted, self::$METHOD, $encryptionKey, OPENSSL_RAW_DATA, $iv);

        if ($decrypted === false) {
            throw new \Exception('Decryption failed');
        }

        return $decrypted;
    }

}