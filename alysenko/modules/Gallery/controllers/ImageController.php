<?php
/**
 * Created by PhpStorm.
 * User: alysenko
 * Date: 30.08.17
 * Time: 22:59
 */

namespace app\modules\Gallery\controllers;

use app\modules\Gallery\models\DaemonImages;
use Yii;
use app\modules\Gallery\models\Albums;
use app\modules\Gallery\models\Images;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use \yii\helpers\ArrayHelper;
use \yii\web\UploadedFile;

/**
 * Class ImageController
 *
 * @package app\modules\Gallery\controllers
 */
class ImageController extends Controller
{

	/**
	 * The default action. Show image page.
	 *
	 * @param integer $imageId
	 *
	 * @return string
	 * @throws NotFoundHttpException
	 */
	public function actionView($imageId) {
		$imageModel = Images::findOne($imageId);
		if (!$imageModel) {
			throw new NotFoundHttpException;
		}

		/** set title */
		$this->view->title = Yii::$app->name . ' - Gallery - ' . $imageModel->title;

		$albumModel = Albums::find()->where(['id' => $imageModel->album_id])->one();

		return $this->render('view', [
			'model' => $imageModel,
			'album' => $albumModel
		]);
	}

	/**
	 * @return string
	 */
	public function actionUpload() {

		/** set title */
		$this->view->title = Yii::$app->name . ' - Gallery - Upload image';
		$imageModel = new Images();
		$uploadPath = Yii::getAlias('@app') . '/web/uploads/source';

		if ($imageModel->load(Yii::$app->request->post())) {
			$file = UploadedFile::getInstance($imageModel, 'source_img');
			$newFileName = Yii::$app->security->generateRandomString() . '.' . $file->extension;

			if ($file->saveAs($uploadPath . '/' . $newFileName)) {
				$imageModel->source_img = $newFileName;

				if ($imageModel->save()) {
					$daemonImages = new DaemonImages();
					$daemonImages->source_img = $imageModel->source_img;
					$daemonImages->save(false);

					Yii::$app->session->setFlash('imageWasAdded', '<strong>Success!</strong> You have added a new image in album!');
					$this->redirect(['/gallery/' . $imageModel->album_id]);
				}
			}
		} else {
			$albumsObjects = Albums::find()->all();

			return $this->render('index', [
				'model' => $imageModel,
				'albums' => $albumsObjects
			]);
		}
	}

}