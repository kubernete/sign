<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/22
 * 时间: 2:14
 */

namespace app\common\model;


class Dynamic extends Base
{
    public function getDynamicByClickNum()
    {
        return $this
            ->field(['dynamic_id', 'user_id', 'create_time', 'content', 'click_num', 'star_num'])
            ->order(['click_num' => 'desc'])
            ->select();
    }

    /**
     * 增加点击量
     * @return int|true
     */
    public function increaseClickNum()
    {
        $param = request()->param();
        if (empty($param['dynamic_id']))
        {
            return 'no';
        }
        $increase = model('dynamic')
            ->where('dynamic_id', '=', $param['dynamic_id'])
            ->setInc('click_num');
        return $increase;
    }

}