<?php

use yii\db\Migration;

/**
 * Class m200128_055446_rating
 */
class m200128_055446_rating extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->execute("
        ALTER TABLE `tbl_rating` ADD `comments` VARCHAR(300) NOT NULL AFTER `question_id`;
    ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m200128_055446_rating cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m200128_055446_rating cannot be reverted.\n";

      return false;
      }
     */
}
