<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/3
 * 时间: 10:43
 */

namespace app\lib\processor;


use think\Cache;

class OAuthProcessor
{

    public function setSign($data)
    {
        // 1.升序排序数组
        ksort($data);
        // 2.拼装成url 比如 device_id=1&app_type=android
        $raw = http_build_query($data);
        // 3.加密
        $sign = (new AesProcessor())->encrypt($raw);
        return $sign;
    }

    public function checkSign($data)
    {
        if(!$data)
        {
            return false;
        }
        $raw = (new AesProcessor())->decrypt($data['sign']);

        if (empty($raw))
        {
            return false;
        }

        parse_str($raw, $array);
        if (!is_array($array) ||
            empty($array['device_id']) ||
            $array['device_id'] != $data['device_id'])
        {
            return false;
        }

        if (empty($array['app_type']) ||
            $array['app_type'] != $data['app_type'])
        {
            return false;
        }

        if (!config('app_debug'))
        {

            if ((time() - ceil($array['time'] / 1000)) > config('app.cache_time'))
            {
                return false;
            }

            // 缓存时间
            if (Cache::get($data['sign']))
            {
                return false;
            }
        }
        return true;
    }

    public static function tokenGeneration()
    {
       return sha1(uniqid(microtime(),true).config('app.token_salt'));
    }

}