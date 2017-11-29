<?php
/**
 * Created by PhpStorm.
 * User: lyh
 * Date: 2017/11/22
 * Time: 14:47
 */

namespace Home\Controller;


use Think\Controller;

class LoginController extends Controller
{
    protected $redis;
    public function __construct(RedisController $redis)
    {
        $this->redis=$redis;
    }

    public function login($token,$id)
    {
        if(true){
            $this->redis->setValue($token,$id);
        }
    }
}