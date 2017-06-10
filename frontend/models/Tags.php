<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;


/**
 * ContactForm is the model behind the contact form.
 */
class Tags extends ActiveRecord 
{
	public static function tableName(){
		return 'tags';
	}
	
	public function getTags()
    {
        return $this
            ->hasMany(Tags::className(), ['id' => 'id_tag'])       
            ->viaTable(Tagchain::tableName(), ['id_user' => 3]);            
    }
}
