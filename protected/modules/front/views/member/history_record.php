<div class="main pad7">
    <?php if ($model): ?>
        <?php foreach ($model as $k => $v): ?>
            <div class="article1">
                <h3><?php echo $v['project_name'] ? $v['project_name'] : ""; ?></h3>
                <p>
                    <?php echo $v['project_desc'] ? $v['project_desc'] : ''; ?>
                </p>
            </div>

            <ul class="record">
                <?php if($v['logModel']): ?>
                <?php foreach ($v['logModel'] as $key => $val): ?>
                    <li>
                        <h3 class="clearfix"><strong><?php echo $val->goodscate->name ?></strong><font><?php echo $val->goods->name ?></font><span><?php echo $val->goodscate->unit ?></span></h3>
                        <p class="clearfix">
                            <strong><?php echo $val->price ?>元</strong><span><?php echo date('Y-m-d H:i:s',$val->created) ?></span>
                        </p>
                        <p class="clearfix">
                            <strong><?php echo $val->place->name ?></strong>
                            <span>
                                <?php 
                                    if($val->times == 1){
                                        list($start,$end) = explode("-", $val->project_first);
                                    }elseif($val->times == 2){
                                        list($start,$end) = explode("-", $val->project_second);
                                    }
                                ?>
                                <?php echo $start,"分到",$end,'分' ?>上报
                            </span>
                        </p>
                    </li>
                <?php endforeach; ?>
                <?php endif; ?>
            </ul>
        <?php endforeach; ?>
    <?php endif; ?>
</div>