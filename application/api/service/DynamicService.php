<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/22
 * 时间: 2:22
 */

namespace app\api\service;


use app\common\model\Dynamic;
use app\common\model\User;

class DynamicService
{
    /**
     * 获取朋友动态
     * @return array
     */
    public function getFriendsDynamic()
    {
        $dynamicModel = new Dynamic();
        // 获取动态信息
        $dynamics = $dynamicModel
            ->getDynamicByClickNum();

        $newIds = [];
        foreach ($dynamics as $key => $dynamic)
        {
            $newIds[] = $dynamic['user_id'];
        }

        // 获取用户信息
        $userModel = new User();
        $users = $userModel->getUserInfoByUserIds($newIds);

        $newList = [];

        // user信息和dynamic信息拼接
        foreach ($dynamics as $key => $dynamic)
        {
            foreach ($users as $k => $user)
            {
                if ($user['id'] == $dynamic['user_id']){
                    $newList[] = [
                        'dynamic_id' => $dynamic['dynamic_id'],
                        'portrait' => $user['image'],
                        'nickname' => $user['nickname'],
                        'time' => date("Y-n-d", $dynamic['create_time']),
                        'content' => $dynamic['content'],
                        'lookNum' => $dynamic['click_num'], // 点击量
                        'starNum' => $dynamic['star_num'],
                    ];
                }

            }
        }

        return $newList;

    }

}