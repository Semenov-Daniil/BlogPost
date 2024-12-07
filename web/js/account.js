$(() => {
    
    $('#pjax-user').on('click', '.btn-update-avatar', function (event) {
        event.preventDefault();

        $.pjax({
            url: $(this).attr('href'),
            container: '#modal-update-avatar .modal-body',
            push: false,
            replace: false,
        });

        $('#modal-update-avatar').modal('show');
    });
    

    $('#pjax-user').on('beforeSubmit', '#update-avatar-form', function (event) {
        event.preventDefault();
        const form = $(this);

        let formData = new FormData();
		formData.append('UpdateUserForm[uploadFile]', $("#updateuserform-uploadfile")[0].files[0]);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            cache: false,
			contentType: false,
			processData: false,
			data: formData,
            success (data) {
                if (data.success) {
                    $('#pjax-user #modal-update-avatar').modal('hide');
    
                    $.pjax.reload({
                        container: '#pjax-user',
                        url: '/account/post/user',
                        push: false,
                        replace: false,
                    });

                    $('header nav .user-item .avatar-cicle').prop('src', data.img);
                } else {
                    $('#pjax-update-avatar').html(data);
                }
            },
        });
    
        return false;
    });

    $('#pjax-user').on('click', '.btn-update-info', function (event) {
        event.preventDefault();

        $.pjax({
            url: $(this).attr('href'),
            container: '#modal-update-info .modal-body',
            push: false,
            replace: false,
        });

        $('#modal-update-info').modal('show');
    });
    

    $('#pjax-user').on('beforeSubmit', '#update-info-form', function (event) {
        event.preventDefault();
        const form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success (data) {
                if (data.success) {
                    $('#pjax-user #modal-update-info').modal('hide');
    
                    $.pjax.reload({
                        container: '#pjax-user',
                        url: '/account/post/user',
                        push: false,
                        replace: false,
                    });

                    $('header nav .user-item .user-login')[0].textContent = data.login;
                } else {
                    $('#pjax-update-info').html(data);
                }
            },
        });
    
        return false;
    });

    $('#pjax-user').on('click', '.btn-change-password', function (event) {
        event.preventDefault();

        $.pjax({
            url: $(this).attr('href'),
            container: '#modal-change-password .modal-body',
            push: false,
            replace: false,
        });

        $('#modal-change-password').modal('show');
    });
    

    $('#pjax-user').on('beforeSubmit', '#change-password-form', function (event) {
        event.preventDefault();
        const form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            success (data) {
                if (data.success) {
                    $('#pjax-user #modal-change-password').modal('hide');
    
                    $.pjax.reload({
                        container: '#pjax-user',
                        url: '/account/post/user',
                        push: false,
                        replace: false,
                    });

                } else {
                    $('#pjax-change-password').html(data);
                }
            },
        });
    
        return false;
    });


    
});