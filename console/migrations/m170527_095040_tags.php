<?php

use yii\db\Migration;

class m170527_095040_tags extends Migration
{
    public function up()
    {
		$this->createTable('tags', [
            'id' => $this->primaryKey(),
			'tag_name' => $this->string(),
			'tag_alias' => $this->string(),
        ]);
    }

    public function down()
    {
        echo "m170527_095040_tags cannot be reverted.\n";

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
