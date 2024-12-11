$(() => {

    $('#pjax-admin-users').on('click', '.btn-temp-block', function(event) {
        event.preventDefault();

        $(`#collapseBlockUser${$(this).data('id')} .card-body`).load($(this).attr('href'));
        $(`#collapseBlockUser${$(this).data('id')}`).collapse('show');
    })

})