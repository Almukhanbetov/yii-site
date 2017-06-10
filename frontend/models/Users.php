<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * ContactForm is the model behind the contact form.
 */
class Users extends ActiveRecord implements IdentityInterface
{
	public function setPassword(){
		$this->password = sha1($password);
	}
	public function validatePassword($password){
		return $this->password === sha1($password);
	}
	public static function findIdentity($id){
		return self::findOne($id);
	}
	public static function findIdentityByAccessToken($token, $type = null){
		 
	}
	public function getId(){
		 return $this->id;
	}
	public function getAuthKey(){
		 
	}
    public function validateAuthKey($authKey){
		
	}
}
