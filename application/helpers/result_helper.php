<?php
/**
 * Created by PhpStorm.
 * User: teemo
 * Date: 2016/11/17
 * Time: 9:36
 */

const RSP_SUCCESS=1;
const RSP_FAIL=-1;
const RSP_FLAG='flag';
const RSP_DATE='date';
const RSP_MSG='msg';


/**
 *110 没权限
 */
function return_110(){
//    redirect('/errorDeal/user_token_fail');
    echo json_encode(array(RSP_FLAG=>RSP_FAIL,RSP_DATE=>null,RSP_MSG=>'小伙子不错啊，有在非法攻击了，你没有权限'));

}

/**
 *120 参数错误或不规范
 */
function return_120(){
//    redirect('/errorDeal/param_fail');
    echo json_encode(array(RSP_FLAG=>RSP_FAIL,RSP_DATE=>null,RSP_MSG=>'参数错误了'));
}

/**
 * 404 找不到界面
 */
function return_404(){
//    redirect('/errorDeal/url_not_find');
    echo json_encode(array(RSP_FLAG=>RSP_FAIL,RSP_DATE=>null,RSP_MSG=>'好好看看路径'));
}


/**
 * 500 服务器异常
 */
function return_500(){
//    redirect('/errorDeal/server_error');
    echo json_encode(array(RSP_FLAG=>RSP_FAIL,RSP_DATE=>null,RSP_MSG=>'服务端错误，尽快解决'));}

/**
 * 返回数据
 */
function return_date($flag,$date=null,$msg=""){
    echo json_encode(array(RSP_FLAG=>$flag,RSP_DATE=>$date,RSP_MSG=>$msg));
}

/**
 * 返回成功
 */
function return_success($date){
    return_date(RSP_SUCCESS,$date,"");
}

/**
 *返回失败
 */
function return_fail($msg){
    return_date(RSP_FAIL,null,$msg);
}