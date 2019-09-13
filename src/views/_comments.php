<?php

use yii\widgets\Pjax;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

Pjax::begin(['id' => 'comments-pjax', 'timeout' => 10000]);

$form = ActiveForm::begin(['id' => 'empty-comment-form',
    'options' => ['class' => 'hidden d-none']
]); ?>

<?= $form->field($model, 'id', ['options' => ['class' => 'hidden d-none']])
    ->hiddenInput(['class' => 'message-id'])
    ->label(false)
?>

<?= $form->field($model, 'message', ['options' => ['class' => 'form-group mb-0']])
    ->textarea([
        'placeholder' => Yii::t('comment', 'Message'),
        'class' => 'form-control edit-message'
    ])
    ->label(false)
?>

<?= Html::submitButton(
    Yii::t('comment', 'Send'),
    ['class' => 'btn text-primary save-comment pull-right float-right c-pointer pt-1'])
?>
<?= Html::a(
    Yii::t('comment', 'Cancel'),
    null,
    ['class' => 'btn text-primary cancel-comment pull-right float-right c-pointer pt-1'])
?>

<?php ActiveForm::end(); ?>

<h1 class="mt-3">
    <?= Yii::t('comment', 'Comments') ?>
    (<?= $commentsCount ?>)
</h1>

<hr>

<?php
if (!$commentsCount) {
    echo Yii::t('comment', 'There are no comments yet.');
} ?>

<div class="media-list">
    <?php
    foreach ($comments as $comment) :
        $username = $comment->getUsername();
        $avatar = $this->context->getAvatar($comment, $defaultAvatar);
        ?>
        <div class="media mb-3 comment-block" data-id="<?= $comment->id ?>">
            <div class="media-left">
                <?= Html::img($avatar, ['class' => 'media-object mr-3'])?>
            </div>
            <div class="media-body">
                <div class="mb-1">
                    <span class="text-primary"><?= $username ?></span>
                    <?php if ($comment->isAuthor()) : ?>
                        <span class="pull-right float-right">
                        <?= Html::a(
                            '&times',
                            null,
                            [
                                'class' => 'btn text-primary delete-comment c-pointer p-0 hidden d-none',
                                'title' => Yii::t('comment', 'Delete'),
                                'data' => [
                                    'id' => $comment->id,
                                    'question' =>
                                        Yii::t('comment', 'Are you sure you want to delete this comment?')
                                ]
                            ]
                        );
                        ?>
                        </span>
                    <?php endif; ?>
                </div>
                <div class="message-block">
                    <span class="message-text"><?= nl2br($comment->message) ?></span>
                </div>
                <div class="media-footer">
                    <span class="text-muted"><?= $comment->getTime() ?></span>
                    <?php
                    if ($comment->isAuthor()) {
                        echo Html::a(
                            Yii::t('comment', 'Edit'),
                            null,
                            ['class' => 'btn text-primary edit-comment c-pointer pt-1']
                        );
                    } ?>
                </div>
            </div>
        </div>
    <?php endforeach ?>
</div>
<?php Pjax::end() ?>

<hr>
