<?php

/**
 * Created by PhpStorm.
 * User: teemo
 * Date: 2016/11/17
 * Time: 9:27
 */
class User extends CI_Controller
{


    public $CI;
    /**不需要权限认证的数组*/
    private $my_allow = array('login','register', 'active', 'test');

    public function __construct()
    {

        parent::__construct();
        $this->CI =& get_instance();
    }


    /**
     * @desc 权限判定方法
     */
    public function _remap($method, $params = array())
    {
        if (method_exists($this->CI, $method)) {
            if (!in_array($method, $this->my_allow)) {
                /**简单user_token是否存在*/
                if (check_user_token($this->CI, $_SERVER['HTTP_USER_TOKEN'])) {
                    return call_user_func_array(array($this->CI, $method), $params);
                } else {
                    /**没有权限*/
                    return_110();
                }
            } else {
                return call_user_func_array(array($this->CI, $method), $params);
            }
        } else {
            return_404();
        }
    }

    public function test()
    {
        log_message("info", json_encode($_SERVER));
        // log_message("info",var_dump($_SERVER));
//     if (isset($_SERVER['HTTP_AUTHORIZATION'])){
//         return_success($_SERVER['HTTP_AUTHORIZATION']);
//     }else{
//         return_success('666666');
//     }
        return_success('666666');

    }


    /**用户名 登陆**/
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['username']) && isset($_POST['password']) &&
                preg_match('/^[a-zA-Z][a-zA-Z0-9]{5,11}$/', $_POST['username'])
            ) {
                $this->load->model('mUser');
                $user = $this->mUser->loginCheck($_POST['username'], $_POST['password']);
                if (isset($user->id)) {
                    /**用户存在 把用户信息生存token保存在session中并返回用户的json值给客户端*/
                    /**生存一个新的usertoken**/
                    set_user_token($this->CI, $user->id);
                    return_success($user);
                } else {
                    return_fail('用户名或密码错误请重新填写');
                }
            } else {
                /**请求参数问题*/
                return_120();
            }
        } else {
            /**不能是get请求*/
            return_404();
        }

    }


    /*
      *注册用户
     * @see 新建用户使用默认头像
     **/
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            //验证邮箱格式
            if (isset($_POST['email']) && preg_match('/^(\w)+(\.\w+)*@(\w)+((\.\w+)+)$/', $_POST['email'])
                && isset($_POST['password']) && isset($_POST['sex']) &&
                isset($_POST['birthday']) && preg_match('/^[a-zA-Z0-9]{6,12}$/', $_POST['password']) &&
                preg_match('/^(19|20)\d{2}-(1[0-2]|0?[1-9])-(0?[1-9]|[1-2][0-9]|3[0-1])$/', $_POST['birthday'])
            ) {
                $this->load->model('mUser');
                if ($this->mUser->checkUsername($_POST['username'])) {
                    if ($this->mUser->checkEmail($_POST['email'])) {
                        /**注册时间*/
                        $create_time = time();
                        /**激活码*/
                        $token = uniqid();
                        /**激活码有效时间1小时*/
                        $token_exptime = $create_time + 60 * 60;
                        /**加密后密码*/
                        $md5_pwd = md5($_POST['password']);
                        /**生日*/
                        $datetime = new DateTime($_POST['birthday'], new DateTimeZone('PRC'));
                        $birthday = $datetime->format('U');
                        $user_id = $this->mUser->register($_POST['username'], $_POST['email'], $md5_pwd, $_POST['sex'], $birthday, $token, $token_exptime, $create_time);
                        if ($user_id > 0) {
                            /**发送激活码到邮箱*/
                            $this->_send_mail($_POST['username'], trim($_POST['email']), $token);
                            $user_rs = array(
                                'id' => $user_id,
                                'user_name' => $_POST['username'],
                                'email' => $_POST['email'],
                                'sex' => $_POST['sex'],
                                'birthday' => $birthday,
                                'is_active'=>0,
                                'avatar' => '',
                                'create_time'=>$create_time
                            );
                            return_success($user_rs);
                        } else {
                            return_fail("注册失败，请查看日志");
                        }
                    } else {
                        return_fail('邮箱已经被注册了');
                    }
                } else {
                    return_fail('用户名已经被注册了');
                }
            } else {
                //参数错误
                return_120();
            }
        } else {
            /***非get请求*/
            return_404();
        }
    }


    /**激活操作*/
    public function active($token)
    {
        $this->load->model('mUser');
        $user = $this->mUser->getUserByToken($token);
        if (isset($user)) {
            $token_exptime = $user->token_exptime;
            $now_time = time();
            if ($now_time < $token_exptime) {
                /**可以激活*/
                $row = $this->mUser->activeUserByToken($user->id);
                if ($row === 1) {
                    echo '激活成功，请在手机客户端登陆';
                } else {
                    echo '激活失败，查看服务端日志';
                }
            } else {
                echo '过期需要重新激活，请登录重新激活';
            }
        } else {
            echo "激活码错误，请检查连接";
        }
    }


    /**发送邮件*/
    private function _send_mail($username, $email, $token)
    {
        $this->load->model('mSmtp');
        $smtpserver = "smtp.sina.cn"; //SMTP服务器，如：smtp.163.com
        $smtpserverport = 25; //SMTP服务器端口，一般为25
        $smtpusermail = "h121baby@sina.cn"; //SMTP服务器的用户邮箱，如xxx@163.com
        $smtpuser = "h121baby@sina.cn"; //SMTP服务器的用户帐号xxx@163.com
        $smtppass = "woshipis"; //SMTP服务器的用户密码
        $smtp = $this->mSmtp->smtp($smtpserver, $smtpserverport, true, $smtpuser, $smtppass); //实例化邮件类
        $emailtype = "HTML"; //信件类型，文本:text；网页：HTML
        $smtpemailto = $email; //接收邮件方，本例为注册用户的Email
        $smtpemailfrom = $smtpusermail; //发送邮件方，如xxx@163.com
        $emailsubject = "卓软社用户帐号激活";//邮件标题
        //邮件主体内容
        $emailbody = "亲爱的" . $username . "：<br/>感谢您在卓软社注册了新帐号。<br/>请点击链接激活您的帐号。<br/> 
        <a href='" . site_url('/user/active/' . $token) . "' target='_blank'>" . site_url('/user/active/' . $token) . "</a><br/> 
        如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接一小时内有效。";
        $rs = $this->mSmtp->sendmail($smtpemailto, $smtpemailfrom, $emailsubject, $emailbody, $emailtype);
        return $rs;
    }


    /**用户名 个人信息*/
    public function info($user_id)
    {

    }
}