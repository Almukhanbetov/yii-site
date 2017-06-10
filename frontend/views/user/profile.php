<?
use yii\helpers\Url;
use frontend\models\Likes;
use frontend\models\Comments;
use frontend\models\Posts;
use frontend\models\Subscribe;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\LinkPager;
use yii\widgets\Pjax;

$script3 = <<< JS

var files;
$('input[type=file]').change(function(){
	files = this.files;
	console.log(files);
});
$('form#profile-newpost').on('beforeSubmit', function(e){
	console.log('beforeSubmit');
	var data = new FormData();
	$.each( files, function( key, value ){
		data.append( key, value );
	});

	var title = $('.post-block .input-title').val();
	var text = $('.rightside .post-block textarea').val();
	var textData = {
		title: title,
		text: text,
		
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
						console.log(files);
						console.log(data);
						if( files ){
							var uploadFile = "../uploads/" + files[0].name;
						}
						
						jQuery('.profile .rightside').prepend('<div class="post-profile"><div class="left"><img class="main-picture" src=' + uploadFile +  ' alt=""></div><div class="right"><span></span><br><h3>' + data.text + '</h3><h5></h5></div></div>');
						
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
				//$(".ajax-respond").html( html );
			}
			else{
				console.log("ОШИБКИ ОТВЕТА сервера: " + respond.error );
			}
		},
		error: function( jqXHR, textStatus, errorThrown ){
			console.log("ОШИБКИ AJAX запроса: " + textStatus );
		}
	});
	
	return false;
});

JS;
$this->registerJs($script3);

?>

<div class="site-index">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<link rel="stylesheet" href="/frontend/web/assets/slick/slick.css" />
<link rel="stylesheet" href="/frontend/web/assets/slick/slick-theme.css" />
<script src="/frontend/web/assets/slick/slick.min.js"></script>

<div class="row">
<div class="profile">
	<div class="big-avatar">
		<!--<img src="https://placeholdit.imgix.net/~text?txtsize=90&txt=user.big.avatar.slider&w=1000&h=320" alt="">-->
		
		<?foreach($avatars as $avatar):?>
			<img src="<?=Url::to('@web/img/avatars/' . $avatar->id_user . '/' .$avatar->img)?>" alt="">
		<?endforeach;?>
		
	</div>
	<div class="leftside">
		<!--<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=user.avatar&w=280&h=380" alt="">-->
		<div class="user-desc" ng-controller="subscribe">
			<?
			$span = Html::tag('span', $user->age);
			echo Html::tag('h2', $user->name . ' ' . $user->surname . ' ' . $span );
			
			//$isSubscribe = Subscribe::find()->select('id')->where(['id_from' => Yii::$app->user->id, 'id_to' => $idUser ])->one();
			?>
			<?if( Yii::$app->request->get()['id'] != Yii::$app->user->id ):?>
				<div id="subscribe-button"> <!-- ng-include="/frontend/views/user/sub-test.php" --> 
					<?if( $isSubscribe ):
					?>
						<button class="btn btn-danger"  ng-click="unsubscribe(<?=Yii::$app->user->id?>, <?=Yii::$app->request->get()['id']?>, 1)">Unsubscribe</button>
						<button class="btn btn-success dNone"  ng-click="subscribe(<?=Yii::$app->user->id?>, <?=Yii::$app->request->get()['id']?>, 0)">Subscribe!</button>
					<?else:
					?>
						<button class="btn btn-danger dNone"  ng-click="unsubscribe(<?=Yii::$app->user->id?>, <?=Yii::$app->request->get()['id']?>, 1)">Unsubscribe</button>
						<button class="btn btn-success"  ng-click="subscribe(<?=Yii::$app->user->id?>, <?=Yii::$app->request->get()['id']?>, 0)">Subscribe!</button>
					<?endif;
					?>
				</div>
			<?endif;?>
			<h3><?=$user->city . ', ' . $user->country?></h3>
		
			<h4>My goal: be a good developer;</h4>
			<h5><?=$user->about?></h5>
		</div>
		<?if(count($subscribers) > 0):?>
			<div class="subscribers">
			<h3>Your subscribers (<?=count($subscribers)?>):</h3>
				<?foreach($subscribers as $subscriber):?>
					<div><a href="<?=Url::to(['user/profile', 'id' => $subscriber['id_from'] ])?>">
						<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=350%C3%97150&w=40&h=60" alt=""></a>
						<h6>
							<a href="<?=Url::to(['user/profile', 'id' => $subscriber['id_from'] ])?>">
							<?=$subscriber['name'] . ' ' . $subscriber['surname']?>
							</a>
						</h6>
					</div>
				<?endforeach;?>
			</div>
		<?endif;?>
		<?if(count($subscribings) > 0):?>
			<div class="subscribing">
			<h3>Your subscribing (<?=count($subscribings)?>):</h3>
				<?foreach($subscribings as $subscribing):?>
					<div><a href="<?=Url::to(['user/profile', 'id' => $subscribing['id_to'] ])?>">
						<img src="https://placeholdit.imgix.net/~text?txtsize=20&txt=350%C3%97150&w=40&h=60" alt=""></a>
						<h6>
							<a href="<?=Url::to(['user/profile', 'id' => $subscribing['id_to'] ])?>">
							<?=$subscribing['name'] . ' ' . $subscribing['surname']?>
							</a>
						</h6>
					</div>
				<?endforeach;?>
			</div>
		<?endif;?>
		<div class="interests">
		<?foreach($tags as $tag):?>
			<a href="tags?tag=<?=$tag->tag_alias?>"><span><?=$tag->tag_name?></span></a>
			<?endforeach;?>
		</div>
	</div>
	<div class="rightside">
		<div class="post-block dNone">
				<? Pjax::begin();?>
				<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data'], 'id' => 'profile-newpost']); ?>

				   <?=Html::input('text', 'title', '', ['class' => 'input-title', 'placeholder' => 'enter title'])?>
				   <?=Html::textarea('text', '', ['class' => 'add-post-text', 'placeholder' => 'write your post'])?>
				   <?=Html::input('file', 'file')?>
				   
				    <div class="buttons">
						<?= Html::submitButton('publish', [ 'class' => 'btn btn-success save-post', 'id' => 'clickButton' ]) ?>
						<?= Html::submitButton('cancel', [ 'class' => 'btn btn-danger cancel-post' ]) ?>
					</div>

				<?php ActiveForm::end(); ?>

				<div id="message"></div>
				<? Pjax::end();?>

		</div>
		
		<?if( Yii::$app->user->id == Yii::$app->request->get()['id'] ):?>
			<div class="add-post"><a href=""><span>add new post</a></span></div>
		<?endif;?>
		<script>
		$( document ).ready(function() {
			/*
				var files;
				$('input[type=file]').change(function(){
				files = $('input[type=file]').files;
				console.log($('input[type=file]').files);
				});
			*/
		
			$('.add-post').on('click', function(){
				jQuery('.add-post').hide();
				jQuery('.post-block').removeClass('dNone');
				jQuery('.profile .rightside').prepend(jQuery('.post-block'));
				//$('.rightside').prepend('<div class="post-block"><input type="text" class="input-title" name="title" placeholder="enter title"/><textarea name="text" placeholder="write your post" class="add-post-text"></textarea><input type="file" enctype="multypert/form-data" name="file" /><div class="buttons"><button type="submit" class="btn btn-success save-post">publish</button><button class="btn btn-danger cancel-post">cancel</button></div></div>');
				return false;
			});
			/*$('.save-post').on('click', function(event){
				event.stopPropagation(); // Остановка происходящего
				event.preventDefault();  // Полная остановка происходящего
				

			/*	var data = new FormData();
				$.each( files, function( key, value ){
					data.append( key, value );
				});
				console.log(data);
				var title = $('.post-block .input-title').val();
				var text = $('.rightside .post-block textarea').val();
				data._csrf = "<?= Yii::$app->request->getCsrfToken() ?>";
				console.log(data._csrf);
				data = JSON.stringify(data);
				
				
				$.ajax({
				//url: '/views/user/submit.php?uploadfiles',
				url: 'submit?uploadfiles',
				type: 'POST',
				data: data,
				cache: false,
				//dataType: 'json',
				processData: false, // Не обрабатываем файлы (Don't process the files)
				contentType: false, // Так jQuery скажет серверу что это строковой запрос
				success: function( respond, textStatus, jqXHR ){
					// Если все ОК
					if( typeof respond.error === 'undefined' ){
								// Файлы успешно загружены, делаем что нибудь здесь
								// выведем пути к загруженным файлам в блок '.ajax-respond'
								var files_path = respond.files;
								var html = '';
								$.each( files_path, function( key, val ){ html += val +'<br>'; } )
								$('.ajax-respond').html( html );
							}
							else{
								console.log('ОШИБКИ ОТВЕТА сервера: ' + respond.error );
							}
						},
						error: function( jqXHR, textStatus, errorThrown ){
							console.log('ОШИБКИ AJAX запроса1: ' + textStatus );
						}
				});
				*/
																/*	var textData = {   //если что - вернуть
																		title: title,
																		text: text
																	};
																	textData = JSON.stringify(textData);
																	$.ajax({
																	url: 'submit?textdata',
																	type: 'GET',
																	data: textData,
																	cache: false,
																	//dataType: 'json',
																	//processData: true, // Не обрабатываем файлы (Don't process the files)
																	contentType: 'application/json; charset=utf-8', // Так jQuery скажет серверу что это строковой запрос
																	success: function( data, textStatus, jqXHR ){

																		if( typeof data.error === 'undefined' ){
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
																	});*/
			//});
			
			$('.cancel-post').on('click', function(event){
				event.stopPropagation(); // Остановка происходящего
				event.preventDefault();  // Полная остановка происходящего
				jQuery('.add-post').show();
				jQuery('.post-block').addClass('dNone');
			});
			
/*	$(".like").bind("click", function() {
        var link = $(this);
        var id = link.data('id');
        var usr = link.data('usr');
        
        $.ajax({
            url: "like.php",
            type: "POST",
            data: {id:id, usr:usr}, // Передаем ID нашей статьи
            dataType: "json",
            success: function(result) {
                if (!result.error){ //если на сервере не произойло ошибки то обновляем количество лайков на странице
					console.log(result);
                    link.addClass('active'); 
					if(result.isActive){
						link.addClass('active'); 
					}else{
						link.removeClass('active'); 
					}
                    // помечаем лайк как "понравившийся"
                    $('.counter',link).html(result.count);
					
                }else{
                    alert(result.message);
                }
            }
        });
    });
	*/
				

			
		});
		</script>
	<?foreach($posts as $key => $post):?>
		<?if($key % 2 === 0):?>
		<?
			$model = Posts::find()->where(['id' => $post->id ])->one();
			$model->hits += 1;
			$model->save();?>
		<div class="post-profile" ng-controller="like" rel="<?=$post->id?>">
			<div class="post-wrapper">
				<div class="left"><img class="main-picture" src="<?=Url::to('@web/img/posts/' . $post->intro_image )?>" alt=""></div>
				<div class="right" >
					<span><?=$post->data?></span>
					<br>
					<h3><?=$post->intro_text?></h3>
					<?$isLike = count(Likes::find()->where(['id_user' => Yii::$app->request->get()['id'], 'id_post' => $post->id])->all());?>
					<?$countLikes = count(Likes::find()->where(['id_post' => $post->id])->all());?>
					<div class="icons">
						<div class="like <?=$isLike ? "active" : ""?>{{(isActive ? 'active' : '')}}" ng-click="clickLike(<?=Yii::$app->request->get()['id']?>, <?=$post->id?>)"><span class="counter"><?=$countLikes?> </span>  
						</div>
						<div class="hits-icon"><span class="icon"><?=$post->hits?></span></div>
						<div class="comments-icon"><span class="icon"  rel="1"></span></div>
					</div>
					
				</div>
			</div>
		
		<?$comments = Comments::find()->where([  'id_post' => $post->id ])->all();?>
			<?if( count($comments) ):?>
				<div class="comments dNone">
					<h3>Comments:</h3>
					<div id="comments-<?=$post->id?>">
						<?foreach($comments as $comment):?>
						<table class="comment">
							<tr>
								<td><em>user #<?=$comment->id_user?> wrote: </em><br><span>date: <?=$comment->data?></span> </td> 
								<td> <span> <?=$comment->text?></span></td>
							</tr>

						</table>
						<?endforeach;?>
					</div>
					<div class="add-new-comment dNone" rel="1">
						<form method="post">
						<textarea placeholder="enter text" name="text" id="textComment-<?=$post->id?>"></textarea>
						<button class="btn btn-success" ng-click="saveComment(<?=$post->author_id?>, <?=$post->id?>)">add comment!</button>
						</form>
					</div>
					<button class="btn btn-info add-comment">Add comment</button>
				</div>
			<?endif;?>
		</div>
		<?else:?>
		<div class="post-profile" ng-controller="like" rel="<?=$post->id?>">
			<div class="post-wrapper">
				<div class="right">
					<span><?=$post->data?></span>
					<br>
					<h3><?=$post->intro_text?></h3>
					<?$isLike = count(Likes::find()->where(['id_user' => Yii::$app->request->get()['id'], 'id_post' => $post->id])->all());?>
					<?$countLikes = count(Likes::find()->where(['id_post' => $post->id])->all());?>
					<div class="icons">
						<div class="like <?=$isLike ? "active" : ""?>{{(isActive ? 'active' : '')}}" ng-click="clickLike(<?=Yii::$app->request->get()['id']?>, <?=$post->id?>)"><span class="counter"><?=$countLikes?> </span>  
						</div>
						<div class="hits-icon"><span class="icon"></span></div>
						<div class="comments-icon"><span class="icon" rel="1"></span></div>
					</div>
					
				</div>
				<div class="left"><img class="main-picture" src="<?=Url::to('@web/img/posts/' . $post->intro_image )?>" alt=""></div>
			</div>
			<?$comments = Comments::find()->where([  'id_post' => $post->id ])->all();?>
			
				<div class="comments dNone">
					<?if( count($comments) ):?>
						<h3>Comments:</h3>
						<?foreach($comments as $comment):?>
							<table class="comment">
								<tr>
									<td><em>user #<?=$comment->id_user?> wrote: </em><br><span>date: <?=$comment->data?></span> </td> 
									<td> <span> <?=$comment->text?></span></td>
								</tr>

							</table>
						<?endforeach;?>
					<?endif;?>
				</div>
			
			
		</div>
		<?endif;?>
	<?endforeach;?>
		<div class="pagination"><?
		echo LinkPager::widget([ 'pagination' => $pagination ]);
		?></div>
	</div>
</div>
				
</div>
</div>
<script>
	$('.big-avatar').slick({
		 infinite: true,
		 /*speed: 3000,*/
		 dots: true,
		 autoplay: true, 
		 autoplaySpeed: 4000
	});
	
	$( document ).ready(function() {
		$('.comments-icon .icon').on('click', function(){
			if( $(this).attr('rel') == 1 ){
				$(this).parent().parent().parent().parent().parent().find('.comments').removeClass('dNone'); 
				$(this).attr('rel', 0);
			}else{
				$(this).parent().parent().parent().parent().parent().find('.comments').addClass('dNone'); 
				$(this).attr('rel', 1);
			}
			
		});
		$('.add-comment').on('click', function(){
			if( $('.add-new-comment').attr('rel') == 1 ){
				$('.add-new-comment').removeClass('dNone').attr('rel', 0);
				$('.comments button.btn-info').addClass('dNone');
			}else{
				$('.add-new-comment').addClass('dNone').attr('rel', 1);
				$('.comments button.btn-info').removeClass('dNone');
			}
			
		});
	});
	
	var app = angular.module('app', []);
	app.controller('like', function($scope){
	$scope.clickLike = function (idUser, idPost){
		var link = $(this);
		
		$.ajax({
            url: "like",
            type: "GET",
            data: JSON.stringify({user:idUser, post:idPost}), // Передаем ID нашей статьи
            dataType: "json",
            success: function(result) {
				
                if (!result.error){ //если на сервере не произойло ошибки то обновляем количество лайков на странице
					console.log(result);
					if( result.oneLike ){
						$scope.isActive = 1;
						$('.post-profile[rel=' + idPost + ']').find('.like').addClass('active').find('.counter').html(result.allLikes);
						//$('.like').addClass('active');
					}else{
						$scope.isActive = 0;
						$('.post-profile[rel=' + idPost + ']').find('.like').removeClass('active').find('.counter').html(result.allLikes);
						//$('.like').removeClass('active');
					}
					link.closest('span').html(result.allLikes);
					$scope.isActive = '';
                    // помечаем лайк как "понравившийся"
                    $('.counter',link).html(result.allLikes);
					
                }else{
                    alert(result.error);
                }
            }
        });
	};
	$scope.showComments = function(){
		
	}
	$scope.saveComment = function(idUser, idPost){
		
			var ajax = function(url, func){
			var xhr = new XMLHttpRequest();
			//var message = document.getElementById('textComment').value.trim();

			xhr.open("GET", url, true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

			xhr.onreadystatechange = function(){ 
						if(xhr.readyState == 4){ 
							func(xhr.responseText); 

							var data = JSON.parse(xhr.responseText);
							var idComm = 'comments-' + data.idPost;
							var div = document.getElementById(idComm);
							var newTable = document.createElement('table');
							newTable.classList.add('comment');
							var newTr = document.createElement('tr');
							var newTd = document.createElement('td');
							var em = document.createElement('em');
							em.innerHTML = 'user #' + data.idUser + ' wrote: ';
							var span = document.createElement('span');
							span.innerHTML = 'date:' + data.data;
							var span2 = document.createElement('span');
							span2.innerHTML = 'time:' + data.time_comment;
							newTd.appendChild(em);
							newTd.appendChild(span);
							var br =  document.createElement('br');
							newTd.appendChild(br);
							newTd.appendChild(span2);
							
							var newTd2 = document.createElement('td');
							newTd2.innerHTML = data.message;
							div.appendChild(newTable);
							newTable.appendChild(newTr);
							newTr.appendChild(newTd);
							newTr.appendChild(newTd2);
							var id = 'textComment' + idPost;
							document.getElementById(id).value = '';
							
						} 
					}; 
			xhr.send();

			};
				var idMess = 'textComment-' + idPost;
				var message = document.getElementById(idMess).value.trim();
				ajax('addcomment?message=' + message + '&idUser=' + idUser + '&idPost=' + idPost, function(data){
					//console.log(data); 
				});
		}

	
})
	.controller('subscribe', function($scope){
		$scope.isSubscribe2 = function(){
			/*var data = {
					id: <?=Yii::$app->request->get()['id']?>
				};
				
				$.ajax({
					url: "issubscribe?id=" + data.id,
					type: "GET",
					dataType: "json",
					success: function( respond, textStatus, jqXHR ){
						console.log(respond.isSubscribe);
						//$scope.isSubscribe = respond.isSubscribe;
						
					},
					error: function( jqXHR, textStatus, errorThrown ){
						console.log("ОШИБКИ AJAX запроса: " + textStatus );
					}
				});*/
		};
		//$scope.isSubscribe = 1;
		$scope.subscribe = function(idFrom, idTo, isSubscribe ){
						console.log(isSubscribe);
						var ajax = function(url, func){
						var xhr = new XMLHttpRequest();
						xhr.open("GET", url, true);
						xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

						xhr.onreadystatechange = function(){ 
									if(xhr.readyState == 4){ 
										func(xhr.responseText); 
										var data = JSON.parse(xhr.responseText);
										//console.log(data);
										$scope.isSubscribe = ( data.status === 'OK' ) ? 1 : 0;
										$('#subscribe-button .btn-success').hide();
										$('#subscribe-button .btn-danger').show();
										//<button class="btn btn-danger" ng-click="unsubscribe(<?=Yii::$app->user->id?>, <?=Yii::$app->request->get()['id']?>)">Unsubscribe</button>
										/*var div = document.getElementById('subscribe-button');
										div.removeChild(div.children[0]);
										
										var button = document.createElement('button');
										button.classList.add('btn');
										button.classList.add('btn-danger');
										button.innerHTML = 'Unsubscribe';
										button.setAttribute('ng-click', 'unsubscribe(<?=Yii::$app->user->id?>, <?=Yii::$app->request->get()["id"]?>)');
										div.appendChild(button);*/
									} 
								}; 
						xhr.send();

						};
							
						ajax('subscribe?idFrom=' + idFrom + '&idTo=' + idTo, function(data){
							//console.log(data); 
						});

		};
		$scope.unsubscribe = function(idFrom, idTo, isSubscribe){
			console.log(isSubscribe);
			var ajax = function(url, func){
			var xhr = new XMLHttpRequest();
			xhr.open("GET", url, true);
			xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

			xhr.onreadystatechange = function(){ 
						if(xhr.readyState == 4){ 
							func(xhr.responseText); 
							var data = JSON.parse(xhr.responseText);
							console.log(data);
							$scope.isSubscribe = ( data.status !== 'OK' ) ? 0 : 1;
							$('#subscribe-button .btn-success').show();
							$('#subscribe-button .btn-danger').hide();
						} 
					}; 
			xhr.send();

			};
				
				ajax('subscribe?un=1&idFrom=' + idFrom + '&idTo=' + idTo, function(data){
					console.log(data); 
				});
		};
	});
</script>