var SweetAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-sm btn-primary',
        cancelButton: 'btn btn-sm btn-secondary ms-2'
    },
    buttonsStyling: false
});

$(document).on('submit', ".sign-in", function(e){
    e.preventDefault();
    var email = $('#email').val();
    var password = $('#password').val();
    if(email == '' || password == '') {
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Empty Field(s)</h4><small>Do not leave an empty field</small>`,
            confirmButtonColor: "#3a57e8"
        });
        return false;
    }

    $("#authenticating").show();
    $("#error").hide();

    $("#authenticating").html(`
            <div class="col d-flex">
                <!-- Bounce -->
                <div class="sk-bounce sk-primary">
                    <div class="sk-bounce-dot"></div>
                    <div class="sk-bounce-dot"></div>
                </div>
                <div class="text-sm mt-1 ms-4">Authenticating...</div>
            </div>
        `);

    setTimeout(() => {
        const formData = new FormData(this);

        async function APIrequest() {
            return await axios.post('/authenticate', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                }
            });
        }

        APIrequest().then(response => {
            $("#error").hide();
            $("#authenticating").hide();
            location.reload();
        })
        .catch(error => {
            console.error('Error:', error);
            let errorMessage = 'An unknown error occurred';
            if (error.response && error.response.data && error.response.data.Message) {
                errorMessage = error.response.data.Message;

                $("#error").show();
                $("#authenticating").hide();
                $('#error').text(errorMessage);

            } else if (error.response && error.response.statusText) {
                errorMessage = error.response.statusText;
            }
        });
    }, 2000);

});