<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%comments}}`.
 */
class m241207_172222_add_date_column_to_comments_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('comments', 'date', $this->date());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('comments', 'date');
    }
}
