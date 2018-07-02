<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/1
 * 时间: 13:36
 */

namespace app\lib\exception;


use think\Exception;

class BaseException extends Exception
{
    // HTTP状态码404或者200多
    public $code = 400;
    //错误的消息
    public $msg = '参数错了';
    //自定义的错误状态码
    public $errorCode = 10000;//通用错误

    public function __construct($param = [])
    {
        if (!is_array($param))
        {
            return ;
        }

        if (array_key_exists('code',$param))
        {
            $this->code = $param['code'];
        }
        if (array_key_exists('msg',$param))
        {
            $this->msg = $param['msg'];
        }
        if (array_key_exists('errorCode',$param))
        {
            $this->errorCode = $param['errorCode]'];
        }

    }

}