<?php

use yii\db\Migration;

/**
 * Handles the creation of table `albums`.
 */
class m170901_133945_create_albums_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('albums', [
            'id' => $this->primaryKey(),
			'name' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('albums');
    }
}
