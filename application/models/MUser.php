<?php

/**
 * Created by PhpStorm.
 * User: teemo
 * Date: 2016/11/17
 * Time: 9:28
 */
class MUser extends CI_Model
{

    public $id;
    public $user_name;
    public $email;
    public $phone;
    public $password;
    public $sex;
    public $birthday;
    public $avatar;
    public $is_active;
    public $create_time;


    public function __construct()
    {
        parent::__construct();
    }


    /**
     *查询用户更具用户名和密码-登陆
     */
    public function loginCheck($username, $password)
    {
        $sql = "SELECT id,user_name,email,phone,password,sex,birthday,avatar,is_active,create_time FROM t_user WHERE user_name=? AND password=?";
        return $this->db->query($sql, array($username, $password))->row(0, __CLASS__);
    }


    /*
    *查询邮箱是否被注册
    */
    public function checkEmail($email)
    {
        $this->db->where('email', $email);
        $this->db->from('t_user');
        if ($this->db->count_all_results() > 0)
            return false;
        else
            return true;
    }

    /*
    * 查询用户名是否被注册
    */
    public function checkUsername($username)
    {
        $this->db->where('user_name', $username);
        $this->db->from('t_user');
        if ($this->db->count_all_results() > 0)
            return false;
        else
            return true;
    }


    /**根据token获取用户信息*/
    public function getUserByToken($token)
    {
        $sql = "SELECT id,user_name,email,token_exptime FROM t_user WHERE token=?";
        return $this->db->query($sql, array($token))->row(0,__CLASS__);
    }

    /**激活*/
    public function activeUserByToken($id)
    {
        $data = array('is_active' => 1);
        $where = 'id=' . $id;
        $str = $this->db->update_string('t_user', $data, $where);
        $this->db->query($str);
        return $this->db->affected_rows();
    }

    /*
     *注册一个新用户
     */
    public function register($username,$email,$password,$sex,$birthday,$token,$token_exptime,$create_time){
        $param=array(
            'user_name'=>$username,
            'email'=>$email,
            'password'=>$password,
            'sex'=>$sex,
            'birthday'=>$birthday,
            'avatar'=>'',
            'type'=>1,
            'token'=>$token,
            'token_exptime'=>$token_exptime,
            'is_active'=>0,
            'create_time'=>$create_time
        );
        $this->db->insert('t_user',$param);
        return $this->db->insert_id();
    }



}