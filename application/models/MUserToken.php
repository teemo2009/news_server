<?php

/**
 * Created by PhpStorm.
 * User: teemo
 * Date: 2016/11/19
 * Time: 18:06
 */
class MUserToken extends CI_Model
{
    public $id;
    public $client_type;
    public $uid;
    public $user_token;

    public function __construct()
    {
        parent::__construct();
    }

    /*
    *查询user是否存在user_token 根据uid查询
    */
    public function isHaveUserTokenByUID($user_id){
        $sql='SELECT id,client_type,uid,user_token FROM t_user_token WHERE uid='.$user_id;
        return $this->db->query($sql)->row(0,__CLASS__);
    }

    /*
    *查询user是否存在user_token 根据user_token查询
    */
    public function isHaveUserToken($user_token){
        $sql='SELECT id,client_type,uid,user_token FROM t_user_token WHERE user_token='.$user_token;
        return $this->db->query($sql)->row(0,__CLASS__);
    }


    /**更新user_token*/
    public function updateUserToken($user_id,$user_token){
        $param=array('user_token'=>$user_token);
        $this->db->where('uid',$user_id);
        return $this->db->update('t_user_token',$param);
    }

    /**插入user_token*/
    public function insertUserToken($user_id,$user_token){
        $param=array('client_type'=>1,'uid'=>$user_id,'user_token'=>$user_token);
        $this->db->insert('t_user_token', $param);
        return $this->db->insert_id();
    }

}