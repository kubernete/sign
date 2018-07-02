<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/5
 * 时间: 16:46
 */

namespace app\api\service;


use app\api\validate\EmailValidate;
use app\api\validate\PasswordValidate;
use app\common\model\User;
use app\lib\Code;
use app\lib\exception\BaseException;
use app\lib\exception\EmailException;
use app\lib\exception\ParameterException;
use app\lib\processor\OAuthProcessor;
use think\Cache;
use think\Request;


class LoginService
{
    /**
     *  接受的邮箱参数,校验邮箱是否存在数据库的过程
     * @return array|false|\PDOStatement|string|\think\Model
     */
    public function checkEmailExistence()
    {
        $right = null;
        (new EmailValidate())->toCheck();
        $param = Request::instance()->param();
        $is_email = array_key_exists('email', $param) && $param['email'];
        if (!$is_email){
            throw new EmailException();
        }
        $user = new User();
        $right = $user->getUserByEmail($param['email']);
        return $right;
    }

    public function checkSamePassword()
    {
        $param = Request::instance()->param();

        // 有再次密码的规则
        $rule = [
            'password' => "require|length:6,20",
            're_password' => "require|length:6,20",
        ];
        if (!array_key_exists('password', $param)){
            throw new BaseException([
                'msg' => '缺少password参数'
            ]);
        }
        if (!array_key_exists('re_password', $param))
        {
            throw new BaseException([
                'msg' => '缺少re_password的参数'
            ]);
        }
        (new PasswordValidate($rule))->toCheck();
        if ($param['password'] != $param['re_password']){
            throw new EmailException([
                'msg' => '两个密码不一致'
            ]);
        }

    }

    /**
     * 缓存验证码，并返回验证码。
     * @param $str
     * @param int $length
     * @return string
     * @throws BaseException
     */
    public function cacheCodeToReturn($str, $length = 4)
    {
        if (!is_string($str))
        {
            throw new BaseException([
                'msg' => 'str必须是字符串'
            ]);
        }
        $code = Code::getRandNumCode($length);

        if (Cache::set($str, $code, config('code.cache_time')))
        {
            return $code;
        }else{
            throw new BaseException([
                'msg' => '失败'
            ]);
        }

    }

    /**
     * 检查验证码
     * @return bool
     * @throws BaseException
     */
    public function checkEmailCode()
    {
        $param = Request::instance()->param();
        $header = Request::instance()->header();

        $email = '';
        if (!empty($header['token']))
        {
            $email = (new User())->getEmailByToken($header['token']);
            if (!$email)
            {
                return false;
            }

        }
        if (!empty($param['email']))
        {
            $email = $param['email'];
        }

        if (empty($email))
        {
            return false;
        }

        if (!array_key_exists('validateCode', $param) )
        {
            throw new BaseException([
                'msg' => 'validateCode字段不存在'
            ]);
        }
        if (Cache::get($email) != $param['validateCode'])
        {
            throw new BaseException([
                'msg' => '验证码错误'
            ]);
        }
        return true;

    }





    /**
     * 这是在已经检测邮箱和密码正确后, 保存新的token
     * @return string $token
     * @throws BaseException
     * @throws ParameterException
     */
    public function byPasswordLoginToToken()
    {
        $param = request()->param();

        $user = new User();

        $getEmailUser = $user->getUserByEmail($param['email']);

        if (!$getEmailUser){
            throw new ParameterException([
                'msg' => '邮箱没有注册'
            ]);
        }

        $getUser = $user->getUserByEmailPassword($param['email'], $param['password']);
        if (!$getUser)
        {
            throw new ParameterException([
                'msg' => '密码错误'
            ]);
        }

        $token = OAuthProcessor::tokenGeneration();

        $saveData = [
            'token' => $token,
            'time_out' => strtotime("+".config('app.login_time_out_day')." days")
        ];
        try{
            $user->save($saveData, ['id' => $getUser->id]);

        }catch (\Exception $e)
        {
            throw new BaseException([
                'msg' => $e->getMessage()
            ]);
        }
        return $token;

    }



}