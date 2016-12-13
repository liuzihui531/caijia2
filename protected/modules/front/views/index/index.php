<div class="main pad7">

    <div class="system mt1">
        <h3>采价系统</h3>
        <?php if ($userProject): ?>            
        <ul>
        <?php foreach ($userProject as $key => $val): ?>
            <li><a href="<?php echo $this->createUrl('project/place',array('id' => $val->id)) ?>"><b><?php echo $key+1 ?></b><?php echo $val->name ?></a></li>            
        <?php endforeach ?>
        </ul>
        <?php endif ?>
    </div>

    <div class="notice mt1">
        <h3>通知公告</h3>
        <ul>
            <?php if ($announceModel): ?>
                <?php foreach ($announceModel as $key => $val): ?>
                    <li><a href="<?php echo $this->createUrl("/front/announce/view",array('id' => $val->id)) ?>"><?php echo $val->title ?></a><span><?php echo date('Y-m-d',$val->created) ?></span></li>
                <?php endforeach ?>
            <?php endif ?>
            
        </ul>
    </div>



</div>



