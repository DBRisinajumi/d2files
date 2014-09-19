<?php

class m140919_014800_alter_table_d2files extends CDbMigration
{

	/**
	 * Alter table
	 */
	public function up()
	{

		$this->execute("
            ALTER TABLE `d2files` CHANGE `model` `model` VARCHAR( 255 ) NOT NULL;
        ");
        
	}

	/**
	 * Alter table
	 */
	public function down()
	{
		$this->execute("
            ALTER TABLE `d2files` CHANGE `model` `model` VARCHAR( 20 ) NOT NULL;
        ");
	}

	/**
	 * Alter table in a transaction-safe way.
	 * Uses $this->up to not duplicate code.
	 */
	public function safeUp()
	{
		$this->up();
	}

	/**
	 * Alter table in a transaction-safe way.
	 * Uses $this->down to not duplicate code.
	 */
	public function safeDown()
	{
		$this->down();
	}
}
