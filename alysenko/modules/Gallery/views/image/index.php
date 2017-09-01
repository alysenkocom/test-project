<?php

use \yii\bootstrap\ActiveForm;
use \yii\widgets\Breadcrumbs;
use \yii\bootstrap\Html;

\app\modules\Gallery\assets\GalleryAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => 'Gallery', 'url' => ['/gallery']];
$this->params['breadcrumbs'][] = 'Upload image';
Breadcrumbs::widget(['links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []]);

?>

<div class="col-sm-offset-3 col-sm-6">
	<?php $form = ActiveForm::begin([
		'layout' => 'horizontal',
		'fieldConfig' => [
			'template' => "{label}\n{beginWrapper}\n{input}\n{hint}\n{error}\n{endWrapper}",
			'horizontalCssClasses' => [
				'label' => 'col-sm-4',
				'wrapper' => 'col-sm-8',
				'error' => '',
				'hint' => '',
			],
		],
		'action' => '/gallery/image/upload',
		'options' => ['enctype' => 'multipart/form-data']
	]); ?>

    <div id="preview"></div>

	<?= $form->field($model, 'source_img')->textInput()->fileInput(['accept' => 'image/*']); ?>
	<?= $form->field($model, 'title'); ?>
	<?= $form->field($model, 'description')->textarea(['rows' => '3']); ?>
	<?= $form->field($model, 'album_id')->dropDownList($albums); ?>

    <div class="form-group field-images-album_id required">
        <label class="control-label col-sm-4"></label>
        <div class="col-sm-8">
            <?= Html::submitButton( 'Save', ['class' => 'btn btn-success']); ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>
</div>