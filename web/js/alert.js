$(() => {

    const hideAlert = function() {
        Array.from( $(".alert[role='alert']")).forEach(element => {
            setTimeout(() => {
                $(element).fadeOut("slow");
            }, 5000); 
        });
    }

    $(document).on('pjax:end', () => { 
        hideAlert();
    });

    $(document).on('ajaxComplete', () => {
        hideAlert();
    });

    hideAlert();
});