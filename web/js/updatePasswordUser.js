$(() => {

    $('#pjax-user').on('click', '.btn-change-password', function (event) {
        event.preventDefault();

        $('#modal-change-password .modal-body').load($(this).attr('href'), function() {
            $('#modal-change-password').modal('show');
        });
    });
    

    $('#pjax-user').on('beforeSubmit', '#change-password-form', function (event) {
        event.preventDefault();
        const form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success (data) {
                if (data.success) {
                    $('#pjax-user #modal-change-password').modal('hide');
                    $.pjax.reload('#pjax-user');
                } else {
                    $('#pjax-change-password').html(data);
                }
            },
        });
    
        return false;
    });

    $('#pjax-user').on('pjax:end', function(event) {
        $.pjax.reload({
            container: '#pjax-alert',
            url: '/site/alert',
            push: false,
            replace: false,
        });
    });

})