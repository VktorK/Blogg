<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%comments}}`.
 */
class m241202_141044_create_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'text' => $this->string(),
            'user_id' => $this->integer(),
            'article_id' => $this->integer(),
            'status' => $this->integer()
        ]);

        $this->createIndex(
            '{{%idx-comments-user_id}}',
            '{{%comments}}',
            'user_id');


        $this->addForeignKey('fk-comments-user_id',
            'comments',
            'user_id',
            'users',
            'id',
            'CASCADE');

        $this->createIndex('idx-article_id',
            '{{%comments}}',
            'article_id');

        $this->addForeignKey('fk-article_id',
            'comments',
            'article_id',
            'articles',
            'id',
            'CASCADE');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%comments}}');
    }
}
