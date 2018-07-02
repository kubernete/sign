<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/21
 * 时间: 15:10
 */

namespace app\api\service;


use app\common\model\Region;

class RegionService
{
    public $region = '';

    public function __construct()
    {
        $this->region = new Region();
    }

    /**
     * 获取省和其对应的城市
     * @return array
     */
    public function getProvincesCities()
    {
        $provinces = $this->region->getProvince();
        $objectList = [];
        $cityAreas = $this->region->getCityAreas();
        foreach ($provinces as $key => $province)
        {
            $objectList[$province['region_name']] = [];
            foreach ($cityAreas as $k => $cityArea)
            {
                if ($cityArea['parent_id'] == $province['region_id']
                    && $cityArea['parent_id'] != 2
                    && $cityArea['parent_id'] != 3
                    && $cityArea['parent_id'] != 10
                    && $cityArea['parent_id'] != 23
                )
                {
                    array_push($objectList[$province['region_name']], $cityArea['region_name']);
                }
            }
        }
        return $objectList;
    }

}