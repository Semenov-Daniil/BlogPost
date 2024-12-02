$(() => {

    $('#pjax-user').on('pjax:complete', function () {
        $('#modal-update-avatar').modal('hide');    
        $('.modal-backdrop').remove();
        $('body').removeClass('modal-open');
        $('body').css({
            'overflow': '',
            'padding-right': ''
        });
    });

    $('#pjax-user').on('pjax:success', function () {
        $('header nav .avatar-user-item .avatar-cicle').prop('src', $('#pjax-user .user-avatar .avatar').attr('src'));
    });
    
});