<?php

use yii\db\Migration;

class m170204_062132_create_table_ticket_sales extends Migration
{
    public function up()
    {
         $this->createTable('{{%tickets_purchase}}', [
            'id' => $this->primaryKey(),
            'ticket_id' => $this->integer()->notNull(),
            'event_id' => $this->integer()->notNull(),
            'customer_id' => $this->integer()->notNull(),
            'status' => $this->integer()->defaultValue(1),
            'transaction_id' => $this->text()->null(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);        
        return false;
    }

    public function down()
    {
       $this->dropTable('{{%tickets_purchase}}');
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
