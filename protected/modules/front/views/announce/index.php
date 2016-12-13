<div class="main pad7">
	<div class="notice">
		<ul>
			<?php if($model): ?>
				<?php foreach($model as $key => $val): ?>
					<li><a href="<?php echo $this->createUrl('view',array('id' => $val->id)) ?>"><?php echo $val->title ?></a><span><?php echo date("Y-m-d",$val->created) ?></span></li>
				<?php endforeach ?>
			<?php endif; ?>
		</ul>
	</div>
			
</div>