<?php
/**
 * 由 PhpStorm 创造.
 * 用户: Administrator朕之天下
 * 日期: 2018/6/1
 * 时间: 14:26
 */

namespace app\api\validate;


use app\lib\exception\ParameterException;
use think\Request;
use think\Validate;

class BaseValidate extends Validate
{
    public function toCheck()
    {
        // 通过获取http传入的参数进行校验
        $request = Request::instance();

        $param = $request->param();

        $result = $this->batch()->check($param);

        if (!$result)
        {
            throw new ParameterException([
                'msg' => $this->error,
            ]);
        }
        else{
            return true;
        }
    }

    protected function isPositiveInteger($value)
    {
        if (is_numeric($value) && is_int($value + 0) && ($value + 0) > 0)
        {
            return true;
        }
        else{
            return false;
        }

    }

    protected function isMobile($value)
    {
        $rule = '^1(3|4|5|7|8)[0-9]\d{8}$^';
        $result = preg_match($rule,$value);
        if ($result){
            return true;
        }
        else{
            return false;
        }
    }

    protected function isNotEmpty($value)
    {
        if (empty($value))
        {
            return false;
        }
        else
        {
            return true;
        }

    }



    /**
     * @param $data 所需要过滤的数据
     * @return array 返回过滤后的数组
     * @throws ParameterException 参数异常抛出
     */
    public function getDataByRule($data)
    {
      if (array_key_exists('user_id', $data) |
          array_key_exists('uid', $data)
      )
      {
          throw new ParameterException([
              'msg' =>'参数中有非法的user_id和uid'
          ]);
      }
      $newArray = [];
      foreach ($this->rule as $key => $value)
      {
          $newArray[$key] = $data[$key];
      }
      return $newArray;

    }


}