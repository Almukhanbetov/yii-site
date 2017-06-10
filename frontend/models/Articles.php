<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


/**
 * ContactForm is the model behind the contact form.
 */
class Articles extends ActiveRecord 
{
	
	public function getFullTitle($title){
		return 'Статья  ' . $title;
	}
	
	public function getShortText($text){
		$text = mb_substr($text, 0, 300);	
		$firsPos = strripos($text, ' ');
		$text = mb_substr($text, 0, $firsPos);
		return $text . '...';
	}
	
	public function getDescription($hits, $value){
		
		$description = array(
			'like' => array( 'лайк', 'лайка', 'лайков'),
			'hit' => array( 'просмотр', 'просмотра', 'просмотров')
		);
		
		if ( mb_substr($hits, -1) == 1 && mb_substr($hits, -2) != 11){
			return $hits . ' ' . $description[$value][0];
		}else if( mb_substr($hits, -1) > 1 && mb_substr($hits, -1) < 5 && (mb_substr($hits, -2) < 5 || mb_substr($hits, -2) > 15)){
			return $hits . ' ' . $description[$value][1];
		}else{
			return $hits . ' ' . $description[$value][2];
		}
	}

}
