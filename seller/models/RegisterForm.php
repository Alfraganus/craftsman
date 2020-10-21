<?php
namespace seller\models;

/**
 * Seller register form
 */
class RegisterForm extends \yii\base\Model
{
    public $name;
    public $surname;
    public $username;
    public $email;
    public $password;
    public $password_confirm;

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'username', 'email', 'password', 'password_confirm'], 'required'],
            [['username', 'email', 'password', 'password_confirm'], 'string'],
        ];
    }

    /**
     * Attribute labels
     *
     * @return array
     */
    public function attributeLabels()
    {
        return [
            'name' => 'First name',
            'surname' => 'Last name',
            'username' => 'Username',
            'email' => 'Email address',
            'password' => 'Password',
            'password_confirm' => 'Password Confirm',
        ];
    }
}
