<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/6
 * 时间: 17:36
 */

namespace app\lib\exception;


class SmsException extends BaseException
{
    public $code = 404;
    public $message = '手机发送校验失败';
    public $errorCode = 20000;
}