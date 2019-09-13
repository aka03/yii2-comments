<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\widgets\Pjax;
?>

<h3><?= Yii::t('comment', 'Leave a comment') ?></h3>
<div class="media-list">
    <div class="media mb-3">
        <div class="media-left">
            <?= Html::img($userAvatar, ['class' => 'media-object mr-3'])?>
        </div>
        <div class="media-body">
            <?php Pjax::begin(['id' => 'comments-form-pjax', 'timeout' => 10000]); ?>

            <?php $form = ActiveForm::begin([
                'id' => 'comment-form',
                'options' => [
                    'data-pjax' => true,
                ],
                'errorCssClass' => null,
                'successCssClass' => null
            ]); ?>

                <?php
                if (Yii::$app->user->isGuest) {
                    echo $form->field($model, 'guest_name', ['template' => '{input}'])
                        ->textInput(['placeholder' => Yii::t('comment', 'Name')]);
                } ?>

                <?= $form->field($model, 'message', ['template' => '{input}'])
                    ->textarea([
                        'rows' => 5,
                        'placeholder' => Yii::t('comment', 'Message'),
                        'class' => 'form-control edit-message'
                    ]);
                ?>

                <div class="form-group text-right pull-right">
                    <?= Html::submitButton(Yii::t('comment', 'Send'), ['class' => 'btn btn-primary']) ?>
                </div>

            <?php ActiveForm::end() ?>
            <?php Pjax::end() ?>
        </div>
    </div>
</div>
