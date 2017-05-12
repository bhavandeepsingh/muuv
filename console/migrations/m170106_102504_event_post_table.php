<?php

use yii\db\Migration;

class m170106_102504_event_post_table extends Migration
{
    public function up()
    {
        $this->createTable("{{%event_post}}", [
                "id" => $this->primaryKey(),
                "title" => $this->string(),
                "host_name" => $this->string(),
                "latitude" => $this->float(),
                "longitude" => $this->float(),
                "flyer_image" => $this->string(),
                "start_date" => $this->date(),
                "end_date" => $this->date(),
                "start_time" => $this->time(),
                "end_time" => $this->time(),
                "like_count" => $this->integer()->defaultValue(0),
                "remuuv_count" => $this->integer()->defaultValue(0),
                "share_count" => $this->integer()->defaultValue(0),
                "comments_count" => $this->integer()->defaultValue(0),
                "capacity" => $this->integer()->defaultValue(0),
                'privacy_status' => $this->integer()->defaultValue(0),
                'type' => $this->integer()->defaultValue(0),
                "user_id" => $this->integer(),
                "parent_id" => $this->integer()->defaultValue(0),
                "created_at" => $this->integer()->notNull(),
                "updated_at" => $this->integer()->notNull()
            ]);
    }

    public function down()
    {
        $this->dropTable("{{%event_post}}");
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
