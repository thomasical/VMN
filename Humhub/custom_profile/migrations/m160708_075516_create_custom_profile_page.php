<?php

use humhub\components\Migration;
use yii\db\Schema;

/**
 * Handles the creation for table `custom_profile_page`.
 */
class m160708_075516_create_custom_profile_page extends Migration {

    /**
     * @inheritdoc
     */
    public function up() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('custom_profile_page');
        if ($tableSchema == null) {
            $this->createTable('custom_profile_page', [
                'id' => Schema::TYPE_PK,
                'name' => 'varchar(255) NOT NULL',
                'title_line1' => 'text',
                'title_line2' => 'text',
                'introductory_text' => 'text',
                'footer_text' => 'text',
                'conclusion_text' => 'text',
                'created_at' => 'int(11) NOT NULL',
                'created_by' => 'int(11) NOT NULL',
                'updated_at' => 'int(11) NOT NULL',
                'updated_by' => 'int(11) NOT NULL',
            ]);
        }
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $tableSchema = Yii::$app->db->schema->getTableSchema('custom_profile_page');
        if ($tableSchema != null) {
            $this->dropTable('custom_profile_page');
        }
    }

}
