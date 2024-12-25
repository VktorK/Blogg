<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "articles".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $description
 * @property string|null $content
 * @property string|null $date
 * @property string|null $image
 * @property int|null $viewed
 * @property int|null $user_id
 * @property int|null $status
 * @property int|null $category_id
 *
 * @property ArticleTag[] $articleTags
 * @property Comments[] $comments
 */
class Articles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'articles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['title','description','content'], 'string'],
            [['date'],'date','format'=>'yyyy-MM-dd'],
            [['date'],'default','value'=>date('Y-m-d')],
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
            'description' => 'Description',
            'content' => 'Content',
            'date' => 'Date',
            'image' => 'Image',
            'viewed' => 'Viewed',
            'user_id' => 'User ID',
            'status' => 'Status',
            'category_id' => 'Category ID',
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => TimestampBehavior::class,
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['updated_at' => new Expression('NOW()')],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at' => new Expression('NOW()')],
                ],
//                'value' => [
//                    'updated_at' => new Expression('NOW()')
//                ]
// если вместо метки времени UNIX используется datetime:
// 'value' => new Expression('NOW()'),
            ],
        ];
    }

    /**
     * Gets query for [[ArticleTags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tags::class, ['id' => 'tag_id'])
            ->viaTable('article_tag', ['article_id' => 'id']);
    }

    /**
     * Gets query for [[Comments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comments::class, ['article_id' => 'id']);
    }

    public function getArticleComments()
    {
        return $this->getComments()->where(['status' => 1])->all();
    }

    public function saveImage($filename)
    {
        $this->image = $filename;

       return $this->save(false);
    }

    public function deleteImage()
    {
        $imageUploadModel = new ImageUpload();
        $imageUploadModel->deleteCurrentImage($this->image);
    }

    public function beforeDelete()
    {
        $this->deleteImage();
        return parent::beforeDelete();
    }

    public function getImage(): string
    {
        return ($this->image) ? '/uploads/' . $this->image : '/no-image.png';
    }

    public function getCategory(): \yii\db\ActiveQuery
    {
        return $this->HasOne(Categories::className(), ['id' => 'category_id']);
    }

    public function saveCategory(int $category_id)
    {
        $category = Categories::findOne($category_id);
        if($category != null)
        {
        $this->link('category', $category);
        return true;
        }
    }

    public function getSelectedTag(): array
    {
        $selectedIds = $this->getTags()->select('id')->asArray()->all();
        return ArrayHelper::getColumn($selectedIds, 'id');
    }

    public function saveTags($tags): void
    {
        ArticleTag::deleteAll(['article_id' => $this->id]);
        if(is_array($tags))
        {
            foreach($tags as $tag_id)
            {
                $tag = Tags::findOne($tag_id);
                $this->link('tags', $tag);
            }
        }
    }

    public function getDate()
    {
        return Yii::$app->formatter->asDate($this->date);
    }

    public static function getAll($pageSize = 1)
    {
        // build a DB query to get all articles
        $query = Articles::find();

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

    public static function getPopularArticles()
    {
        return Articles::find()->orderBy(['viewed' => SORT_DESC])->limit(3)->all();
    }

    public static function getLastArticles()
    {
        return Articles::find()->orderBy(['date' => SORT_DESC])->limit(3)->all();

    }



    public function saveArticle()
    {
        $this->user_id = Yii::$app->user->id;
        return $this->save(false);
    }

    public function getAuthor()
    {
        return $this->hasOne(User::class, ['id'=>'user_id']);
    }
}
