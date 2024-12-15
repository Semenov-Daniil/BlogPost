$(() => {

    $('#pjax-admin-users').on('click', '.btn-unblock', function(event) {
        event.preventDefault();

        const collapse = $(`#collapseBlockUser${$(this).data('id')}`);

        if (collapse.hasClass('show')) {
            collapse.collapse('hide');
            setTimeout(() => {
                collapse.find('.card-body').html('');
            }, 500);
        } else {
            collapse.find('.card-body').load($(this).attr('href'), function() {
                collapse.collapse('show');
            });
        }
    });

    $('#pjax-admin-users').on('beforeSubmit', `.unblock-user-form`, function(event) {
        event.preventDefault();

        const form = $(this);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success(data) {
                if (data.success) {
                    $(`#collapseBlockUser${form.data('id')}`).collapse('hide');
                    setTimeout(() => {
                        $(`#collapseBlockUser${form.data('id')}`).find('.card-body').html('');
                    }, 500);

                    $.pjax.reload('#pjax-admin-users');
                } else {
                    $(`#pjax-unblock-${form.data('id')}`).html(data);
                }
            }
        });

        return false;
    });

    $('#pjax-admin-users').on('click', '.btn-hide-collapse', function(event) {
        event.preventDefault();

        const collapse = $(`#collapseBlockUser${$(this).data('id')}`);

        collapse.collapse('hide');

        setTimeout(() => {
            collapse.find('.card-body').html('');
        }, 500);
    });



})