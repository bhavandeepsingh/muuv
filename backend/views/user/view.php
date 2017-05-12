<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use common\models\User;

/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

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
//            'id',
            'username',
            'first_name:ntext',
            'last_name:ntext',
     //       'auth_key',
  //          'password_hash',
   //         'password_reset_token',
            'email:email',
            'mobile',
            'dob',
            'status' => [
                'label' => 'Status',
                'value' => ($model->status == User::STATUS_ACTIVE)? 'Actvive': 'De Active'
            ],
            'role_id',
            'followers_count',
            'follow_count',
            'profile_pic' => [
                'label' => 'Profile Pic',
                'value' => yii\helpers\Url::to('@uploads/'),
                'format' => 'html'
            ],
            'created_at',
            'updated_at',
            'url:url',
            'desc',
            'gender' => [
                'label' => 'Gender',
                'value' => ($model->gender == 'm')?'Male':'Female'
            ],
        ],
    ]) ?>

</div>
