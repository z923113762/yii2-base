<?php
/**
 * Create user table
 * @author jonas  jonas_php@163.com
 *
 */
use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    const TBL_NAME="{{%user}}";
    /**
     * Create "user" table and index 
     * @see \yii\db\Migration::safeUp()
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB AUTO_INCREMENT = 100';
        }
        //dorp table
        $this->dropTable(self::TBL_NAME);
        
        $this->createTable(self::TBL_NAME, [
            'id' => Schema::TYPE_PK,
            'username' => Schema::TYPE_STRING . ' NOT NULL',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . ' NOT NULL',
            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10',
            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $tableOptions);
        //create index
        $this->createIndex('username', self::TBL_NAME, ['username'],true);
        $this->createIndex('email', self::TBL_NAME, ['email'],true);
    }
    /**
     * removing "user" table
     * @see \yii\db\Migration::safeDown()
     */
    public function safeDown()
    {
        $this->dropTable(self::TBL_NAME);
    }
}
