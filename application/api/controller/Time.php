<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/3
 * 时间: 14:09
 */

namespace app\api\controller;


use think\Controller;

class Time extends Controller
{
    public function index()
    {
        return time();
    }
}