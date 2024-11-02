$(document).on('input', '#rfid-number', function() {

    if ($(this).val().length === 10) {
        $('.label-status').hide(100);
        $('.processing').show(100);
        $('#rfid-number').prop('disabled', true);

        $('.processing').html(`
            <div class="col d-flex">
                <div>
                    <!-- Pulse -->
                    <div class="sk-pulse sk-primary"></div>
                </div>
                <div class="text-sm mt-1 ms-4">Validating...</div>
            </div>
        `);

        setTimeout(() => {

            const formData = new FormData();
            formData.append('RFID', $(this).val());

            async function APIrequest() {
                return await axios.post('/api/log/attendance', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                });
            }

            APIrequest().then(response => {
                let message = response.data.Message;
                let messageIcon = 'iconamoon:check-circle-1-duotone';
                let alertClass = 'alert-success';

                if (message.includes("scan limit")) {
                    messageIcon = 'icon-park-twotone:error';
                    alertClass = 'alert-warning';
                } else if (message.includes("Logged Out")) {
                    messageIcon = 'iconamoon:check-circle-1-duotone';
                } else if (message.includes("Logged In")) {
                    messageIcon = 'iconamoon:check-circle-1-duotone';
                } else {
                    messageIcon = 'icon-park-twotone:error';
                    alertClass = 'alert-danger';
                }

                $('.processing').removeClass('alert-success alert-danger alert-warning').addClass(alertClass);
                $('.processing').html(`
                    <div class="col d-flex">
                        <div>
                            <iconify-icon icon="${messageIcon}" width="28" height="28" class="mt-1"></iconify-icon>
                        </div>
                        <div class="text-sm mt-2 ms-2">${message}</div>
                    </div>
                `);

                setTimeout(() => {
                    $('.processing').hide(100);
                    $('.label-status').show(100);
                    $('#rfid-number').prop('disabled', false).val('').focus(); // Autofocus after clearing
                }, 1500);

            }).catch(error => {
                $('.processing').removeClass('alert-success');
                $('.processing').toggleClass('alert-danger');
                $('.processing').html(`
                    <div class="col d-flex">
                        <div>
                            <iconify-icon icon="icon-park-twotone:error" width="28" height="28" class="mt-1"></iconify-icon>
                        </div>
                        <div class="text-sm mt-2 ms-2">Unregistered RFID Card Number</div>
                    </div>
                `);

                setTimeout(() => {
                    $('.processing').hide(100);
                    $('.processing').removeClass('alert-danger').addClass('alert-success');
                    $('.label-status').show(100);
                    $('#rfid-number').prop('disabled', false).val('').focus(); // Autofocus after clearing
                }, 1500);
            });

        }, 500);
    } else {
        return false;
    }

});


document.addEventListener('livewire:navigated', () => { 

    const input = document.getElementById('rfid-number');
    input.addEventListener('blur', (event) => {
        event.target.focus();
    });

});