<?php

namespace crypto;

class Rsa
{
    public $privateKey = '-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDfVhBR62L5lTNQ
Zyo2SKjYHzjZRbOKRUU9TXHP/C9yOdOuwh6b9Kyw/J5Prkf/t7Om8y+XoMxcflpu
AHFEkGllFu7naY1iWIbYsRkEClQkzZUvzghW/7/KDobFb6bjcUeHwuNiOMw42zzL
CyULUPGo7T85my4f7gpmkWGqc08BxmSbbM8CNhtExSzm0pry8h429IXoMCS7PcWK
V7d3e0YHoltQ/l2PZHhr+1YUORtVrC4dg2XIfavgIqD+gCsv+7CGI43dRr3iiK5Q
36F7pCc0h6Y+dafRhJbdFmQbtO24DpddD8D1baZOVXsjDqEfVrwnHIwLLZiiov4u
54k7qE3dAgMBAAECggEBANoo5dQ/zPTkS7XUsKVKILTM+ukybwk4VURmrDBwtaAs
4JyrPt81CKPygGpxYh9nQPRqRSkmh7oqKwedIwfI0UtQNZqTvuo8c6ykgj0yIbO5
pmuGJRtmw+AKhJfEUw+FjkwNkbRWqxc3AZGNl2gQb5+F8ObCsTG7gyliBjdMX/bo
E82/8xRVT5+83KPWVyXq4SmfvgS63RLWd1l0pHqxkEHiumDMMmSiKVWcnYFA5iFk
58TwxeZxKteUWhYpjLLHJOI5++bMSy9o9a575gWZ4IVkiZriXKjo3qdhdaUXiULP
9w04BCrn98Xg9uMX3Vg1PBCEltYUPle1c64jLKrCtbkCgYEA+HTu8hBGWi9exCg5
McIWwHUCYVlcGruPi6Vdah3+RxYP5MstaHNBghhesv1dOj16pj+KZzaLOxNNneW0
1PiqJ9vM5RpYHDy983+g0UxUoIJ18T9QvX49nLcEABYrIWVJ16WoPFUEqIxj8Nwv
/dupQoTTwJhC4t6aOGTDxYk3fO8CgYEA5h3jFlgCoQxkgx5J1lvuw7PyOWXuqAcK
U9bm2AiAvCok7sdfGs7YFl/fY8utrcF6TDBAVsfKp5kEk3hebY9qEoJWmkxjgri0
vVS0wQf0QV2yWIl3JmhF8npV74QlXGjOMd0T1w5ERVaL+UDeTNMLAfsGWBALWN9A
Xg94AnCMufMCgYAENze2s7/917/r5CLUTU7FhTa9IB8H9RbCb9Pd8RRXcHBkmW3z
z8DUzEUPFG14h4KFP57BkZNbNUCj5TnkQzPf6ULYwFGuaPlwIEJCSuFEt/H4XfKo
xHOXLSPMPJQOxQEzv4PTQj4J/hfUBmhqDkgY8NgG9I5t+wjy3ALWXzWp0QKBgC6Q
8bk9yhpo9ZYK9QopxGFZ8rRmyiq6cf6RSFmDLvnk1WB0e+xi2xt7/yqkttqogmUU
hpCJEZtkvaZR/1nQYbipI3lJ6AE1+20szP8a6vSnT0XXW4MsKqts0iML7LuMgd1Z
TYCBZJNbdivUUqfdNScLczcy1/j+BHqEStbDi9a9AoGBAKB3NlzFPBEPiaWbLUTI
O8/grX+5wMYzs8APPY830rTnIcWt/p6UlzlyYoIEp9NA89TzsPdx1xoRYvU0pUMb
13cC5DO6FEqavDjC/bUr1I5Ei7JHStYq49wiHiyQMg+m2lgAgWjj7PFYqojo4jBs
YtBt7xqgn7WHZi/PK9bZV+SI
-----END PRIVATE KEY-----';
    public $publicKey;
    public $key='public';
    public function generateKeyPair()
    {
        $resource = openssl_pkey_new();
        openssl_pkey_export($resource, $this->privateKey);
        $detail = openssl_pkey_get_details($resource);
        $this->publicKey = $detail['key'];
        return array('public_key'=>$this->publicKey, 'private_key' => $this->privateKey);
    }
    public function encrypt($plaintext, $key='privateKey')
    {
        if ($key == 'privateKey') {
            openssl_private_encrypt($plaintext, $encrypted, $this->privateKey);
            return base64_encode($encrypted);
        } else {
            openssl_public_encrypt($plaintext, $encrypted, $this->publicKey);
            return base64_encode($encrypted); # 防止乱码
        }
    }
    public function decrypt($ciphertext, $key='privateKey')
    {
        $ciphertext = base64_decode($ciphertext);
        if ($key == 'publicKey') {
            openssl_public_decrypt($ciphertext, $decrypted, $this->publicKey);
            return $decrypted;
        } else {
            openssl_private_decrypt($ciphertext, $decrypted, $this->privateKey);
            return $decrypted;
        }
    }
    public static function showMe()
    {
        $rsa = new Rsa();
        //$rsa->generateKeyPair();
        $rsa->publicKey='-----BEGIN PUBLIC KEY-----
MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA31YQUeti+ZUzUGcqNkio
2B842UWzikVFPU1xz/wvcjnTrsIem/SssPyeT65H/7ezpvMvl6DMXH5abgBxRJBp
ZRbu52mNYliG2LEZBApUJM2VL84IVv+/yg6GxW+m43FHh8LjYjjMONs8ywslC1Dx
qO0/OZsuH+4KZpFhqnNPAcZkm2zPAjYbRMUs5tKa8vIeNvSF6DAkuz3File3d3tG
B6JbUP5dj2R4a/tWFDkbVawuHYNlyH2r4CKg/oArL/uwhiON3Ua94oiuUN+he6Qn
NIemPnWn0YSW3RZkG7TtuA6XXQ/A9W2mTlV7Iw6hH1a8JxyMCy2YoqL+LueJO6hN
3QIDAQAB
-----END PUBLIC KEY-----';
        $rsa->privateKey = '-----BEGIN PRIVATE KEY-----
MIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQDfVhBR62L5lTNQ
Zyo2SKjYHzjZRbOKRUU9TXHP/C9yOdOuwh6b9Kyw/J5Prkf/t7Om8y+XoMxcflpu
AHFEkGllFu7naY1iWIbYsRkEClQkzZUvzghW/7/KDobFb6bjcUeHwuNiOMw42zzL
CyULUPGo7T85my4f7gpmkWGqc08BxmSbbM8CNhtExSzm0pry8h429IXoMCS7PcWK
V7d3e0YHoltQ/l2PZHhr+1YUORtVrC4dg2XIfavgIqD+gCsv+7CGI43dRr3iiK5Q
36F7pCc0h6Y+dafRhJbdFmQbtO24DpddD8D1baZOVXsjDqEfVrwnHIwLLZiiov4u
54k7qE3dAgMBAAECggEBANoo5dQ/zPTkS7XUsKVKILTM+ukybwk4VURmrDBwtaAs
4JyrPt81CKPygGpxYh9nQPRqRSkmh7oqKwedIwfI0UtQNZqTvuo8c6ykgj0yIbO5
pmuGJRtmw+AKhJfEUw+FjkwNkbRWqxc3AZGNl2gQb5+F8ObCsTG7gyliBjdMX/bo
E82/8xRVT5+83KPWVyXq4SmfvgS63RLWd1l0pHqxkEHiumDMMmSiKVWcnYFA5iFk
58TwxeZxKteUWhYpjLLHJOI5++bMSy9o9a575gWZ4IVkiZriXKjo3qdhdaUXiULP
9w04BCrn98Xg9uMX3Vg1PBCEltYUPle1c64jLKrCtbkCgYEA+HTu8hBGWi9exCg5
McIWwHUCYVlcGruPi6Vdah3+RxYP5MstaHNBghhesv1dOj16pj+KZzaLOxNNneW0
1PiqJ9vM5RpYHDy983+g0UxUoIJ18T9QvX49nLcEABYrIWVJ16WoPFUEqIxj8Nwv
/dupQoTTwJhC4t6aOGTDxYk3fO8CgYEA5h3jFlgCoQxkgx5J1lvuw7PyOWXuqAcK
U9bm2AiAvCok7sdfGs7YFl/fY8utrcF6TDBAVsfKp5kEk3hebY9qEoJWmkxjgri0
vVS0wQf0QV2yWIl3JmhF8npV74QlXGjOMd0T1w5ERVaL+UDeTNMLAfsGWBALWN9A
Xg94AnCMufMCgYAENze2s7/917/r5CLUTU7FhTa9IB8H9RbCb9Pd8RRXcHBkmW3z
z8DUzEUPFG14h4KFP57BkZNbNUCj5TnkQzPf6ULYwFGuaPlwIEJCSuFEt/H4XfKo
xHOXLSPMPJQOxQEzv4PTQj4J/hfUBmhqDkgY8NgG9I5t+wjy3ALWXzWp0QKBgC6Q
8bk9yhpo9ZYK9QopxGFZ8rRmyiq6cf6RSFmDLvnk1WB0e+xi2xt7/yqkttqogmUU
hpCJEZtkvaZR/1nQYbipI3lJ6AE1+20szP8a6vSnT0XXW4MsKqts0iML7LuMgd1Z
TYCBZJNbdivUUqfdNScLczcy1/j+BHqEStbDi9a9AoGBAKB3NlzFPBEPiaWbLUTI
O8/grX+5wMYzs8APPY830rTnIcWt/p6UlzlyYoIEp9NA89TzsPdx1xoRYvU0pUMb
13cC5DO6FEqavDjC/bUr1I5Ei7JHStYq49wiHiyQMg+m2lgAgWjj7PFYqojo4jBs
YtBt7xqgn7WHZi/PK9bZV+SI
-----END PRIVATE KEY-----';
        $data = 'ML8EnxKlMzVvO3rldi9/H8h2knh8HW+KD5DIORF/vXwWKy+khpJeSnUsB5NA3FO5GSl9pbDRJ3vyDO18bRtqbjFjF556fWOHQRPEovc/2ebE+HBXLKg9hLgmdeuzv4ugxw78e/IREsFESHF9pSybkDhaK3L1aRqMkuycSZ983y4uEMcTJ7rX4XIeSeoazZ6bq27kkvVRRvlCqILp7v+wQcI1+lyFSNf2IwXS4njPwv52lrojjyfH7njYGmZ4TLsCmW//r5qcxY5A+4XYqxPPH1CA5f86zToRiIeZ9LT6jZmWsa/acyu+iAIMi/F8UTqLJlpc1UnzIBmfSFS6HYKsmg==';

        echo $rsa->decrypt($data);
    }
}