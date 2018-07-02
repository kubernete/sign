<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/5
 * 时间: 20:17
 */

namespace app\common\model;


use think\Model;

class User extends Base
{
    public function userImg()
    {

    }

    /**
     * 获取用户信息通过邮箱
     * @param $email
     * @return array|false|\PDOStatement|string|Model
     */
    public function getUserByEmail($email)
    {
        $getEmail = $this->where('email', '=', $email)
            ->find();
        return $getEmail;
    }

    /**
     * 更新昵称通过token
     * @param $token
     * @return array|false|\PDOStatement|string|Model
     */
    public function updateNicknameByToken($token)
    {
        $updateNickname = $this->where('token', '=', $token)->find();
        return $updateNickname;
    }

    public function getEmailByToken($token = '')
    {
        $user = self::where('token', '=',$token)->find();
        return $user['email'];
    }

    /**
     * 通过邮箱和密码获取用户信息
     * @param $email
     * @param $password
     * @return array|false|\PDOStatement|string|Model
     */
    public function getUserByEmailPassword($email, $password)
    {
        $getUser = $this
            ->where(['password' => md5($password), 'email' => $email])
            ->find();
        return $getUser;
    }


    /**
     * 根据id查询用户信息
     * @param array $userIds
     * @return false|\PDOStatement|string|\think\Collection
     */
    public function getUserInfoByUserIds($userIds = [])
    {
        $data = [
            'id' => ['in', implode(',',$userIds)],
            'status' => 1,
        ];

        $order = [
          'id' => 'desc'
        ];
        return $this->where($data)
            ->field(['id', 'nickname', 'image'])
            ->order($order)
            ->select();
    }


}