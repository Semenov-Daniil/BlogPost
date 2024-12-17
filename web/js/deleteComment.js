$(() => {

    $('#pjax-comments').on('click', '.btn-delete-comment', function(event) {
        event.preventDefault();

        $('#modal-delete-comment .modal-body .modal-action .btn-delete-comment').prop('href', $(this).attr('href'));
        $('#modal-delete-comment .modal-body .modal-cnt').load($(this).attr('href'), function () {
            $('#modal-delete-comment').modal('show');
        });
    });

    $('#modal-delete-comment').on('click', '.btn-delete-comment', function(event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            method: 'POST',
            success(data) {
                $('#modal-delete-comment').modal('hide');
                $.pjax.reload('#pjax-comments');
            }
        })
    });

})