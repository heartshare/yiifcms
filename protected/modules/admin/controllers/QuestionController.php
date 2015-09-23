<?php
/**
 * 留言管理
 * 
 * @author        Sim Zhao <326196998@qq.com>
 * @copyright     Copyright (c) 2014-2015. All rights reserved.
 */

class QuestionController extends Backend
{	
    /**
     * 首页
     */
    public function actionIndex() {       
        $model = new Question();
        $criteria = new CDbCriteria();
        $condition = '1';
        $realname = trim( Yii::app()->request->getParam( 'realname' ) );
        $question = trim( Yii::app()->request->getParam( 'question' ) );
        $question && $condition .= ' AND question LIKE \'%' . $question . '%\'';
        $realname && $condition .= ' AND realname LIKE \'%' . $realname . '%\'';
        $criteria->condition = $condition;
        $criteria->order = 't.id DESC';
        $count = $model->count( $criteria );
        $pages = new CPagination( $count );
        $pages->pageSize = 15;
        $pageParams = $this->buildCondition( $_GET, array ( 'site_name' ) );
        $pages->params = is_array( $pageParams ) ? $pageParams : array ();
        $criteria->limit = $pages->pageSize;
        $criteria->offset = $pages->currentPage * $pages->pageSize;
        $result = $model->findAll( $criteria );
        $this->render( 'index', array ( 'datalist' => $result , 'pagebar' => $pages ) );
    }
    
    /**
     * 更新留言
     *
     */
    public function actionUpdate( $id ) {        
        $model = Question::model()->findByPk( $id );
        if ( isset( $_POST['Question'] ) ) {
            $model->attributes = $_POST['Question'];
            if ( $model->save() ) {                
                $this->redirect( array ( 'index' ) );
            }
        }
        $this->render( 'update', array ( 'model' => $model ) );
    }

    /**
     * 批量操作
     *
     */
    public function actionBatch() {
    	
        if ($this->method() == 'GET') {
			$command = trim(Yii::app()->request->getParam('command'));
			$ids = intval(Yii::app()->request->getParam('id'));
		} elseif ($this->method() == 'POST') {
			$command = Yii::app()->request->getPost('command');
			$ids = Yii::app()->request->getPost('id');			
		} else {
			throw new CHttpException(404, Yii::t('admin','Only POST Or GET'));
		}
		empty($ids) && $this->message('error',  Yii::t('admin','No Select'));		

        switch ( $command ) {
        case 'delete':
        	foreach((array)$ids as $id){
        		$questionModel = Question::model()->findByPk($id);
        		if($questionModel){        			
        			$questionModel->delete();
        		}
        	}
        	break;
        default:
            throw new CHttpException(404, Yii::t('admin','Error Operation'));
            break;
        }
        $this->message('success', Yii::t('admin','Batch Operate Success'));
    }

}
