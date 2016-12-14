<div class="widget-box">
    <div class="widget-header">
        <h4>日期搜索框</h4>
    </div>
    <div class="widget-body">
        <div class="widget-main">
            <form class="form-inline" method="get">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="input-group input-group-sm">
                            <input type="text" id="datepicker_date" name="date" class="form-control datepicker"value="<?php echo Yii::app()->request->getParam('date','') ?>" placeholder="时间"/>
                            <span class="input-group-addon">
                                <i class="icon-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-purple btn-sm">
                        确定
                        <i class="icon-search icon-on-right bigger-110"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php if($price_log_data): ?>

<form>
<table class="table table-hover table-bordered">
    <tr>
        <th colspan="2">品种</th>
        <th>规格</th>
        <?php if($place_model): ?>
            <?php foreach ($place_model as $k => $v): ?>
        <th><?php echo $v['name'] ?></th>
            <?php endforeach; ?>
        <?php endif; ?>
        <th>今日平均</th>
        <th>昨日平均</th>
        <!--<th>状态</th>-->
    </tr>
    <?php if ($all_count): ?>
        <?php foreach ($all_count as $k => $v): ?>
            <tr>
                <td rowspan="<?php echo $v ?>"><?php echo $goods_data[$k] ?></td>
                <?php foreach ($group_count[$k] as $key => $val): ?>
                    <td rowspan="<?php echo $val ?>"><?php echo $goods_data[$key] ?></td>
                    <?php for ($i = 0; $i < $val; $i++): ?>
                        <?php if ($i != 0): ?><tr><?php endif; ?>
                        <td><?php echo $all_goods[$k][$key][$i]['name'] ?></td>
                        <?php $today_price =0;$today_count = 0; ?>
                        <?php foreach ($place_model as $kk => $vv): ?>
                            <td>
                                <?php 
                                    $goods_id = $all_goods[$k][$key][$i]['id'];
                                    $place_id = $vv['id'];
                                    $price = isset($price_log_data[$goods_id][$place_id]) ?  $price_log_data[$goods_id][$place_id] : 0;
                                    echo $price;
                                    if($price > 0){//价格大于0才计算
                                        $today_price += $price;
                                        $today_count += 1;
                                    }
                                ?>
                            </td>
                        <?php endforeach; ?>
                        <td><?php echo $today_count == 0 ? 0 : $today_price/$today_count ?></td>
                        <td><?php echo isset($yesterday_data[$good_id]) ? $yesterday_data[$good_id] : 0 ?></td>
<!--                        <td>
                            <?php if(isset($price_operate_data[$goods_id])): ?>
                                <?php if($price_operate_data[$goods_id]['status'] == 1): ?>
                                    已上报&nbsp;&nbsp;<a href="<?php echo $this->createUrl("audit",array('id' => $price_operate_data[$goods_id]['id'])) ?>">去审核</a>
                                <?php elseif($price_operate_data[$goods_id]['status'] == 2): ?>
                                    已审核
                                <?php endif; ?>
                            <?php else: ?>
                                    未上报&nbsp;&nbsp;
                                    <a href="<?php echo $this->createUrl("up",array('goods_id' => $goods_id,'date' => $date,'project_id' => $project_id,'today_price'=>$today_price,'total_count' => $today_count)) ?>">去上报</a>
                            <?php endif; ?>
                        </td>-->
                        <?php if ($i != 0): ?></tr><?php endif; ?>
                <?php endfor; ?>
            <?php endforeach; ?>
        </tr>

    <?php endforeach; ?>
<?php endif; ?>

</table>
    <?php else: ?>
    暂无数据
    <?php endif; ?>
    <div class="clearfix form-actions">
    <div class="col-md-offset-3 col-md-9">
        <button class="btn btn-info" type="button" id="submit">
            <i class="icon-ok bigger-110"></i>
            上报
        </button>
    </div>
</div>
</form>
<script type="text/javascript">
     jQuery(function ($) {
        $("#datepicker_date").datepicker({
            showOtherMonths: true,
            selectOtherMonths: false,
            dateFormat: 'yy-mm-dd', //日期格式  
            monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六']
        });
    });
</script>
