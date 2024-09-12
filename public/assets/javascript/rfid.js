$(document).on('input', '#rfid-number', function() {

    if ($(this).val().length === 10) {
        $('.label-status').hide(100);
        $('.processing').show(100);
        $('#rfid-number').prop('disabled', true);

        $('.processing').html(`
            <div class="col d-flex">
                <div>
                    <!-- Pluse -->
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
                })
            }

            APIrequest().then(response => {

                $('.processing').html(`
                    <div class="col d-flex">
                        <div>
                            <iconify-icon icon="iconamoon:check-circle-1-duotone" width="28" height="28" class="mt-1"></iconify-icon>
                        </div>
                        <div class="text-sm mt-2 ms-2">${response.data.Message}</div>
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

                    $('.processing').removeClass('alert-danger');
                    $('.processing').toggleClass('alert-success');

                    $('.label-status').show(100);
                    $('#rfid-number').prop('disabled', false).val('').focus(); // Autofocus after clearing
                }, 1500);

            });

        }, 500);
    } else {
        return false;
    }

});
