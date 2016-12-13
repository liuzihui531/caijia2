<style>
    .is_hidden{display: none}
    .is_active{display: inline}    
</style>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id' => 'id-form',
    'action' => $this->createUrl('save'),
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'role' => 'form',
    ),
        ));
?>
<?php if ($model->id): ?>
    <input type="hidden" name="id" value="<?php echo $model->id ?>" />
<?php endif; ?>
<div class="form-group">
    <?php echo $form->labelEx($model, 'name', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'name', array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'depart_ids', array('class' => 'col-sm-3 control-label no-padding-right')) ?>
    <div class="col-sm-9">
        <?php if ($departModel = Depart::getDepart()): ?>
            <?php foreach ($departModel as $k => $v): ?>
                <label>
                    <input name="Project[depart_ids][]" type="checkbox" class="ace" value="<?php echo $k ?>" <?php if(in_array($k,explode(',',$model->depart_ids))): ?>checked="checked"<?php endif; ?>>
                    <span class="lbl">&nbsp;<?php echo $v ?>&nbsp;&nbsp;</span>
                </label>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'goodscate_ids', array('class' => 'col-sm-3 control-label no-padding-right')) ?>
    <div class="col-sm-9">
        <?php if ($goodsCateModel = GoodsCategory::getPcateKv()): ?>
            <?php foreach ($goodsCateModel as $k => $v): ?>
                <label>
                    <input name="Project[goodscate_ids][]" type="checkbox" class="ace" value="<?php echo $k ?>" <?php if(in_array($k,explode(',',$model->goodscate_ids))): ?>checked="checked"<?php endif; ?>>
                    <span class="lbl">&nbsp;<?php echo $v ?>&nbsp;&nbsp;</span>
                </label>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'first', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <input type='text' name="First[start][0]" value="<?php echo isset($first['start'][0]) ? $first['start'][0] : 7 ?>" style='width:60px'> : 
        <input type='text' name="First[start][1]" value="<?php echo isset($first['start'][1]) ? $first['start'][1] : 0 ?>" style='width:60px' >
        ----
        <input type='text' name="First[end][0]" value="<?php echo isset($first['end'][0]) ? $first['end'][0] : 17 ?>" style='width:60px'> : 
        <input type='text' name="First[end][1]" value="<?php echo isset($first['end'][1]) ? $first['end'][1] : 30 ?>" style='width:60px'>
    </div>
</div>
<div class="form-group">
    <label class='col-sm-3 control-label no-padding-right'></label>

    <input type='checkbox' name='is_second' <?php if ($second): ?>checked="checked<?php endif ?> class="is_second">添加第二次采价时间
</div>
<div class="form-group <?php if (!$second): ?>is_hidden<?php else: ?>is_active<?php endif ?> second_caijia">
    <?php echo $form->labelEx($model, 'second', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <input type='text' name="Second[start][0]" value="<?php echo isset($second['start'][0]) ? $second['start'][0] : '' ?>" style='width:60px'> : 
        <input type='text' name="Second[start][1]" value="<?php echo isset($second['start'][1]) ? $second['start'][1] : '' ?>" style='width:60px'>
        ----
        <input type='text' name="Second[end][0]" value="<?php echo isset($second['end'][0]) ? $second['end'][0] : '' ?>" style='width:60px'> : 
        <input type='text' name="Second[end][1]" value="<?php echo isset($second['end'][1]) ? $second['end'][1] : '' ?>" style='width:60px'>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'desc', array('class' => 'col-sm-3 control-label no-padding-right')) ?>
    <?php echo $form->textArea($model, 'desc', array('rows' => 10, 'cols' => 60)); ?>
</div>
<div class="clearfix form-actions">
    <div class="col-md-offset-3 col-md-9">
        <button class="btn btn-info" type="button" id="submit">
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
<?php $this->endWidget(); ?>
<script type="text/javascript">
    $(function () {
        $('.is_second').on('click', function () {
            if ($('.second_caijia').hasClass('is_hidden')) {
                $('.second_caijia').removeClass('is_hidden').addClass('is_active');
            } else {
                $('.second_caijia').removeClass('is_active').addClass('is_hidden');
            }
        });
    })
</script>