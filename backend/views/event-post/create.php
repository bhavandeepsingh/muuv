<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\EventPost */

$this->title = 'Create Event Post';
$this->params['breadcrumbs'][] = ['label' => 'Event Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-post-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
