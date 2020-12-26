<?php

use yii\db\Migration;

/**
 * Class m200128_074730_cheque_holder_name
 */
class m200128_074730_cheque_holder_name extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->execute("
       ALTER TABLE `tbl_cheque` ADD `user_name` VARCHAR(100) NOT NULL AFTER `remarks`;
    ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m200128_074730_cheque_holder_name cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m200128_074730_cheque_holder_name cannot be reverted.\n";

      return false;
      }
     */
}
