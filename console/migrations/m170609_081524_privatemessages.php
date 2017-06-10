<?php

use yii\db\Migration;

class m170609_081524_privatemessages extends Migration
{
    public function up()
    {
		$this->createTable('privatemessages', [
            'id' => $this->primaryKey(),
			'id_from' => $this->integer(),
			'id_to' => $this->integer(),
			'text' => $this->string(2000),
			'data' => $this->date("Y-m-d H:i:s")
        ]);
    }

    public function down()
    {
        echo "m170609_081524_privatemessages cannot be reverted.\n";

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
