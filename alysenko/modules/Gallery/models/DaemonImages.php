<?php

namespace app\modules\Gallery\models;

use Yii;

/**
 * This is the model class for table "daemon_images".
 *
 * @property integer $id
 * @property string $source_img
 * @property integer $status
 */
class DaemonImages extends \yii\db\ActiveRecord
{

	/**
	 * @var integer
	 */
	const STATUS_NEW = 0;

	/**
	 * @var integer
	 */
	const STATUS_OLD = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'daemon_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'integer'],
            [['source_img'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'source_img' => 'Source Img',
            'status' => 'Status',
        ];
    }
}
