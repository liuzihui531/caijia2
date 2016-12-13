<div class="main pad7">
	<?php if ($placeModel): ?>
	<ul class="address">
		<?php foreach ($placeModel as $key => $val): ?>
			<li><a href="<?php echo $this->createUrl("goods",array('projectId' => $projectModel->id,'placeId' => $val->id)) ?>"><?php echo $val->name ?></a><span>10/<?php echo $goodsCount ?></span></li>
		<?php endforeach ?>		
	</ul>				
	<?php endif ?>
</div>