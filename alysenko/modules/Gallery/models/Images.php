<?php

namespace app\modules\Gallery\models;

use Yii;
use yii\helpers\Url;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "images".
 *
 * @property integer $id
 * @property integer $album_id
 * @property string $title
 * @property string $description
 * @property string $source_img
 */
class Images extends ActiveRecord
{
	/**
	 * @var integer
	 */
	const SIZE_SMALL_IMG = 100;

	/**
	 * @var integer
	 */
	const SIZE_MEDIUM_IMG = 360;

	/**
	 * @var integer
	 */
	const SIZE_LARGE_IMG = 720;

	/**
	 * @var string
	 */
	const PATH_UPLOAD = 'web/uploads/';

	/**
	 * @var string
	 */
	const PATH_SOURCE_IMG = self::PATH_UPLOAD . 'source/';

	/**
	 * @var string
	 */
	const PATH_SMALL_IMG = self::PATH_UPLOAD . '100/';

	/**
	 * @var string
	 */
	const PATH_MEDIUM_IMG = self::PATH_UPLOAD . '360/';

	/**
	 * @var string
	 */
	const PATH_LARGE_IMG = self::PATH_UPLOAD . '720/';

	/**
	 * @var array
	 */
	private $defaultImages = [
		'source' => 'http://placehold.it/100x100',
		'small' => 'http://placehold.it/100x100',
		'medium' => 'http://placehold.it/360x360',
		'large' => 'http://placehold.it/720x720',
	];

	/**
	 * @var string
	 */
	public $small_img = 'http://placehold.it/100x100';

	/**
	 * @var string
	 */
	public $medium_img = 'http://placehold.it/360x360';

	/**
	 * @var string
	 */
	public $large_img = 'http://placehold.it/720x720';

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
	 * images
	 */
	public function afterFind() {

		$fullPath = Yii::getAlias('@app') . '/';

		/** check `small` */
		if (file_exists($fullPath . self::PATH_SMALL_IMG . $this->source_img)) {
			$this->small_img = Url::home(true) . self::PATH_SMALL_IMG . $this->source_img;
		}

		/** check `medium` */
		if (file_exists($fullPath . self::PATH_MEDIUM_IMG . $this->source_img)) {
			$this->medium_img = Url::home(true) . self::PATH_MEDIUM_IMG . $this->source_img;
		}

		/** check `large` */
		if (file_exists($fullPath . self::PATH_LARGE_IMG . $this->source_img)) {
			$this->large_img = Url::home(true) . self::PATH_LARGE_IMG . $this->source_img;
		}

	}

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
			[['source_img'], 'file', 'extensions' => 'png, jpg'],
            [['album_id'], 'required'],
            [['album_id'], 'integer'],

            [['description'], 'string'],
            [['title','description'], 'string', 'length' => [4, 255]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => 'Album',
            'title' => 'Title',
            'description' => 'Description',
            'source_img' => 'Source Img',
        ];
    }

	/**
	 * @param null / integer $imageId
	 *
	 * @return array
	 */
    public function getImages($imageId = null) {
    	$imagesPath = $this->defaultImages;

    	if (! is_null($imageId)) {
			$imagesObjects = self::findOne($imageId);
			if (! is_null($imagesObjects)) {
				$fullPath = Yii::getAlias('@app') . '/';

				/** check `source` */
				if (file_exists($fullPath . self::PATH_SOURCE_IMG . $imagesObjects->source_img)) {
					$imagesPath['source'] = Url::home(true) . self::PATH_SOURCE_IMG . $imagesObjects->source_img;
				}

				/** check `small` */
				if (file_exists($fullPath . self::PATH_SMALL_IMG . $imagesObjects->source_img)) {
					$imagesPath['small'] = Url::home(true) . self::PATH_SMALL_IMG . $imagesObjects->source_img;
				}

				/** check `medium` */
				if (file_exists($fullPath . self::PATH_MEDIUM_IMG . $imagesObjects->source_img)) {
					$imagesPath['medium'] = Url::home(true) . self::PATH_MEDIUM_IMG . $imagesObjects->source_img;
				}

				/** check `large` */
				if (file_exists($fullPath . self::PATH_LARGE_IMG . $imagesObjects->source_img)) {
					$imagesPath['large'] = Url::home(true) . self::PATH_LARGE_IMG . $imagesObjects->source_img;
				}
			}
		}

    	return $imagesPath;
	}

}
