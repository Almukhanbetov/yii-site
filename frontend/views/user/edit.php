<? 
use frontend\models\User;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;

$model = new User;
?>
<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data', 'name' => 'formname', 'class' => 'someclass'], 'id' => 'edit-form']); ?>

    <?= $form->field($model, 'email')->textInput(['value' => $userInfo->email]) ?>
    <?= $form->field($model, 'name')->textInput(['value' => $userInfo->name]) ?>
    <?= $form->field($model, 'surname')->textInput(['value' => $userInfo->surname]) ?>
    <?= $form->field($model, 'age')->textInput(['value' => $userInfo->age]) ?>
    <?= $form->field($model, 'sex')->textInput(['value' => $userInfo->sex]) ?>
    <?= $form->field($model, 'about')->textArea([ 'value' => $userInfo->about ]) ?>
    <?= $form->field($model, 'tags')->textInput(['value' => $userInfo->tags]) ?>
    <?= $form->field($model, 'country')->textInput(['value' => $userInfo->country]) ?>
    <?= $form->field($model, 'city')->textInput(['value' => $userInfo->city]) ?>
    <?= $form->field($model, 'avatar')->fileInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>



















<table class="avatar-list" ng-controller="rmAvatar">
<?foreach($avatars as $item):?>
	<tr class="one-avatar" id="avatar-<?=$item->id?>" ><td><img src="<?=Url::to('@web/img/avatars/' . $item->id_user . '/' . $item->img)?>" alt=""></td>
	<td><button class="btn btn-danger" ng-click="removeAvatar(<?=$item->id_user?>, <?=$item->id?>)">Remove</button></td>
	</tr>
<?endforeach;?>
</table>



<script>
	var app = angular.module('app', []);
	app.controller('rmAvatar', function($scope){
		$scope.removeAvatar = function(userID, avatarID){
			var ajax = function(url, func){
			var xhr = new XMLHttpRequest();
			var user = 1;
			var body = 'users=' + user + '&us=' + 10;

			xhr.open("GET", url, true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

			xhr.onreadystatechange = function(){ 
						if(xhr.readyState == 4){ 
							func(xhr.responseText); 
							console.log(xhr);
							document.getElementById('avatar-' + avatarID).remove();
						} 
					}; 

			//xhr.send(body);
			xhr.send();
			console.log(xhr);
			};
				ajax('rmavatar?userID=' + userID + '&avatarID=' + avatarID, function(data){
					console.log(data); 
					
				});
		}
	});
</script>