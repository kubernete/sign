<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/3
 * 时间: 11:36
 */

namespace app\lib;


class Time
{
    /** 获得13位的时间
     * @return string
     */
    public static function get13Time()
    {
        list($t1,$t2) = explode(' ',microtime());

        return $t2.ceil($t1*1000);
    }


    /**
     * 获取本周开始时间戳
     * @return false|int
     */
    public static function getThisWeekStartTimeStampByTime()
    {
        return strtotime("this week Monday");
    }

    /**
     * 获取本周结束时间戳
     * @return false|int
     */
    public static function getThisWeekEndTimeStampByTime()
    {
        return  strtotime("this week Sunday") + 24*3600 -1 ;
    }

    /**
     * 获取上周开始时间戳
     * @return false|int
     */
    public static function getLastWeekStartTimeStampByTime()
    {
        return strtotime("last week Monday");
    }

    /**
     * 获取上周结束时间戳
     * @return false|int
     */
    public static function getLastWeekEndTimeStampByTime()
    {
        return  strtotime("last week Sunday") + 24*3600 -1 ;
    }


    /**
     * 获取时间戳的当天开始时间
     * @param int $time
     * @return bool|false|int
     */
    public static function getDayStartTimeByTimeStamp($time = 0)
    {
        if ($time <= 0)
            $time = time();
        $is_right = self::isPositiveInteger($time);
        if ($is_right){
            $startTime = strtotime(date("Y-m-d 00:00:00", time()));
            return $startTime;
        }else{
            return false;
        }

    }

    /**
     * 获取时间戳的当天开始时间
     * @param int $time
     * @return bool|false|int
     */
    public static function getDayEndTimeByTimeStamp($time = 0)
    {
        if ($time <= 0)
            $time = time();
        $is_right = self::isPositiveInteger($time);
        if ($is_right){
            $endTime = strtotime(date("Y-m-d 23:59:59", time()));
            return $endTime;
        }else{
            return false;
        }

    }


    /**
     * 根据时间戳转换为小时带一位数
     *
     * @param int $time
     * @return bool|float|string
     */
    public static function timeStampToHour($time = 0)
    {
        $is_right = self::isPositiveInteger($time);
        if ($is_right){
            $hourTime = intval($time / 3600)  . ".". intval(($time % 3600) / 3600*10);
            $hourTime = floatval($hourTime);
            return $hourTime;
        }else{
            return 0;
        }

    }

    /**
     * 检查时间戳是否是正整数
     * @param $time
     * @return bool
     */
    public static function isPositiveInteger($time)
    {
        if (is_numeric($time) && is_int($time + 0) && ($time + 0) > 0)
        {
            return true;
        }
        else{
            return false;
        }
    }

    /**
     * 返回所有英文星期，从星期一到星期天
     * @return array
     */
    public static function getAllEnglishWeek()
    {
        $allWeeks = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
        return $allWeeks;
    }

    /**
     *
     * @param int $month
     * @param int $year
     * @return bool|int
     */
    public static function getLastDayByYearMonth($month = 1, $year = 2015)
    {
        if ( !self::isPositiveInteger($month) || !self::isPositiveInteger($year)
        || $month > 12 || strlen($year) != 4){
            return false;
        }

        return cal_days_in_month(CAL_GREGORIAN, $month,$year);
    }

}