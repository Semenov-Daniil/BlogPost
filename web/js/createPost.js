$(() => {

    $('#pjax-create-post').on('change', '#posts-check', function(event) {
        const select = $('#posts-themes_id');
        const theme = $('#posts-theme');

        select.find('option:first').prop('selected', true);

        select.removeClass('is-invalid is-valid');
        theme.removeClass('is-invalid is-valid');

        if ($(this).prop('checked')) {
            select.prop('disabled', true);
            theme.prop('disabled', false);
        } else {
            select.prop('disabled', false);
            theme.prop('disabled', true);
            theme.prop('value', '');
        }
    });

});