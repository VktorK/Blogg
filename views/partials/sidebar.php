<?php



?>

<div class="col-md-4" data-sticky_column>
    <div class="primary-sidebar">

        <aside class="widget">
            <h3 class="widget-title text-uppercase text-center">Popular Posts</h3>
            <?php
            /** @var TYPE_NAME $popularArticles */
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

            <?php /** @var TYPE_NAME $lastArticles */
            foreach ($lastArticles as $lastArticle): ?>
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
            /** @var TYPE_NAME $categories */
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
