<?php

use yii\db\Migration;

class m170107_044708_create_table_event_like extends Migration
{
    public function up()
    {
        $this->createTable("{{%event_likes}}", [
            "id" => $this->primaryKey(),
            "event_id" => $this->integer()->notNull(),
            "user_id" => $this->integer()->notNull(),
            "status" => $this->integer()->defaultValue(1),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);
    }

    public function down()
    {
        $this->dropTable("{{%event_likes}}");
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
