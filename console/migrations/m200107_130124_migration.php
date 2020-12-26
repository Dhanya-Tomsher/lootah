<?php

use yii\db\Migration;

/**
 * Class m200107_130124_migration
 */
class m200107_130124_migration extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m200107_130124_migration cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200107_130124_migration cannot be reverted.\n";

        return false;
    }
    */
}
