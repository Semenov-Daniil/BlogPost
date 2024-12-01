$(() => {

    const selectResize = function() {
        Array.from($('select').find('option')).forEach(element => {
            if (element.textContent.length >= 35) {
                element.textContent = element.textContent.slice(0, 35) + '...';
            }  
        });
    }

    selectResize();

    $(document).on('pjax:end', () => { selectResize() });
})