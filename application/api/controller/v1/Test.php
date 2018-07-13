<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/2
 * 时间: 19:13
 */

namespace app\api\controller\v1;


use app\api\service\RegionService;
use app\api\service\Upload;
use app\common\model\Region;
use app\lib\exception\BaseException;
use app\lib\exception\ParameterException;
use app\lib\FileUpload;
use app\lib\processor\OAuthProcessor;
use app\lib\Time;
use think\Controller;
use think\Db;
use think\Request;

class Test extends Controller
{
    public $myUser;

    public function _initialize()
    {
        $this->myUser = model('sign')->find();
    }

    public function index()
    {
        $headers = Request::instance()->header();
        $data = [
            'device_id' => $headers['device_id'],
            'app_type' => $headers['app_type'],
            'time' => Time::get13Time(),
        ];
        $oauth = new OAuthProcessor();
        $encrypted = $oauth->setSign($data);
        return $encrypted;
    }


    public function time()
    {

        $param = request()->param();
        $ymd = date("Ymd", time());
        $his = date("YmdHis", time());
        $fileName = $his.'stream.jpg';
        $dir = config('file.save_path').$ymd."/";
        $isDir = is_dir($dir);
        if (!$isDir)
        {
            mkdir($dir,0777,1);
            chmod($dir, 0777);
        }


        return FileUpload::generateUniqueMicroTimeFileName();
    }

    /**
     * 测试评论用例
     */
    public function comment()
    {
        Db::order();
        $newsId = input('param.id', 0, 'intval');
        if (empty($newsId)){
            throw new BaseException([
                'code' => 404
            ]);
        }

    }

    public function putImg()
    {
        $str = strtotime("this week Monday 00:00:00");
        $str1 = strtotime("this week Sunday 23:59:59");
        echo date("Y-m-d H:i:s", $str).PHP_EOL;
        echo date("Y-m-d H:i:s", $str1).PHP_EOL;
    }



}