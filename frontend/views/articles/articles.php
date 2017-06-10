<?
use yii\helpers\Url;

?>

<div class="site-index">
<div class="jumbotron">
<h1>This is title for page</h1>
</div>
<div class="row">

	<?foreach($articles as $article):?>
	<div class="col-lg-4">
		<h2><a href="<?=Url::to(['articles/article', 'id' => $article->id])?>"><?=$article->getFullTitle($article->title)?></a></h2>

		<p><?=$article->getShortText($article->text)?></p>

		<p><a class="btn btn-default" href="<?=Url::to(['articles/article', 'id' => $article->id])?>">Submit »</a></p>
	</div>
	<?endforeach;?>					
</div>
</div>