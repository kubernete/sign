<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/1
 * 时间: 13:33
 */

namespace app\lib\exception;


use think\exception\Handle;
use think\exception\HttpException;
use think\Log;
use think\Request;

class ExceptionHandler extends Handle
{
    private $code;
    private $msg;
    private $errorCode;

    // 需要返回请求的url路径

    public function render(\Exception $e)
    {
        if ($e instanceof BaseException){
            $this->code = $e->code;
            $this->msg = $e->msg;
            $this->errorCode = $e->errorCode;
        }elseif ($e instanceof HttpException)
        {
            $this->code = 500;
            $this->msg = "请求的地址并不存在";
            $this->errorCode = 999;
        }else{
            if (config('app_debug')){
                return parent::render($e);
            }else{
                $this->code = 500;
                $this->errorCode = 10000;
                $this->msg = "服务器内部错误";
                $this->recodeErrLog($e);
            }
        }

        $request = Request::instance();
        $result = [
            'msg' => $this->msg,
            'status' => 'no',
            'request_url' => $request->url(),
            'error_code' => $this->errorCode,
        ];
        return json($result,$this->code);


    }

    private function recodeErrLog(\Exception $e)
    {

        Log::init([
            // 日志记录方式，内置 file socket 支持扩展
            'type'  => 'File',
            // 日志保存目录
            'path'  => LOG_PATH,
            // 日志记录级别
            'level' => ['error'],
        ]);
        Log::record($e->getMessage(),'error');

    }

}