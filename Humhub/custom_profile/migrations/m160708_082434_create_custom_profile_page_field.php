<?php

use humhub\components\Migration;
use yii\db\Schema;

/**
 * Handles the creation for table `custom_profile_page_field`.
 */
class m160708_082434_create_custom_profile_page_field extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('custom_profile_page_field');
        if ($tableSchema == null) {
            $this->createTable('custom_profile_page_field', [
                'id' => Schema::TYPE_PK,
                'custom_profile_page_id' => 'int(11) NOT NULL',
                'profile_field_id' => 'int(11) NOT NULL',
                'internal_name' => 'varchar(255) NOT NULL',
                'display_name' => 'text',
                'sort_order' => 'int(11) NOT NULL DEFAULT 0',
                'created_at' => 'int(11) NOT NULL',
                'created_by' => 'int(11) NOT NULL',
            ]);
            $this->addForeignKey('fk-custom_profile_page_field-custom_profile_page_id', 'custom_profile_page_field', 'custom_profile_page_id', 'custom_profile_page', 'id', 'CASCADE');
        }
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('custom_profile_page_field');
        if ($tableSchema != null) {
            $this->dropTable('custom_profile_page_field');
        }
    }

}
