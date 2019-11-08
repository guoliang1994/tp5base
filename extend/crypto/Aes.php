<?php
namespace crypto;

class Aes
{
    private $cipher;// 加密方式
    private $key;// 密钥
    private $options = 0;// options 是以下标记的按位或： OPENSSL_RAW_DATA 、 OPENSSL_ZERO_PADDING
    private $iv;
    public function __construct($cipher,$key,$options = 0,$iv = '')
    {
        $this->cipher = $cipher;
        $this->key = $key;
        $this->iv = $iv;
    }
    public function encrypt($plaintext)
    {
        $ciphertext = openssl_encrypt($plaintext, $this->cipher, $this->key, $this->options, $this->iv);
        return $ciphertext;
    }
    public function decrypt($ciphertext)
    {
        $plaintext = openssl_decrypt($ciphertext, $this->cipher, $this->key, $this->options, $this->iv);
        return $plaintext;
    }
    public static function showMe()
    {
        $tmp = new AES("aes-128-cbc", "123456789WANGchao");
        $plaintext = "message to be encrypted";
        $ciphertext = $tmp->encrypt($plaintext);
        echo $ciphertext . "\n";
        $original_plaintext = $tmp->decrypt($ciphertext);
        echo $original_plaintext . "\n";
    }
}