<?php

namespace app\modules\Gallery\controllers;

use app\modules\Gallery\models\DaemonImages;
use Yii;
use app\modules\Gallery\models\Images;
use app\modules\Gallery\models\Albums;
use yii\data\Pagination;
use yii\imagine\Image;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Default controller for the `Gallery` module
 */
class DefaultController extends Controller
{

	/**
	 * @var integer
	 */
	const IMAGES_PAGINATION_SIZE = 10;

	/**
	 * @var integer
	 */
	const ALBUMS_PAGINATION_SIZE = 10;

	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		return [
			'error' => [
				'class' => 'yii\web\ErrorAction',
			],
		];
	}

	/**
	 * @param null/id $galleryId
	 *
	 * @return string
	 * @throws \yii\web\NotFoundHttpException
	 */
    public function actionIndex($galleryId = null)
    {
    	if (! is_null($galleryId)) {

			$modelAlbum = Albums::findOne($galleryId);
			if (! is_null($modelAlbum)) {

				/** set title */
				$this->view->title = Yii::$app->name . ' - Gallery - ' . $modelAlbum->name;

				$imagesObjects = Images::find()->where(['album_id' => $galleryId])->orderBy('id desc');
				$pages = new Pagination(['totalCount' => $imagesObjects->count(), 'pageSize' => self::IMAGES_PAGINATION_SIZE]);
				$pages->pageSizeParam = false;
				$imageObjects = $imagesObjects->offset($pages->offset)->limit($pages->limit)->all();

				return $this->render('view',[
					'model' => $modelAlbum,
					'images' => $imageObjects,
					'pages' => $pages
				]);
			} else {
				throw new NotFoundHttpException('Album not found.');
			}

		} else {

			/** set title */
			$this->view->title = Yii::$app->name . ' - Gallery';

			$albumsModel = new Albums();
			$albumsObjects = Albums::find()->orderBy('id desc');

			$pages = new Pagination(['totalCount' => $albumsObjects->count(), 'pageSize' => self::ALBUMS_PAGINATION_SIZE]);
			$pages->pageSizeParam = false;
			$albumsObjects = $albumsObjects->offset($pages->offset)->limit($pages->limit)->all();

			return $this->render('index',[
				'model' => $albumsModel,
				'albumsObjects' => $albumsObjects,
				'pages' => $pages
			]);
		}
    }

	/**
	 * @return string
	 */
    public function actionCreate() {
		if (Yii::$app->request->isAjax) {
			$model = new Albums();
			if ($model->load(Yii::$app->request->post()) && $model->save()) {

				Yii::$app->session->setFlash('albumWasAdded', '<strong>Success!</strong> You have added a new "' . $model->name . '" album!');

				return json_encode(['status' => 'done']);
			}
		} else {
			$this->redirect(['/gallery']);
		}
	}

}
