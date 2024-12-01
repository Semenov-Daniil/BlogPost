$(() => {

    $('#pjax-posts').on('input', '#postssearch-title', function(event) {
        let url = new URL(window.location);
        url.searchParams.set('PostsSearch[title]', $(this).val());
        url.searchParams.set('PostsSearch[themes_id]', $('#postssearch-themes_id').find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-posts',
            url: url.href,
            pushState: false,
            timeout: 5000,
        });

        $('#pjax-posts').on('pjax:complete', function(event) {
            let inputField = $('#postssearch-title');
            inputField.focus();
            let val = inputField.val();
            inputField[0].setSelectionRange(val.length, val.length);

            $('#pjax-posts').off(event);
        })
    });

    $('#pjax-posts').on('input', '#postssearch-themes_id', function(event) {
        let url = new URL(window.location);
        url.searchParams.set('PostsSearch[title]', $('#postssearch-title').val());
        url.searchParams.set('PostsSearch[themes_id]', $(this).find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-posts',
            url: url.href,
            pushState: false,
            timeout: 5000,
        });
    });
})