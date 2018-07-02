<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/19
 * 时间: 8:20
 */

namespace app\api\service;


use app\lib\exception\FileException;

class Upload
{
    /**
     *  获取上传的文件并返回文件日期目录加上文件名
     * @return string
     * @throws FileException
     */
    public function saveImg()
    {
        // 获取表单上传文件
        $file = request()->file('img');

        if($file){
            // 移动到框架应用根目录/public/source/ 目录下 根据配置文件file的save_path字段决定
            // save_path 最后一个字符是斜杠
            $info = $file->move(config('file.save_path'));
            if($info){
            // 输出 20160820/42a79759f284b767dfcb2a0197904287.jpg
                return $info->getSaveName();

            }else{

                throw new FileException([
                    'msg' => $file->getError()
                ]);
            }
        }else{
            throw new FileException();
        }

    }
}