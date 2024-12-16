$(() => {

    $(document).on('pjax:end', () => { 
        setTimeout(() => {
            $('.alert').fadeOut("slow");
        }, 3000);
    });

    $(document).on('ajaxComplete', () => {
        setTimeout(() => {
            $('.alert').fadeOut("slow");
        }, 3000);
    });

});