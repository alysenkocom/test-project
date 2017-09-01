<?php

use yii\db\Migration;

/**
 * Handles the creation of table `daemon_images`.
 */
class m170901_134020_create_daemon_images_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('daemon_images', [
            'id' => $this->primaryKey(),
			'source_img' => $this->string()->notNull(),
			'status' => $this->integer()->notNull()->defaultValue('0'),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('daemon_images');
    }
}
