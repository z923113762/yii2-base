<?php

use yii\db\Schema;
use yii\db\Migration;

class m150424_085303_rbac extends Migration
{
    //定义要创建的表名常量
    const TBL_NAME_RULE='{{%auth_rule}}';
    const TBL_NAME_ITEM='{{%auth_item}}';
    const TBL_NAME_ITEM_CHILD='{{%auth_item_child}}';
    const TBL_NAME_ASSIGNMENT='{{%auth_assignment}}';
    
    
    //执行数据库操作
    public function safeUp()
    {
        //定义表选项(引擎、编码等)
        $tableOptions = null;
        //判断数据驱动是否已经成功加载
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        //创建表
        $this->createTable(self::TBL_NAME_RULE, [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
        ], $tableOptions);
        
        $this->createTable(self::TBL_NAME_ITEM, [
            'name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'type' => Schema::TYPE_INTEGER . ' NOT NULL',
            'description' => Schema::TYPE_TEXT,
            'rule_name' => Schema::TYPE_STRING . '(64)',
            'data' => Schema::TYPE_TEXT,
            'created_at' => Schema::TYPE_INTEGER,
            'updated_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (name)',
            'FOREIGN KEY (rule_name) REFERENCES ' . self::TBL_NAME_RULE . ' (name) ON DELETE SET NULL ON UPDATE CASCADE',
        ], $tableOptions);
 
        $this->createTable(self::TBL_NAME_ITEM_CHILD, [
            'parent' => Schema::TYPE_STRING . '(64) NOT NULL',
            'child' => Schema::TYPE_STRING . '(64) NOT NULL',
            'PRIMARY KEY (parent, child)',
            'FOREIGN KEY (parent) REFERENCES ' . self::TBL_NAME_ITEM . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
            'FOREIGN KEY (child) REFERENCES ' . self::TBL_NAME_ITEM . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
        
        $this->createTable(self::TBL_NAME_ASSIGNMENT, [
            'item_name' => Schema::TYPE_STRING . '(64) NOT NULL',
            'user_id' => Schema::TYPE_STRING . '(64) NOT NULL',
            'created_at' => Schema::TYPE_INTEGER,
            'PRIMARY KEY (item_name, user_id)',
            'FOREIGN KEY (item_name) REFERENCES ' . self::TBL_NAME_ITEM . ' (name) ON DELETE CASCADE ON UPDATE CASCADE',
        ], $tableOptions);
        
        //创建索引
        $this->createIndex('idx-auth_item-type', self::TBL_NAME_ITEM, 'type');
    }
    //执行回滚
    public function safeDown()
    {
        //移除表
        $this->dropTable(self::TBL_NAME_RULE);
        $this->dropTable(self::TBL_NAME_ITEM);
        $this->dropTable(self::TBL_NAME_ITEM_CHILD);
        $this->dropTable(self::TBL_NAME_ASSIGNMENT);
    }
    
}
