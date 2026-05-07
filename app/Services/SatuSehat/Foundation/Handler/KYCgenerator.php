<?php

namespace App\Services\SatuSehat\Foundation\Handler;

use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\PublicKeyLoader;
use Illuminate\Support\Str;

trait KYCgenerator
{
    /**
     * Generate pasangan kunci RSA 2048-bit.
     */
    public function generateRSAKeyPair(): array
    {
        $privateKey = RSA::createKey(2048);
        $publicKey  = $privateKey->getPublicKey()->toString('PKCS8');

        return [
            'privateKey' => $privateKey,
            'publicKey'  => $publicKey,
        ];
    }

    /**
     * Generate symmetric key AES-256 (32 byte random string).
     */
    public function generateSymmetricKey(): string
    {
        return Str::random(32);
    }

    /**
     * Enkripsi data menggunakan AES-256-GCM.
     */
    public function aesEncrypt(string $data, string $symmetricKey): string
    {
        $ivLength = 12;
        $iv       = random_bytes($ivLength);

        $cipher = new AES('gcm');
        $cipher->setKeyLength(256);
        $cipher->setKey($symmetricKey);
        $cipher->setNonce($iv);

        $ciphertext = $cipher->encrypt($data);
        $tag        = $cipher->getTag();

        // Format: IV (12 byte) + ciphertext + tag (16 byte)
        return $iv . $ciphertext . $tag;
    }

    /**
     * Dekripsi data AES-256-GCM.
     */
    public function aesDecrypt(string $encryptedData, string $symmetricKey): string
    {
        $ivLength  = 12;
        $tagLength = 16;

        $iv         = substr($encryptedData, 0, $ivLength);
        $tag        = substr($encryptedData, -$tagLength);
        $ciphertext = substr($encryptedData, $ivLength, -$tagLength);

        $aes = new AES('gcm');
        $aes->setKeyLength(256);
        $aes->setKey($symmetricKey);
        $aes->setNonce($iv);
        $aes->setTag($tag);

        return $aes->decrypt($ciphertext);
    }

    /**
     * Format payload dalam PEM-style envelope.
     */
    public function formatMessage(string $data): string
    {
        $dataAsBase64 = chunk_split(base64_encode($data));
        return "-----BEGIN ENCRYPTED MESSAGE-----\r\n{$dataAsBase64}-----END ENCRYPTED MESSAGE-----";
    }

    /**
     * Enkripsi pesan menggunakan RSA-OAEP + AES-256-GCM.
     *
     * @param  string $message  Data yang akan dienkripsi
     * @param  string $pubPEM   Public key PEM dari server
     * @return string           Pesan terenkripsi dalam format PEM envelope
     */
    public function encryptMessage(string $message, string $pubPEM): string
    {
        $aesKey = $this->generateSymmetricKey();

        $serverKey    = PublicKeyLoader::load($pubPEM);
        $serverKey    = $serverKey->withPadding(RSA::ENCRYPTION_OAEP);
        $wrappedAesKey = $serverKey->encrypt($aesKey);

        $encryptedMessage = $this->aesEncrypt($message, $aesKey);

        return $this->formatMessage($wrappedAesKey . $encryptedMessage);
    }

    /**
     * Dekripsi pesan yang diterima dari server.
     *
     * @param  string $message     Pesan terenkripsi dalam format PEM envelope
     * @param  string $privateKey  Private key RSA
     * @return string              Plaintext pesan
     */
    public function decryptMessage(string $message, string $privateKey): string
    {
        $beginTag = "-----BEGIN ENCRYPTED MESSAGE-----";
        $endTag   = "-----END ENCRYPTED MESSAGE-----";

        // Ekstrak konten base64
        $messageContents = substr(
            $message,
            strlen($beginTag) + 1,
            strlen($message) - strlen($endTag) - strlen($beginTag) - 2
        );

        $binaryDerString = base64_decode($messageContents);

        // Wrapped AES key = 256 byte (RSA 2048-bit output)
        $wrappedKeyLength = 256;
        $wrappedKey       = substr($binaryDerString, 0, $wrappedKeyLength);
        $encryptedMessage = substr($binaryDerString, $wrappedKeyLength);

        $key    = PublicKeyLoader::load($privateKey);
        $aesKey = $key->withPadding(RSA::ENCRYPTION_OAEP)->decrypt($wrappedKey);

        return $this->aesDecrypt($encryptedMessage, $aesKey);
    }
}
