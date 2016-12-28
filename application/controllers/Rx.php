<?php

/**
 * Created by PhpStorm.
 * User: teemo
 * Date: 2016/11/19
 * Time: 14:45
 */
class Rx extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function hello()
    {
        echo site_url('/public/bootstrap/css/bootstrap.min.css');
    }



}