<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/27
 * 时间: 9:06
 */

namespace app\lib;


class FileUpload
{
    public static function binaryStringToFile($binary = '', $fileType = 'jpg')
    {
        $ymdDir = date("Ymd", time()).'/';
        $fileName = self::generateUniqueMicroTimeFileName($fileType);
        $saveName = $ymdDir.$fileName;
        $dir = config('file.save_path').$ymdDir;
        self::createDir($dir);chmod($dir, 0777);
        try{
            if (!$binary)
            {
                return false;
            }

            $file = fopen(config('file.save_path').$saveName,'w');
            fwrite($file, $binary);
            fclose($file);
        }catch (\Exception $e){
            return false;
        }
        return $saveName;

    }

    /**
     * 接受二进制流文件，保存为$fileType类型的文件 返回保存名
     * @param string $fileType 文件类型
     * @return bool|string $saveName 保存名，含有日期目录
     */
    public static function ReceiveFileToSaveName($fileType = 'jpg')
    {
        $ymdDir = date("Ymd", time()).'/';
        $fileName = self::generateUniqueMicroTimeFileName($fileType);
        $saveName = $ymdDir.$fileName;
        $dir = config('file.save_path').$ymdDir;
        self::createDir($dir);chmod($dir, 0777);
        try{
            $xmlStr = file_get_contents('php://input');

            if (!$xmlStr)
            {
                return false;
            }


            $file = fopen(config('file.save_path').$saveName,'w');
            fwrite($file, $xmlStr);
            fclose($file);
        }catch (\Exception $e){
            return false;
        }
        return $saveName;

    }

    public static function createDir($dirName, $recursive = 1,$mode=0777)
    {
        ! is_dir ( $dirName ) && mkdir ( $dirName,$mode,$recursive );
    }

    /**
     * 获取唯一时间混杂字符串文件名
     * @param string $fileType 文件类型
     * @return string
     */
    public static function generateUniqueMicroTimeFileName($fileType = 'jpg')
    {
        $str1 = self::generateRandomString(3);
        $str2 = self::generateRandomString(5);
        list($micro,$time) = explode(' ',microtime());
        $his = date("YmdHis", time());
        $rand = rand(0, 100);
        $micro = intval($micro*10000);
        $fileName = $str1.$his.$micro.$rand.$str2.'.'.$fileType;
        return $fileName;
    }

    public static function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }
        return $randomString;
    }



}