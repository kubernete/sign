<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/18
 * 时间: 19:22
 */

namespace app\api\validate;


class StudentIDValidate extends BaseValidate
{
    protected $rule = [
        'student_id' => 'require|isPositiveInteger'
    ];

    protected $message = [
        'student_id' => '学号12位且正整数数字'
    ];
}