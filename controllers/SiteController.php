<?php

namespace app\controllers;

use app\models\Articles;
use app\models\Categories;
use app\models\CommentForm;
use app\models\Comments;
use Yii;
use yii\data\ActiveDataProvider;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex(): string
    {

        $data = Articles::getAll(5);
        $popularArticles = Articles::getPopularArticles();
        $lastArticles = Articles::getLastArticles();
        $categories = Categories::getAllCategories();
        return $this->render('index',[
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
            'popularArticles' => $popularArticles,
            'lastArticles' => $lastArticles,
            'categories' => $categories,
        ]);
    }

    public function actionView($id): string
    {
        $article = Articles::findOne($id);
        $articleTags = $article->getTags()->all();
        $popularArticles = Articles::getPopularArticles();
        $lastArticles = Articles::getLastArticles();
        $categories = Categories::getAllCategories();
        $comments = $article->getArticleComments();
        $author = $article->getAuthor($article->user_id);
//        echo '<pre>';var_dump($author); echo '<pre>';die();
        $commentForm = new CommentForm();
//        echo '<pre>';
//        var_dump($comments);
//        echo '<pre>';
//        die();
        return $this->render('single',[
            'article' => $article,
            'articleTags' => $articleTags,
            'popularArticles' => $popularArticles,
            'lastArticles' => $lastArticles,
            'categories' => $categories,
            'commentForm' => $commentForm,
            'comments' => $comments,
            'author' => $author,
        ]);

    }

    public function actionCategory($id): string
    {
        $data = Categories::getAllArticletToCategoryId($id,1);
        $popularArticles = Articles::getPopularArticles();
        $lastArticles = Articles::getLastArticles();
        $categories = Categories::getAllCategories();
        return $this->render('category',[
            'articles' => $data['articles'],
            'pagination' => $data['pagination'],
            'popularArticles' => $popularArticles,
            'lastArticles' => $lastArticles,
            'categories' => $categories,
        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin(): Response|string
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout(): Response
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact(): Response|string
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout(): string
    {
        return $this->render('about');
    }

    public function actionComments($id)
    {
        $model = new CommentForm();
        if(Yii::$app->request->isPost)
        {
            $model->load(Yii::$app->request->post());
            if($model->saveComment($id))
            {
                Yii::$app->getSession()->setFlash('comment', 'Your comment will be added soon!');
                return $this->redirect(['site/view', 'id' => $id]);
            }
        }
    }
}
