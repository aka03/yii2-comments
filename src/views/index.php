<?php
use aka03\comments\assets\CommentAsset;
CommentAsset::register($this);
?>

<hr>

<?php if (!Yii::$app->user->isGuest || (Yii::$app->user->isGuest && $this->context->showCommentsForGuests)) :
    echo $this->render('_comments', [
        'model' => $model,
        'comments' => $comments,
        'commentsCount' => $commentsCount,
        'defaultAvatar' => $defaultAvatar
    ]);
endif; ?>

<?php
if (Yii::$app->user->isGuest && !$this->context->showCommentsForGuests) {
    echo Yii::t('comment', 'Only registered users can see and leave comments.');
} elseif (Yii::$app->user->isGuest && !$this->context->guestCanLeaveComment) {
    echo Yii::t('comment', 'Only registered users can leave comments.');
} else {
    echo $this->render('_form', [
        'model' => $model,
        'defaultAvatar' => $defaultAvatar,
        'userAvatar' => $userAvatar
    ]);
}
