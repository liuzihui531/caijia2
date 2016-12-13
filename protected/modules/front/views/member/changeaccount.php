<div class="main pad7">

    <div class="vip1">
        <p>
            <strong><?php echo $model->name ?></strong>
            采价号：<?php echo $model->mobile ?>
        </p>
        <ul>
            <li><a href="<?php echo $this->createUrl('changeAttr', array('field' => 'sex')) ?>">性别</a></li>
            <li><a href="<?php echo $this->createUrl('changeAttr', array('field' => 'birthday')) ?>">生日</a></li>
            <li><a href="<?php echo $this->createUrl('changeAttr', array('field' => 'education')) ?>">学历</a></li>
        </ul>
        <ul>
            <li><a href="<?php echo $this->createUrl('changeAttr', array('field' => 'mobile')) ?>">联系方式</a></li>
            <li><a href="<?php echo $this->createUrl('changeAttr', array('field' => 'address')) ?>">家庭地址</a></li>
        </ul>
        <ul>
            <li><a href="<?php echo $this->createUrl('changeAttr', array('field' => 'idcard')) ?>">身份证号码</a></li>
            <li><a href="<?php echo $this->createUrl('changeAttr', array('field' => 'bank_card')) ?>">银行卡号码</a></li>
        </ul>
    </div>


</div>