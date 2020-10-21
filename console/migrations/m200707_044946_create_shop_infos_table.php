<?php
use yii\db\Migration;
use yii\db\Schema;

/**
 * Handles the creation of table `{{%shop_infos}}`.
 */
class m200707_044946_create_shop_infos_table extends Migration
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

        $this->createTable('shop_infos', [
            'info_id' => $this->primaryKey(),
            'shop_id' => Schema::TYPE_INTEGER,
            'company_type' => $this->string(100),
            'company_no' => $this->string(100),
            'person_status' => $this->string(100),
            'email' => $this->string(100),
            'phone' => $this->string(100),
            'mobile' => $this->string(100),
            'fax' => $this->string(100),
            'country' => $this->string(100),
            'city' => $this->string(100),
            'region' => $this->string(100),
            'postal_code' => $this->string(100),
            'address' => $this->string(255),
            'description' => $this->text(),
            'image' => $this->string(255),
            'cover_image' => $this->string(255),
            'files' => $this->text(),
        ], $tableOptions);

        // $this->addPrimaryKey('shop-info_pk', 'shop_infos', ['shop_id']);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%shop_infos}}');
    }
}
