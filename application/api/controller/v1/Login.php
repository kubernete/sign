<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/1
 * 时间: 19:26
 */

namespace app\api\controller\v1;


use app\api\service\MailService;
use app\api\service\LoginService;
use app\api\validate\EmailValidate;
use app\api\validate\PasswordValidate;
use app\common\model\User;
use app\lib\Code;
use app\lib\exception\BaseException;
use app\lib\exception\EmailException;
use app\lib\exception\ParameterException;
use app\lib\exception\PasswordException;
use app\lib\exception\TokenException;
use app\lib\processor\OAuthProcessor;
use think\Cache;
use think\Controller;
use think\Request;

class Login extends Controller
{
    /**
     * 初始输入邮箱，进行邮箱是否存在的校验
     */
    public function checkEmailExist()
    {
        $token = new LoginService();
        $existence = $token->checkEmailExistence();
        if (!$existence)
        {
            return 'yes';
        }else{
            return 'no';
//            throw new EmailException([
//                'msg' => '邮箱存在'
//            ]);
        }
    }

    /**
     * 发送邮箱 , 保存验证码
     * @return string
     * @throws EmailException
     */
    public function sendMail()
    {
        // 1.检测传输数据是否规范
        // 2.生成验证码发送邮箱
        // 3.返回状态

        // 检测邮箱
        (new EmailValidate())->toCheck();
        $param = Request::instance()->param();
        $headers = Request::instance()->header();
        $token = new LoginService();
        // 检查密码
//        $token->checkSamePassword();
        $email = '';
        if (array_key_exists('email', $param)){
            $email = $param['email'];
        }
        if (!empty($headers['token'])){
            $email = (new User())->getEmailByToken($headers['token']);
            if (!$email)
            {
                return 'no';
            }

        }
        if (empty($email))
        {
            return 'no';
        }

        // 生成，缓存验证码并返回
        $code = $token->cacheCodeToReturn($email);
        // 发送邮箱
        $mailService = new MailService();
        $mail = $mailService->sendMail($email, '新叶签到','给您的验证码是：'.$code.'，时效只有三分钟');
        if (!$mail)
        {
            throw new  EmailException([
                'msg' => '邮箱发送失败'
            ]);
        }

        return 'yes';

    }

    /**
     * 邮箱跟进验证码校验,并存入数据库创建用户
     * @return array|string
     * @throws PasswordException
     */
    public function codeToSuccess()
    {
        // 检测邮箱
        (new EmailValidate())->toCheck();
        (new PasswordValidate())->toCheck();
        $token = new LoginService();
        $check = $token->checkEmailCode();

        if (!$check){
            throw new PasswordException([
                'msg' => '校验失败'
            ]);
        }

        $param = Request::instance()->param();
        if (!array_key_exists('password', $param)){
            throw new PasswordException([
                'msg' => '缺少密码参数'
            ]);
        }
        $token = OAuthProcessor::tokenGeneration();

        $data = [
            'token' => $token,
            'time_out' => strtotime("+".config('app.login_time_out_day')." days"),
            'nickname' => '新叶粉丝'.$param['email'],
            'status' => 1,
            'email' => $param['email'],
            'password' => md5($param['password']),
        ];
        try{
            // 数据库存入
            $save = model('user')->data($data)->save();
            if ($save){
                return [
                    'token' => $token,
                    'status' => 'yes'
                ];
            }else{
                throw new TokenException();
            }
        }catch (\Exception $e){
            return 'no';
        }


    }

    /**
     *  通过邮箱和密码登录
     * @throws ParameterException
     */
    public function passwordLogin()
    {
        $param = request()->param();
        if(empty($param['email'])){
            throw new ParameterException([
                'msg' => 'email参数不能为空'
            ]);
        }
        if(empty($param['password'])){
            throw new ParameterException([
                'msg' => 'password参数不能为空'
            ]);
        }
        (new EmailValidate())->toCheck();
        (new PasswordValidate())->toCheck();

        $loginService = new LoginService();
        $token = $loginService->byPasswordLoginToToken();

        return [
          'token' => $token,
          'status' => 'yes'
        ];

    }

    /**
     * 校验验证码并修改密码
     * @return string
     * @throws ParameterException
     */
    public function verificationCodeModifyPassword()
    {
        $param = request()->param();
        $headers = request()->header();

        $email = '';   // 检查是token的登录状态的修改密码，还是未登录的忘记密码
        if (array_key_exists('email', $param)){
            (new EmailValidate())->toCheck();
            $email = $param['email'];
        }
        if (!empty($headers['token'])){
            $email = (new User())->getEmailByToken($headers['token']);
            if (!$email)
            {
                return 'no';
            }
        }
        if (empty($email))
        {
            return 'no';
        }

        if(empty($param['password'])){
            throw new ParameterException([
                'msg' => 'password参数不能为空'
            ]);
        }

        (new PasswordValidate())->toCheck();
        $token = new LoginService();
        $check = $token->checkEmailCode();

        if (!$check){
            return 'no';
        }
        $data = [
          'password' => md5($param['password'])
        ];

        try{ // 根据邮箱修改密码
           $mail = model('user')->save($data,['email' => $email]);
            if (!$mail){
                return 'no';
            }
        }catch (\Exception $e){
            return 'no';
        }
        return 'yes';

    }

    /**
     * 昵称初始设置
     * @return string
     */
    public function nicknameSet()
    {
        $param = request()->param();
        $headers = request()->header();
        $email = '';    // token还是邮箱
        if (array_key_exists('email', $param)){
            (new EmailValidate())->toCheck();
            $email = $param['email'];
        }
        if (!empty($headers['token'])){
            $email = (new User())->getEmailByToken($headers['token']);
            if (!$email)
            {
                return 'no';
            }
        }
        if (empty($email))
        {
            return 'no';
        }

        $data = [
            'nickname' => $param['nickname']
        ];
        // 根据邮箱修改昵称
        try{
            $mail = model('user')->save($data,['email' => $email]);
            if (!$mail){
                return 'no';
            }
        }catch (\Exception $e){
            return 'no';
        }
        return 'yes';

    }



}