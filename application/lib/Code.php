<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/6
 * 时间: 19:25
 */

namespace app\lib;


class Code
{
    /**
     *  获取$num位的随机数字验证码
     * @param int $num
     * @return string
     */
    public static function getRandNumCode($num = 4)
    {
        $str = '1234567890';
        $newStr = '';
        for ($i = 0; $i < $num;$i ++){
            $newStr .= $str[rand(0, strlen($str) - 1)];
        }
        return $newStr;

    }

}