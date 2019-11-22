<!DOCTYPE html>
<html>
    <head>
	<meta name="viewport" content="width=1201, user-scalable=no">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="it" />

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/styles.css" />
	<link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jstree/themes/default/style.min.css" />

	<link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico"/>
	<link rel="icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/favicon.ico" type="image/x-icon"/>

	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jquery-1.11.1.min.js"></script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jstree/jstree.min.js"></script>
	<script> var baseUrl = "<?php echo Yii::app()->request->baseUrl ?>" + "/index.php"</script>
	<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/engine.js"></script>

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>

    </head>

    <body>

	<div id="overlay"></div>
	<!-- NAVIGATION BAR -->
	<?php
	if (Yii::app()->user->isGuest) {
	    $this->widget('bootstrap.widgets.TbNavbar', array(
		//'type' => 'inverse',
		//'brand' => 'Title',
		'fixed' => 'top',
		'fluid' => true,
		'items' => array(
		    array(
			'class' => 'bootstrap.widgets.TbMenu',
			'type' => 'navbar',
			'items' => array(
			    array('label' => 'Home', 'icon' => 'home', 'url' => array('/site/index')),
			    array('label' => 'Login', 'icon' => 'off', 'url' => array('/site/login')),
			),
		    ),
		),
	    ));
	} else {
	    $this->widget('bootstrap.widgets.TbNavbar', array(
		#'type' => 'inverse',
		'items' => array(
		    array(
			'class' => 'bootstrap.widgets.TbMenu',
			'items' => array(
			    array('label' => 'Dipendenti', 'icon' => 'icon-user', 'url' => array('/employee/admin')),
			    array('label' => 'Corsi', 'icon' => 'icon-tags', 'url' => array('/course/admin')),
                            array('label' => 'Sedi', 'icon' => 'icon-flag', 'url' => array('/location/admin')),
			)
		    ),		    
		    array(
			'class' => 'bootstrap.widgets.TbMenu',
			'encodeLabel' => false,
			'htmlOptions' => array('class' => 'pull-right'),
			'items' => array(
			    array('label' => 'Admin Tools', 'icon' => 'icon-wrench', 'url' => '#',
				'items' => array(
				    array('label' => 'Export', 'icon' => 'icon-download-alt', 'url' => array('/export/admin')),				    
				    array('label' => 'Admin SRBAC', 'icon' => 'icon-magnet', 'url' => array('/srbac/authitem/assignments')),				    				
				)
			    ),			    
			    array('label' => 'Logout', 'icon' => 'icon-off', 'url' => array('/site/logout'), 'visible' => !Yii::app()->user->isGuest),
			),
		    ),
		),
	    ));
	}
	?>

	<div class="container" id="page">
	    
	    <!-- OPERATIONS -->
            <div class="pull-right">
                    <?php if ( isset($this->menu) && $this->menu != null) {
                        $this->widget('bootstrap.widgets.TbButtonGroup', array(
                            'type'=>'inverse',
                            'buttons'=>$this->menu,
                        ));
                    } ?>                        
            </div>
	    
	    <?php echo $content; ?>

	    <div class="clear"></div>

	    <div id="footer">
		  <p class="pull-right">Created by <a href="http://www.sbrillo.com">Sbrillo Ltd</a></p>
		  <p>Copyright &copy; <?php echo date('Y'); ?> by <a target="_blank" href="http://www.sbrillo.com">Sbrillo Ltd</a>.</p>
	    </div>

	</div><!-- footer -->

</body>

</html>
