<?php

class BlogController extends Zend_Controller_Action {

    public function init() {
        
    }

    public function indexAction() {

        $this->view->headTitle()->prepend('Winwinhost Blogs');
        $data = new Default_Model_DbTable_News();
        $offset = "5";
        $order = "news_id DESC";
        //$news =  $data->fetchAll($offset,$order);
        //$this->view->data = $news;
        //$adapter = new Zend_Paginator_Adapter_DbSelect($data->select()->order($order));

        $adapter = new Zend_Paginator_Adapter_DbSelect($data->select()->setIntegrityCheck(false)->from(array('n' => 'news'))->join(array('m' => 'members'), 'm.member_id = n.member_id ')->join(array('c' => 'news_categories'), 'c.id = n.cat_id')->order($order));

        $paginator = new Zend_Paginator($adapter);
        $paginator->setItemCountPerPage($offset);
        $paginator->setCurrentPageNumber($this->_getParam('page'));
        $this->view->data = $paginator;
    }

    public function detailAction() {
 $order = "news_id DESC";
        $post_title = $this->getRequest()->getParam('post_title');
        if (!isset($post_title)) {
            $this->_redirect('/blog/');
            $data = new Default_Model_DbTable_News();
            exit();
        }
        $news = new Default_Model_DbTable_News();

        //$row = $news->fetchRow($news->select()->where('news_title=?', $post_title));
        $row = $news->fetchRow($news->select()->setIntegrityCheck(false)->from(array('n' => 'news'))->join(array('m' => 'members'), 'm.member_id = n.member_id ')->join(array('c' => 'news_categories'), 'c.id = n.cat_id')->where('news_title=?', $post_title));

        if (!$row) {
            $this->_redirect('/blog/');
        } else {
            $this->view->headTitle()->prepend($row->news_title);
            $this->view->data = $row;

            $arch = $news->select()
                    ->from('news', array("MONTH(news_posted) as mth", "news_posted" => new Zend_Db_Expr("count(MONTH(news_posted))")))
                    ->where('year(news_posted)=?', date('Y'))
                    ->group(array("MONTH(news_posted)"));

//            $sql = $arch->__toString();
//            echo "$sql\n";
            $arch = $news->fetchAll($arch);
            foreach ($arch->toArray() as $val):
                $blogcount[$val['mth']] = $val['news_posted'];
            endforeach;
            $this->view->archive = $blogcount;
            //for recent post
            $limit = '3';
            $select = $news->select()->setIntegrityCheck(false)->from(array('n' => 'news'))->join(array('m' => 'members'), 'm.member_id = n.member_id ')->join(array('c' => 'news_categories'), 'c.id = n.cat_id')->order($order)->limit($limit);
            $rows = $news->fetchAll($select);
            $this->view->r_news = $rows;
            //
        }

        $order = "news_id DESC";
        $select = $news->select()->order($order);
        $rows = $news->fetchAll($select);
        $this->view->b = $rows;

        // for news categories
        $ordr = "id DESC";
        $news_cat = new Default_Model_DbTable_Newscategories();
        $selt = $news_cat->select()->order($ordr);
        $rows = $news_cat->fetchAll($selt);
        $this->view->n_cat = $rows;
        //
    }

    // catagories wise search
    public function catagorysearchAction() {
        $this->view->headTitle()->prepend('Blogs Categories Wise');
        $cat_name = $this->getRequest()->getParam('cat_name');
        if (!isset($cat_name)) {
            $this->_redirect('/blog/');
            exit();
        } else {
            $data = new Default_Model_DbTable_News();
            $offset = "5";
            $order = "news_id DESC";
            $adapter = new Zend_Paginator_Adapter_DbSelect($data->select()->setIntegrityCheck(false)->from(array('n' => 'news'))->join(array('m' => 'members'), 'm.member_id = n.member_id ')->join(array('c' => 'news_categories'), 'c.id = n.cat_id ')->where('name=?', $cat_name)->order($order));

            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage($offset);
            $paginator->setCurrentPageNumber($this->_getParam('page'));
            $this->view->data = $paginator;
        }
    }

     //month wise search
    public function monthsearchAction() {
        $this->view->headTitle()->prepend('Blogs month Wise');
        $month= $this->getRequest()->getParam('month');
        if (!isset($month)) {
            $this->_redirect('/blog/');
            exit();
        } else {
            $data = new Default_Model_DbTable_News();
            $offset = "5";
            $year=date('Y');
            $order = "news_id DESC";
            $adapter = new Zend_Paginator_Adapter_DbSelect($data->select()->setIntegrityCheck(false)->from(array('n' => 'news'))->join(array('m' => 'members'), 'm.member_id = n.member_id ')->join(array('c' => 'news_categories'), 'c.id = n.cat_id ')->where('MONTH(news_posted)=?',$month)->where('YEAR(news_posted)=?',$year)->order($order));
 
            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage($offset);
            $paginator->setCurrentPageNumber($this->_getParam('page'));
            $this->view->data = $paginator;
        }
    }
    
    //year wise search
    public function yearsearchAction() {
        $this->view->headTitle()->prepend('Blogs year Wise');
        $year= $this->getRequest()->getParam('year');
        if (!isset($year)) {
            $this->_redirect('/blog/');
            exit();
        } else {
            $data = new Default_Model_DbTable_News();
            $offset = "5";
            
            $order = "news_id DESC";
            $adapter = new Zend_Paginator_Adapter_DbSelect($data->select()->setIntegrityCheck(false)->from(array('n' => 'news'))->join(array('m' => 'members'), 'm.member_id = n.member_id ')->join(array('c' => 'news_categories'), 'c.id = n.cat_id ')->where('YEAR(news_posted)=?',$year)->order($order));
 
            $paginator = new Zend_Paginator($adapter);
            $paginator->setItemCountPerPage($offset);
            $paginator->setCurrentPageNumber($this->_getParam('page'));
            $this->view->data = $paginator;
        }
    }
}