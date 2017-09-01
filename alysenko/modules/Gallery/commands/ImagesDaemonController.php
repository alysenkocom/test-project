<?php
/**
 * Created by PhpStorm.
 * User: alysenko
 * Date: 01.09.17
 * Time: 12:40
 */

namespace app\modules\Gallery\commands;

use Yii;
use app\modules\Gallery\models\DaemonImages;
use app\modules\Gallery\models\Images;
use yii\imagine\Image;
use vyants\daemon\DaemonController;

class ImagesDaemonController extends DaemonController
{

	/**
	 * @return array
	 */
	protected function defineJobs()
	{
		$imageList = DaemonImages::findAll(['status' => DaemonImages::STATUS_NEW]);

		return $imageList;
	}

	/**
	 * @param $job
	 *
	 * @return bool
	 */
	protected function doJob($job)
	{
		$fullPath = Yii::getAlias('@app') . '/';
		$sourceImage = $fullPath . Images::PATH_SOURCE_IMG . $job->source_img;

		if (file_exists($sourceImage)) {
			$sourceImageDataObject = Image::getImagine()->open($sourceImage)->getSize();

			$smallImage = $fullPath . Images::PATH_SMALL_IMG . $job->source_img;
			$mediumImage = $fullPath . Images::PATH_MEDIUM_IMG . $job->source_img;
			$largeImage = $fullPath . Images::PATH_LARGE_IMG . $job->source_img;

			$status = [];
			/** small */
			if (! file_exists($smallImage)) {
				if (
					$sourceImageDataObject->getWidth() > Images::SIZE_SMALL_IMG ||
					$sourceImageDataObject->getHeight() > Images::SIZE_SMALL_IMG
				) {
					$return = Image::thumbnail($sourceImage, Images::SIZE_SMALL_IMG, Images::SIZE_SMALL_IMG)->save($smallImage, ['quality' => 100]);
					if ($return) {
						$status['small'] = true;
					}
				} else {
					if (copy($sourceImage, $smallImage)) {
						$status['small'] = true;
					}
				}
			}

			/** medium */
			if (! file_exists($mediumImage)) {
				if (
					$sourceImageDataObject->getWidth() > Images::SIZE_MEDIUM_IMG ||
					$sourceImageDataObject->getHeight() > Images::SIZE_MEDIUM_IMG
				) {
					$return = Image::thumbnail($sourceImage, Images::SIZE_MEDIUM_IMG, Images::SIZE_MEDIUM_IMG)->save($mediumImage, ['quality' => 100]);
					if ($return) {
						$status['medium'] = true;
					}
				} else {
					if (copy($sourceImage, $smallImage)) {
						$status['medium'] = true;
					}
				}
			}

			/** large */
			if (! file_exists($largeImage)) {
				if (
					$sourceImageDataObject->getWidth() > Images::SIZE_LARGE_IMG ||
					$sourceImageDataObject->getHeight() > Images::SIZE_LARGE_IMG
				) {
					$return = Image::thumbnail($sourceImage, Images::SIZE_LARGE_IMG, Images::SIZE_LARGE_IMG)->save($largeImage, ['quality' => 100]);
					if ($return) {
						$status['large'] = true;
					}
				} else {
					if (copy($sourceImage, $smallImage)) {
						$status['large'] = true;
					}
				}
			}

			if (count($status) === 3) {
				$update = DaemonImages::findOne($job->id);
				$update->status = DaemonImages::STATUS_OLD;
				if ($update->update()) {
					return true;
				} else {
					// we have to remove what we have created.
				}
			} else {
				// we should remove what we have created.
			}
		}

		return false;
	}

}