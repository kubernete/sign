<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/18
 * 时间: 15:54
 */

namespace app\common\model;


use app\lib\exception\ParameterException;
use think\Model;

class Base extends Model
{
    protected $autoWriteTimestamp = true;

    /**
     *  新增数据
     * @param $data
     * @return mixed
     * @throws ParameterException
     */
    public function addData($data)
    {
        if (!is_array($data)){
            throw new ParameterException();
        }
        $this->allowField(true)->save($data);
        return $this->id;
    }

}