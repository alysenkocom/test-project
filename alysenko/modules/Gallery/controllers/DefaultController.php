<?php

namespace app\modules\Gallery\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use app\modules\Gallery\models\Images;
use app\modules\Gallery\models\Albums;

/**
 * Class DefaultController
 *
 * @package app\modules\Gallery\controllers
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
	 * @return string
	 */
    public function actionIndex()
    {
		/** set title */
		$this->view->title = Yii::$app->name . ' - Gallery';
		$albumsModel = new Albums();

		$query = Albums::find()->orderBy('id desc');
		$provider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => self::ALBUMS_PAGINATION_SIZE,
			],
		]);

		return $this->render('index',[
			'model' => $albumsModel,
			'albumsObjects' => $provider->models,
			'pages' => $provider->pagination
		]);
    }

	/**
	 * @param integer $albumId
	 * @return string
	 *
	 * @throws NotFoundHttpException
	 */
    public function actionView($albumId) {

		$modelAlbum = Albums::findOne($albumId);
		if (!$modelAlbum) {
			throw new NotFoundHttpException;
		}

		/** set title */
		$this->view->title = Yii::$app->name . ' - Gallery - ' . $modelAlbum->name;

		$query = Images::find()->where(['album_id' => $modelAlbum->id])->orderBy('id desc');
		$provider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => self::IMAGES_PAGINATION_SIZE,
			],
		]);

		return $this->render('view',[
			'model' => $modelAlbum,
			'images' => $provider->models,
			'pages' => $provider->pagination
		]);
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
