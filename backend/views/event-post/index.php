<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\EventPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Event Posts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="event-post-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Event Post', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            //'id',
            'title',
            'host_name',
            //'latitude',
            //'longitude',
             'flyer_image',
             'start_date',
             'end_date',
            // 'start_time',
            // 'end_time',
            // 'like_count',
            // 'remuuv_count',
            // 'share_count',
            // 'comments_count',
            // 'capacity',
            // 'privacy_status',
             [
                 'label' => 'Type',
                 'value' => function($data){
                    return $data->getTypeName();
                 }
             ],
             [
                 'label' => 'Event Author',
                 'value' => function($data){
                    return $data->eventAuthor->first_name . ' '.$data->eventAuthor->last_name;
                 }
             ],
            // 'parent_id',
            // 'created_at',
            // 'updated_at',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
