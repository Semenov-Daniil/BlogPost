$(() => {

    $('#pjax-comments').on('click', '.btn-answer-comment', function(event) {
        event.preventDefault();

        const link = $(this);
        const collapse = $(`#${$(this).attr('aria-controls')}`);


        if (collapse.hasClass('show')) {
            collapse.collapse('hide');
            $(this).prop('aria-expanded', 'false');
            $(this).html('Написать ответ');
            setTimeout(() => {
                collapse.find('.card-body').html('');
            }, 500);
        } else {
            collapse.find('.card-body').load($(this).attr('href'), function() {
                collapse.collapse('show');
                link.prop('aria-expanded', 'true');
                link.html('Скрыть форму ответа');
            });
        }
    });

    $('#pjax-comments').on('beforeSubmit', `.create-answer-comment-form`, function(event) {
        event.preventDefault();

        const form = $(this);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success(data) {
                if (data.success) {
                    $(`#collapseAnswerForm${form.data('id')}`).collapse('hide');

                    $.pjax.reload('#pjax-comments');
                } else {
                    $(`#pjax-answer-comment-${form.data('id')}`).html(data);
                }
            }
        });

        return false;
    });

})