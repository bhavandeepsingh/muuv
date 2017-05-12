<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EventRequest */

$this->title = Yii::t('app', 'Create Event Request');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Event Requests'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-request-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
