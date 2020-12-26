<?php

use yii\db\Migration;

/**
 * Class m200128_105952_final_contract
 */
class m200128_105952_final_contract extends Migration {

    /**
     * {@inheritdoc}
     */
    public function safeUp() {
        $this->execute("
       ALTER TABLE `tbl_client_booking_form` CHANGE `contract_status` `contract_status` INT(11) NOT NULL DEFAULT '0' COMMENT '7-Security Cheque Added, 8-Contract Generated, 9-Contract Approved by Agent 10-Contract approved by User & Add digital signature, 11-Contract regenerated using the digital signature, 12-twelve(12) Cheque Added , 13-Contract creation on CRM,14-Contract creation on CRM,';
    ");
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown() {
        echo "m200128_105952_final_contract cannot be reverted.\n";

        return false;
    }

    /*
      // Use up()/down() to run migration code without a transaction.
      public function up()
      {

      }

      public function down()
      {
      echo "m200128_105952_final_contract cannot be reverted.\n";

      return false;
      }
     */
}
