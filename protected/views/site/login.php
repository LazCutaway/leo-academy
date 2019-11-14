<?php
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */

$this->pageTitle = Yii::app()->name . ' - Login';
$this->breadcrumbs = array(
	'Login',
);
?>

<div class="row">

	<div class="column span3"></div>

	<div class="column span9">
		<h1>Login</h1>

		<p>Inserisci le credenziali:</p>

		<div class="form">

			<?php
			$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
				'id' => 'login-form',
				'type' => 'horizontal',
				'enableClientValidation' => true,
				'clientOptions' => array(
					'validateOnSubmit' => true,
				),
			));
			?>

			<?php echo $form->textFieldRow($model, 'username', array('tabindex' => '1')); ?>

			<?php
			echo $form->passwordFieldRow($model, 'password', array(
				'hint' => '',
				'tabindex' => '1',
			));
			?>

			    <?php echo $form->checkboxRow($model, 'rememberMe'); ?>

			<div class="form-actions">
				<?php
				$this->widget('bootstrap.widgets.TbButton', array(
					'buttonType' => 'submit',
					'type' => 'primary',
					'label' => 'Login',
				));
				?>
			</div>

<?php $this->endWidget(); ?>

		</div><!-- form -->
	</div>
</div>