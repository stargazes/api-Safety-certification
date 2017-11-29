<?php
/**
 * Created by PhpStorm.
 * User: lyh
 * Date: 2017/11/22
 * Time: 11:35
 */

namespace Home\Controller;


use Think\Controller;

class CommonController extends Controller
{
    const Secret_key="123456";
    protected $token;
    public function __construct()
    {
        //先判断是否

        $redis=new RedisController();
        $token=$_SERVER['HTTP_TOKEN'];//用户token
        $sign=$_SERVER['HTTP_SIGN'];//签名  token跟时间戳跟秘钥生成
        $timestamp=$_SERVER['HTTP_TIME'];//当前时间戳

        $serverSign=$this->sign($token,$timestamp);

        if($redis->getValue($sign) || $sign!=$serverSign || time()-$timestamp>300){
            //无效请求
            $this->josnReturnToTerminal(403,[]);
        }else{
            if($redis->getValue($token)){
                $this->token=$redis->getValue($token);
                //将签名存入redis中
                $redis->setPeriodValue($sign);
            }else{
                //登录失效
                $this->josnReturnToTerminal(401,[]);
            }
        }

    }

    //签名方法
    protected function sign($token,$timestamp)
    {
        return md5($token.$timestamp.base64_encode(Secret_key));
    }

    //定义全局json返回格式
    protected function josnReturnToTerminal($code,$data){
        $status=C('Http_Status');//获取状态数组
        $arr['status_code']=$code;
        $arr['msg']=$status[$code];
        $arr['data']=$data;
        $this->ajaxReturn($arr);
    }



}