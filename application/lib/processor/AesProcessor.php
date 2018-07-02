<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/2
 * 时间: 21:22
 */

namespace app\lib\processor;


class AesProcessor
{
    private $key = null;

    /**
     * AesProcessor constructor.
     * @param key 密钥
     */
    public function __construct()
    {
        // app.php定义的aeskey
        $this->key = config('app.aeskey');
    }

    /**
     * @param string $text 加密的字符串
     * @return string
     */
    public function encrypt($text = '')
    {
        $size = mcrypt_get_block_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB);
        $text = $this->PKCS5Padding($text, $size);
        $td = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_ECB, '');
        $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        mcrypt_generic_init($td, $this->key, $iv);
        $data = mcrypt_generic($td, $text);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
        $data = base64_encode($data);

        return $data;

    }

    /**
     * 填充方式 pkcs5
     * @param $text 原始的字符串长度
     * @param $size 加密的长度
     * @return string 加密后的值
     */
    public function PKCS5Padding($text, $size)
    {
        $pad = $size - (strlen($text) % $size);
        return $text.str_repeat(chr($pad), $pad);
    }

    /**
     * @param $text 解密字符串
     * @param string key 解密的key
     * @return bool|string
     */
    public function decrypt($text)
    {
        $decrypted = mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $this->key, base64_decode($text), MCRYPT_MODE_ECB);

        $decrypt_length = strlen($decrypted);
        $padding = ord($decrypted[$decrypt_length-1]);
        $decrypted = substr($decrypted, 0, -$padding);
        return $decrypted;
    }


}