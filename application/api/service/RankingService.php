<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/27
 * 时间: 16:18
 */

namespace app\api\service;


use app\common\model\User;
use app\lib\Time;

class RankingService
{

    /**
     * 上周和这周的用户信息，用户总时间（可以扩展where的条件参数）
     * @return array
     */
    public static function thisLastWeekRankingList()
    {
        $signs = model('sign')
 //         ->where()
//            ->where('sign_time', '>', 0)
            ->whereTime('sign_time', 'this week last week')
            ->select();

        $userIds = [];

        // 签名信息中提取user_id
        if ($signs)
        {
            foreach ($signs as $sign)
            {
                $userIds[] = $sign['user_id'];
            }
            $userIds = array_unique($userIds);
        }
        $userModel = new User();
        $users = $userModel->getUserInfoByUserIds($userIds);
        $usersInfo = [];
        if ($users)
        {
            foreach ($users as $user)
            {
                $usersInfo[$user->id] = $user;
            }
        }
        // 上周始末时间
        $lastWeekStart = strtotime("last week Monday 00:00:00");
        $lastWeekEnd = strtotime("last week Sunday 23:59:59");

        // 本周始末时间
        $thisWeekStart = strtotime("this week Monday 00:00:00");
        $thisWeekEnd = strtotime("this week Sunday 23:59:59");

        $lastWeekData = [];
        $thisWeekData = [];

        $userLastWeekHours = [];
        $userThisWeekHours = [];

        // 用户签到时间总计初始化
        foreach ($signs as $sign)
        {
            $userLastWeekHours[$sign['user_id']] = 0;
            $userThisWeekHours[$sign['user_id']] = 0;
        }

        // 各个用户的上周时间累积，这周时间累积
        foreach ($signs as $sign)
        {
            if ($sign['leave_time'] > 1)
            {
                if ( $sign['sign_time'] > $lastWeekStart  &&  $sign['sign_time'] < $lastWeekEnd )
                {
                    $char = $sign['leave_time'] - $sign['sign_time'];
                    $userLastWeekHours[$sign['user_id']] += $char;
                }

                if ($sign['sign_time'] > $thisWeekStart  &&  $sign['sign_time'] < $thisWeekEnd)
                {
                    $char = $sign['leave_time'] - $sign['sign_time'];
                    $userThisWeekHours[$sign['user_id']] += $char;
                }

            }
        }

        foreach ($users as $user)
        {

            $lastWeekData[] = [
                "portraitUrl" => $user['image'],
                'nickname' => $user['nickname'],
                'hours' => $userLastWeekHours[$user['id']],
            ];

            $thisWeekData[] = [
                "portraitUrl" => $user['image'],
                'nickname' => $user['nickname'],
                'hours' => $userThisWeekHours[$user['id']],
            ];
        }
        // 排序时间最长组成新数组
        $newLastWeekData = self::insertionSortByHours($lastWeekData);
        $newThisWeekData = self::insertionSortByHours($thisWeekData);
        return [
          $newLastWeekData,$newThisWeekData
        ];

    }

    /**
     * 排序某个数组，必须含有hours参数，且为时间戳，并转为小时带2位的小数点，并附上placing参数来显示排名第几
     * @param array $arrays
     * @return array
     */
    public static function insertionSortByHours($arrays = [])
    {

        foreach ($arrays as $key => $array)
        {
            if (!array_key_exists('hours', $array))
            {
                return [];
            }
            $i = $key;
            for (;$i > 0 && $arrays[$i-1]['hours'] < $array['hours'] ; $i--)
            {
                $arrays[$i] = $arrays[$i-1];
            }

            $arrays[$i] = $array;
        }
        $newArrays = [];
        foreach ($arrays as $key => $array)
        {
            $newArrays[] =
                [
                    'portraitUrl' => $array['portraitUrl'],
                    'placing' => $key + 1,
                    'hours' =>  Time::timeStampToHour($array['hours'])
                ];

//            $array['placing'] = $key + 1;
//            $array['hours'] = Time::timeStampToHour($array['hours']);

        }

        return $newArrays;
    }


}