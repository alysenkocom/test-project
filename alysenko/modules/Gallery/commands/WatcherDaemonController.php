<?php
/**
 * Created by PhpStorm.
 * User: alysenko
 * Date: 01.09.17
 * Time: 12:38
 */

namespace app\modules\Gallery\commands;

/**
 * Class WatcherDaemonController
 *
 * @package app\modules\Gallery\commands
 */
class WatcherDaemonController extends \vyants\daemon\controllers\WatcherDaemonController
{

	/**
	 * @return array
	 */
	protected function defineJobs()
	{
		sleep($this->sleep);

		$daemons = [
			['className' => 'ImagesDaemonController', 'enabled' => true],
		];

		return $daemons;
	}

}