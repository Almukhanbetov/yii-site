<?
use frontend\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
$model = new User;
?>

<? Pjax::begin();?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'edit-form']); ?>

    <?= $form->field($model, 'email') ?>
    <?= $form->field($model, 'name') ?>
    <?= $form->field($model, 'surname') ?>
   
    <?= $form->field($model, 'age') ?>
    <?= $form->field($model, 'sex') ?>
    <?= $form->field($model, 'about')->textArea() ?>
    <?= $form->field($model, 'tags') ?>
    <?= $form->field($model, 'country') ?>
    <?= $form->field($model, 'city') ?>
    <?= $form->field($model, 'avatar')->fileInput() ?>

    <div class="form-group" id="this-block">
	<?var_dump($success);?>
<?	if(!$success):?>
    <?= Html::submitButton('Login', ['class' => 'btn btn-success', 'id' => 'clickButton']) ?>
<?else:?>
	<?= Html::submitButton('Login', ['class' => 'btn btn-danger', 'id' => 'clickButton' ]) ?>
<?endif;?>
       <!-- <?= Html::a("Login", ['user/test'], ['class' => 'btn btn-success']) ?>-->
    </div>

<?php ActiveForm::end(); ?>
<div id="reload"><?if($userMy->name){
	echo $userMy->name ;
}else{
	echo 'no';
}?></div>
<div id="message"></div>
<? Pjax::end();?>
<?php
/*
$script = <<< JS
$('form#edit-form').on('beforeSubmit', function(e){
	
	var \$form = $(this);
	$.ajax({
		url: "test",
		type: "POST",
		data: \$form.serialize(),
		
		success: function(data){
			//console.log(data);
			$('#reload').html('success');
			\$pjax.reload({container: '#this-block'});
		},
		error: function(data){
			$('#reload').html('error');
		}
	});
	return false;
});

JS;
$this->registerJs($script);
$script2 = <<< JS
$('form#edit-form').on('beforeSubmit', function(e){
	var \$form = $(this);
	$.post(
		\$form.attr('action'),
		\$form.serialize()
	)
		.done(function(result){
			console.log(result);
			if( result == 1 ){
				//$(document).find('#secondmodal').modal('hide');
				\$pjax.reload({container: '#reload'});
			}else{
				$(\$form).trigger('reset');
				$('#message').html(result.message);
			}
		}).fail(function(){
			console.log('server error');
		});
	return false;
});

JS;

*/



	
/*$script = <<< JS
    alert("Hi");
JS;
$this->registerJs($script);*/
?>
