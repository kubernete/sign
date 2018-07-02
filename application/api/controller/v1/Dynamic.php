<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/21
 * 时间: 20:21
 */

namespace app\api\controller\v1;


use app\api\service\DynamicService;
use app\common\model\Attention;
use app\lib\exception\ParameterException;
use think\Controller;
use app\common\model\Zan as ZanModel;
use app\common\model\Dynamic as DynamicModel;
class Dynamic extends BaseAuth
{
    /**
     * 获取所有的动态
     * @return array
     */
    public function allDynamic()
    {
        $dynamicService = new DynamicService();
        $returnDynamics = $dynamicService->getFriendsDynamic();

        $zanModel = new ZanModel();
        $attentionModel = new Attention();

        $dynamics = [];
        foreach ($returnDynamics as $key => $returnDynamic)
        {
            $data = [
              'dynamic_id' => $returnDynamic['dynamic_id'],
              'user_id' => $this->user['id']
            ];

            $zan = $zanModel->where($data)->find();

            $returnDynamic['isStar'] = $zan? true:false;

            $attention = $attentionModel->where($data)->find();

            $returnDynamic['isFollow'] = $attention? true:false;
            $dynamics[] = $returnDynamic;
        }
        return $dynamics;

    }

    /**
     *  点击增加点击量
     *
     */
    public function clickNumAdd()
    {
        $param = request()->param();

        if (empty($param['dynamic_id'])){
            throw new ParameterException([
                'msg' => '没有dynamic_id参数'
            ]);
        }

        $dynamic = new DynamicModel();
        $clickNumInc = $dynamic->increaseClickNum();
        if ($clickNumInc)
        {
            return 'yes';
        }
        else{
            return 'no';
        }

    }

    /**
     * 点赞
     * @return string
     */
    public function clickZan()
    {
        $dynamic_id = input('param.dynamic_id', 0, 'intval');
        // user_id 为点赞的人的ID
        $data = [
          'dynamic_id' => $dynamic_id,
          'user_id' => $this->user['id']
        ];
        $zanModel = new ZanModel();
        $zan = $zanModel->where($data)->find();

        if ($zan)
        {
            return 'no';
        }

        try{
           $zans = $zanModel->addData($data);
           if ($zans)
           {
               return 'yes';
           }else{
               return 'no';
           }

        }catch (\Exception $e)
        {
            return 'no';
        }


    }

    /**
     * 取消赞
     * @return string
     */
    public function cancelZan()
    {
        $dynamic_id = input('param.dynamic_id', 0, 'intval');
        // user_id 为点赞的人的ID
        $data = [
            'dynamic_id' => $dynamic_id,
            'user_id' => $this->user['id']
        ];

        $zanModel = new ZanModel();
        $zan = $zanModel->where($data)->delete();
        if ($zan)
        {
            return 'yes';
        }else{
            return 'no';
        }

    }

    /**
     * 关注动态
     * @return string
     */
    public function attentionDynamic()
    {
        $dynamic_id = input('param.dynamic_id', 0, 'intval');
        // user_id 为点赞的人的ID
        $data = [
            'dynamic_id' => $dynamic_id,
            'user_id' => $this->user['id']
        ];

        $attentionModel = new Attention();
        $attention = $attentionModel->where($data)->find();
        if ($attention)
        {
            return 'no';
        }

        try{
            $attentions = $attentionModel->addData($data);
            if ($attentions)
            {
                return 'yes';
            }else{
                return 'no';
            }

        }catch (\Exception $e)
        {
            return 'no';
        }

    }

    /**
     * 取消动态关注
     * @return string
     */
    public function cancelAttention()
    {
        $dynamic_id = input('param.dynamic_id', 0, 'intval');
        // user_id 为点赞的人的ID
        $data = [
            'dynamic_id' => $dynamic_id,
            'user_id' => $this->user['id']
        ];

        $attentionModel = new Attention();
        $attention = $attentionModel->where($data)->delete();
        if ($attention)
        {
            return 'yes';
        }else{
            return 'no';
        }
    }



}