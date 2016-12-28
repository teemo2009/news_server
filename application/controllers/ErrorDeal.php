<?php

/**
 * Created by PhpStorm.
 * User: teemo
 * Date: 2016/11/17
 * Time: 9:59
 */
class ErrorDeal extends CI_Controller
{

    /*
     * 500 服务端错误
     */
    public function server_error(){

        echo json_encode(array(RSP_FLAG=>RSP_FAIL,RSP_DATE=>null,RSP_MSG=>'服务端错误，尽快解决'));
    }

    /*
     * 404 请求不存在
     */
    public function url_not_find(){
        echo json_encode(array(RSP_FLAG=>RSP_FAIL,RSP_DATE=>null,RSP_MSG=>'好好看看路径'));
    }

    /*
     * 没有权限 110
    */
    public function user_token_fail(){
        echo json_encode(array(RSP_FLAG=>RSP_FAIL,RSP_DATE=>null,RSP_MSG=>'小伙子不错啊，有在非法攻击了，你没有权限'));
    }
    /*
      * 没有权限 120
     */
    public function param_fail(){
        echo json_encode(array(RSP_FLAG=>RSP_FAIL,RSP_DATE=>null,RSP_MSG=>'参数错误了'));
    }
}