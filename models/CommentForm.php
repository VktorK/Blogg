<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class CommentForm extends Model
{
    public $comment;




    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['comment'], 'required'],
            [['comment'], 'string', 'length' => [3, 255]],
        ];
    }

    public function saveComment($article_id)
    {
        $comment = new Comments();
        $comment->article_id = $article_id;
        $comment->user_id = Yii::$app->user->id;
        $comment->text = $this->comment;
        $comment->status = 0;
        return $comment->save();
    }
}
