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
    
});