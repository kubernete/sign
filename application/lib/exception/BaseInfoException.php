<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/7
 * 时间: 23:44
 */

namespace app\lib\exception;


class BaseInfoException extends BaseException
{
    public $msg = '缺少参数';
    public $errorCode = 40000;
}