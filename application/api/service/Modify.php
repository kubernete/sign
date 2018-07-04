<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/7
 * 时间: 23:33
 */

namespace app\api\service;


use app\api\validate\StudentIDValidate;
use app\common\model\User;
use app\lib\exception\BaseException;
use app\lib\exception\BaseInfoException;
use app\lib\exception\ParameterException;
use app\lib\FileUpload;
use think\Exception;

class Modify
{
    public function modifyBaseInfo($param = [], $user = [])
    {
        $data = [];

        // 头像
/*        if(!empty($_FILES['image']))
        {
            // 获取上传的文件并返回文件日期目录加上文件名
            $upload = new Upload();
            $saveName =  $upload->saveImg();
            // 保存格式如20180530/xxxxxxxx.jpg
            $data['image'] = $saveName;
        }*/


        $xmlStr = file_get_contents('php://input');
        $xml = getimagesizefromstring($xmlStr);

        if ($xml)
        {
            $saveName = FileUpload::ReceiveFileToSaveName();
            if ($saveName){
                $data['image'] = $saveName;
            }
        }

        if (!empty($param['portraitByte']))
        {
            $xml = getimagesizefromstring($param['portraitByte']);
            if ($xml)
            {
                $saveName = FileUpload::binaryStringToFile($param['portraitByte']);
                if ($saveName){
                    $data['image'] = $saveName;
                }
            }
        }

        // 昵称
        if(!empty($param['nickname']))
        {
            $data['nickname'] = $param['nickname'];
        }

        // 性别
        if(!empty($param['sex']))
        {
            $data['sex'] = $param['sex'];
        }

        // 生日
        if(!empty($param['birthday']))
        {
            $data['birthday'] = $param['birthday'];
        }

        // 所在地
        if(!empty($param['address']))
        {
            $data['address'] = $param['address'];
        }

        // 签名
        if(!empty($param['signature']))
        {
            $data['signature'] = $param['signature'];
        }

        // 学校
        if(!empty($param['school']))
        {
            $data['school'] = $param['school'];
        }

        // 学院
        if(!empty($param['department']))
        {
            $data['department'] = $param['department'];
        }

        // 专业
        if(!empty($param['major']))
        {
            $data['major'] = $param['major'];
        }

        // 班级
        if(!empty($param['team']))
        {
            $data['team'] = $param['team'];
        }

        // 学号
        if(!empty($param['num']))
        {
            $data['num'] = $param['num'];
        }


        try{
            $userModel = new User();
            $id = $userModel->save($data, ['id' => $user['id']]);
            if (!$id){
                throw new ParameterException([
                    'msg' => '修改数据失败',
                    'code' => 404
                ]);
            }

        }catch (\Exception $e){
            return 'no';
        }

        return $data;


    }

    /**
     * 汉字转换成数字，以方便入数据库
     * @param $sex
     * @return bool
     * @throws ParameterException
     */
    public function chineseCharSexToNum($sex)
    {
        if (empty($sex) || strlen($sex) > 3){
            return false;
        }
        switch ($sex){
            case "男":
                $sex = 0;
                break;
            case "女":
                $sex = 1;
                break;
            default:
                throw new ParameterException([
                    'msg' => '性别传的不是 男 或者是 女 单个汉字'
                ]);

        }
        return $sex;
    }

}