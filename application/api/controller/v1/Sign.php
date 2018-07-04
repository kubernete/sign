<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/19
 * 时间: 2:16
 */

namespace app\api\controller\v1;


use app\api\controller\BaseController;
use app\api\service\SignService;
use app\api\service\Upload;
use app\lib\exception\ParameterException;
use app\lib\Time;

class Sign extends BaseAuth
{
    /**
     * 签到
     * @return string
     */
    public function toSign()
    {
        $checkLeaveSign = SignService::checkSignWorkable($this->user['id']);
        if (!$checkLeaveSign)
        {
            return '还没有签到过的没有点击离开';
        }

        $data = [
            'sign_time' => time(),
            'user_id' => $this->user['id'],
        ];
        try{
            $sign = model('sign')->data($data)->save();
            if (!$sign){
                return '签到失败';
            }
        }catch (\Exception $e)
        {
            return '签到错误';
        }

        return 'yes';
    }

    /**
     * 离开
     * @return string
     */
    public function toLeave()
    {
        $checkLeave = SignService::checkLeaveWorkable($this->user['id']);
        if (!$checkLeave)
        {
            return '还没有签到过的点击离开';
        }
        $where = [
          'user_id' => $this->user['id']
        ];
        $leave = model('sign')
            ->where($where)
            ->order(['id' => 'desc'])
            ->find();
        $id = $leave->id;
        $data = [
            'leave_time' => time(),

        ];
        try{
            $leaves = model('sign')
                ->save($data,['id' => $id]);
            if (!$leaves)
            {
                return '离开失败';
            }
        }catch (\Exception $e)
        {
            return '离开错误';
        }

        $newLeave = model('sign')
            ->where(['id' => $id])
            ->find();
        $newTime = $newLeave->leave_time - $newLeave->sign_time;

        return $newTime;

    }

    /**
     * 获取当天每次的签到离开时间
     * @return array
     * @throws ParameterException
     */
    public function getDaySignSituation()
    {
        $param = request()->param();

        if (empty($param['time']))
        {
            throw new ParameterException([
                'msg' => '缺少time参数',
            ]);
        }

        if (strlen($param['time']) != 8 || !Time::isPositiveInteger($param['time']))
        {
            $strlen = strlen($param['time']);
            $strlens = Time::isPositiveInteger($param['time']);
            throw new ParameterException([
                'msg' => 'time参数不符合规范'
            ]);
        }
        $signLeave = SignService::OneDaySignLeaveSituationGet($this->user['id'],$param['time']);

        return $signLeave;
    }

    /**
     * 根据年和月查出月签到的有哪几号
     * @return array|bool|string
     * @throws ParameterException
     */
    public function comeDays()
    {

        // 检查年月的正确性
        $month = input('param.month', 1, 'intval');
        $year = input('param.year', 1, 'intval');

        $day = cal_days_in_month(CAL_GREGORIAN, $month,$year);
        if (!$day)
        {
            throw new ParameterException([
                'msg' => 'month，year有一个不规范'
            ]);
        }

        $list = SignService::listOutSignDays($this->user['id'], $month, $year);
        $list = array_unique($list);
        if (empty($list))
        {
            return 'no';
        }
        return $list;

    }


}