<?php

use yii\db\Migration;

class m160905_132417_update_profile_field_table_column extends Migration
{
    public function up()
    {
        $this->alterColumn('profile_field', 'field_type_config', 'LONGTEXT');
    }

    public function down()
    {
        echo "m160905_132417_update_profile_field_table_column cannot be reverted.\n";

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
