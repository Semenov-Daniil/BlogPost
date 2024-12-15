$(() => {

    $('#pjax-login-form').on('beforeSubmit', '#login-form', function(event) {
        event.preventDefault();

        const form = $(this);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            data: form.serialize(),
            success(data) {
                if (data.isBlock) {
                    $('#modal-block .modal-body').html(data.data);
                    $('#modal-block').modal('show');
                } else {
                    $('#pjax-login-form').html(data);
                }
            }
        });

        return false;
    });

    $('#modal-block').on('hidden.bs.modal', function(event) {
        $.pjax.reload('#pjax-login-form');
        setTimeout(() => {
            $('#modal-block .modal-body').html('');
        }, 1000);
    })

});