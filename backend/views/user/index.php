<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\User;
/* @var $this yii\web\View */
/* @var $searchModel common\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Users';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create User', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'username',
            [
               'label' => 'Full name',
               'value' => function($data){
                    return  $data->first_name . " ".$data->last_name;                    
               }
            ],
            // 'password_hash',
            // 'password_reset_token',
             'email:email',
             'mobile',
            // 'dob',
            [
                'label' => 'Status',
                'format' => 'html',
                'value' => function($data){
                    $new_status = ($data->status == User::STATUS_ACTIVE)? User::STATUS_DELETED: User::STATUS_ACTIVE;                    
                    return '<a href="'.yii\helpers\Url::to(['user/status', 'id' => $data->id, 'User' => ['status' => $new_status ]]).'">'. (($data->status == User::STATUS_ACTIVE)? 'De Activated': 'Activated').'</a>';
                }
            ],
            // 'role_id',
            // 'followers_count',
            // 'follow_count',
            // 'profile_pic',
            // 'created_at',
            // 'updated_at',
            // 'url:url',
            // 'desc',
            // 'gender',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
