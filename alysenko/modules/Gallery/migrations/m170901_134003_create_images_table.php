<?php

use yii\db\Migration;

/**
 * Handles the creation of table `images`.
 */
class m170901_134003_create_images_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('images', [
            'id' => $this->primaryKey(),
			'album_id' => $this->integer()->notNull(),
			'title' => $this->string()->defaultValue(''),
			'description' => $this->text(),
			'source_img' => $this->string()->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('images');
    }
}
