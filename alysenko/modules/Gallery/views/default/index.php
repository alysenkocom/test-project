<?php

use \yii\bootstrap\Modal;
use \yii\widgets\ActiveForm;
use \yii\bootstrap\Html;
use \yii\widgets\LinkPager;
use \yii\widgets\Pjax;
use \yii\helpers\Url;
use \yii\helpers\Html as HelpersHtml;

\app\modules\Gallery\assets\GalleryAsset::register($this);

?>
<div class="row">
    <div class="col-sm-12 bottom-buffer">
		<?php $form = ActiveForm::begin([
            'id' => 'form-create-album',
			'action' => '/gallery/create'
		]); ?>

        <?php Modal::begin([
            'id' => 'modal-create-album',
            'header' => '<h3>Create new album</h3>',
            'toggleButton' => [
                'tag' => 'input',
                'type' => 'button',
                'class'=>'btn btn-default',
                'value' => 'Create new album',
            ],
            'footer' => Html::button('Close', ['class' => 'btn btn-default', 'data-dismiss' => 'modal']) . PHP_EOL .
                        Html::submitButton('Save', ['class' => 'btn btn-success']),
        ]); ?>
        <?= $form->field($model, 'name'); ?>
        <?php Modal::end(); ?>

		<?php ActiveForm::end(); ?>
    </div>

	<?php Pjax::begin(['id'=>'ajax-body']); ?>

	<?php if(Yii::$app->session->hasFlash('albumWasAdded')): ?>
    <div class="col-lg-12">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <?= Yii::$app->session->getFlash('albumWasAdded') ?>
        </div>
    </div>
	<?php endif; ?>

    <div class="ajax-body">
        <!-- entities block -->
        <div class="top-buffer">
            <?php foreach ($albumsObjects as $model): ?>
                <div class="col-lg-3 col-md-4 col-xs-6 thumb">
                    <p class="thumbnail">
                        <a data-pjax="0" href="<?= Url::to('/gallery/' . $model->id); ?>">
                            <img class="img-responsive" src="<?= $model->images['medium']; ?>" alt="">
                        </a>
						<?= HelpersHtml::encode($model->name); ?>
                    </p>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- pagination block -->
        <div class="col-lg-12">
            <?php echo LinkPager::widget([
                'pagination' => $pages,
				'prevPageLabel' => 'Prev',
				'nextPageLabel' => 'Next',
            ]); ?>
        </div>
        <?php Pjax::end();?>
    </div>
</div>