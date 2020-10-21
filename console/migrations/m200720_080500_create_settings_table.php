<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%settings}}`.
 */
class m200720_080500_create_settings_table extends Migration
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

        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string('255'),
            'settings_key' => $this->string('255'),
            'settings_value' => 'mediumtext',
            'settings_group' => $this->string('255'),
            'settings_type' => $this->string('255'),
            'description' => $this->text(),
            'status' => $this->integer(),
            'sort' => $this->integer(),
            'required' => 'tinyint not null',
            'updated_on' => $this->timestamp(),
        ], $tableOptions);

        $this->createTable('{{%settings_translation}}', [
            'id' => $this->primaryKey(),
            'language' => $this->string('100'),
            'settings_key' => $this->string('255'),
            'settings_value' => 'mediumtext',
            'updated_on' => $this->timestamp(),
        ], $tableOptions);

        $this->execute("
        INSERT INTO `settings` (`title`, `settings_key`, `settings_value`, `settings_group`, `settings_type`, `status`, `sort`, `required`, `updated_on`) VALUES
            ('Brand Name', 'brand_name', 'AVLO', 'store', 'text', 1, 1, 1, NULL),
            ('Store Name', 'store_name', 'AVLO - Online Shop', 'store', 'text', 1, 2, 1, NULL),
            ('Store Info', 'store_info', 'Mega Online Shop in Uzbekistan', 'store', 'text', 1, 3, 1, NULL),
            ('Administrator Email', 'administrator_email', 'admin@avlo.uz', 'store', 'email', 1, 4, 1, NULL),
            ('Store Status', 'store_status', '1', 'store', 'yes/no', 1, 5, 1, NULL),
            ('Status Message', 'unavailable_message', 'Sorry, we are doing some work on the site!', 'store', 'text', 1, 6, 1, NULL),
            ('Password Protection', 'store_password_protection', '1', 'store', 'yes/no', 1, 7, 1, NULL),
            ('Password', 'store_password', " . rand(100000, 999999) . ", 'store', 'text', 1, 8, 1, NULL),
            ('Store Logo', 'store_logo', '', 'store', 'file', 1, 9, 1, NULL),
            ('Store Favicon', 'store_favicon', '', 'store', 'file', 1, 10, 1, NULL),
            ('Multi Language', 'multi_language', '0', 'general', 'yes/no', 1, 1, 1, NULL),
            ('Store language', 'store_language', 'en', 'general', 'languages_dropdown', 1, 2, 1, NULL),
            ('Character encoding', 'store_charset', 'UTF-8', 'general', 'text', 1, 3, 1, NULL),
            ('Locale', 'locale_code', 'en_GB', 'general', 'locale_dropdown', 1, 4, 1, NULL),
            ('Timezone', 'timezone', 'Asia/Tashkent', 'general', 'timezone_dropdown', 1, 5, 1, NULL),
            ('Webmaster Email', 'webmaster_email', 'info@domain.com', 'general', 'email', 1, 6, 1, NULL),
            ('Phone number', 'phone_number', '', 'contacts', 'phone', 1, 1, 0, NULL),
            ('Mobile number', 'mobile_number', '', 'contacts', 'phone', 1, 2, 0, NULL),
            ('Fax number', 'fax_number', '', 'contacts', 'phone', 1, 3, 0, NULL),
            ('Email address', 'email_address', '', 'contacts', 'email', 1, 4, 0, NULL),
            ('Company address', 'company_address', '', 'contacts', 'text', 1, 5, 0, NULL),
            ('Google Map', 'google_map', '', 'contacts', 'text', 1, 6, 0, NULL),
            ('Skype', 'skype_address', '', 'contacts', 'text', 1, 7, 0, NULL),
            ('Whatsapp', 'whatsapp_number', '', 'contacts', 'text', 1, 8, 0, NULL),
            ('Telegram', 'telegram_number', '', 'contacts', 'text', 1, 9, 0, NULL),
            ('Viber', 'viber_number', '', 'contacts', 'text', 1, 10, 0, NULL),
            ('Facebook', 'social_fb', '', 'social', 'text', 1, 1, 0, NULL),
            ('Instagram', 'social_instagram', '', 'social', 'text', 1, 2, 0, NULL),
            ('Linkedin', 'social_linkedin', '', 'social', 'text', 1, 3, 0, NULL),
            ('Pinterest', 'social_pinterest', '', 'social', 'text', 1, 4, 0, NULL),
            ('Twitter', 'social_twitter', '', 'social', 'text', 1, 5, 0, NULL),
            ('Youtube', 'social_youtube', '', 'social', 'text', 1, 6, 0, NULL);
        ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%settings}}');
        $this->dropTable('{{%settings_translation}}');
    }
}
