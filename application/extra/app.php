<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/2
 * 时间: 19:43
 */

return [
    'password_salt' => '***', // 给密码加上盐
    'aeskey' => '***',
    // AES算法密钥 这个值 比如说android端和PHP端保持一致性 Only keys of sizes 16, 24 or 32 supported
    'app_types' => [
        'android',
        'ios',
    ],
    'token_salt' => '***',
    'sign_time' => 10, // 有效sign时间
    'cache_time' => 20,  // 缓存时间sign
    'login_time_out_day' => 20, // 登录token失效的天数

];