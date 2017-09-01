<?php

namespace app\modules\Gallery;

use Yii;
use \yii\base\Module as BaseModule;
use yii\base\BootstrapInterface;
use \yii\console\Application;

/**
 * Gallery module definition class
 */
class Module extends BaseModule implements BootstrapInterface
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'app\modules\Gallery\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

		$this->setAliases([
			'@gallery-assets' => __DIR__ . '/web',
			'@gallery-views' => __DIR__ . '/views',
		]);

		$this->layout = '@gallery-views/layouts/main';
    }

	/**
	 * @param $app
	 */
	public function bootstrap($app)
	{
		if ($app instanceof Application) {
			$this->controllerNamespace = 'app\modules\Gallery\commands';
		}
	}

}
