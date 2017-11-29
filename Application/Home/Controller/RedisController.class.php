<?php
/**
 * Created by PhpStorm.
 * User: lyh
 * Date: 2017/11/22
 * Time: 14:26
 */

namespace Home\Controller;


use Think\Cache\Driver\Redis;
use Think\Controller;

class RedisController extends Controller
{
    protected $model;
    protected $period=5;

    public function __construct()
    {
            $redis=new \Redis();
            $redis->connect('172.18.20.200',6379);
            $this->model=$redis;
            return ;
    }

    //设置值
    public function setValue($token,$id)
    {
        return $this->model->set($token,$id);
    }

    //获取值
    public function getValue($token)
    {
        return $this->model->get($token);
    }

    //设置防止接口过期时间内对接口的二次访问
    public function setPeriodValue($sign)
    {
        return $this->model->set($sign,true,$this->period);
    }
}