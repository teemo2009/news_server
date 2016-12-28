<?php
/**
 * Created by PhpStorm.
 * User: teemo
 * Date: 2016/11/17
 * Time: 17:11
 */

/*
 * 检查 user_token
*/
    function check_user_token($CI,$user_token){
        if (!isset($user_token)){
            return false;
        }
        if ($CI->session->has_userdata($user_token)){
          return true;
        }else{
            $CI->load->model('mUserToken');
            if($CI->mUserToken->isHaveUserToken($user_token)->id>0){
                //用户登陆过了，不过session失效，重新添加session
                $CI->session->set_userdata($user_token,$user_token);
                return true;
            }else{
                return false;
            }
        }

    }

/**插入一个新的user_token 如果存在就更新*/
    function set_user_token($CI,$user_id){
        //判断是否存在
        $CI->load->model('mUserToken');
        $user=$CI->mUserToken->isHaveUserTokenByUID($user_id);
        $user_token=uniqid();
        if (isset($user->id)){
            /**以及存在更新user_token*/
            if($CI->mUserToken->updateUserToken($user_id,$user_token)){
                $CI->session->set_userdata($user_token,$user_token);
            }
        }else{
            /**不存在插入*/
            if ($CI->mUserToken->insertUserToken($user_id,$user_token)>0){
                $CI->session->set_userdata($user_token,$user_token);
            }
        }
    }