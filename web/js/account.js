$(() => {
    $('#pjax-user, #pjax-user-posts').on('pjax:end', function(event) {
        $.pjax.reload({
            url: '/site/alert',
            container: '#pjax-alert',
            push: false,
            replace: false,
        });
    })
})