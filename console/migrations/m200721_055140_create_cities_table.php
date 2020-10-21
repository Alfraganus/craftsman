<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%cities}}`.
 */
class m200721_055140_create_cities_table extends Migration
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

        $this->createTable('{{%cities}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string('150'),
            'slug' => $this->string('150'),
            'country_id' => $this->integer(),
            'sort' => $this->integer()->defaultValue(0),
            'status' => $this->tinyInteger(1)->defaultValue(0),
            'created_on' => $this->timestamp(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_on' => $this->timestamp(),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex(
            'idx-cities-country_id',
            'cities',
            'country_id'
        );

        $this->addForeignKey(
            'fk-cities-country_id',
            'cities',
            'country_id',
            'countries',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey(
            'fk-cities-country_id',
            'cities'
        );

        $this->dropIndex(
            'idx-cities-country_id',
            'cities'
        );

        $this->dropTable('{{%cities}}');
    }
}
