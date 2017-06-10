<?
use yii\helpers\Url;
?>
<div>
	<h1><?=$article->getFullTitle($article->title)?></h1>
	<p><?=$article->text?></p>
	<span><?=$article->author_id?> <?=$article->data?>  <?=$article->getDescription($article->likes, "like")?> <?=$article->getDescription($article->hits, "hit")?></span>
</div>

<p>back to <a href="<?=Url::to('articles')?>">articles list >></a></p>