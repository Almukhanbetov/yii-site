<?php

use yii\db\Migration;

class m170530_135702_likes extends Migration
{
    public function up()
    {
		$this->createTable('likes', [
            'id' => $this->primaryKey(),
			'id_user' => $this->integer(),
			'id_post' => $this->integer()
        ]);
    }

    public function down()
    {
        echo "m170530_135702_likes cannot be reverted.\n";

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
