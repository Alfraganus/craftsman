<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql') {
            // https://stackoverflow.com/questions/51278467/mysql-collation-utf8mb4-unicode-ci-vs-utf8mb4-default-collation
            // https://www.eversql.com/mysql-utf8-vs-utf8mb4-whats-the-difference-between-utf8-and-utf8mb4/
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'deleted' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createTable('{{%profile}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'name' => $this->string(255),
            'surname' => $this->string(255)->null(),
            'lastname' => $this->string(255)->null(),
            'image' => $this->string(255)->null(),
            'bio' => $this->text()->null(),
            'phone' => $this->string(70)->null(),
            'mobile' => $this->string(60)->null(),
            'birthdate' => $this->date(),
            'gender' => $this->smallInteger(6)->defaultValue(0),
            'country' => $this->string(100)->null(),
            'city' => $this->string(100)->null(),
            'region' => $this->string(100)->null(),
            'address' => $this->string(255)->null(),
            'postal_code' => $this->string(100)->null(),
        ], $tableOptions);

        $this->insert('{{%users}}', [
            'username' => 'avlodev',
            'auth_key' => "TfahRfstRagt426",
            'password_hash' => \Yii::$app->security->generatePasswordHash("helloAvlo"),
            'password_reset_token' => null,
            'email' => 'dev@avlo.uz',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%profile}}', [
            'user_id' => 1,
            'name' => "Avlo",
            'surname' => "Developer",
        ]);

        $this->insert('{{%users}}', [
            'username' => 'seller',
            'auth_key' => "KgstFay26Ga261Ha9",
            'password_hash' => \Yii::$app->security->generatePasswordHash("helloAvlo"),
            'password_reset_token' => null,
            'email' => 'seller@avlo.uz',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%profile}}', [
            'user_id' => 2,
            'name' => "Avlo",
            'surname' => "Seller",
        ]);

        $this->insert('{{%users}}', [
            'username' => 'buyer',
            'auth_key' => "LhsfYsyi725ha8Hs",
            'password_hash' => \Yii::$app->security->generatePasswordHash("helloAvlo"),
            'password_reset_token' => null,
            'email' => 'buyer@avlo.uz',
            'status' => 10,
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        $this->insert('{{%profile}}', [
            'user_id' => 3,
            'name' => "Default",
            'surname' => "User",
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%users}}');
    }
}
