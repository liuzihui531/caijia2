<div class="row">
    <div class="col-xs-12">
        <div class="table-responsive">
            <!--搜索框开始-->
            <div class="widget-box">
                <div class="widget-header">
                    <h4>搜索框</h4>
                </div>
                <div class="widget-body">
                    <div class="widget-main">
                        <form class="form-inline" method="get">
                            <input type="text" name="name" value="<?php echo Yii::app()->request->getParam('name', '') ?>" class="input-medium" placeholder="项目名称">
                            <button type="submit" class="btn btn-purple btn-sm">
                                搜索
                                <i class="icon-search icon-on-right bigger-110"></i>
                            </button>
                            <a href="<?php echo $this->createUrl('create') ?>" class="btn btn-primary btn-sm">添加</a>
                            <a href="javascript:void(0)" data-url="<?php echo $this->createUrl('delete') ?>" class="btn btn-danger delete btn-sm">删除</a>
                        </form>
                    </div>
                </div>
            </div>
            <!--搜索框结束-->
            <?php if ($model): ?>
                <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="center">
                                <label>
                                    <input type="checkbox" class="ace" />
                                    <span class="lbl"></span>
                                </label>
                            </th>
                            <th>项目名称</th>
                            <th>日期</th>
                            <th>采价点</th>
                            <th class="hidden-480">创建时间</th>

                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php foreach ($model as $k => $v): ?>
                            <tr>
                                <td class="center">
                                    <label>
                                        <input type="checkbox" class="ace delete-id" name="id[]" value="<?php echo $v->id ?>" />
                                        <span class="lbl"></span>
                                    </label>
                                </td>
                                <td><?php echo $v->name ?></td>
                                <td><?php echo $v->dates?'已填':"<font color='red'>未填</font>"; ?></td>
                                <td><?php echo $v->place_ids?'已填':"<font color='red'>未填</font>"; ?></td>
                                <td><?php echo date('Y-m-d H:i:s', $v->created) ?></td>
                                <td>
                                    <a href="<?php echo $this->createUrl('common/index', array('id' => $v->id,'type'=>'project')) ?>">编辑采价点</a>
                                    <a href="<?php echo $this->createUrl('common/dates', array('id' => $v->id)) ?>">编辑日期</a>
                                    <a href="<?php echo $this->createUrl('common/report', array('id' => $v->id)) ?>">查看采价</a>
                                    <a href="<?php echo $this->createUrl('update', array('id' => $v->id)) ?>">修改</a>
                                    <a href="javascript:void(0)" class="delete-single" data-url="<?php echo $this->createUrl('delete', array('id' => $v->id)) ?>">删除</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="page">
                    <ul class="pagination">
                        <?php
                        $this->widget('CLinkPager', array(
                            //'header' => '共' . $pager->getItemCount() . '条记录',
                            'header' => '',
                            'firstPageLabel' => '首页',
                            'lastPageLabel' => '末页',
                            'prevPageLabel' => '上一页',
                            'nextPageLabel' => '下一页',
                            'pages' => $pager,
                            'maxButtonCount' => 5,
                            'cssFile' => '',
                            'internalPageCssClass' => '',
                            'selectedPageCssClass' => 'active',
                            'htmlOptions' => array(
                                'class' => 'pagination clear',
                            ),
                                )
                        );
                        ?>
                    </ul>
                </div>
            <?php else: ?>
                <div class="no-record">
                    暂无数据
                </div>
            <?php endif; ?>
        </div><!-- /.table-responsive -->
    </div><!-- /span -->
</div><!-- /row -->