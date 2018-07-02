<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/26
 * 时间: 10:03
 */

namespace app\api\service;


use app\lib\Time;

class SignService
{
    /**
     * 列出签到的时间，根据年月
     * @param int $uid
     * @param int $month
     * @param int $year
     * @return array|bool
     */
    public static function listOutSignDays($uid = 1,$month = 1, $year = 2018)
    {
        if ( !Time::isPositiveInteger($month) || !Time::isPositiveInteger($year)
            || $month > 12 || strlen($year) != 4){
            return false;
        }
        $day = cal_days_in_month(CAL_GREGORIAN, $month,$year);

        $signs = model('sign')
            ->where(['user_id' => $uid])
            ->whereTime('create_time', 'between',
                [$year.'-'.$month.'-1 00:00:00', $year.'-'.$month.'-'.$day.' 23:59:59'])
            ->select();
        $manyDays = [];
        foreach ($signs as $sign)
        {
            $manyDays[] = (int)date('d',$sign['sign_time']);
        }
        return $manyDays;
    }

    /**
     * 检查最新数据是否签到没有点击离开
     * @param int $user_id
     * @return bool
     */
    public static function checkSignWorkable($user_id = 1)
    {
        $data = [
            'user_id' => $user_id
        ];

        $order = [
            'id' => 'desc'
        ];
        $sign = model('sign')->where($data)->order($order)->find();
        // 签到存在且leave_time小于1
        if ($sign && ( empty($sign->leave_time) || $sign->leave_time < 1) )
        {
            return false;
        }
        // sign_time不存在或者小于1
        if ($sign && (empty($sign->sign_time) || $sign->sign_time < 1))
        {
            return false;
        }
        return true;
    }

    /**
     * 检查最新数据是否存在签到离开
     * @param int $user_id
     * @return bool
     */
    public static function checkLeaveWorkable($user_id = 1)
    {
        $data = [
            'user_id' => $user_id
        ];

        $order = [
            'id' => 'desc'
        ];
        $sign = model('sign')->where($data)->order($order)->find();
        // 签到不为空
        if (!$sign)
        {
            return false;
        }
        // sign_time 为空或者小于 1
        if (empty($sign->sign_time) || $sign->sign_time < 1)
        {
            return false;
        }
        // leave_time不为空且大于0
        if ( !empty($sign->leave_time) && $sign->leave_time > 0  )
        {
            return false;
        }
        return true;
    }

    /**
     * 根据时间,比如20180312,获取当天的签到离开时间
     * @param $uid
     * @param int $time
     * @return array
     */
    public static function OneDaySignLeaveSituationGet($uid, $time = 0)
    {
        $time = date('Y-m-d',strtotime($time));
        $signs = model('sign')
            ->where('user_id', '=', $uid)
            ->whereTime('create_time','between',[$time.' 00:00:00', $time.' 23:59:59'])
            ->order(['id' => 'aes'])
            ->select();

        $signLeave = [];
        foreach ($signs as $sign)
        {
            $signLeave[]= [
                'come' => $sign['sign_time'],
                'move' => $sign['leave_time'],
            ];
        }
        return $signLeave;

    }





}