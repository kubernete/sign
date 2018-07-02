<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/6
 * 时间: 16:42
 */

namespace app\api\validate;


class PhoneValidate extends BaseValidate
{
    protected $rule =[
        'phone' => 'require|isMobile'
    ];

    protected $message = [
        'phone' => '手机号码格式错误'
    ];
}