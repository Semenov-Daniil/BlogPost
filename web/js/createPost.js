$(() => {

    $('#pjax-create-post').on('change', '#posts-check', function(event) {
        const themes = $('#posts-themes_id');
        const otherTheme = $('#posts-other_theme');

        themes.find('option:first').prop('selected', true);

        themes.removeClass('is-invalid is-valid');
        otherTheme.removeClass('is-invalid is-valid');

        if ($(this).prop('checked')) {
            themes.prop('disabled', true);
            otherTheme.prop('disabled', false);
        } else {
            themes.prop('disabled', false);
            otherTheme.prop('disabled', true);
            otherTheme.prop('value', '');
        }
    });

    $('#pjax-create-post').on('change', '#posts-uploadfile', function(event) {
        const file = this.files[0];
        let image = $('#imagePost');

        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                if (Object.keys(image).length === 0) {
                    image = $('<img id="imagePost" class="post-img rounded mb-3 card-img-top object-fit-cover" src="" alt="Изображение поста">');
                    $('#create-post-form .form-group').before(image);
                }

                image.attr("src", event.target.result);
            };
            reader.readAsDataURL(file);
        }
    });
});