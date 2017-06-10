<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use frontend\models\User;
use frontend\models\Tagchain;
use frontend\models\Tags;
use frontend\models\Subscribe;
use frontend\models\Avatars;
use frontend\models\Posts;
use frontend\models\Likes;
use frontend\models\Comments;
use frontend\models\UploadForm;
use yii\web\UploadedFile;
use yii\data\Pagination;

/**
 * Site controller
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

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
	 public function beforeAction($action){
		 //if($action->id)
			 $this->enableCsrfValidation = false;
		 return parent::beforeAction($action);
	 }
	 
	 
	 
    public function actionProfile()
    {
		$idUser = (Yii::$app->request->get()['id'] ? intval(Yii::$app->request->get()['id']) : 0);
		$user = User::find()->where(['id' => $idUser ])->one();

		//$tags = Tagchain::findBySql("SELECT `tags`.`tag_name` FROM `tags` JOIN `tagchain` ON `tags`.`id` = `tagchain`.`id_tag` WHERE `tagchain`.`id_user` = 3")->all();
		$tags = Tags::findBySql("SELECT `tags`.`tag_name`, `tags`.`tag_alias` FROM `tags` JOIN `tagchain` ON `tags`.`id` = `tagchain`.`id_tag`")->
									where([ 'id_user' => $idUser ])->all();

		$query = new \yii\db\Query;
		$query->select('*')
            ->from('`user`')
            ->leftJoin('`subscribe`', '`user`.`id` = `subscribe`.`id_from`')
			->where(['`subscribe`.`id_to`' => $idUser ]);
           // ->limit(10);
		$command = $query->createCommand();
		$subscribers = $command->queryAll();

		$query = new \yii\db\Query;
		$query->select('*')
            ->from('`user`')
            ->leftJoin('`subscribe`', '`user`.`id` = `subscribe`.`id_to`')
			->where(['`subscribe`.`id_from`' => $idUser ]);
           // ->limit(10);
		$command = $query->createCommand();
		$subscribings = $command->queryAll();
		$isSubscribe = Subscribe::find()->select('id')->where(['id_from' => Yii::$app->user->id, 'id_to' => $idUser ])->one();

		$avatars = Avatars::find()->where([ 'id_user' => $idUser ])->all();
		$posts = Posts::find()->where([ 'author_id' => $idUser ]);
		//$posts = Posts::find();
		$pagination = new Pagination([
			'defaultPageSize' => 10,
			'totalCount' => $posts->count()
		]);
		$posts = $posts->offset( $pagination->offset )->limit( $pagination->limit )->all();
		//var_dump($posts);die();
		

		if( Yii::$app->request->post()['save-post'] ){
			//echo 555;
		}
		$query = new \yii\db\Query;
		$query->select('*')
            ->from('`tagchain`')
            ->leftJoin('`tags`', '`tagchain`.`id_tag` = `tags`.`id`');
            //->limit($Limit);
		$command = $query->createCommand();
		$resp = $command->queryAll();
		//var_dump($resp);
		
		
        return $this->render('profile', 
		[
			'user' => $user,
			'tags' => $tags,
			'subscribers' => $subscribers,
			'subscribings' => $subscribings,
			'avatars' => $avatars,
			'posts' => $posts,
			'isSubscribe' => $isSubscribe,
			'pagination' => $pagination
			
		]);
    }
	
	/*public function actionIssubscribe(){
		if( Yii::$app->request->isAjax ){
			$idUser = (Yii::$app->request->get()['id'] > 0 ? intval(Yii::$app->request->get()['id']) : 0);
			
			if( $idUser ){
				$isSub = Subscribe::find()->select('id')->where([ 'id_from' => Yii::$app->user->id , 'id_to' => $idUser ])->one();
				
				$data = (object) array( 'isSubscribe' => count($isSub) );
				echo json_encode($data);
				
			}else{
				return false;
			}
		}

	}*/
	
	public function actionEdit(){
		
		if( Yii::$app->request->isPost ){
			
			$idUser = Yii::$app->user->id;
			$user = User::find()->where([ 'id' => $idUser ])->one();
			(Yii::$app->request->post()["User"]['email'] ? $user->email = Yii::$app->request->post()["User"]['email'] : "");
			(Yii::$app->request->post()["User"]['name'] ? $user->name = Yii::$app->request->post()["User"]['name'] : "");
			(Yii::$app->request->post()["User"]['surname'] ? $user->surname = Yii::$app->request->post()["User"]['surname'] : "");
			(Yii::$app->request->post()["User"]['age'] ? $user->age = Yii::$app->request->post()["User"]['age'] : "");
			(Yii::$app->request->post()["User"]['sex'] ? $user->sex = Yii::$app->request->post()["User"]['sex'] : "");
			(Yii::$app->request->post()["User"]['about'] ? $user->about = Yii::$app->request->post()["User"]['about'] : "");
			(Yii::$app->request->post()["User"]['tags'] ? $user->tags = Yii::$app->request->post()["User"]['tags'] : "");
			(Yii::$app->request->post()["User"]['country'] ? $user->country = Yii::$app->request->post()["User"]['country'] : "");
			(Yii::$app->request->post()["User"]['city'] ? $user->city = Yii::$app->request->post()["User"]['city'] : "");
			
			$user->save();
			
			($_FILES["User"]["name"]['avatar'] ? $user->avatar = UploadedFile::getInstance($user, 'avatar') : "");
			if( $user->avatar && $user->validate() ){
				$model = new Avatars;
				$user->avatar->saveAs(Yii::getAlias('@frontend/web/img/avatars/' . 
								$idUser . '/') . $user->avatar->baseName . '.' . 
								$user->avatar->extension);
				
				$model->img = $user->avatar->baseName . '.' . $user->avatar->extension;
				$model->data = date("Y-m-d");
				$model->id_user = Yii::$app->request->get()['id'];
				$model->save();
				
				Yii::$app->getResponse()->redirect(Yii::$app->getRequest()->getUrl());//перезагружаем страницу после POST запроса
			}
			
			
		}
		$userInfo = User::find()->where([ 'id' => Yii::$app->request->get()['id'] ])->one();
		$avatars = Avatars::find()->where(['id_user' => Yii::$app->request->get()['id']])->all();
		return $this->render('edit', [
			'avatars' => $avatars,
			'userInfo' => $userInfo
		]);
	}
	public function actionActiverecord(){
		
		$query = new \yii\db\Query;
		$query->select('*')
            ->from('`tagchain`')
            ->leftJoin('`tags`', '`tagchain`.`id_tag` = `tags`.`id`');
            //->limit($Limit);
		$command = $query->createCommand();
		$resp = $command->queryAll();
		//var_dump($resp);die();
		
		
		
		return $this->render('activerecord', [
			'resp' => $resp
			
		]);
	}
	
	public function actionTags(){ //TAGS
		
		if( Yii::$app->request->isGet ){ 
			$idTag = Tags::find()->select('id')->where([ 'tag_alias' => Yii::$app->request->get()['tag'] ])->one();
			$users = Tagchain::find()->select('id_user')->where( ['id_tag' => $idTag->id] )->all();
		}
		
		return $this->render('tags', [
			'users' => $users
		]);
	}
	
	public function actionRmavatar(){//remove avatar in user edit page
		if( Yii::$app->request->isGet && Yii::$app->request->get()['userID'] && Yii::$app->request->get()['avatarID'] ){
			$avatar = Avatars::find()->where([ 'id' => Yii::$app->request->get()['avatarID'], 'id_user' => Yii::$app->request->get()['userID'] ])->one();
			$avatar->delete();
		}
	}
	public function actionSubscribe(){ //SUBSCRIBE
		
		if( Yii::$app->request->get()['idFrom'] && Yii::$app->request->get()['idTo'] && Yii::$app->request->get()['un'] != 1){ //subscribe
			$idFrom = intval(htmlspecialchars(Yii::$app->request->get()['idFrom']));
			$idTo = intval(htmlspecialchars(Yii::$app->request->get()['idTo']));

			$model = new Subscribe;
			$model->id_from = $idFrom;
			$model->id_to = $idTo;
			
			if( $model->save() ){
				$data = (object) array('status' => 'OK');
			}else{
				$data = (object) array('status' => 'error: cannot add subscribe in db');
			}
			
		}
		if( Yii::$app->request->get()['un'] == 1 && Yii::$app->request->get()['idFrom'] && Yii::$app->request->get()['idTo'] ){ //unsubscribe
			$idFrom = intval(htmlspecialchars(Yii::$app->request->get()['idFrom']));
			$idTo = intval(htmlspecialchars(Yii::$app->request->get()['idTo']));
			$mySubscribe = Subscribe::find()->select('id')->where(['id_from' => $idFrom, 'id_to' => $idTo ])->one();
			
			if( $mySubscribe->delete() ){
				$data = (object) array('status' => 'OK');
			}else{
				$data = (object) array('status' => 'error: cannot unsubscribe in db');
			}
		}
		echo json_encode($data);
		
		$isSubscribe = Subscribe::find()->select('id')->where(['id_from' => Yii::$app->user->id, 'id_to' => $idUser ])->one();
		/*return $this->renderPartial('profile', [
			'isSubscribe' => $isSubscribe
		]);*/
	}
	public function actionAddcomment(){ //COMMENTS

		$message = htmlspecialchars(Yii::$app->request->get()['message']);
		$idUser = (intval(Yii::$app->request->get()['idUser']) > 0 ? intval(htmlspecialchars(Yii::$app->request->get()['idUser'])) : 0 );
		$idPost = (intval(Yii::$app->request->get()['idUser']) > 0 ? intval(htmlspecialchars(Yii::$app->request->get()['idPost'])) : 0 );

		$model = new Comments;
		$model->id_user = $idUser;
		$model->id_post = $idPost;
		$model->text = $message;
		$model->data = date("Y-m-d");
		$model->time_comment = date("H:i:s");
		$model->save();
		$data = (object) array('message' => $message, 'idUser' => $idUser, 'idPost' => $idPost, 'data' => date("Y-m-d"), 'time_comment' => date("H:i:s"));
		echo json_encode($data);
	}
	
	public function actionSubmit(){

	 if( isset( $_GET['textdata'] ) ){
		$data = '';
		 foreach($_GET as $key => $item){
			 if( mb_stripos($key, 'title') > 0 || mb_stripos($key, 'text') > 0 ){
				 $data = $key;
			 }
		 }
		 $dataModel = json_decode($data);
		 
		 $model = new Posts;
		 $model->title = $dataModel->title;
		 $model->text = $dataModel->text;
		 $model->author_id = Yii::$app->user->id;
		 $model->hits = 0;
		 $model->data = date("Y-m-d");
		 $model->save();
		 
		 echo  $data;
 }

		if( Yii::$app->request->isAjax ){

		}

	}
	
	public function actionTest(){
		if( Yii::$app->request->isAjax ){
			//var_dump(Yii::$app->request->post());
			$userMy = User::find()->where([ 'id' => Yii::$app->user->id ])->one();
			$userMy->name = Yii::$app->request->post()["User"]['name'];
			if ( $userMy->save() ){
				$success = 1;
			}else{
				echo 0;
			}
			return $this->render('test', [
			'userMy' => $userMy,
			'success' => $success
			]);
		}else{
			return $this->render('test', [
			'userMy' => $userMy
			]);
		}

	}
	public function actionTest2(){
		$userMy = User::find()->where([ 'id' => Yii::$app->user->id ])->one();
		return $this->render('test', [
			'userMy' => $userMy
		]);
	}
	public function actionSubmitfile(){
		$model = Posts::find()->where([ 'author_id' => Yii::$app->user->id ])->orderBy([ '`id`' => SORT_DESC ])->one();
		$data = array();
		if( isset( $_GET['uploadfiles'] ) ){
				$error = false;
				$files = array();

				//$uploaddir = './uploads/'; // . - текущая папка где находится submit.php
				$uploaddir = './img/posts/'; // . - текущая папка где находится submit.php
				
				// Создадим папку если её нет
				if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );

				// переместим файлы из временной директории в указанную
				foreach( $_FILES as $file ){
					if( move_uploaded_file( $file['tmp_name'], $uploaddir . basename($file['name']) ) ){
						$files[] = realpath( $uploaddir . $file['name'] );
					}
					else{
						$error = true;
					}
				}
				
				
				
				$model->intro_image = $file['name'];
				$model->save();
				$data = $error ? array('error' => 'Ошибка загрузки файлов.') : array('files' => $files );
				
				echo json_encode( $data );
		}
	
	}
	
	public function actionLike(){
		if( Yii::$app->request->isAjax){

		 foreach($_GET as $key => $item){
			 if( mb_stripos($key, 'user') > 0 && mb_stripos($key, 'post') > 0 ){
				 $data = $key;
			 }
		 }
		 $data = json_decode($data);
		 
		 if ( count( Likes::find()->where(['id_user' => $data->user, 'id_post' => $data->post])->all()) > 0){
			$like = Likes::find()->where(['id_user' => $data->user, 'id_post' => $data->post])->one();
			$like->delete();
			 //remove like
			 $oneLike = 0;
		 }else{
			 $model = new Likes;
			 $model->id_user = $data->user;
			 $model->id_post = $data->post;
			 $model->save();
			//add like
			$oneLike = 1;
		 }
		 
		 $allLikes = Likes::find()->where([ 'id_post' => $data->post ])->all();
		 if( (!$oneLike || $oneLike != 0) && !$allLikes || $allLikes != 0 ){
			 $data = (object) array('error' => 'error! not likes:(');
		 }
		 $data = (object) array('allLikes' => count($allLikes), 'oneLike' => $oneLike);
		 //echo  json_encode($allLikes);
		 //$data = array(count($allLikes), $oneLike);
		 echo json_encode($data);
		}
	}


	
	
}
