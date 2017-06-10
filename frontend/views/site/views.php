<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

//var_dump($messages);


?>
<h1>Все записи из формы контактов:</h1>
<table>
<tbody>
<?foreach($messages as $message):?>
	<tr>
		<td><?=$message->name?></td>
		<td><?=$message->subject?></td>
		<td><?=$message->email?></td>
		<td><?=$message->body?></td>

	</tr>
<?endforeach;?>
</tbody>
</table>

