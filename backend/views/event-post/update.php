<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\EventPost */

$this->title = 'Update Event Post: ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Event Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="event-post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>