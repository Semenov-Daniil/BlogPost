$(() => {

    $('#pjax-posts').on('input', '#postssearch-title', function(event) {
        let url = new URL(window.location);
        url.searchParams.set('PostsSearch[title]', $(this).val());
        url.searchParams.set('PostsSearch[themes_id]', $('#postssearch-themes_id').find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-posts',
            url: url.href,
            push: false,
            replace: false,
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
            push: false,
            replace: false,
            timeout: 5000,
        });
    });

    $('#pjax-user-posts').on('input', '#postssearch-title', function(event) {
        let url = new URL(window.location);
        url.searchParams.set('PostsSearch[title]', $(this).val());
        url.searchParams.set('PostsSearch[themes_id]', $('#postssearch-themes_id').find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-user-posts',
            url: url.href,
            push: false,
            replace: false,
            timeout: 5000,
        });

        $('#pjax-user-posts').on('pjax:complete', function(event) {
            let inputField = $('#postssearch-title');
            inputField.focus();
            let val = inputField.val();
            inputField[0].setSelectionRange(val.length, val.length);

            $('#pjax-user-posts').off(event);
        })
    });

    $('#pjax-user-posts').on('input', '#postssearch-themes_id', function(event) {
        let url = new URL(window.location);
        url.searchParams.set('PostsSearch[title]', $('#postssearch-title').val());
        url.searchParams.set('PostsSearch[themes_id]', $(this).find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-user-posts',
            url: url.href,
            push: false,
            replace: false,
            timeout: 5000,
        });
    });

    $('#pjax-user-posts').on('click', '.btn-reset', function(event) {
        event.preventDefault();

        $.pjax.reload({
            container: '#pjax-user-posts',
            url: $(this).attr('href'),
            push: false,
            timeout: 5000,
        });
    });

    $('#pjax-admin-posts').on('input', '#postssearch-title', function(event) {
        let url = new URL(window.location);
        url.searchParams.set('PostsSearch[title]', $(this).val());
        url.searchParams.set('PostsSearch[themes_id]', $('#postssearch-themes_id').find('option:selected').val());
        url.searchParams.set('PostsSearch[statuses_id]', $('#postssearch-statuses_id').find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-admin-posts',
            url: url.href,
            push: false,
            replace: false,
            timeout: 5000,
        });

        $('#pjax-admin-posts').on('pjax:complete', function(event) {
            let inputField = $('#postssearch-title');
            inputField.focus();
            let val = inputField.val();
            inputField[0].setSelectionRange(val.length, val.length);

            $('#pjax-admin-posts').off(event);
        })
    });

    $('#pjax-admin-posts').on('input', '#postssearch-themes_id', function(event) {
        let url = new URL(window.location);
        url.searchParams.set('PostsSearch[title]', $('#postssearch-title').val());
        url.searchParams.set('PostsSearch[themes_id]', $(this).find('option:selected').val());
        url.searchParams.set('PostsSearch[statuses_id]', $('#postssearch-statuses_id').find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-admin-posts',
            url: url.href,
            push: false,
            replace: false,
            timeout: 5000,
        });
    });

    $('#pjax-admin-posts').on('input', '#postssearch-statuses_id', function(event) {
        let url = new URL(window.location);
        url.searchParams.set('PostsSearch[title]', $('#postssearch-title').val());
        url.searchParams.set('PostsSearch[themes_id]', $('#postssearch-themes_id').find('option:selected').val());
        url.searchParams.set('PostsSearch[statuses_id]', $(this).find('option:selected').val());

        $.pjax.reload({
            container: '#pjax-admin-posts',
            url: url.href,
            push: false,
            replace: false,
            timeout: 5000,
        });
    });

    $('#pjax-admin-posts').on('click', '.btn-reset', function(event) {
        event.preventDefault();

        $.pjax.reload({
            container: '#pjax-admin-posts',
            url: $(this).attr('href'),
            push: false,
            timeout: 5000,
        });
    });
})