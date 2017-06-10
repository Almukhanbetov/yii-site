<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\widgets\Pjax;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
	<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.4/angular.min.js"></script>
	
</head>
<body ng-app="app">
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'New service',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [
        ['label' => 'Post', 'url' => ['/post/index']],
        ['label' => 'home', 'url' => ['/site/index']],
        ['label' => 'edit', 'url' => ['/user/edit?id=3']],
        ['label' => 'Contact', 'url' => ['/site/contact']],
        ['label' => 'Views', 'url' => ['/site/views']],
        ['label' => 'Profile', 'url' => ['/user/profile?id=3']],
    ];
    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Signup', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Login', 'url' => ['/site/login']];
    } else {
        $menuItems[] = '<li>'
            . Html::beginForm(['/site/logout'], 'post')
            . Html::submitButton(
                'Logout (' . Yii::$app->user->identity->email . ')',
                ['class' => 'btn btn-link logout']
            )
            . Html::endForm()
            . '</li>';
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; New service <?= date('Y') ?></p>

        <p class="pull-right">All rights reserved &copy;</p>
    </div>
</footer>

<?php $this->endBody() ?>

<?
/*$script3 = <<< JS

var files;
$('input[type=file]').change(function(){
	files = this.files;
	console.log(files);
});


$('form#edit-form').on('beforeSubmit', function(e){
	
	var data = new FormData();
	$.each( files, function( key, value ){
		data.append( key, value );
	});
	
$.ajax({
		url: "submitfile?uploadfiles",
		type: "POST",
		data: data,
		cache: false,
		dataType: "json",
		processData: false, 
		contentType: false, 
		success: function( respond, textStatus, jqXHR ){
			
			if( typeof respond.error === "undefined" ){
				
				var files_path = respond.files;
				var html = "";
				$.each( files_path, function( key, val ){ html += val +"<br>"; } )
				$(".ajax-respond").html( html );
			}
			else{
				console.log("ОШИБКИ ОТВЕТА сервера: " + respond.error );
			}
		},
		error: function( jqXHR, textStatus, errorThrown ){
			console.log("ОШИБКИ AJAX запроса: " + textStatus );
		}
	});
	
	var textData = {
	title: title,
	text: text
	};
		textData = JSON.stringify(textData);
		$.ajax({
		url: "submit?textdata",
		type: "GET",
		data: textData,
		cache: false,
		contentType: "application/json; charset=utf-8", // Так jQuery скажет серверу что это строковой запрос
		success: function( data, textStatus, jqXHR ){

			if( typeof data.error === "undefined" ){
						data = JSON.parse(data);
						jQuery('.profile .rightside').prepend('<div class="post-profile"><div class="left"><img class="main-picture" src="" alt=""></div><div class="right"><span></span><br><h3>' + data.text + '</h3><h5></h5></div></div>');
						
						$('.post-block .input-title').val('');
						$('.rightside .post-block textarea').val('');
						jQuery('.add-post').show();
						jQuery('.post-block').addClass('dNone');
						jQuery('.profile .rightside').prepend(jQuery('.add-post'));
						
					}
					else{
						console.log('ОШИБКИ ОТВЕТА сервера: ' + data.error );
					}
				},
				error: function( jqXHR, textStatus, errorThrown ){
					console.log('ОШИБКИ AJAX запроса2: ' + textStatus );
				}
		});
	
	return false;
});

JS;
$this->registerJs($script3);*/
?>
</body>
</html>
<?php $this->endPage() ?>
