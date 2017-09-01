<?php
/**
 * Created by PhpStorm.
 * User: alysenko
 * Date: 30.08.17
 * Time: 22:20
 */

namespace app\modules\Gallery\assets;

use yii\web\AssetBundle;

/**
 * Class GalleryAsset
 *
 * @package app\modules\Gallery
 */
class GalleryAsset extends AssetBundle
{

	/**
	 * @inheritdoc
	 */
	public $sourcePath = '@gallery-assets';

	/**
	 * @var array $css
	 */
	public $css = [
		'css/style.css',
	];

	/**
	 * @var array $js
	 */
	public $js = [
		'js/loadFile.js',
		'js/modals.js',
	];

	/**
	 * @var array
	 */
	public $depends = [
		'yii\web\YiiAsset',
		'yii\bootstrap\BootstrapAsset',
	];

}