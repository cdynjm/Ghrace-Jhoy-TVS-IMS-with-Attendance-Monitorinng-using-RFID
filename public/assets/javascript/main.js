document.addEventListener('livewire:navigated', () => { 
    $(document).on('click', '#show-bar', function() {
        const $icon = $(this).find('i');
        if ($icon.hasClass('fa-toggle-on')) {
            $icon.removeClass('fa-toggle-on').addClass('fa-toggle-off');
        } else {
            $icon.removeClass('fa-toggle-off').addClass('fa-toggle-on');
        }
    });
});

