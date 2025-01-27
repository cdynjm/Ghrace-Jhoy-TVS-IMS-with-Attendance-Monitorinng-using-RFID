$(document).on('change', "#select-region", function(e){
    $('#select-province')
        .find('option')
        .remove()
        .end()
        .append('<option value="0">Retrieving, please wait...</option>');

    const data = { code: $(this).val() };
    async function APIrequest() {
        return await axios.post('/api/get-province', data, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
    }
    APIrequest().then(response => {
        $("#select-province").html(response.data.Province);
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('change', "#select-province", function(e){
    $('#select-municipal')
        .find('option')
        .remove()
        .end()
        .append('<option value="0">Retrieving, please wait...</option>');

    const data = { code: $(this).val() };
    async function APIrequest() {
        return await axios.post('/api/get-municipal', data, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
    }
    APIrequest().then(response => {
        $("#select-municipal").html(response.data.Municipal);
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('change', "#select-municipal", function(e){
    $('#select-barangay')
        .find('option')
        .remove()
        .end()
        .append('<option value="0">Retrieving, please wait...</option>');

    const data = { code: $(this).val() };
    async function APIrequest() {
        return await axios.post('/api/get-barangay', data, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
    }
    APIrequest().then(response => {
        $("#select-barangay").html(response.data.Barangay);
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('click', 'input[name=employmentStatus]', function() {
    var status = $(this).val();
    if(status == '1' || status == '2')
        $('#show-employment-type').show(100);
    else
        $('#show-employment-type').hide(100);
});

$(document).on('change', '#birthdate', function() {
    var birthdate = new Date($(this).val());
    var today = new Date();
    var age = today.getFullYear() - birthdate.getFullYear();
    var monthDifference = today.getMonth() - birthdate.getMonth();
    if (monthDifference < 0 || (monthDifference === 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }
    if (age < 0) {
        age = 0;
    }
    $('#age').val(age);
});

$(document).on('change', "#select-birthplace-region", function(e){
    $('#select-birthplace-province')
        .find('option')
        .remove()
        .end()
        .append('<option value="0">Retrieving, please wait...</option>');

    const data = { code: $(this).val() };
    async function APIrequest() {
        return await axios.post('/api/get-birthplace-province', data, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
    }
    APIrequest().then(response => {
        $("#select-birthplace-province").html(response.data.Province);
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('change', "#select-birthplace-province", function(e){
    $('#select-birthplace-municipal')
        .find('option')
        .remove()
        .end()
        .append('<option value="0">Retrieving, please wait...</option>');

    const data = { code: $(this).val() };
    async function APIrequest() {
        return await axios.post('/api/get-birthplace-municipal', data, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            }
        })
    }
    APIrequest().then(response => {
        $("#select-birthplace-municipal").html(response.data.Municipal);
    })
    .catch(error => {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('submit', "#admission-application", function(e){
    e.preventDefault();

    // Get password values
    const password = $('#password').val();
    const retypePassword = $('#retype-password').val();

    // Check if passwords match
    if (password !== retypePassword) {
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Passwords Do Not Match</h4><small>Please ensure both passwords are the same.</small>`,
            confirmButtonColor: "#3a57e8"
        });
        return; // Stop form submission
    }

    SweetAlert.fire({
        icon: 'question',
        html: 
        `
            <h4 class="mb-0">Confirmation</h4>
            <small>Submit your admission application?</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Submit it!',
    })
    .then((result) => {
        if (result.value) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: true,
                showConfirmButton: false
            });
            const formData = new FormData(this);
            async function APIrequest() {
                return await axios.post('/api/admission-application', formData, {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    }
                })
            }
            APIrequest().then(response => {
                SweetAlert.fire({
                    icon: 'success',
                    html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                    confirmButtonColor: "#3a57e8"
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = response.data.Redirect;
                    }
                });                
            })
            .catch(error => {
                console.error('Error:', error);
                SweetAlert.fire({
                    icon: 'error',
                    html: `<h4 class="mb-0">Opss..</h4><small>${error.response.data.Message}</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
});