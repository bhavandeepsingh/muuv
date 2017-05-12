<?php

use yii\db\Migration;

class m170111_055437_alter_user_tbale extends Migration
{
    public function up()
    {        
        $this->addColumn('{{%user}}', 'url', 'string');
        $this->addColumn('{{%user}}', 'desc', 'string');
    }

    public function down()
    {     
        $this->dropColumn('{{%user}}', 'url');
        $this->dropColumn('{{%user}}', 'desc');
    }
 
}
