<?php

namespace app\modules\admin\controllers;

use app\models\Articles;
use app\models\ArticlesSearch;
use app\models\Categories;
use app\models\Comments;
use app\models\ImageUpload;
use app\models\Tags;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ArticleController implements the CRUD actions for Articles model.
 */
class CommentController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }


    public function actionIndex(): string
    {
        $comments = Comments::find()->orderBy('id desc')->all();
        return $this->render('index', ['comments' => $comments]);
    }

    public function actionDestroy($id)
    {
        $comment = Comments::findOne($id);
        if($comment->delete())
        {
            return $this->redirect(['comment/index']);
        }
    }

    public function actionAllow($id)
    {
        $comment = Comments::findOne($id);
        if($comment->allow())
        {
            return $this->redirect(['index']);
        }
    }

    public function actionDisallow($id)
    {
        $comment = Comments::findOne($id);
        if($comment->disallow())
        {
            return $this->redirect(['index']);
        }
    }

}