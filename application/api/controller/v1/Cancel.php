<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/7/4
 * 时间: 9:44
 */

namespace app\api\controller\v1;


class Cancel extends BaseAuth
{
    public function cancelToken()
    {
        $this->user['token'] = '';
        try{
            $u = model('user')->save(['token' => $this->user['token']], ['id' => $this->user['id']]);
            if (!$u)
            {
                return 'no';
            }
        }catch (\Exception $e)
        {
            return 'no';
        }

        return 'yes';
    }
}