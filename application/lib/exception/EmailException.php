<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/6
 * 时间: 21:27
 */

namespace app\lib\exception;


class EmailException extends BaseException
{
    public $errorCode = 30000;
    public $msg = '发送邮箱接口错误格式';
}