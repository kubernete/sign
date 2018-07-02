<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/5/31
 * 时间: 23:25
 */

namespace app\api\controller\v1;



use app\api\controller\BaseController;
use app\api\service\MailService;
use app\api\service\SmsService;
use app\api\validate\EmailValidate;
use app\lib\Code;
use app\lib\processor\AesProcessor;
use app\lib\processor\OAuthProcessor;
use app\lib\Time;
use think\Cache;
use think\Controller;
use think\Request;

class Index extends Controller
{
    public function index()
    {
//        (new EmailValidate())->toCheck();

//        \phpmailer\Email::send('495002381@qq.com','我是你好','注册成功');

          $mailService = new MailService();
          $tomail = $mailService->sendMail('495002381@qq.com','我是你好','注册成功');

          $zan = 1;


        return $zan;


    }

    public function test()
    {
//        $id = 0;
//        return captcha_src($id);



          $numCode =  Code::getRandNumCode(4);

//          $param = Request::instance()->param();
//          $phone = $param['phone'];
//        $response = SmsService::sendSms('11111111111', $numCode);
//        $code = $response->Code;
//        $response = json_encode($response);
           $token = OAuthProcessor::tokenGeneration();

//        if ($code){
//            Cache::set($phone, $numCode, config('aliyun.identify_time'));
//        }
//            Cache::get($phone);
          $day = model('daytime')->field(['intraday'])->find();
        return $day;

//        $user = model('user')
//            ->where('id','>=', 0)
//            ->where('id', '<=', 2)
//            ->count();
//        return $user;
    }

    public function timeGet()
    {
        $time = date('Y-m-d',strtotime("20180702"));

        $sign_times = model('sign')
            ->where('user_id' , '=', 1)
            ->whereTime('sign_time', 'week')

            ->select();
        foreach ($sign_times as $sign_time)
        {
            $sign_time['create_time'] = date('Y-m-d H:i:s', $sign_time['create_time']);
            $sign_time['update_time'] = date('Y-m-d H:i:s', $sign_time['update_time']);
        }

        return $sign_times; //
    }

}