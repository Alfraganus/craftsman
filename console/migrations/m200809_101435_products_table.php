<?php

use yii\db\Migration;

/**
 * Class m200809_101435_products_table
 */
class m200809_101435_products_table extends Migration
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

        // Products
        $this->createTable('{{%products}}', [
            'id' => $this->primaryKey(),
            'shop_id' => $this->integer()->notNull()->defaultValue(0),
            'brand_id' => $this->integer()->defaultValue(0)->notNull(),
            'upc' => $this->string(255)->notNull(),
            'mpn' => $this->string(255)->notNull(),
            'currency' => $this->string(10)->notNull(),
            'price' => $this->double()->notNull()->defaultValue(0),
            'discount' => $this->double()->notNull()->defaultValue(0),
            'discount_price' => $this->double()->notNull()->defaultValue(0),
            'discount_type' => $this->string(255)->notNull(),
            'quantity' => $this->integer()->notNull()->defaultValue(0),
            'quantity_min' => $this->integer()->notNull()->defaultValue(0),
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


        // Products info
        $this->createTable('{{%products_info}}', [
            'info_id' => $this->primaryKey(),
            'product_id' => $this->integer()->defaultValue(0)->notNull(),
            'language' => $this->string(10)->notNull(),
            'name' => $this->string(200)->notNull(),
            'short_title' => $this->string(255)->notNull(),
            'slug' => $this->string(255)->unique()->notNull(),
            'description' => $this->text()->notNull(),
            'image' => $this->string(255)->notNull(),
            'gallery' => $this->text()->notNull(),
            'meta' => $this->json(),
            'type' => $this->string(255)->notNull(),
        ], $tableOptions);


        // Products category
        $this->createTable('{{%products_category}}', [
            'pct_id' => $this->primaryKey(),
            'product_id' => $this->integer()->defaultValue(0)->notNull(),
            'category_id' => $this->integer()->defaultValue(0)->notNull(),
        ], $tableOptions);


        // Products field
        $this->createTable('{{%products_field}}', [
            'field_id' => $this->primaryKey(),
            'product_id' => $this->integer()->defaultValue(0),
            'field_key' => $this->string(255)->notNull(),
            'field_value' => $this->text(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%products}}');
        $this->dropTable('{{%products_info}}');
        $this->dropTable('{{%products_field}}');
        $this->dropTable('{{%products_category}}');
    }
}
