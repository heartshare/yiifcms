<?php
/**
 * 前端软件控制器
 *
 * @author        zhao jinhan <326196998@qq.com>
 * @copyright     Copyright (c) 2014-2015 . All rights reserved. 
 */
class SoftController extends FrontBase
{
	protected $_catalog;
	
	public function init(){
		parent::init();
		//栏目
		$this->_catalog = Catalog::model()->findAll('status_is=:status AND type = :type',array(':status'=>'Y',':type'=>'soft'));
	}
	  /**
	   * 首页
	   */
	  public function actionIndex() {  	
	    $catalog_id = trim( $this->_request->getParam( 'catalog_id' ) );
	    $keyword = trim( $this->_request->getParam( 'keyword' ) );
	    $catalog = Catalog::model()->findByPk($catalog_id);    
	    //调取子孙分类和当前分类
	    $catalog_ids = Catalog::get($catalog?$catalog_id:0, $this->_catalog);  
	    $children_ids = Helper::array_key_values($catalog_ids, 'id');     
	    $catalog_id?$all_ids = array_merge($children_ids, (array)$catalog_id):$all_ids = $children_ids;   
	    $db_in_ids = implode(',',$all_ids);   
	    //SEO
	    if($catalog){
	    	$this->_seoTitle = $catalog->seo_title?$catalog->seo_title:$catalog->catalog_name.' - '.$this->_setting['site_name'];
	    	$this->_seoKeywords = $catalog->seo_keywords;
	    	$this->_seoDescription = $catalog->seo_description; 
	    	$navs = $catalog->catalog_name;   	
	    }else{ 
	    	$this->_seoTitle = Yii::t('common','SoftListTitle').' - '.$this->_setting['site_name'];
	    	$this->_seoKeywords = Yii::t('common','SoftListKeywords');
	    	$this->_seoDescription = Yii::t('common','SoftListDescription',array('{site_name}'=>$this->_setting['site_name']));
	    	$navs = $this->_seoTitle;
	    }
	    //查询条件
	    $post = new Soft();
	    $criteria = new CDbCriteria();
	    $condition = "t.status = 'Y'";
	    $keyword && $condition .= ' AND title LIKE \'%' . $keyword . '%\'';
	    $condition .= ' AND catalog_id IN ('.$db_in_ids.')';
	   
	    $criteria->condition = $condition;
	    $criteria->order = 'down_count DESC, t.id DESC';
	    $criteria->with = array ( 'catalog' );
	    $criteria->select = "title, id, t.update_time,t.introduce, t.down_count";
	   
	    //分页
	    $count = $post->count( $criteria );    
	    $pages = new CPagination( $count );
	    $pages->pageSize = 10;
	    
	    $criteria->limit = $pages->pageSize;
	    $criteria->offset = $pages->currentPage * $pages->pageSize;
	    
	    $datalist = $post->findAll($criteria);	   
	    
	    //最近的软件
	    $last_softs = Soft::model()->findAll(array('condition'=>'catalog_id IN ('.$db_in_ids.')','order'=>'id DESC','limit'=>10,));
	    
	    //加载css,js	
	    Yii::app()->clientScript->registerCssFile($this->_stylePath . "/css/list.css");
		Yii::app()->clientScript->registerScriptFile($this->_static_public . "/js/jquery/jquery.js");	
		
	    $this->render( 'index', array('navs'=>$navs, 'softs'=>$datalist,'pagebar' => $pages,'last_softs'=>$last_softs));
	  }
  
  
  /**
   * 浏览详细内容
   */
  public function actionView( $id ) {
  	$post = Post::model()->findByPk( intval( $id ) );
  	if ( false == $post )
  		throw new CHttpException( 404, '内容不存在' );
  	//更新浏览次数
  	$post->updateCounters(array ('view_count' => 1 ), 'id=:id', array ('id' => $id ));
  	//seo信息
  	$this->_seoTitle = empty( $post->seo_title ) ? $post->title  .' - '. $this->_setting['site_name'] : $post->seo_title;
  	$this->_seoKeywords = empty( $post->seo_keywords ) ? $this->_seoKeywords  : $post->seo_keywords;
  	$this->_seoDescription = empty( $post->seo_description ) ? $this->_seoDescription: $post->seo_description;
  	$catalogArr = Catalog::model()->findByPk($post->catalog_id);
  
  	//自定义数据
  	//$attrVal = AttrVal::model()->findAll(array('condition'=>'post_id=:postId','with'=>'attr', 'params'=>array('postId'=>$post->id)));
  
  	$tplVar = array(
  			'post'=>$post,
  			'catalogArr'=>$catalogArr,
  
  	);
  	$this->render( 'view', $tplVar);
  }
  
}
 
