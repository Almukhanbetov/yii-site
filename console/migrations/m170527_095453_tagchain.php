<?php

use yii\db\Migration;

class m170527_095453_tagchain extends Migration
{
    public function up()
    {
		$this->createTable('tagchain', [
            'id' => $this->primaryKey(),
			'id_tag' => $this->integer(),
			'id_user' => $this->integer()
        ]);
    }

    public function down()
    {
        echo "m170527_095453_tagchain cannot be reverted.\n";

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
