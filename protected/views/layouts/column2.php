<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
<div class="row">
    <!-- BREADCRUMB -->
    <div class="span3">
        <div class="row">
            <div class="span marginright-10">
                <?php if (isset($this->breadcrumbs)): ?>
                    <?php $this->widget('bootstrap.widgets.TbBreadcrumbs', array(
                        'links' => $this->breadcrumbs,
                        'homeLink'=> false,
                    )); ?><!-- breadcrumbs -->
                <?php endif ?>
            </div>
        </div>
        <div id="sidebar">
            <?php $this->widget('bootstrap.widgets.TbButton', array(
                'label'=>'x',
                'type'=>'info', // null, 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'size'=>'mini', // null, 'large', 'small' or 'mini'
                'htmlOptions'=>array('id'=>'closeAll', 'class'=>'marginright-10 zindex'),
            ));  ?>
            <?php 
                if(!Yii::app()->user->isGuest) {
                    echo '<div id="jstree" class="column span3"></div>';
                } else echo '<div class="column span3"></div>';
            ?>
        </div><!-- sidebar -->
    </div>
    <div class="span9">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
</div>
<?php $this->endContent(); ?>