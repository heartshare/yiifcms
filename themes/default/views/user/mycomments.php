<div class="user clear">
	<?php
		//引用公共提示信息
	   $this->renderPartial('/layouts/alert');
	?>
	
	<div class="user_left">
		<!-- 用户菜单导航开始 -->
		<?php $this->renderPartial('user_left');?>
		<!-- 用户菜单导航结束 -->
	</div>
	
	<div class="user_right">		
		<div class="user_edit">			
			<h3><?php echo Yii::t('common','Comments Manage');?></h3>
			
		</div>		
	</div>
</div>
