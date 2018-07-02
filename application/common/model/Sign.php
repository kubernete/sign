<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/20
 * 时间: 13:56
 */

namespace app\common\model;


use app\lib\Time;

class Sign extends Base
{
    protected $autoWriteTimestamp = true;

    /**
     * 根据用户ID获取签到状态
     * 签到：0
     * 离开：1
     * @param int $id
     * @return int
     */
    public  function getUserSignSituationById($id = 1)
    {
        $data = [
            'user_id' => $id,
        ];
        $order = [
            'id' => 'desc'
        ];
        $situation = $this->where($data)->order($order)->find();
        if (!$situation || $situation['leave_time'] > 0)
        {
            // 离开状态码： 1
            return 1;
        }
        // 签到状态码：0
        return 0;
    }

    /**
     * 计算这周签到总共时间
     * @param $uid
     * @return bool|float|int|string
     */
    public function thisWeekTotalTime($uid = 1)
    {
        $sign_times = $this
            ->where('user_id' , '=', $uid)
            ->whereTime('sign_time', 'week')
            ->select();
        $total = 0;
        foreach ($sign_times as $sign_time)
        {
            if ($sign_time['leave_time'] > 1)
            {
                $cha = $sign_time['leave_time'] - $sign_time['sign_time'];

                $total = $total + $cha;
            }
        }
        $total = Time::timeStampToHour($total);
        return $total;
    }


}