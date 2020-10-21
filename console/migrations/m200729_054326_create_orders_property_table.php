<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%orders_property}}`.
 */
class m200729_054326_create_orders_property_table extends Migration
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

        $this->createTable('{{%orders_property}}', [
            'id' => $this->primaryKey(),
            'order_id' => $this->string(255),
            'shop_id' => $this->integer(),
            'products' => 'LONGTEXT',
            'products_count' => $this->integer(),
            'total_price' => 'FLOAT',
            'cargo_id' => $this->integer(),
            'cargo_track_no' => $this->string(255),
            'note' => $this->string(255),
            'status' => $this->integer(),
            'deleted' => 'TINYINT',
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders_property}}');
    }
}
