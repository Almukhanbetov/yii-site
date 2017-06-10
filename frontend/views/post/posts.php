<?
use yii\grid\GridView;
use yii\data\ActiveDataProvider;
use frontend\models\Posts;
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\base\Widget;
use frontend\widgets\SomeWidget;
?>
<div class="site-index">
<div class="jumbotron">
<h1>This is title for page</h1>
</div>
<div class="row">

	<?foreach($posts as $post):?>
	<div class="col-lg-4">
		<h2><?=$post->title?></h2>

		<p><?=$post->text?></p>

		<p><a class="btn btn-default" href="<?=$post->alias?>">Submit 1 »</a></p>
	</div>
	<?endforeach;?>			

<?
$dataProvider = new ActiveDataProvider([
    'query' => Posts::find(),
    'pagination' => [
        'pageSize' => 20,
    ],
]);
echo GridView::widget([
    'dataProvider' => $dataProvider,
	 'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        // Обычные поля определенные данными содержащимися в $dataProvider.
        // Будут использованы данные из полей модели.
        'id',
        'title',
		'hits',
		 [
            'attribute' => 'data',
            'format' => ['date', 'php:d F Y']
        ],
		]
]);
?>	
<? 
$model = new Posts;
?>
<?php $form = ActiveForm::begin(['id' => 'login-form']); ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'text') ?>

    <div class="form-group">
        <?= Html::submitButton('Login', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>


<?
class HelloWidget extends Widget
{
    public $message;

    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = 'Hello World';
        }
    }
	public function setMessage($message){
		$this->message = $message;
	}

    public function run()
    {
		$p = Html::tag('p', Html::encode($this->message), ['class' => 'username']);
        return $p;
    }
}

$obj = new HelloWidget();
echo $obj->run();
$obj->setMessage('myMessage');
echo $obj->run();
$obj2 = new SomeWidget;
echo $obj2->run();
?>
</div>
</div>
