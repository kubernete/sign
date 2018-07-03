<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/25
 * 时间: 15:41
 */

namespace app\api\controller\v1;

use app\common\model\Sign as SignModel;

class Info extends BaseAuth
{
    /**
     * 返回用户基本信息
     */
    public function baseInfoGet()
    {

        $user = model('user')
            ->where(['id' => $this->user['id']])
            ->field(['nickname', 'sex', 'birthday', 'address',
                'signature', 'school', 'department', 'major', 'team', 'num'])
            ->find();

        if (!empty($user['birthday']))
        {
            $user['birthday'] = date('Y-m-d', $user['birthday']);
        }
        return $user;
    }

    /**
     * 返回用户的签到离开状态和这周累计签到时间
     * @return array
     */
    public function statusGetTotal()
    {
        $signModel = new SignModel();

        // 签到：0 离开：1
        $status = $signModel->getUserSignSituationById($this->user['id']);

        $sign_times = $signModel->whereTime('sign_time', 'week')->select();

        $total = $signModel->thisWeekTotalTime($this->user['id']);

        return [
          'status' => $status,
          'total' => $total,
        ];

    }

    /**
     * 获取用户图片地址
     * @return
     */
    public function imgUrlGet()
    {
        $image =  $this->user['image']?$this->user['image']:'moRen.jpg';
        if (!$image)
        {
            return null;
        }
        $api = config('api.api_url');
        $source = config('api.source_url');
        $imgUrl = config('api.api_url').config('api.source_path').$image;
        return $imgUrl;
    }

}