<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%regions}}`.
 */
class m200721_093042_create_regions_table extends Migration
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

        $this->createTable('{{%regions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string('150'),
            'slug' => $this->string('150'),
            'country_id' => $this->integer(),
            'city_id' => $this->integer(),
            'sort' => $this->integer()->defaultValue(0),
            'status' => $this->tinyInteger(1)->defaultValue(0),
            'created_on' => $this->timestamp(),
            'created_by' => $this->integer()->notNull()->defaultValue(0),
            'updated_on' => $this->timestamp(),
            'updated_by' => $this->integer()->notNull()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex(
            'idx-regions-country_id',
            'regions',
            'country_id'
        );

        $this->addForeignKey(
            'fk-regions-country_id',
            'regions',
            'country_id',
            'countries',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-regions-city_id',
            'regions',
            'city_id'
        );

        $this->addForeignKey(
            'fk-regions-city_id',
            'regions',
            'city_id',
            'cities',
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
            'fk-regions-country_id',
            'regions'
        );

        $this->dropIndex(
            'idx-regions-country_id',
            'regions'
        );

        $this->dropForeignKey(
            'fk-regions-city_id',
            'regions'
        );

        $this->dropIndex(
            'idx-regions-city_id',
            'regions'
        );

        $this->dropTable('{{%regions}}');
    }
}
