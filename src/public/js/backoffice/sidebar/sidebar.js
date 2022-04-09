export default document.addEventListener('DOMContentLoaded', () => {

    $(document).on('click', '#sidebarnav li a:not(.open-items-link)', (e) => {

        let link = $(e.currentTarget);
        $('.open-items').removeClass('visible')

        $(link).toggleClass('active')
        $('#sidebarnav li a').not(link).removeClass('active')

        if ($(link).hasClass('active')) {
            $(link).next().toggleClass('visible');
        }

    })
});