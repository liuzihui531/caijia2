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
        <th>状态</th>
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
                        <td>
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
                        </td>
                        <?php if ($i != 0): ?></tr><?php endif; ?>
                <?php endfor; ?>
            <?php endforeach; ?>
        </tr>

    <?php endforeach; ?>
<?php endif; ?>
<!--    <tr>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
</tr>
<tr>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
</tr>
<tr>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
</tr>
<tr>
<td rowspan="8">1</td>
<td rowspan="3">1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
</tr>
<tr>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
</tr>
<tr>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
</tr>
<tr>
<td rowspan="2">1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
</tr>
<tr>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
</tr>
<tr>
<td rowspan="3">1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
</tr>
<tr>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
</tr> <tr>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
<td>1</td>
</tr>-->
</table>
