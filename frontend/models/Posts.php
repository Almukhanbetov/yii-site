<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


/**
 * ContactForm is the model behind the contact form.
 */
class Posts extends ActiveRecord 
{
	public function getLikes($like){
		return $like . ' лайков';
	}
	public function getHits($hit){
		return $hit . ' просмотров';
	}
	public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs('uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}
