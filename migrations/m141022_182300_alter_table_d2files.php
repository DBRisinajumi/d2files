<?php

class m141022_182300_alter_table_d2files extends CDbMigration
{

	/**
	 * Alter table
	 */
	public function up()
	{

		$this->execute("
            ALTER TABLE `d2files` CHANGE `type` `type_id` SMALLINT UNSIGNED NULL;
            ALTER TABLE `d2files` ADD INDEX ( `type_id` );
            ALTER TABLE `d2files` ADD FOREIGN KEY ( `type_id` ) REFERENCES `d2files_type` (
             `id` 
            );
        ");
        
	}
    
	/**
	 * Alter table
	 */
	public function down()
	{
		$this->execute("
            ALTER TABLE `d2files` DROP FOREIGN KEY `d2files_ibfk_1`;
            ALTER TABLE `d2files` DROP INDEX `type_id`;
            ALTER TABLE `d2files` CHANGE `type_id` `type` ENUM( 'Document', 'Image', 'Other' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL;
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
