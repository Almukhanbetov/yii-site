<?php

use yii\db\Migration;

class m170531_101300_comments extends Migration
{
    public function up()
    {
		$this->createTable('comments', [
            'id' => $this->primaryKey(),
			'name' => $this->string(50),
			'id_user' => $this->integer(),
			'id_post' => $this->integer(),
			'text' => $this->string(2000),
			'data' => $this->date("Y-m-d"),
			'time' => $this->date("H:i:s")
        ]);
    }

    public function down()
    {
        echo "m170531_101300_comments cannot be reverted.\n";

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
