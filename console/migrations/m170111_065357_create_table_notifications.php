<?php

use yii\db\Migration;

class m170111_065357_create_table_notifications extends Migration
{
    public function up()
    {
        $this->createTable('{{%notification}}', [
            'id' => $this->primaryKey(),
            'notify_user_id' => $this->integer(),
            'notification_created_id' => $this->integer(),
            'content' => $this->text(),
            'type' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%notification}}');
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
