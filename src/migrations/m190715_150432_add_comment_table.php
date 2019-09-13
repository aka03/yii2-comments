<?php

use yii\db\Migration;

/**
 * Class m190715_150432_add_comment_table
 */
class m190715_150432_add_comment_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{comment}}', [
            'id' => $this->primaryKey(),
            'page' => $this->string(),
            'page_id' => $this->integer(),
            'user_id' => $this->integer(),
            'guest_name' => $this->string(255),
            'message' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{comment}}');
    }
}
