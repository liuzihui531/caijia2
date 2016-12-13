<div class="main pad7">
		
		<div class="article1">
			<h3><?php echo $projectModel->name ?></h3>
			<p>
				<?php echo $projectModel->desc ?>
			</p>
		</div>
		
		<div class="price">
			<h3><?php echo $placeModel->name ?></h3>
			<?php if ($goodsModel): ?>
				<ul>
					<?php $colorData = array('bgRed','bgYellow','bgBlue','bgYellow'); ?>
					<?php foreach ($goodsModel as $key => $val): ?>
						<?php $colorKey = $key % 4; ?>
						<li data-goodsid="<?php echo $val->id ?>" class="<?php echo $colorData[$colorKey] ?> goodsIsEnableClick"><strong><?php echo $val->goodsCategory->name ?></strong><p><?php echo $val->name ?></p><span><?php echo $val->goodsCategory->unit ?></span>
                                                    <span class='uped_price'><?php echo isset($price_log_data[$val->id][$placeModel->id]) ? "(".$price_log_data[$val->id][$placeModel->id].")" :"" ?></span></li>
					<?php endforeach ?>
				</ul>
			<?php endif ?>			
		</div>
		
		<div class="money" style="display: none">
			<input type="text" name='price' value="" placeholder="请输入价格" class="input_m" />
			<input type="button" value="确认提交" class="btn1 submitPrice" />
			<p><a href="javascript:void(0)" class='transPrice'><img src="/static/front/img/ico_6.png" /></a></p>
			<a href="javascript:void(0)" class='closeMoney'>关闭</a>
		</div>
		<div class="price-hidden">
			<input type="hidden" name="project_id" value="<?php echo $projectModel->id ?>">
			<input type="hidden" name="place_id" value="<?php echo $placeModel->id ?>">
			<input type="hidden" name="goods_id" value="0">
		</div>
	</div>