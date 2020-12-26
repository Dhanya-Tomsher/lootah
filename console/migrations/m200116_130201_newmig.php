<?php

use yii\db\Migration;

/**
 * Class m200116_130201_newmig
 */
class m200116_130201_newmig extends Migration
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
        echo "m200116_130201_newmig cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m200116_130201_newmig cannot be reverted.\n";

        return false;
    }
    */
}
