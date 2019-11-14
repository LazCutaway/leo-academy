<?php /* @var $this Controller */ ?>
<?php $this->beginContent('//layouts/main'); ?>
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
<div class="row">
    <div class="span12">
        <div id="content">
            <?php echo $content; ?>
        </div><!-- content -->
    </div>
</div>
<?php $this->endContent(); ?>