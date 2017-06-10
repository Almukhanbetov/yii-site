<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
//use frontend\models\Users;
use common\models\User;

/**
 * ContactForm is the model behind the contact form.
 */
class Login extends Model
{
	public $email;
	public $password;

	public function rules(){
		return [
			[['email', 'password'], 'required', 'message' => 'Обязательное поле'],
			['email', 'email', 'message' => 'Введите корректный email'],
			['password', 'string', 'min' => 6, 'message' => 'Минимум 6 символов'],
			['password', 'validatePassword' ]
		];
	}
	
	public function validatePassword(){
		$user = $this->getUser();
		if(!$this->hasErrors()){
			if(!$user || !$user->validatePassword($this->password)){
			$this->addError($attribute, 'Пароль не верен');

			}
		}
	}
	public function getUser(){
		return User::findOne(['email' => $this->email]);
	}
}
