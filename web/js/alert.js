$(() => {

    $(document).on('pjax:end', () => { 
        setTimeout(() => {
            $(".alert[role='alert']").fadeOut("slow");
        }, 3000);
    });

    $(document).on('ajaxComplete', () => {
        setTimeout(() => {
            $(".alert[role='alert']").fadeOut("slow");
        }, 3000);
    });

    setTimeout(() => {
        $(".alert[role='alert']").fadeOut("slow");
    }, 3000);

});