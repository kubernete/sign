<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/7
 * 时间: 8:21
 */

namespace app\lib\exception;


class PasswordException extends BaseException
{
    public $errorCode = 30001;
    public $msg = '密码错误';
}