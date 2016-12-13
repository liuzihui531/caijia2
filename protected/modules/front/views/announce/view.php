<style type="text/css">
	.article *{background: #f0e6e6 !important;}
</style>
<div class="main pad7">
	
	<div class="article">
		<h3><?php echo $model->title ?></h3>
		<span>通知公告｜<?php echo date("m.d.Y",$model->created) ?></span>
		<p>
			<?php echo Utils::deSlashes($model->content) ?>
		</p>
	</div>
			
</div>