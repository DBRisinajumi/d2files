<?php

class m131226_112800_create_tables_d2files extends CDbMigration
{

	/**
	 * Creates initial version of the table
	 */
	public function up()
	{

		$this->execute("
            CREATE TABLE IF NOT EXISTS `d2files` (
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
            ) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

            ALTER TABLE `d2files` ADD INDEX (`model`(4), `model_id`);
        ");
        
	}

	/**
	 * Drops the table
	 */
	public function down()
	{
        $this->dropTable('d2files');
	}

	/**
	 * Creates initial version of the table in a transaction-safe way.
	 * Uses $this->up to not duplicate code.
	 */
	public function safeUp()
	{
		$this->up();
	}

	/**
	 * Drops the table in a transaction-safe way.
	 * Uses $this->down to not duplicate code.
	 */
	public function safeDown()
	{
		$this->down();
	}
}
