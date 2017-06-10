<h1>Логин:</h1>
<?
use yii\widgets\ActiveForm;
use yii\helpers\Html;

$form = ActiveForm::begin();
echo $form->field($loginModel, 'email')->textInput([ 'placeholder' => 'enter email' ]);
echo $form->field($loginModel, 'password')->passwordInput([ 'placeholder' => 'enter password' ]);
echo Html::submitButton('Enter', ['class' => 'btn btn-success']);

$form = ActiveForm::end();