<form method="post" id='form_changeattr'>
    <div style='width:80%;margin:20px auto'>
        <?php if ($field == 'sex'): ?>
            <select name='Field[sex]' class='input_m'>
                <?php if ($sex = User::getSexKv()): ?>
                    <?php foreach ($sex as $k => $v): ?>
                        <option value="<?php echo $k ?>" <?php if ($model->sex == $k): ?>selected="selected"<?php endif; ?>><?php echo $v ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        <?php endif; ?>
        <?php if ($field == 'birthday'): ?>
            <input type='text' name='Field[birthday][]'class='input_m' value="<?php echo substr($model->birthday, 0, 4) ?>" />年
            <input type='text' name='Field[birthday][]'class='input_m' value="<?php echo substr($model->birthday, 4, 2) ?>" />月
            <input type='text' name='Field[birthday][]'class='input_m' value="<?php echo substr($model->birthday, 6, 2) ?>" />日
        <?php endif; ?>
        <?php if ($field == 'education'): ?>
            <select name='Field[education]' class='input_m'>
                <?php if ($education = User::getEducation()): ?>
                    <?php foreach ($education as $k => $v): ?>
                        <option value="<?php echo $k ?>" <?php if ($model->education == $k): ?>selected="selected"<?php endif; ?>><?php echo $v ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        <?php endif; ?>
        <?php if ($field == 'mobile'): ?>
            <input type='text' name='Field[mobile]'class='input_m' value="<?php echo $model->mobile ? $model->mobile : ''; ?>" />
        <?php endif; ?>
        <?php if ($field == 'address'): ?>
            <input type='text' name='Field[address]'class='input_m' value="<?php echo $model->address ? $model->address : ''; ?>" />
        <?php endif; ?>
        <?php if ($field == 'idcard'): ?>
            <input type='text' name='Field[idcard]'class='input_m' value="<?php echo $model->idcard ? $model->idcard : ''; ?>" />
        <?php endif; ?>
        <?php if ($field == 'bank_card'): ?>
            <input type='text' name='Field[bank_card]'class='input_m' value="<?php echo $model->bank_card ? $model->bank_card : ''; ?>" />
        <?php endif; ?>
        <?php if ($field == 'password'): ?>
            <input type='text' name='Field[password]'class='input_m' value="" />
        <?php endif; ?>
        <input type='button' class='btn1 changeattr_submit' value='提交'>
    </div>
</form>