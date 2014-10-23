<?php

class m141022_172300_create_table_d2files_type extends CDbMigration
{

	/**
	 * Create table
	 */
	public function up()
	{

		$this->execute("
            CREATE TABLE `d2files_type` (
              `id` smallint(5) unsigned NOT NULL AUTO_INCREMENT,
              `type` varchar(50) NOT NULL,
              `model` varchar(50) NOT NULL,
              PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
        ");
        
	}

	/**
	 * Drop table
	 */
	public function down()
	{
		$this->dropTable('d2files_type');
	}

	/**
	 * Create table in a transaction-safe way.
	 * Uses $this->up to not duplicate code.
	 */
	public function safeUp()
	{
		$this->up();
	}

	/**
	 * Drop table in a transaction-safe way.
	 * Uses $this->down to not duplicate code.
	 */
	public function safeDown()
	{
		$this->down();
	}
}
