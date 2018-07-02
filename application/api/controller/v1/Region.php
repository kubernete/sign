<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/21
 * 时间: 15:28
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;

use app\api\service\RegionService;
use app\common\model\Region as RegionModel;

/**
 * 获取地区信息
 * Class Region
 * @package app\api\controller\v1
 */
class Region extends BaseController
{
    /**
     * 返回省和对应的城市
     * @return array
     */
    public function ProvincesCity()
    {
        $region = new RegionModel();
        $provinceList = $region->getProvincesList();

        $regionService = new RegionService();
        $provinceCities = $regionService->getProvincesCities();

        $data = [
            'provinces' => $provinceList,
            'city' => $provinceCities
        ];
        return $data;
    }
}