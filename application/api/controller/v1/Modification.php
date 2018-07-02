<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/7
 * 时间: 22:44
 */

namespace app\api\controller\v1;


use app\api\service\Modify;
use think\Controller;
use think\Request;

class Modification extends BaseAuth
{
    /**
     * 修改用户信息
     * @return array
     */
    public function infoChange()
    {
        $param = Request::instance()->param();

        $modify = new Modify();
        // 修改用户信息, 需要用户和参数
        $data = $modify->modifyBaseInfo($param, $this->user);

        return $data;

    }
}