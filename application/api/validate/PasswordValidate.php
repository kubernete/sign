<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/7
 * 时间: 0:15
 */

namespace app\api\validate;


use app\lib\exception\PasswordException;

class PasswordValidate extends BaseValidate
{
    protected $rule = [
        'password' => "require|length:6,20",
    ];

    /**
     * PasswordValidate constructor. 校验是否是传入的数组和两次密码是否一致
     * @param array $rules
     * @param array $message
     * @param array $field
     * @throws PasswordException
     */
    public function __construct(array $rules = [], array $message = [], array $field = [])
    {
        parent::__construct($rules, $message, $field);
        if (!is_array($rules)){
            throw new PasswordException([
                'msg' => '传入不是数组'
            ]);
        }

    }



}