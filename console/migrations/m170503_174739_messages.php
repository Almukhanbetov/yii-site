<?php

use yii\db\Migration;

class m170503_174739_messages extends Migration
{
    public function up()
    {
		$this->createTable('messages', [
            'id' => $this->primaryKey(),
			'name' => $this->string(50),
			'email' => $this->string(100),
			'subject' => $this->string(100),
			'body' => $this->string(2000)

        ]);
    }

    public function down()
    {
        $this->dropTable('messages');
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
