<?php
namespace crypto;

interface Crypto
{
    public function encrypt($plaintext, $other);
    public function decrypt($ciphertext, $other);
}