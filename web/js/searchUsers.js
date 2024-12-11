$(() => {

    $('#pjax-admin-users').on('input', '#userssearch-id', function(event) {
        let url = new URL(window.location);
        url.searchParams.set('UsersSearch[id]', $(this).val());
        url.searchParams.set('UsersSearch[login]', $('#userssearch-login').val());

        $.pjax.reload({
            container: '#pjax-admin-users',
            url: url.href,
            push: false,
            replace: false,
            timeout: 5000,
        });

        $('#pjax-admin-users').on('pjax:complete', function(event) {
            let inputField = $('#userssearch-id');
            inputField.focus();
            let val = inputField.val();
            inputField[0].setSelectionRange(val.length, val.length);

            $('#pjax-admin-users').off(event);
        })
    });

    $('#pjax-admin-users').on('input', '#userssearch-login', function(event) {
        let url = new URL(window.location);
        url.searchParams.set('UsersSearch[id]', $('#userssearch-id').val());
        url.searchParams.set('UsersSearch[login]', $(this).val());

        $.pjax.reload({
            container: '#pjax-admin-users',
            url: url.href,
            push: false,
            replace: false,
            timeout: 5000,
        });

        $('#pjax-admin-users').on('pjax:complete', function(event) {
            let inputField = $('#userssearch-login');
            inputField.focus();
            let val = inputField.val();
            inputField[0].setSelectionRange(val.length, val.length);

            $('#pjax-admin-users').off(event);
        })
    });

    $('#pjax-admin-users').on('click', '.btn-reset', function(event) {
        event.preventDefault();

        $.pjax.reload({
            container: '#pjax-admin-users',
            url: $(this).attr('href'),
            push: false,
            timeout: 5000,
        });
    });
})