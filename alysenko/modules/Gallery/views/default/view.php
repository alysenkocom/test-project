<?php

use \yii\widgets\Breadcrumbs;
use \yii\widgets\Pjax;
use \yii\helpers\Url;
use \yii\widgets\LinkPager;
use \yii\helpers\Html;

$this->params['breadcrumbs'][] = ['label' => 'Gallery', 'url' => ['/gallery']];
$this->params['breadcrumbs'][] = Html::encode($model->name);
Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [] ]);

?>

<h1><?= Html::encode($model->name); ?></h1><hr/>

<?php if (Yii::$app->session->hasFlash('imageWasAdded')): ?>
<div class="row">
    <div class="col-lg-12 top-buffer">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <?= Yii::$app->session->getFlash('imageWasAdded') ?>
        </div>
    </div>
</div>
<?php endif; ?>

<?php Pjax::begin(['id'=>'ajax-body']); ?>
<?php if (! empty($images)): ?>
    <?php foreach ($images as $image): ?>
        <div class="row">
            <div class="col-md-2 text-center">
                <a data-pjax="0" class="thumbnail" href="<?= Url::to('/gallery/image/' . $image->id); ?>">
                    <img class="img-responsive" style="display:inline-block;" src="<?= $image->small_img ?>" alt="">
                </a>
            </div>
            <div class="col-md-10">
                <h4>
                    <a data-pjax="0" href="<?= Url::to('/gallery/image/' . $image->id); ?>"><?= Html::encode($image->title); ?></a>
                </h4>
                <p><?= Html::encode($image->description); ?></p>
            </div>
        </div>
        <br/>
    <?php endforeach; ?>
<?php else: ?>
    <div class="row">
        <div class="col-md-12 text-center">
            there are no images..
        </div>
    </div>
<?php endif; ?>

<div class="col-lg-12">
	<?php echo LinkPager::widget([
		'pagination' => $pages,
		'prevPageLabel' => 'Prev',
		'nextPageLabel' => 'Next',
	]); ?>
</div>
<?php Pjax::end();?>