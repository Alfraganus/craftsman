<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%shops}}`.
 */
class m200707_044934_create_shops_table extends Migration
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

        $this->createTable('shops', [
            'id' => $this->primaryKey(),
            'title' => $this->string(255),
            'slug' => $this->string(255),
            'type' => $this->string(255),
            'sort' => $this->integer()->notNull(),
            'status' => $this->integer()->notNull(),
            'deleted' => $this->tinyInteger()->notNull(),
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
        $this->dropTable('{{%shops}}');
    }
}
