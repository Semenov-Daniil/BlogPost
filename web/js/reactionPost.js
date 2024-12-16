$(() => {

    $('#pjax-reactions').on('click', '.btn-reaction', function(event) {
        event.preventDefault();

        $.ajax({
            url: $(this).attr('href'),
            method: 'POST',
            success(data) {
                $('#pjax-reactions').html(data);
            }
        })
    });

})