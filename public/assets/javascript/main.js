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

$(document).on('click', '#edit-user-profile', function() {

    var name = $(this).data('name');
    var email = $(this).data('email');

    $('input[name=profileName]').val(name);
    $('input[name=profileEmail]').val(email);

    $('#edit-user-profile-modal').modal('show');
})

$(document).on('submit', "#update-user-profile", function(e){
    e.preventDefault();
    $('.processing').show(100);
    $('.processing').html(`
        <div class="col d-flex">
            <div>
                <!-- Pluse -->
                <div class="sk-pulse sk-primary"></div>
            </div>
            <div class="text-sm mt-1 ms-4">Processing...</div>
        </div>
    `);
    
    setTimeout(() => {
        const formData = new FormData(this);
        async function APIrequest() {
            return await axios.post('/api/update-profile', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $('#edit-user-profile-modal').modal('hide');
            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            });
        })
        .catch(error => {
            $('.processing').hide(100);
            $('#edit-user-profile-modal').modal('hide');
            console.error('Error:', error);
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>${error.response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});