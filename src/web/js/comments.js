$(document).ready(function() {
    setInterval(function () {
        var activeComment = document.getElementsByClassName('edit-comment-active');
        if (activeComment.length < 1 && window.getSelection().toString().length < 1) {
            $.pjax.reload({container: '#comments-pjax'});
        }
    }, 10000);

    $('#comments-form-pjax').on('pjax:end', function () {
        $.pjax.reload({container: '#comments-pjax'});
    });

    $('body').on('click', '.edit-comment', function() {
        var activeForm = $('body').find('.edit-comment-active');
        if (activeForm) {
            clearForm(activeForm);
        }
        $(this).addClass('edit-comment-active');
        $(this).closest('.media-body').find('.delete-comment').addClass('hidden d-none');

        var msgBlock = $(this).closest('.media-body').find('.message-block');
        var msgId = $(this).closest('.comment-block').data('id');
        var msg = $.trim(msgBlock.find('.message-text').text());

        var emptyForm = $('#empty-comment-form').clone();
        emptyForm.removeAttr('id').removeClass();

        msgBlock.append(emptyForm);
        emptyForm.find('.edit-message').text(msg).data('id', msgId);

        msgBlock.find('.message-text').hide();
        msgBlock.append(emptyForm);

        resizeTextarea(emptyForm.find('.edit-message')[0]);
        emptyForm.find('.message-id').val(msgId);
        $(this).hide();
    });

    $('body').on('click', '.cancel-comment', function() {
        clearForm($(this));
        if (document.getElementsByClassName('edit-comment-active').length < 1) {
            $(this).find('.delete-comment').removeClass('hidden d-none');
        }
    });

    $('body').on('input', '.edit-message', function() {
        resizeTextarea(this);
    });

    $('body').on('click', '.delete-comment', function() {
        var question = $(this).data('question');
        if (confirm(question)) {
            $.post('', { action: 'delete', id: $(this).data('id') })
                .done(function() {
                    $.pjax.reload({container: '#comments-pjax'});
                });
        }
    });

    $('body').on('mouseenter', '.comment-block', function() {
        if (document.getElementsByClassName('edit-comment-active').length < 1) {
            $(this).find('.delete-comment').removeClass('hidden d-none');
        }
    });

    $('body').on('mouseleave', '.comment-block', function() {
        $(this).find('.delete-comment').addClass('hidden d-none');
    });

    function clearForm(comment) {
        var mediaFooter = comment.parents().find('.media-footer');
        var mediaBody = comment.parents().find('.media-body');

        mediaFooter.find('.edit-comment-active').removeClass('edit-comment-active');
        mediaFooter.find('.edit-comment').show();

        var activeMsg = mediaBody.find('.message-block');
        activeMsg.find('form').remove();
        activeMsg.find('.message-text').show();
    }

    function resizeTextarea(message) {
        message.style.height = 'auto';
        message.style.height = (message.scrollHeight) + 'px';
    }
});
