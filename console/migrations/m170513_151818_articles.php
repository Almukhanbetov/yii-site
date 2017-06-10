<?php

use yii\db\Migration;

class m170513_151818_articles extends Migration
{
    public function up()
    {
		$this->createTable('articles', [
            'id' => $this->primaryKey(),
			'title' => $this->string(200),
			'text' => $this->string(),
			'author_id' => $this->integer(),
			'alias' => $this->string(200),
			'data' => $this->date("Y-m-d"),
			'likes' => $this->integer(),
			'hits' => $this->integer(),
        ]);
    }

    public function down()
    {
        echo "m170513_151818_articles cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
