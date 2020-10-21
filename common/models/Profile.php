<?php

namespace common\models;

/**
 * This is the model class for table "profile".
 *
 * @property int $id
 * @property int|null $user_id
 * @property string|null $name
 * @property string|null $surname
 * @property string|null $lastname
 * @property string|null $image
 * @property string|null $bio
 * @property string|null $phone
 * @property string|null $mobile
 * @property string|null $birthdate
 * @property string|null $gender
 * @property string|null $country
 * @property string|null $city
 * @property string|null $region
 * @property string|null $address
 * @property string|null $postal_code
 */
class Profile extends \yii\db\ActiveRecord
{
    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'profile';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['user_id', 'gender', 'postal_code'], 'integer'],
            [['birthdate'], 'safe'],
            [['phone'], 'string', 'max' => 70],
            [['mobile'], 'string', 'max' => 60],
            [['country', 'region', 'city', 'address'], 'string', 'max' => 255],
            [['name', 'surname', 'lastname'], 'string', 'max' => 150],
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
            'id' => 'ID',
            'user_id' => 'User ID',
            'name' => 'Name',
            'surname' => 'Surname',
            'lastname' => 'Lastname',
            'image' => 'Image',
            'phone' => 'Phone number',
            'mobile' => 'Mobile number',
            'address' => 'Address',
            'birthdate' => 'Birthdate',
            'gender' => 'Gender',
            'country' => 'Country',
            'region' => 'Region',
            'postal_code' => 'Postal code',
        ];
    }

    /**
     * Get user fullname
     *
     * @param object $profile
     * @return mixed
     */
    public static function getFullname($profile)
    {
        $fullname = '';

        if ($profile && $profile->name) {
            $fullname = _strtotitle($profile->name) . ' ';
        }

        if ($profile && $profile->surname) {
            $fullname .= _strtotitle($profile->surname);
        }

        return $fullname ? trim($fullname) : 'Unknown User';
    }

    /**
     * Get user avatar
     *
     * @param object $profile
     * @return mixed
     */
    public static function getAvatar($profile)
    {
        $image = images_url('user.png');

        if ($profile && $profile->image && is_url($profile->image)) {
            $image = $profile->image;
        }

        return $image;
    }
}
