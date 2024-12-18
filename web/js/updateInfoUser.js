$(() => {

    $('#pjax-user').on('click', '.btn-update-info', function (event) {
        event.preventDefault();

        $('#modal-update-info .modal-body').load($(this).attr('href'), function() {
            $('#modal-update-info').modal('show');
        });
    });
    

    $('#pjax-user').on('beforeSubmit', '#update-info-form', function (event) {
        event.preventDefault();
        const form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success (data) {
                if (data.success) {
                    $('#pjax-user #modal-update-info').modal('hide');
                    $.pjax.reload('#pjax-user');
                    $('header nav .user-item .user-login')[0].textContent = data.login;
                } else {
                    $('#pjax-update-info').html(data);
                }
            },
        });
    
        return false;
    });
})