<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\EventPost */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Event Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-post-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'host_name',
            'latitude',
            'longitude',
            'flyer_image',
            'start_date',
            'end_date',
            'start_time',
            'end_time',
            'like_count',
            'remuuv_count',
            'share_count',
            'comments_count',
            'capacity',
            'privacy_status' => [
                'label' => 'Privacy Status',
                'value' => $model->getPrivacyText()
            ],
            'type' => [
                'label' => 'Type',
                'value' => $model->getTypeName()
            ],
            'user_id' => [
                'label' => 'Event Author',
                'value' => $model->eventAuthor->first_name. ' '. $model->eventAuthor->last_name
            ],
            'parent_id' => [
                'label' => 'Parent Post',
                'value' => ($model->parent_id)? '<a href="'.yii\helpers\Url::to(['event-post/view', 'id' => $model->parent_id]).'">View Parent Event</a>': 'No Parent',
                'format' => 'html'
            ],
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
