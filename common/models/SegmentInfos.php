<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "site_segments_info".
 *
 * @property int $info_id
 * @property int|null $segment_id
 * @property string $language
 * @property string $title
 * @property string $slug
 * @property string $description
 * @property string $icon
 * @property string $image
 * @property string $cover_image
 * @property string|null $meta
 */
class SegmentInfos extends \yii\db\ActiveRecord
{
    public $meta_title;
    public $focus_keywords;
    public $meta_description;

    /**
     * Table name
     *
     * @return string
     */
    public static function tableName()
    {
        return 'site_segments_info';
    }

    /**
     * Rules
     *
     * @return array
     */
    public function rules()
    {
        return [
            [['title', 'segment_id', 'language'], 'required'],
            [['title', 'slug', 'icon', 'image', 'cover_image'], 'string', 'max' => 255],
            [['language', 'description', 'meta', 'meta_title', 'focus_keywords', 'meta_description'], 'string'],
            [['icon', 'image', 'cover_image'], 'default', 'value' => ''],
            [['meta', 'meta_title', 'meta_description', 'focus_keywords'], 'default', 'value' => ''],
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
            'info_id' => 'Info ID',
            'segment_id' => 'Segment ID',
            'language' => 'Language',
            'title' => 'Title',
            'slug' => 'Slug',
            'description' => 'Description',
            'icon' => 'Icon',
            'image' => 'Image',
            'cover_image' => 'Cover Image',
            'meta' => 'Meta',
            'meta_title' => 'Meta title',
            'meta_description' => 'Meta description',
            'focus_keywords' => 'Focus keywords',
        ];
    }
}
