$(document).on('input', '#rfid-number', function () {
    const rfidNumber = $(this).val();

    if (rfidNumber.length === 10) {
        // Show processing UI and hide label
        $('.label-status').hide(100);
        $('.processing').show(100);
        $('#rfid-number').prop('disabled', true);

        // Set the processing UI with a spinner and "Validating..." text
        $('.processing').html(`
            <div class="col d-flex">
                <div>
                    <div class="sk-pulse sk-primary"></div>
                </div>
                <div class="text-sm mt-1 ms-4">Validating...</div>
            </div>
        `);

        // Set a timeout to simulate delay and perform API request
        setTimeout(() => {
            const formData = new FormData();
            formData.append('RFID', rfidNumber);

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
                const { Message, Log } = response.data;

                const formattedDate = new Date(Log.date).toLocaleDateString('en-US', {
                    weekday: 'long',   // Full day name (e.g., 'Monday')
                    year: 'numeric',   // Full year (e.g., '2024')
                    month: 'long',     // Full month name (e.g., 'November')
                    day: 'numeric'     // Day of the month (e.g., '25')
                });
                
                // Helper function to format time
                function formatTime(timeString) {
                    if (!timeString) return 'N/A';
                    const time = new Date(`1970-01-01T${timeString}`);
                    return time.toLocaleTimeString('en-US', {
                        hour: 'numeric',   // Hour in 12-hour format
                        minute: '2-digit', // Minutes with leading zero
                        hour12: true       // Use 12-hour format with AM/PM
                    });
                }
                
                // Update log display with relevant data
                let logDetails = `
                    <div class="text-secondary">
                        <strong>Name: ${Log.student.firstname} ${Log.student.lastname}</strong><br><br>
                        <span>Date:</span> <strong>${formattedDate || 'N/A'}</strong><br>
                        <span>Morning In:</span> <strong>${formatTime(Log.timeInMorning)}</strong><br>
                        <span>Morning Out:</span> <strong>${formatTime(Log.timeOutMorning)}</strong><br>
                        <span>Afternoon In:</span> <strong>${formatTime(Log.timeInAfternoon)}</strong><br>
                        <span>Afternoon Out:</span> <strong>${formatTime(Log.timeOutAfternoon)}</strong>
                    </div>
                `;
                

                // Check for specific statuses based on the API response message
                let icon = 'iconamoon:check-circle-1-duotone';
                let alertClass = 'alert-success';
                let messageText = Message;

                // Check if the message contains the phrase for "already logged in"
                if (Message.includes('already logged in')) {
                    alertClass = 'alert-warning'; // Change alert type to warning if already logged in
                    icon = 'icon-park-twotone:error';
                } else if (Message.includes('not found')) {
                    alertClass = 'alert-danger'; // Error if student not found
                    icon = 'icon-park-twotone:error';
                } else if (Message.includes('Morning log has already been completed for today.')) {
                    // Special handling for "Morning log already completed"
                    alertClass = 'alert-success'; // Same warning style for already completed
                    icon = 'icon-park-twotone:error';
                }
                else if (Message.includes('Afternoon log has already been completed for today.')) {
                    // Special handling for "Morning log already completed"
                    alertClass = 'alert-success'; // Same warning style for already completed
                    icon = 'icon-park-twotone:error';
                }

                // Update processing UI with appropriate message and log details
                $('.processing').removeClass('alert-danger alert-warning alert-success').addClass(alertClass);
                $('.processing').html(`
                    <div class="col d-flex">
                        <div>
                            <iconify-icon icon="${icon}" width="28" height="28" class="mt-1"></iconify-icon>
                        </div>
                        <div class="text-sm mt-2 ms-2">${messageText}</div>
                    </div>
                    <hr>
                    ${logDetails}
                `);

                // Hide processing UI and reset form after a delay
                setTimeout(() => {
                    $('.processing').hide(100);
                    $('.label-status').show(100);
                    $('#rfid-number').prop('disabled', false).val('').focus();
                }, 5000); // Change this to your preferred timeout duration
            }).catch(error => {
                // Show error message if the RFID is not registered
                $('.processing').removeClass('alert-success').addClass('alert-danger');
                $('.processing').html(`
                    <div class="col d-flex">
                        <div>
                            <iconify-icon icon="icon-park-twotone:error" width="28" height="28" class="mt-1"></iconify-icon>
                        </div>
                        <div class="text-sm mt-2 ms-2">Unregistered RFID Card Number</div>
                    </div>
                `);

                // Reset form after a short delay
                setTimeout(() => {
                    $('.processing').hide(100);
                    $('.label-status').show(100);
                    $('#rfid-number').prop('disabled', false).val('').focus();
                }, 1500);
            });
        }, 500); // Delay for a more smooth transition
    }
});



// Ensure input stays focused when navigating away using Livewire
document.addEventListener('livewire:navigated', () => {
    const input = document.getElementById('rfid-number');
    input.addEventListener('blur', (event) => {
        event.target.focus();
    });
});
