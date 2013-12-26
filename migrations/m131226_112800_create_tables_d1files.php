<?php

class m131226_112800_create_tables_d1files extends CDbMigration
{

	/**
	 * Creates initial version of the audit trail table
	 */
	public function up()
	{

        $sSql = "DROP TABLE IF EXISTS d1files";
        $result = Yii::app()->db->createCommand($sSql)->query();

        $sSql = "

        CREATE TABLE `d1files` (
          `id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
          `type` ENUM('Document','Image','Other') NOT NULL,
          `file_name` VARCHAR(255) NOT NULL,
          `upload_path` TEXT NOT NULL,
          `add_datetime` DATETIME NOT NULL,
          `user_id` INT(11) NOT NULL,
          `deleted` TINYINT(1) NOT NULL DEFAULT '0',
          `notes` TEXT,
          `model` VARCHAR(20) NOT NULL,
          `model_id` BIGINT(20) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8
            ";
        $result = Yii::app()->db->createCommand($sSql)->query();
        
        $sSql = "ALTER TABLE `d1files` ADD INDEX (`model`(4), `model_id`); ";
        $result = Yii::app()->db->createCommand($sSql)->query();
        

	}

	/**
	 * Drops the audit trail table
	 */
	public function down()
	{
        $sSql = "DROP TABLE IF EXISTS d1files";
        $result = Yii::app()->db->createCommand($sSql)->query();

	}

	/**
	 * Creates initial version of the audit trail table in a transaction-safe way.
	 * Uses $this->up to not duplicate code.
	 */
	public function safeUp()
	{
		$this->up();
	}

	/**
	 * Drops the audit trail table in a transaction-safe way.
	 * Uses $this->down to not duplicate code.
	 */
	public function safeDown()
	{
		$this->down();
	}
}
