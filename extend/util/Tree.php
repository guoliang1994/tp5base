<?php
namespace util;

class Tree {

    static public $treeList = array(); //存放无限分类结果如果一页面有多个无限分类可以使用 Tool::$treeList = array(); 清空
    /**
     * 无限级分类
     *
     * @access public
     * @param Array $data     //数据库里获取的结果集
     * @param Int $pid
     * @param Int $count       //第几级分类
     * @return Array $treeList
     */
    static public function tree($data, $pid = 0, $count = 1, $parent_name ='') {
        foreach ($data as $key => $value){
            if($value['parent_id'] == $pid){
                $value['count'] = $count;
                if ($pid != 0) {
                    //$value['name'] =  $parent_name . "->" .$value['name'];
                }
                $value['text_indent'] =  str_repeat("&nbsp;", $count*5) ."└─";
                self::$treeList []=$value;
                //unset($data[$key]);
                self::tree($data, $value['id'],$count+1);
            }
        }
        return self::$treeList ;
    }
}