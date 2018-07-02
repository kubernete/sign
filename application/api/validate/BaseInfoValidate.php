<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/19
 * 时间: 19:45
 */

namespace app\api\validate;


class BaseInfoValidate extends BaseValidate
{
    public $rule = [
        'sex' => 'require|isOneOrZero',
        'nickname' => "require|length:1,30",
        'birthday' => "require|isPositiveInteger",
        'address' => "require|length:1,255",
        'signature' => "require|length:1,255",
        'school' => "require|length:1,30",
        'department' => "require|length:1,50",
        'major' => "require|length:1,50",
        'team' => "require|length:1,50",
        'num' => 'require|isPositiveInteger',
    ];

    /**
     * 数据是1还是2
     * @param $value
     * @return bool
     */
    protected function isOneOrZero($value)
    {
        if (!$value || is_int($value)){
            return false;
        }
        if ($value == 1 || $value == 0)
        {
            return true;
        }else{
            return false;
        }

    }

//    protected function isTimeStamp($value)
//    {
//
//    }

}