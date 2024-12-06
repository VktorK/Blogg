<?php

namespace app\models;

use Yii;
use yii\data\Pagination;

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

    public static function getAllArticletToCategoryId($id,$pageSize = 1)
    {
        // build a DB query to get all articles
        $query = Categories::findOne($id)->getArticles();

//        var_dump($query);
//        die();

// get the total number of articles (but do not fetch the article data yet)
        $count = $query->count();

// create a pagination object with the total count
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => $pageSize]);

// limit the query using the pagination and retrieve the articles
        $articles = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        $data['articles'] = $articles;
        $data['pagination'] = $pagination;
        return $data;
    }
}
