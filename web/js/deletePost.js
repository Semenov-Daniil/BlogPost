$(() => {

    let pjax = '';

    $('#pjax-user-posts .post').on('click', '.btn-delete', function(event) {
        event.preventDefault();

        $('#modal-delete .modal-body .modal-body-text').html(`Вы точно хотите удалить пост: ${$(this).data('title')}?`);
        $('#modal-delete .modal-body .modal-action .btn-delete').prop('href', $(this).attr('href'));
        $('#modal-delete').modal('show');

        pjax = '#pjax-user-posts';
    });

    $('#pjax-admin-posts .post').on('click', '.btn-delete', function(event) {
        event.preventDefault();

        $('#modal-delete .modal-body .modal-body-text').html(`Вы точно хотите удалить пост: ${$(this).data('title')}?`);
        $('#modal-delete .modal-body .modal-action .btn-delete').prop('href', $(this).attr('href'));
        $('#modal-delete').modal('show');

        pjax = '#pjax-admin-posts';
    });


    $('#modal-delete').on('click', '.btn-delete', function(event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            method: 'POST',
            success(data) {
                $('#modal-delete').modal('hide');
                $.pjax.reload(pjax);
            }
        })
    });

})