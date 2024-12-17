$(() => {

    $('#pjax-user-posts').on('click', '.bnt-moder', function (event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            method: 'POST',
            success (data) {
                $.pjax.reload('#pjax-user-posts');
            }
        })
    });

})