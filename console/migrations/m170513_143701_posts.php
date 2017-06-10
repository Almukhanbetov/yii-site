<?php

use yii\db\Migration;

class m170513_143701_posts extends Migration
{
    public function up()
    {
		$this->createTable('posts', [
            'id' => $this->primaryKey(),
			'title' => $this->string(200),
			'text' => $this->string(2000),
			'author_id' => $this->integer(),
			'alias' => $this->string(200),
			'data' => $this->date("Y-m-d H:i:s"),
			'likes' => $this->integer(),
			'hits' => $this->integer(),
        ]);
    }

    public function down()
    {
        echo "m170513_143701_posts cannot be reverted.\n";

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
