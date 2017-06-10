<?php

use yii\db\Migration;

/**
 * Handles the creation of table `user`.
 */
class m170419_162304_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
		
        $this->createTable('users', [
            'id' => $this->primaryKey(),
			'email' => $this->string(100),
			'password' => $this->string(255)
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('users');
    }
}
