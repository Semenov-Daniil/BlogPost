$(() => {

    const showCollapse = function (link, collapse) {
        collapse.find('.card-body').load(link.attr('href'), function() {
            if (link.hasClass('btn-temp-block')) {
                collapse.addClass('collapse-temp-block');
                collapse.find('.btn-blocked').html('Заблокировать на время');
            } else {
                collapse.addClass('collapse-perm-block');
                collapse.find('.btn-blocked').html('Заблокировать навсегда');
            }
            collapse.collapse('show');
        });
    }

    const hideCollapse = function (link, collapse) {
        collapse.collapse('hide');
        setTimeout(() => {
            collapse.find('.card-body').html('');
        }, 500);
    }

    $('#pjax-admin-users').on('click', '.btn-temp-block, .btn-perm-block', function(event) {
        event.preventDefault();

        const collapse = $(`#collapseBlockUser${$(this).data('id')}`);
        const link = $(this);

        if (collapse.hasClass('show')) {
            hideCollapse(link, collapse);

            if (link.hasClass('btn-temp-block') && collapse.hasClass('collapse-perm-block')) {
                collapse.removeClass('collapse-perm-block');
                setTimeout(() => {
                    showCollapse(link, collapse);
                }, 500);
            }
            
            if (link.hasClass('btn-perm-block') && collapse.hasClass('collapse-temp-block')) {
                collapse.removeClass('collapse-temp-block');
                setTimeout(() => {
                    showCollapse(link, collapse);
                }, 500);
            }
        } else {
            showCollapse(link, collapse);
        }
    });

    $('#pjax-admin-users').on('beforeSubmit', `.block-user-form`, function(event) {
        event.preventDefault();

        const form = $(this);
        const collapse = $(`#collapseBlockUser${form.data('id')}`);

        if (collapse.hasClass('collapse-perm-block')) {
            $('#modal-blocked .btn-bloked').attr('href', `/panel-admin/user/permanens-block?id=${form.data('id')}`);
            $('#modal-blocked').modal('show');

            $('#modal-blocked').on('click', '.btn-bloked', function(event) {
                event.preventDefault();
                $.ajax({
                    url: form.attr('action'),
                    method: form.attr('method'),
                    data: form.serialize(),
                    success(data) {
                        if (data.success) {
                            $('#modal-blocked').modal('hide');
                            
                            $(`#collapseBlockUser${form.data('id')}`).collapse('hide');
                            setTimeout(() => {
                                $(`#collapseBlockUser${form.data('id')}`).find('.card-body').html('');
                            }, 500);
        
                            $.pjax.reload('#pjax-admin-users');
                        } else {
                            collapse.find('.card-body').html(data);
                        }
                    }
                });
            });
        } else {
            $.ajax({
                url: form.attr('action'),
                method: form.attr('method'),
                data: form.serialize(),
                success(data) {
                    if (data.success) {
                        $(`#collapseBlockUser${form.data('id')}`).collapse('hide');
                        setTimeout(() => {
                            $(`#collapseBlockUser${form.data('id')}`).find('.card-body').html('');
                        }, 500);
    
                        $.pjax.reload('#pjax-admin-users');
                    } else {
                        collapse.find('.card-body').html(data);
                        collapse.find('.btn-blocked').html('Заблокировать на время');
                    }
                }
            });
        }


        return false;
    });

    $('#pjax-admin-users').on('click', '.btn-hide-collapse', function(event) {
        event.preventDefault();

        const collapse = $(`#collapseBlockUser${$(this).data('id')}`);

        collapse.collapse('hide');

        setTimeout(() => {
            collapse.find('.card-body').html('');
        }, 500);
    });
})