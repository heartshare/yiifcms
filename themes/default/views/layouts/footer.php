<!-- 底部footer开始 -->
<div id="footer">
	<ul class="ft_header clear">
		<li class="footer_left">
			<h2><?php echo $this->_setting['site_name'];?></h2>
			<p><?php echo $this->_setting['seo_description'];?></p>
		</li>
		<li class="footer_mid">
			<h2>新手指南</h2>
			<ul>
				<li><a href="<?php echo $this->createUrl('page/index', array('title_alias'=>'guide'));?>">新手指南</a></li>
				<li><a href="<?php echo $this->createUrl('page/index', array('title_alias'=>'register'));?>">注册流程</a></li>		
				<li><a href="<?php echo $this->createUrl('page/index', array('title_alias'=>'comment'));?>">评论审核</a></li>		
			</ul>
		</li>
		<li class="footer_mid">
			<h2>快捷通道</h2>
			<ul>
				<li><a href="<?php echo $this->createUrl('page/index', array('title_alias'=>'about'));?>">关于我们</a></li>
				<li><a href="<?php echo $this->createUrl('question/index');?>">留言反馈</a></li>	
			</ul>
		</li>
		<li class="footer_right">
			<h2>Power By <strong>zhao jinhan(Beijing Of China)</strong></h2>			
			<div class="clear">
				<label><img width="70" src="<?php echo $this->_stylePath;?>/images/my_header.jpg" /></label>
				<div class="text">
					<p><a href="http://weibo.com/u/1503697997" class="sinawb_me" target="_blank">Ps冷眸_涵</a></p>
					<p><a href="mailto:xb_zjh@126.com" class="email_me">xb_zjh@126.com</a></p>
					<p><a href="tencent://message/?uin=326196998" class="qq_me">326196998</a></p>
				</div>				
			</div>
		</li>
	</ul>
	<div id="copyright">	
		<div class="clear">
			<span><?php echo $this->_setting['site_copyright'];?></span>	
			<span><?php echo $this->_setting['site_icp'];?></span>			
			<ul class="outer">
				<li><?php echo $this->_setting['site_stats'];?></li>			
			</ul>
		</div>		
	</div>
</div>
<!-- 底部footer结束 -->

<!-- Js script开始 -->
<script type="text/javascript">
	$(function(){		
		//导航菜单
		$("#menu li a").mouseover(function(){
			$(this).next().next("div.child_box").show();
		});
		$("#menu li").mouseleave(function(){
			$(this).children("div.child_box").hide();
		});		
		
		//友情链接滑动				
		var li_len = $(".client_body li").width();		
		var move_len = 3*(li_len+30);	
		var client_len = $(".client_body li").length;
		var max_len = (client_len-1)*li_len;	
		$("#client_left").val(0);
		$(".crt_btn").click(function(){				
			//向左滑动		
			var cur_left = parseFloat($("#client_left").val());			
			var move_left = cur_left - move_len;
			if(client_len <= 6 || Math.abs(move_left) > max_len){
				return;
			}else{			
				$("#client_left").val(move_left);
				$(".client_body").animate({left: move_left+'px'}, "slow");
			}
		});
		$(".clf_btn").click(function(){
			//向右滑动			
			var cur_left = parseFloat($("#client_left").val());					
			var move_left = cur_left + move_len;			
			if(client_len <= 6 || cur_left >= 0 ){
				return;
			}else{		
				$("#client_left").val(move_left);
				$(".client_body").animate({left: move_left+'px'}, "slow");
			}
		});
		//登录状态
		$("#logout").mouseover(function(){
			$(".show_drop").addClass("show_drop_hover");
			$("#drop_down_user").show();
		});
		$("#logout").mouseout(function(){
			$(".show_drop").removeClass("show_drop_hover");
			$("#drop_down_user").hide();
		});
		
		//刷新验证码
		$("#yw0").ready(function(){
		     $('#yw0').trigger('click');
		});		
	});
</script>
<!-- Js script结束 -->
</body>
</html>