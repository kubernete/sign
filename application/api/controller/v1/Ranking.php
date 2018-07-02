<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/27
 * 时间: 15:24
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\RankingService;

class Ranking extends BaseController
{
    /**
     * 用户上周与本周的小时排名
     * @return array
     */
    public function lastThisWeekRanking()
    {
        list($lastWeekRanking, $thisWeekRanking) = RankingService::thisLastWeekRankingList();
        return [
            [
                // 本周
                'weekly' => 0,
                'userRankingList' => $thisWeekRanking,
            ],
            [
                // 上周
                'weekly' => -1,
                'userRankingList' => $lastWeekRanking,
            ],
        ];

    }
}