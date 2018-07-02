<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/20
 * 时间: 13:56
 */

namespace app\common\model;



class Region extends Base
{
    /**
     * 获取省份
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getProvince()
    {
        $provinces = $this->where('parent_id', '=', 1)
            ->field(['region_name', 'region_id', 'parent_id'])
            ->select();
        return $provinces;
    }

    /**
     * 获得省的列表
     * @return array
     */
    public function getProvincesList()
    {
        $provinces = $this->getProvince();
        $list = [];
        foreach ($provinces as $key => $value)
        {
            array_push($list, $value['region_name']);
        }
        return $list;
    }

//    public function getProvinceCity()
//    {
//        $proLists = $this->getProvince();
//        $newList = [];
//        foreach ($proLists as $proList)
//        {
//            if ($proList['parent_id'] == 1)
//            {
//                $newList[$proList['region_name']] = 1;
//            }
//
//        }
//        return $newList;
//    }

    /**
     * 获得所有市区
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getCityAreas()
    {
        $cityAreas = $this->where('parent_id', '>', 3)
            ->field(['region_name', 'region_id', 'parent_id'])
            ->select();
       return $cityAreas;
    }



}