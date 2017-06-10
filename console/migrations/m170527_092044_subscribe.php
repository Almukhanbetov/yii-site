<?php

use yii\db\Migration;

class m170527_092044_subscribe extends Migration
{
    public function up()
    {
		$this->createTable('subscribe', [
            'id' => $this->primaryKey(),
			'id_from' => $this->integer(),
			'id_to' => $this->integer()
        ]);
    }

    public function down()
    {
        echo "m170527_092044_subscribe cannot be reverted.\n";

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
