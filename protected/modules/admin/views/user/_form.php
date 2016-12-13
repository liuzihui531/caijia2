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
    <?php echo $form->labelEx($model, 'sex', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->dropDownlist($model, 'sex', User::getSexKv(), array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'mobile', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'mobile', array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'idcard', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'idcard', array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'password', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'password', array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
    *密码默认为身份证后六位，不填则不作修改
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'birthday', array('class' => 'col-sm-3 control-label no-padding-right')) ?>
    <div class="row">
        <div class="col-sm-3">
            <div class="input-group input-group-sm">
                <input type="text" id="birthday" name="User[birthday]" class="form-control datepicker" <?php if ($model->birthday): ?> value="<?php echo $model->birthday ?>" <?php endif; ?>/>
                <span class="input-group-addon">
                    <i class="icon-calendar"></i>
                </span>
            </div>
        </div>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'depart_id', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->dropDownList($model, 'depart_id', Depart::getDepart(), array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'bank', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'bank', array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'bank_card', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'bank_card', array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'address', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->textField($model, 'address', array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
</div>
<div class="form-group">
    <?php echo $form->labelEx($model, 'education', array('class' => 'col-sm-3 control-label no-padding-right')) ?>

    <div class="col-sm-9">
        <?php echo $form->dropDownList($model, 'education', User::getEducation(), array('class' => 'col-xs-10 col-sm-5', 'placeholder' => '')) ?>
    </div>
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
<script type='text/javascript'>
    jQuery(function ($) {
        $("#birthday").datepicker({
            showOtherMonths: true,
            selectOtherMonths: false,
            dateFormat: 'yy-mm-dd', //日期格式  
            monthNames: ['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月'],
            dayNamesMin: ['日', '一', '二', '三', '四', '五', '六']
        });
    });
</script>