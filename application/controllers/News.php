<?php

/**
 * Created by PhpStorm.
 * User: teemo
 * Date: 2016/11/23
 * Time: 18:15
 */
class News extends CI_Controller
{
  public function __construct()
  {
      parent::__construct();
  }

  public function getDetail($id=3){
      if ($_SERVER["REQUEST_METHOD"]==='GET'){
            $this->load->model('mNews');
            $user=$this->mNews->getNewsById($id);
            $this->load->view('news_detail',array('news_content'=>$user->content));
      }else{
          return_404();
      }
  }

  //获取列表 $type,$currIndex,$pageSize
  public function getNewsListByType(){
      if ($_SERVER['REQUEST_METHOD']==='POST') {
          if (isset($_POST['type']) && isset($_POST['currIndex']) && isset($_POST['pageSize'])) {
              $this->load->model('mNews');
              $result=$this->mNews->getPageNewsByType($_POST['type'], $_POST['currIndex'], $_POST['pageSize']);
              foreach ($result as $user ){
                  $user->desc=mb_substr(strip_tags(htmlspecialchars_decode($user->content)), 0, 20, 'utf-8');
              }
              return_success($result);
          } else {
              return_120();
          }
      }else{
          return_404();
      }
  }
    public function GG(){
        //mb_substr(strip_tags(htmlspecialchars_decode($item->content)), 0, 50, 'utf-8')
                $this->load->model('mNews');
                $result=$this->mNews->getPageNewsByType(1,1, 10);
                foreach ($result as $user ){
                    $user->desc=mb_substr(strip_tags(htmlspecialchars_decode($user->content)), 0, 50, 'utf-8');
                }
                return_success($result);
    }
}