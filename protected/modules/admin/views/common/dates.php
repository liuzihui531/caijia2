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
                            <input type="text" id="datepicker_begin" name="begin_date" class="form-control datepicker"value="<?php echo $begin_date?date('Y-m-d',  strtotime($begin_date)):'' ?>" placeholder="开始时间"/>
                            <span class="input-group-addon">
                                <i class="icon-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group input-group-sm">
                            <input type="text" id="datepicker_end" name="end_date" class="form-control datepicker" value="<?php echo $end_date?date('Y-m-d',  strtotime($end_date)):''; ?>" placeholder="结束时间"/>
                            <span class="input-group-addon">
                                <i class="icon-calendar"></i>
                            </span>
                        </div>
                    </div>
                    <input type='hidden' name='type' value="1"/>
                    <button type="submit" class="btn btn-purple btn-sm">
                        确定
                        <i class="icon-search icon-on-right bigger-110"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<form class="form-horizontal" id='form_dates' method="post" action='<?php echo $this->createUrl('dodates') ?>'>
    <?php if ($date_list): ?>
        <div class="form-group">
            <label class="col-sm-1 control-label no-padding-right">时间：</label>
            <div class="col-sm-11">
                <?php foreach ($date_list as $k => $v): ?>
                    <label>
                        <input name="Dates[]" type="checkbox" class="ace" <?php if(in_array($v,$dates_arr)): ?>checked="checked"<?php endif; ?> value="<?php echo $v ?>">
                        <span class="lbl">&nbsp;<?php echo date('Y-m-d',  strtotime($v)) ?>&nbsp;&nbsp;</span>
                    </label>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>
    <input type="hidden" name="id" value="<?php echo Yii::app()->request->getParam('id',0); ?>"
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type='submit' id="dates_submit">
                <i class="icon-ok bigger-110"></i>
                提交
            </button>

            &nbsp; &nbsp; &nbsp;
            <button class="btn" type="reset">
                <i class="icon-undo bigger-110"></i>
                重置
            </button>
        </div>
    </div>
    <input type='hidden' name='id' value='<?php echo Yii::app()->request->getParam("id", 0) ?>'>
</form>
<script type="text/javascript">
    jQuery(function ($) {
        $("#datepicker_begin").datepicker({
            showOtherMonths: true,
            selectOtherMonths: false,
            dateFormat: 'yy-mm-dd', //日期格式  
            monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六']
        });
        $("#datepicker_end").datepicker({
            showOtherMonths: true,
            selectOtherMonths: false,
            dateFormat: 'yy-mm-dd', //日期格式  
            monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六']
        });
    });
//    $(function(){
//         $('#dates_submit').bind('click',function(){
//            $.post("<?php echo $this->createUrl('dodates') ?>",$('#form_dates').serialize(),function(data){
//                alert(data.msg)
//                if(data.sta == 1){
//                    
//                }
//            },'json')
//        });
//    })
</script>