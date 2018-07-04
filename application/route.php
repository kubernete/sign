<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

use think\Route;
// 测试首页
Route::get('api/:version/myindex', 'api/:version.Index/index');
Route::post('api/:version/mytest', 'api/:version.Index/test');
Route::post('api/:version/indextime', 'api/:version.Index/timeGet');
// 测试用例
Route::post('api/:version/testindex','api/:version.Test/index');
Route::get('api/:version/comment','api/:version.Test/comment');
Route::post('api/:version/mytime','api/:version.Test/time');
Route::put('api/:version/img/save','api/:version.Test/putImg');

// 正式接口
Route::get('api/:version/time','api/:version.Time/index');// 获取时间

Route::get('api/:version/email/existence', 'api/:version.Login/checkEmailExist');// 检查邮箱是否存在
Route::post('api/:version/email/sending', 'api/:version.Login/sendMail');// 邮箱发送 token登录状态，email非登录
Route::post('api/:version/email/registration' ,'api/:version.Login/codeToSuccess');// 根据验证码注册入库
Route::put('api/:version/email/password' ,'api/:version.Login/passwordLogin');// 账号密码登陆
Route::put('api/:version/password/verification' ,'api/:version.Login/verificationCodeModifyPassword');
// 校验验证码并修改密码,token登录状态,email非登录
Route::put('api/:version/nickname/setting' ,'api/:version.Login/nicknameSet'); // 昵称设置


Route::put('api/:version/info/modification', 'api/:version.Modification/infoChange'); // 用户信息修改

// 退出登录
Route::put('api/:version/token/null', 'api/:version.Cancel/cancelToken');

Route::post('api/:version/coming', 'api/:version.Sign/toSign'); // 签到
Route::put('api/:version/leaving', 'api/:version.Sign/toLeave'); // 离开
Route::get('api/:version/day/details', 'api/:version.Sign/getDaySignSituation'); // 查询日签到详情
Route::get('api/:version/month/days', 'api/:version.Sign/comeDays'); // 查询某年某月有哪些天签到

// 动态
Route::get('api/:version/dynamic/all', 'api/:version.Dynamic/allDynamic'); // 查询动态列表
Route::post('api/:version/zan/increase', 'api/:version.Dynamic/clickZan'); // 点赞
Route::delete('api/:version/zan/cancel', 'api/:version.Dynamic/cancelZan'); // 取消赞
Route::post('api/:version/attention/increase', 'api/:version.Dynamic/attentionDynamic'); // 添加关注
Route::delete('api/:version/attention/cancel', 'api/:version.Dynamic/cancelAttention'); // 取消关注

// 用户上周与本周的小时排名
Route::get('api/:version/ranking/recent', 'api/:version.Ranking/lastThisWeekRanking');

// 地区信息获取
Route::get('api/:version/province/city', 'api/:version.Region/ProvincesCity');

// 用户基本信息获取
Route::get('api/:version/user/info', 'api/:version.Info/baseInfoGet');
Route::get('api/:version/status/total', 'api/:version.Info/statusGetTotal'); // 返回用户的签到离开状态和这周累计签到时间
Route::get('api/:version/img/url', 'api/:version.Info/imgUrlGet'); // 获取用户图片地址