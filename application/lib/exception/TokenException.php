<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/7
 * 时间: 20:42
 */

namespace app\lib\exception;


class TokenException extends BaseException
{
    public $msg = '注册并生成token失败';

}