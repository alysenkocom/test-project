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
use vyants\daemon\DaemonController;

/**
 * Class ImagesDaemonController
 *
 * @package app\modules\Gallery\commands
 */
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
		$modelObject = new Images();
		$result = $modelObject->createThumbnails($job->source_img);

		if (count($result) === 3) {
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

		return false;
	}

}