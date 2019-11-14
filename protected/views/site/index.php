<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<div class="row">
    
    <?php 
        echo '<div class="column span3"></div>';
    ?>
    
    <div class="column span10">
        <?php $this->beginWidget('bootstrap.widgets.TbHeroUnit',array(
            //'heading'=>'Welcome to '.CHtml::encode(Yii::app()->name)
        )); ?>
        <div class="row marginbottom-5">
            <div class="column span5">
                <h1><i>Soundo</i></h1>
                <?php if (Yii::app()->user->isGuest) { ?>
                <p class="margintop-15"><?php $this->widget('bootstrap.widgets.TbButton', array(
                        'type'=>'primary',
                        'size'=>'large',
                        'label'=>'Login',
                        'url'=>array('/site/login')
                    )); ?></p>
                <?php } ?>

            </div>            
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>





