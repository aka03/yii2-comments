<?php
use aka03\comments\CommentWidget;
?>

<div class="testPage-default-index">
    <h1>Test Page</h1>
    <p>
        This is the view content for action "<?= $this->context->action->id ?>".
        The action belongs to the controller "<?= get_class($this->context) ?>"
        in the "<?= $this->context->module->id ?>" module.
    </p>
    <p>
        You may customize this page by editing the following file:<br>
        <code><?= __FILE__ ?></code>
    </p>

    <?= CommentWidget::widget([
        'page' => $this->context->module->id,
        'page_id' => null,
        'guestCanLeaveComment' => true,
        'showCommentsForGuests' => true,
    ]) ?>
</div>
