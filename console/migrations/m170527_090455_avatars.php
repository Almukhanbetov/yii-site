<?php

use yii\db\Migration;

class m170527_090455_avatars extends Migration
{
    public function up()
    {
		$this->createTable('avatars', [
            'id' => $this->primaryKey(),
			'img' => $this->string(255),
			'data' => $this->date("Y-m-d H:i:s"),
			'likes' => $this->integer(),
			'id_user' => $this->integer()
        ]);
    }

    public function down()
    {
        echo "m170527_090455_avatars cannot be reverted.\n";

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
