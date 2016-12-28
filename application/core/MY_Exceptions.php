<?php

/**
 * Created by PhpStorm.
 * User: teemo
 * Date: 2016/11/17
 * Time: 14:18
 */
class MY_Exceptions extends CI_Exceptions
{
//    /**请求地址不存在*/
    public function show_404($page = '', $log_error = TRUE)
    {
        if ($log_error)
        {
            log_message('error', '404 Page Not Found'.': '.$page);
        }

        echo json_encode(array('flag'=>'-1','date'=>null,'msg'=>'请求地址不存在'));
        exit(4); // EXIT_UNKNOWN_FILE
    }



}