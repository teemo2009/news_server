<?php

/**
 * Created by PhpStorm.
 * User: teemo
 * Date: 2016/11/23
 * Time: 18:38
 */
class MNews extends CI_Model
{
    public $id;
    public $title;
    public $thumb_pic;
    public $author;
    public $type_id;
    public $content;
    public $shows;
    public $create_time;


    public function __construct()
    {
        parent::__construct();
    }


    /**获取分页的数据***/
    public function getPageNewsByType($news_type,$curr_index,$page_size=10){
        $curr_index=$curr_index<1?1:$curr_index;
        $sql='select id,title,thumb_pic,author,type_id,content,shows,create_time from t_news WHERE type_id='.$news_type.' ORDER BY id DESC LIMIT '. ($curr_index-1)*$page_size.','.$page_size;
       return  $this->db->query($sql)->result(__CLASS__);
    }

    /**获取分页详情*/
    public function  getNewsById($id){
        $sql='select id,title,thumb_pic,author,type_id,content,shows,create_time from t_news WHERE id='.$id;
        return $this->db->query($sql)->row(0,__CLASS__);
    }
}