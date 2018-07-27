<?php

use yii\db\Migration;

class m000000_000000_init extends Migration
{
    public function safeUp()
    {
        $this->createTable('{{%user}}', [
            'id' => 'int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'email' => 'varchar(64) NOT NULL',
            'password' => 'varchar(255) NOT NULL',
            'auth_key' => 'varchar(255) NOT NULL',
            'created_at' => 'datetime(6) NOT NULL',
            'updated_at' => 'datetime(6) NOT NULL',
            'UNIQUE KEY(`email`)',
        ]);

        $this->createTable('{{%page}}', [
            'id' => 'int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'slug' => 'varchar(255) NOT NULL',
            'title' => 'varchar(255) NOT NULL',
            'text' => 'text NOT NULL',
            'created_at' => 'datetime(6) NOT NULL',
            'updated_at' => 'datetime(6) NOT NULL',
            'UNIQUE KEY(`slug`)',
        ]);

        $this->createTable('{{%raid}}', [
            'id' => 'int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'slug' => 'varchar(255) NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'subtitle' => 'varchar(255) NOT NULL',
            'description' => 'varchar(255) NOT NULL',
            'image' => 'varchar(255) NOT NULL',
            'is_active' => 'tinyint(1) unsigned NOT NULL',
            'created_at' => 'datetime(6) NOT NULL',
            'updated_at' => 'datetime(6) NOT NULL',
            'UNIQUE KEY(`slug`)',
        ]);
        $this->createTable('{{%raid_section}}', [
            'id' => 'int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'raid_id' => 'int(10) unsigned NOT NULL',
            'slug' => 'varchar(255) NOT NULL',
            'type' => 'varchar(255) NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'content' => 'text NOT NULL',
            'is_default' => 'tinyint(1) unsigned NOT NULL',
            'created_at' => 'datetime(6) NOT NULL',
            'updated_at' => 'datetime(6) NOT NULL',
            'UNIQUE KEY(`slug`)',
        ]);
        $this->addForeignKey('raid_section_ibfk1', '{{%raid_section}}', 'raid_id', '{{%raid}}', 'id', 'CASCADE', 'CASCADE');

        $this->createTable('{{%settings}}', [
            'id' => 'int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT',
            'type' => 'varchar(255) NOT NULL',
            'section' => 'varchar(255) NOT NULL',
            'key' => 'varchar(255) NOT NULL',
            'value' => 'text NOT NULL',
            'active' => 'tinyint(1) unsigned NOT NULL',
            'created' => 'tinyint(1) unsigned NOT NULL',
            'modified' => 'datetime(6) NOT NULL',
            'UNIQUE KEY(`section`, `key`)',
        ]);
    }

    public function safeDown()
    {
        $this->dropTable('{{%user}}');
        $this->dropTable('{{%raid_section}}');
        $this->dropTable('{{%raid}}');
        $this->dropTable('{{%page}}');
        $this->dropTable('{{%settings}}');
    }
}
