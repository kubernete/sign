<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/22
 * 时间: 2:19
 */

namespace app\common\model;


class Zan extends Base
{
    public function getCountByDynamicId($id = 1)
    {
        return $this->where('dynamic_id')->count();
    }
}