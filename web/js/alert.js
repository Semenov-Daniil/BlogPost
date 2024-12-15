$(() => {

    $(document).on('pjax:end', () => { 
        selectResize();
        console.log('test');
        $('.alert').animate({opacity: 1.0}, 3000).fadeOut("slow");
    });

    $(document).on('ajaxComplete', () => {
        setTimeout(() => {
            $('.alert').fadeOut("slow");
        }, 3000);
    });

});