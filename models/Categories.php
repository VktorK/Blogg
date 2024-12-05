<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string|null $title
 */
class Categories extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
        ];
    }

    public function getArticles(): \yii\db\ActiveQuery
    {
        return $this->HasMany(Articles::className(), ['category_id' => 'id']);
    }

    public function getArticlesCount(): bool|int|string|null
    {
        return $this->getArticles()->count();
    }

    public static function getAllCategories()
    {
        return Categories::find()->all();
    }
}
