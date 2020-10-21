<?php

use yii\db\Migration;

/**
 * Class m200910_205947_brands
 */
class m200910_205947_brands extends Migration
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

        // Brands
        $this->createTable('{{%brands}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->notNull(),
            'description' => $this->text()->notNull(),
            'icon' => $this->string(255)->notNull(),
            'image' => $this->string(255)->notNull(),
            'cover_image' => $this->string(255)->notNull(),
            'meta' => $this->json(),
            'settings' => $this->json(),
            'template' => $this->string(255)->notNull(),
            'layout' => $this->string(255)->notNull(),
            'sort' => $this->integer()->notNull()->defaultValue(0),
            'status' => $this->tinyInteger(1)->defaultValue(0),
            'deleted' => $this->tinyInteger()->notNull()->defaultValue(0),
            'cacheable' => $this->tinyInteger()->notNull()->defaultValue(0),
            'searchable' => $this->tinyInteger()->notNull()->defaultValue(0),
            'created_on' => $this->timestamp(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_on' => $this->timestamp(),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%brands}}');
    }
}
