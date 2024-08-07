$.ajaxSetup({
    headers: {  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
    headers: {  "Authorization": "Bearer " + $('meta[name="token"]').attr('content') }
});


var SweetAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-primary btn-sm',
        cancelButton: 'btn btn-secondary btn-sm ms-2'
    },
    buttonsStyling: false
});

$(document).on('click', '#download-forms', function() {
    var id = $(this).data('registration-id');
    var name = $(this).data('name');

    var psa = $(this).data('psa');
    var form137 = $(this).data('form137');

    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        html: `
        <h4>Download Forms</h4>
            <div>
                <a href="javascript:;" id="downloadApplicantPDF" data-id="${id}" data-name="${name}">
                    <i class="fas fa-file-pdf"></i> <small>Registration Form</small>
                </a>
            </div>
            <hr>
            <div>
                <a href="/storage/documents/PSA/${psa}" target="_blank">
                    <i class="fas fa-file-pdf"></i> <small>PSA/NSO/Birth Certificate</small>
                </a>
            </div>
            <hr>
            <div>
                <a href="/storage/documents/Form137/${form137}" target="_blank">
                    <i class="fas fa-file-pdf"></i> <small>Form137/Certification</small>
                </a>
            </div>
            <hr>
        `,
        allowOutsideClick: false,
        showConfirmButton: true,
        confirmButtonText: 'Close'
    });
});

$(document).on('click', '#downloadApplicantPDF', function() {
    var id = $(this).data('id');
    var name = $(this).data('name');
    const formData = new FormData();
    formData.append('id', id);

    axios.post('/registrar/registration-form', formData, {
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        }
    }).then(function(response) {
            var data = response.data;
            var tempDiv = $('<div></div>').html(data);
            $('#content').append(tempDiv);

            var style = $(`
                <style>
                    #content, h1, h2, h3, h4, h5, h6 {
                        color: black !important;
                    }
                </style>
            `);
            tempDiv.append(style);

            html2pdf().from(tempDiv[0]).set({
                margin: 0.5,
                filename: name + '-reg-form.pdf',
                html2canvas: { scale: 2 },
                jsPDF: { orientation: 'portrait', unit: 'in', format: 'legal' }
            }).save().then(function () {
                tempDiv.remove();
            });

            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>Wait for the file to be downloaded.</small>`,
                confirmButtonColor: "#3a57e8"
            });
        })
        .catch(function(error) {
            console.error('Error fetching the content:', error);
        });

    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        html: `<h4>Downloading...</h4>`,
        allowOutsideClick: false,
        showConfirmButton: false
    });
});

$(document).on('change', '#masterCheckbox', function() {
    $('.childCheckbox').prop('checked', $(this).prop('checked'));
});

$(document).on('change', '.childCheckbox', function() {
    var allChecked = true;
    $('.childCheckbox').each(function() {
        if (!$(this).prop('checked')) {
            allChecked = false;
        }
    });
    $('#masterCheckbox').prop('checked', allChecked);
});

$(document).on('change', '#masterCheckbox-exam', function() {
    var index = $(this).data('index');
    $('.childCheckbox-exam-' + index).prop('checked', $(this).prop('checked'));
});

$(document).on('change', '#childCheckbox-exam', function() {
    var allChecked = true;
    var parent = $(this).data('parent-index');

    $('.childCheckbox-exam-' + parent).each(function() {
        if (!$(this).prop('checked')) {
            allChecked = false;
        }
    });
    $('.masterCheckbox-exam-' + parent).prop('checked', allChecked);
});

$(document).on('change', '#masterCheckbox-interview', function() {
    var index = $(this).data('index');
    $('.childCheckbox-interview-' + index).prop('checked', $(this).prop('checked'));
});

$(document).on('change', '#childCheckbox-interview', function() {
    var allChecked = true;
    var parent = $(this).data('parent-index');

    $('.childCheckbox-interview-' + parent).each(function() {
        if (!$(this).prop('checked')) {
            allChecked = false;
        }
    });
    $('.masterCheckbox-interview-' + parent).prop('checked', allChecked);
});

$(document).on('change', '#masterCheckbox-final', function() {
    $('.childCheckbox-final').prop('checked', $(this).prop('checked'));
});

$(document).on('change', '.childCheckbox-final', function() {
    var allChecked = true;
    $('.childCheckbox-final').each(function() {
        if (!$(this).prop('checked')) {
            allChecked = false;
        }
    });
    $('#masterCheckbox-final').prop('checked', allChecked);
});

$(document).on('click', '#set-schedule', function() {

    var hasApplicants = false;
    $('.childCheckbox:checked').each(function() {
        hasApplicants = true;
    });

    if (!hasApplicants) {
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss..</h4><small>Please select at least one applicant before setting the date!</small>`,
            confirmButtonColor: "#3a57e8"
        });
        return;
    }

    SweetAlert.fire({
        icon: 'info',
        html: 
        `
            <h4 class="mb-0">Set Schedule</h4>
            <input class="form-control mt-2" type="date" id="date-scheduled" />
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Set Date',
    })
    .then((result) => {
        if (result.value) {
            var dateScheduled = $('#date-scheduled').val();
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            
            if(!dateScheduled) {
                SweetAlert.fire({
                    icon: 'error',
                    html: `<h4 class="mb-0">Opss..</h4><small>Date is required</small>`,
                    confirmButtonColor: "#3a57e8"
                });
                return;
            }

            var formData = new FormData();
            $('.childCheckbox:checked').each(function() {
                formData.append('applicant[]', $(this).val());
            });
            formData.append('date', dateScheduled);
            formData.append('_method', 'PATCH');
            async function APIrequest() {
                return await axios.post('/api/update/exam-schedule', formData, {
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $('#unscheduled-data').html(response.data.Unscheduled);
                $('#layout-menu').html(response.data.Status);
                SweetAlert.fire({
                    icon: 'success',
                    html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            })
            .catch(error => {
                console.error('Error:', error);
                SweetAlert.fire({
                    icon: 'error',
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
});

$(document).on('click', '#proceed-to-interview', function() {
    var proceed = $(this).data('proceed-index');

    var hasApplicants = false;
    $('.childCheckbox-exam-'+ proceed +':checked').each(function() {
        hasApplicants = true;
    });

    if (!hasApplicants) {
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss..</h4><small>Please select at least one applicant before setting the date!</small>`,
            confirmButtonColor: "#3a57e8"
        });
        return;
    }

    SweetAlert.fire({
        icon: 'info',
        html: 
        `
            <h4 class="mb-0">Set Interview Schedule</h4>
            <input class="form-control mt-2" type="date" id="date-scheduled" />
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
    })
    .then((result) => {
        if (result.value) {
            var dateScheduled = $('#date-scheduled').val();
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false
            });
            
            if(!dateScheduled) {
                SweetAlert.fire({
                    icon: 'error',
                    html: `<h4 class="mb-0">Opss..</h4><small>Date is required</small>`,
                    confirmButtonColor: "#3a57e8"
                });
                return;
            }

            var formData = new FormData();
            $('.childCheckbox-exam-'+ proceed +':checked').each(function() {
                formData.append('applicant[]', $(this).val());
            });
            formData.append('date', dateScheduled);
            formData.append('_method', 'PATCH');
           
            async function APIrequest() {
                return await axios.post('/api/update/proceed-to-interview', formData, {
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $('#exam-data').html(response.data.Exam);
                $('#layout-menu').html(response.data.Status);
                SweetAlert.fire({
                    icon: 'success',
                    html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            })
            .catch(error => {
                console.error('Error:', error);
                SweetAlert.fire({
                    icon: 'error',
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
});

$(document).on('click', '#proceed-to-final-result', function() {
    var proceed = $(this).data('proceed-index');

    var hasApplicants = false;
    $('.childCheckbox-interview-'+ proceed +':checked').each(function() {
        hasApplicants = true;
    });

    if (!hasApplicants) {
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss..</h4><small>Please select at least one applicant</small>`,
            confirmButtonColor: "#3a57e8"
        });
        return;
    }

    SweetAlert.fire({
        icon: 'info',
        html: 
        `
            <h4 class="mb-0">Mark as Done</h4>
            <small>Selected particpants will be evaluated for the final result</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
    })
    .then((result) => {
        if (result.value) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false
            });

            var formData = new FormData();
            $('.childCheckbox-interview-'+ proceed +':checked').each(function() {
                formData.append('applicant[]', $(this).val());
            });
            formData.append('_method', 'PATCH');
            async function APIrequest() {
                return await axios.post('/api/update/proceed-to-final-result', formData, {
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $('#interview-data').html(response.data.Interview);
                $('#layout-menu').html(response.data.Status);
                SweetAlert.fire({
                    icon: 'success',
                    html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            })
            .catch(error => {
                console.error('Error:', error);
                SweetAlert.fire({
                    icon: 'error',
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
});

$(document).on('click', '#admission-passed', function() {

    var hasApplicants = false;
    $('.childCheckbox-final:checked').each(function() {
        hasApplicants = true;
    });

    if (!hasApplicants) {
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss..</h4><small>Please select at least one applicant</small>`,
            confirmButtonColor: "#3a57e8"
        });
        return;
    }

    SweetAlert.fire({
        icon: 'info',
        html: 
        `
            <h4 class="mb-0">Mark as Passed</h4>
            <small>Selected particpants will be mark as PASSED and will proceed to Enrollment</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Confirm',
    })
    .then((result) => {
        if (result.value) {
            SweetAlert.fire({
                position: 'center',
                icon: 'info',
                title: 'Processing...',
                allowOutsideClick: false,
                showConfirmButton: false
            });

            var formData = new FormData();
            $('.childCheckbox-final:checked').each(function() {
                formData.append('applicant[]', $(this).val());
            });
            formData.append('_method', 'PATCH');
            async function APIrequest() {
                return await axios.post('/api/update/admission-passed', formData, {
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $('#final-result-data').html(response.data.FinalResult);
                $('#layout-menu').html(response.data.Status);
                SweetAlert.fire({
                    icon: 'success',
                    html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            })
            .catch(error => {
                console.error('Error:', error);
                SweetAlert.fire({
                    icon: 'error',
                    html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
                    confirmButtonColor: "#3a57e8"
                });
            });
        }
    });
});

