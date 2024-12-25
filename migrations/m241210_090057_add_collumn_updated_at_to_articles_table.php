<?php

use yii\db\Migration;

/**
 * Class m241210_090057_add_collumn_updated_at_to_articles_table
 */
class m241210_090057_add_collumn_updated_at_to_articles_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('articles','updated_at','datetime');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropColumn('articles','updated_at');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m241210_090057_add_collumn_updated_at_to_articles_table cannot be reverted.\n";

        return false;
    }
    */
}
