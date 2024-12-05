<!--main content start-->
<?php use yii\widgets\LinkPager;
/** @var TYPE_NAME $popularArticles */
/** @var TYPE_NAME $pagination */
/** @var TYPE_NAME $lastArticles */
/** @var TYPE_NAME $categories */
?>
<div class="main-content">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <?php foreach($articles as $article): ?>

                <article class="post">
                    <div class="post-thumb">
                        <a href="blog.html"><img src="<?=$article->getImage()?>" alt=""></a>

                        <a href="blog.html" class="post-thumb-overlay text-center">
                            <div class="text-uppercase text-center">View Post</div>
                        </a>
                    </div>
                    <div class="post-content">
                        <header class="entry-header text-center text-uppercase">
                            <h6><a href="#"> <?= $article->category->title ?></a></h6>

                            <h1 class="entry-title"><a href="blog.html"><?=$article->title ?></a></h1>


                        </header>
                        <div class="entry-content">
                            <p><?=$article->description ?>
                            </p>

                            <div class="btn-continue-reading text-center text-uppercase">
                                <a href="blog.html" class="more-link">Continue Reading</a>
                            </div>
                        </div>
                        <div class="social-share">
                            <span class="social-share-title pull-left text-capitalize">By <a href="#">Rubel</a> <?=$article->getDate() ?></span>
                            <ul class="text-center pull-right">
                                <li><a class="s-facebook" href="#"><i class="fa fa-eye"></i></a></li><?=$article->viewed ?>
                            </ul>
                        </div>
                    </div>
                </article>
                <?php endforeach ?>
                    <?php


                    echo LinkPager::widget([
                        'pagination' => $pagination,
                    ]); ?>
            </div>
            <div class="col-md-4" data-sticky_column>
                <div class="primary-sidebar">

                    <aside class="widget">
                        <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>
                        <?php
                        foreach ($popularArticles as $popularArticle): ?>
                        <div class="popular-post">


                            <a href="#" class="popular-img"><img src="<?=$popularArticle->getImage()?>" alt="">

                                <div class="p-overlay"></div>
                            </a>

                            <div class="p-content">
                                <a href="#" class="text-uppercase"><?=$popularArticle->title?></a>
                                <span class="p-date"><?=$popularArticle->getDate()?></span>

                            </div>
                        </div>
                        <?php endforeach ?>
                    </aside>
                    <aside class="widget pos-padding">
                        <h3 class="widget-title text-uppercase text-center">Recent Posts</h3>

                        <?php foreach ($lastArticles as $lastArticle): ?>
                        <div class="thumb-latest-posts">


                            <div class="media">
                                <div class="p-content">
                                    <a href="#" class="text-uppercase"><?= $lastArticle->title ?> </a>
                                    <span class="p-date"><?= $lastArticle->getDate() ?></span>
                                </div>
                            </div>
                        </div>
                        <?php endforeach ?>
                    </aside>
                    <aside class="widget border pos-padding">
                        <h3 class="widget-title text-uppercase text-center">Categories</h3>
                        <?php
                        foreach ($categories as $category): ?>
                        <ul>
                            <li>
                                <a href="#"><?= $category->title?></a>
                                <span class="post-count pull-right"> (<?= $category->getArticlesCount() ?>)</span>
                            </li>

                        </ul>
                        <?php endforeach ?>
                    </aside>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- end main content-->