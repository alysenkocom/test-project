<?php

use \yii\widgets\Breadcrumbs;
use \yii\helpers\Url;
use \yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Gallery', 'url' => ['/gallery']];
$this->params['breadcrumbs'][] = ['label' => Html::encode($album->name), 'url' => ['/gallery/' . $model->album_id]];
$this->params['breadcrumbs'][] = Html::encode($model->title);
Breadcrumbs::widget([ 'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [] ]);

?>

<div class="col-sm-offset-3 col-sm-6">
    <h1>
		<?= Html::encode($model->title); ?>
    </h1>
    <div class="thumbnail">
        <a target="_blank" href="<?= Url::to('@web/uploads/source/' . $model->source_img); ?>">
            <img src="<?= $model->large_img; ?>" alt="">
        </a>
        <?= Html::encode($model->description); ?>
    </div>
</div>