<form method="post">
    <div class="form-group">
        <div class="col-sm-9">
            <?php if ($goods_category): ?>
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th width='200'>商品分类</th>
                            <th>商品</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($goods_category as $k => $v): ?>
                            <tr>
                                <td><?php echo $v['html'] . $v['name']; ?></td>
                                <td>
                                    <?php if (isset($goodsData[$v['id']])): ?>
                                        <?php foreach ($goodsData[$v['id']] as $key => $val): ?>
                                            <label class="pull-left place-checkbox">
                                                <input type="checkbox" <?php if (in_array($val['id'], $modelGoodsIds)): ?>checked='checked'<?php endif ?> class="ace" name='goods_ids[]' value='<?php echo $val['id'] ?>'>
                                                <span class="lbl"> <?php echo $val['name'] ?>&nbsp;&nbsp;</span>
                                            </label>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
    <div class="clearfix form-actions">
        <div class="col-md-offset-3 col-md-9">
            <button class="btn btn-info" type="submit" id="submit">
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
