<?php

use yii\db\Migration;

class m170116_143446_alter_table_user_1 extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'gender', 'enum(\'m\', \'f\')');        
    }

    public function down()
    {        
        $this->dropColumn('{{%user}}', 'gender');
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
