<?php

use yii\db\Migration;

/**
 * Class m200129_074044_params_notification
 */
class m200129_074044_params_notification extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->execute("
       ALTER TABLE `tbl_notification` ADD `params` TEXT NOT NULL AFTER `receiver_id`;

    ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m200129_074044_params_notification cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m200129_074044_params_notification cannot be reverted.\n";

      return false;
      }
     */
}
