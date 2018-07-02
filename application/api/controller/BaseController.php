<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/2
 * 时间: 19:21
 */

namespace app\api\controller;


use app\lib\exception\HeaderException;
use app\lib\processor\OAuthProcessor;
use think\Cache;
use think\Controller;
use think\Request;

/**
 * 基类 含有公共函数和headers信息基本校验
 * Class BaseController
 * @package app\api\controller
 */
class BaseController extends Controller
{
    /**
     * 头部信息headers
     * @var string/array
     */
    public $headers = '';

    public function _initialize()
    {
        // $this->checkRequestAuth();
        $headers = request()->header();
        if ($headers){
            $this->headers = $headers;
        }

    }


    public function checkRequestAuth()
    {
        // header头里面必须带有device_id, app_type, 和 sign字段,app_type详情请见extra文件夹的app.php

        $headers = Request::instance()->header();

        if (empty($headers['sign']))
        {
            throw new HeaderException([
                'msg' => 'sign不存在'
            ]);
        }

        if (!in_array($headers['app_type'], config('app.app_types')))
        {
            throw new HeaderException([
                'msg' => 'app_type不合法'
            ]);
        }

        $is_right = (new OAuthProcessor())->checkSign($headers);
        if(!$is_right)
        {
            throw new HeaderException([
                'msg' => 'sign授权失败'
            ]);
        }


        Cache::set($headers['sign'], 1, config('app.cache_time'));

        $this -> headers = $headers;


    }
}