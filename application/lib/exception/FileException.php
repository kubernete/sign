<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/19
 * 时间: 16:44
 */

namespace app\lib\exception;


class FileException extends BaseException
{
    public $msg = '文件上传失败';
    public $code = 400;
}