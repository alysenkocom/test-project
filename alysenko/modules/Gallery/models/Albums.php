<?php

namespace app\modules\Gallery\models;

use Yii;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "albums".
 *
 * @property integer $id
 * @property string $name
 */
class Albums extends ActiveRecord
{

	/**
	 * default image for album
	 *
	 * @var array
	 */
	public $images = [];

	/**
	 * @return array
	 */
	public function events()
	{
		return [
			ActiveRecord::EVENT_AFTER_FIND => 'afterFind',
		];
	}

	/**
	 * set images
	 */
	public function afterFind()
	{
		$model = Images::find()->where(['album_id' => $this->id])->orderBy('id desc')->one();
		if (! is_null($model)) {
			$this->images = (new Images())->getImages($model->id);
		} else {
			$this->images = (new Images())->getImages();
		}
	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'albums';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['name'], 'required', 'message' => 'Please type name!'],
            [['name'], 'string', 'length' => [4, 255]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }
}
