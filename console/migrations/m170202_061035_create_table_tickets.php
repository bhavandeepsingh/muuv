<?php

use yii\db\Migration;

class m170202_061035_create_table_tickets extends Migration
{
    public function up()
    {
        $this->createTable('{{%tickets}}', [
            'id' => $this->primaryKey(),
            'name' => $this->text(),
            'description' => $this->text(),
            'event_id' => $this->integer(),
            'status' => $this->integer(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]); 
    }

    public function down()
    {
        $this->dropTable("{{%notification}}");

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
