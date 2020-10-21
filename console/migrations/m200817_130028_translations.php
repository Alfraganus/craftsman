<?php

use yii\db\Migration;

/**
 * Class m200817_130028_translations
 */
class m200817_130028_translations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/51278467/mysql-collation-utf8mb4-unicode-ci-vs-utf8mb4-default-collation
            // https://www.eversql.com/mysql-utf8-vs-utf8mb4-whats-the-difference-between-utf8-and-utf8mb4/
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        // Translation fields
        $this->createTable('{{%translations}}', [
            'table_id' => $this->primaryKey(),
            'res_id' => $this->integer()->defaultValue(0),
            'language' => $this->string(100)->notNull(),
            'translation_key' => $this->string(200)->notNull(),
            'translation_value' => $this->text()->notNull(),
        ], $tableOptions);

        // Translation links
        $this->createTable('{{%translation_links}}', [
            'table_id' => $this->primaryKey(),
            'type' => $this->string(200)->notNull(),
            'res_id' => $this->integer()->defaultValue(0),
            'translation_id' => $this->integer()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%translations}}');
        $this->dropTable('{{%translation_links}}');
    }
}
