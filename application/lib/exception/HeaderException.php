<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/3
 * 时间: 10:58
 */

namespace app\lib\exception;


class HeaderException extends BaseException
{
    public $code = 400;
    public $msg = 'header参数不正确';
    public $errorCode = 10000;
}