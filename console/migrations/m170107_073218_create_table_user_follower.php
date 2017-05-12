<?php

use yii\db\Migration;

class m170107_073218_create_table_user_follower extends Migration
{
    public function up()
    {
        $this->createTable('{{%followers}}', [
            'id' => $this->primaryKey(),
            'follower_id' => $this->integer()->notNull(),
            'follow_id' => $this->integer()->notNull(),
            "status" => $this->integer()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%followers}}');
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
