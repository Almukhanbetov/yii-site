<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use frontend\models\Posts;
use frontend\models\Messages;


class PostController extends Controller
{


    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->render('index');
    }



	public function actionPosts(){
		$posts = Posts::find()->all();
		
		
		return $this->render('posts', [
			'posts' => $posts,
			
		]);
	}
	
	public function actionPost(){
		$post = Posts::find()->where(['id' => Yii::$app->request->get()['id']])->one();
		$post->hits += 1;
		$post->save();
		return $this->render('post', [
			'post' => $post
		]);
	}
	
    
}
