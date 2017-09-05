<?php

namespace app\modules\Gallery\models;

use Yii;
use yii\helpers\Url;
use \yii\db\ActiveRecord;
use yii\imagine\Image;

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
	 * images properties
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
	 * images
	 */
	public function afterFind() {
		$this->images = $this->getImages($this);
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
	 * @param null / integer $imageObject
	 *
	 * @return array
	 */
    public function getImages($imageObject = null) {
		$imagesPath = [];
		$fullPath = Yii::getAlias('@app') . '/';
		foreach (Yii::$app->params['galleryModule']['sizes'] as $type => $imageData) {
			$resultImage = $imageData['defaultImg'];
			if (! is_null($imageObject) && file_exists($fullPath . $imageData['path'] . $imageObject->source_img)) {
				$resultImage = Url::home(true) . $imageData['path'] . $imageObject->source_img;
			}

			$imagesPath[$type] = $resultImage;
		}

		return $imagesPath;
	}

	/**
	 * Create thumbnails
	 *
	 * @param string $sourceImgName
	 * @return array
	 */
	public function createThumbnails($sourceImgName) {
		$returnResult = [];
		$moduleConfigure = Yii::$app->params['galleryModule'];
		$fullPath = Yii::getAlias('@app') . '/';
		$sourceImage = $fullPath . $moduleConfigure['sourcePath'] . $sourceImgName;
		$sourceImageDataObject = Image::getImagine()->open($sourceImage)->getSize();

    	if (file_exists($sourceImage)) {
			foreach ($moduleConfigure['sizes'] as $type => $imageData) {
				$imagePath = $fullPath . $imageData['path'] . $sourceImgName;
				if (! file_exists($imagePath)) {
					if (
						$sourceImageDataObject->getWidth() > $imageData['size'] ||
						$sourceImageDataObject->getHeight() > $imageData['size']
					) {
						$return = Image::thumbnail($sourceImage, $imageData['size'], $imageData['size'])
										->save($imagePath, ['quality' => 100]);

						if (! is_null($return)) {
							$returnResult[$type] = $return;
						}
					}
				}
			}
		}

		return $returnResult;
	}

}
