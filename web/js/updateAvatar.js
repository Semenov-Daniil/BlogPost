$(() => {
    
    $('#pjax-user').on('click', '.btn-update-avatar', function (event) {
        event.preventDefault();

        $('#modal-update-avatar .modal-body').load($(this).attr('href'), function() {
            $('#modal-update-avatar').modal('show');
        })

    });

    $('#pjax-user').on('change', '#updateuserform-uploadfile', function(event) {
        const file = this.files[0];
        let image = $('#userAvatar');

        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                if (Object.keys(image).length === 0) {
                    image = $('<img id="userAvatar" class="avatar-cicle-xl object-fit-cover mx-auto" src="" alt="Аватарка">');
                    $('#updateuserform-uploadfile .avatar-wrapp').appendChild(image);
                }

                image.attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
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
                    $.pjax.reload('#pjax-user');
                    $('header nav .user-item .avatar-cicle').prop('src', `/${data.img}`);
                } else {
                    $('#pjax-update-avatar').html(data);
                }
            },
        });
    
        return false;
    });
});