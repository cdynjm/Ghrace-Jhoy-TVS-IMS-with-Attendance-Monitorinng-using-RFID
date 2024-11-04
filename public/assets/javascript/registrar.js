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

$(document).on('click', '#edit-sms-token', function() {

    var accessToken = $(this).data('access-token');
    var mobileIdentity = $(this).data('mobile-identity');
    $('#SMSAccessToken').val(accessToken);
    $('#SMSMobileIdentity').val(mobileIdentity)
    $('#edit-sms-token-modal').modal('show');
});

$(document).on('submit', "#update-sms-token", function(e){
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
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/sms-token', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#edit-sms-token-modal").modal('hide');
            
            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            }).then((result) => {
                if (result.isConfirmed) {
                    location.reload();
                }
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
    }, 1500);
});

$(document).on('click', "#admission-status", function(e){
    const status = $(this).is(':checked') ? $(this).val() : 'q0CwLsWJBelHrDYiAuk-xgVVFtLpyPnkGPiDKIk7oC0HMfeSbTU8QnQ49oSI7FfEi1-oTPyckxEcbK4l5UbB3YstLUe1vDtwHWk8BcNl-Oa5qrYVSEd9gbUMifkKmRzZ6xOJqjpf4tXZcreBWVK5vQ:ISlAKCMqZiYlXjEyMzQ1Ng';
    const formData = new FormData();
    formData.append('status', status);
    formData.append('_method', 'PATCH');
    async function APIrequest() {
        return await axios.post('/api/update/registrar/admission-status', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });
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

$(document).on('change', '#masterCheckbox-second-interview', function() {
    var index = $(this).data('index');
    $('.childCheckbox-second-interview-' + index).prop('checked', $(this).prop('checked'));
});

$(document).on('change', '#childCheckbox-second-interview', function() {
    var allChecked = true;
    var parent = $(this).data('parent-index');

    $('.childCheckbox-second-interview-' + parent).each(function() {
        if (!$(this).prop('checked')) {
            allChecked = false;
        }
    });
    $('.masterCheckbox-second-interview-' + parent).prop('checked', allChecked);
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

$(document).on('click', '#failed-exam', function() {
    var proceed = $(this).data('proceed-index');

    var hasApplicants = false;
    $('.childCheckbox-exam-'+ proceed +':checked').each(function() {
        hasApplicants = true;
    });

    if (!hasApplicants) {
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss..</h4><small>Please select at least one applicant!</small>`,
            confirmButtonColor: "#3a57e8"
        });
        return;
    }

    SweetAlert.fire({
        icon: 'warning',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will mark the selected students to failed application.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Confirm!',
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
            $('.childCheckbox-exam-'+ proceed +':checked').each(function() {
                formData.append('applicant[]', $(this).val());
            });
            formData.append('_method', 'PATCH');
            async function APIrequest() {
                return await axios.post('/api/update/failed-exam', formData, {
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

$(document).on('click', '#failed-interview', function() {
    var proceed = $(this).data('proceed-index');

    var hasApplicants = false;
    $('.childCheckbox-interview-'+ proceed +':checked').each(function() {
        hasApplicants = true;
    });

    if (!hasApplicants) {
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss..</h4><small>Please select at least one applicant!</small>`,
            confirmButtonColor: "#3a57e8"
        });
        return;
    }

    SweetAlert.fire({
        icon: 'warning',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will mark the selected students to failed application.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Confirm!',
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
                return await axios.post('/api/update/failed-interview', formData, {
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

$(document).on('click', '#proceed-to-second-interview', function() {
    var proceed = $(this).data('proceed-index');

    var hasApplicants = false;
    $('.childCheckbox-interview-'+ proceed +':checked').each(function() {
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
            <h4 class="mb-0">Set Second Interview Schedule</h4>
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
            $('.childCheckbox-interview-'+ proceed +':checked').each(function() {
                formData.append('applicant[]', $(this).val());
            });
            formData.append('date', dateScheduled);
            formData.append('_method', 'PATCH');
           
            async function APIrequest() {
                return await axios.post('/api/update/proceed-to-second-interview', formData, {
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

$(document).on('click', '#proceed-to-final-result', function() {
    var proceed = $(this).data('proceed-index');

    var hasApplicants = false;
    $('.childCheckbox-second-interview-'+ proceed +':checked').each(function() {
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
            $('.childCheckbox-second-interview-'+ proceed +':checked').each(function() {
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

$(document).on('click', '#failed-admission', function() {

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
        icon: 'warning',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will mark the selected students to failed application.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Confirm!',
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
                return await axios.post('/api/update/failed-admission', formData, {
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

$(document).on('click', '#enroll-student', function() {
    var courseID = $(this).parents('tr').find('td[courseID]').attr("courseID");
    var id = $(this).parents('tr').find('td[id]').attr("id");
    $('#student-id').val(id);
    $('#course-id').val(courseID);

    const formData = new FormData();
    formData.append('id', id);
    async function APIrequest() {
        return await axios.post('/api/search/specific-schedule', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#schedule-list').html(response.data.Schedule); 
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });

    $('#enroll-student-modal').modal('show');
});

$(document).on('submit', "#submit-enroll-student", function(e){
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
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/enroll-student', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#enroll-student-modal").modal('hide');
            $('select').val('');
            $('#enrollment-data').html(response.data.Enrollees);
            $('#schedule-list').html(response.data.Schedule);
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
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('click', '#edit-grades-value', function() {
    var gradeID = $(this).parents('tr').find('td[gradeID]').attr("gradeID");
    var id = $(this).parents('tr').find('td[id]').attr("id");
    var mt = $(this).parents('tr').find('td[mt]').attr("mt");
    var ft = $(this).parents('tr').find('td[ft]').attr("ft");
    var nc = $(this).parents('tr').find('td[nc]').attr("nc");
    var assessment = $(this).parents('tr').find('td[assessment]').attr("assessment");

    $('#student-id').val(id);
    $('#grade-id').val(gradeID);
    $('#mt').val(mt);
    $('#ft').val(ft);

    if(nc == 1) {
        $('#assessment').val(assessment);
        $('.resultant-subject').show(200);
    }
    else {
        $('.resultant-subject').hide(200);
    }

    $('#edit-grades-modal').modal('show');
});

$(document).on('submit', "#update-grades", function(e){
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
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/grades', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#edit-grades-modal").modal('hide');
            $('input').val('');
            $('#edit-grades-data').html(response.data.Grades);
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
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('click', "#graduate-student", function(e){
    SweetAlert.fire({
        icon: 'question',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will officially mark the student as a <b class="text-primary">Graduate</b>, as they have successfully completed all academic requirements, including their majors and minors. <br><br> The student has also fulfilled all necessary assessments, participated in required internships, and demonstrated proficiency in their field of study. As a result of these accomplishments, they will receive a <b class="text-primary">Diploma</b> and be transitioned to the employment phase, where they can begin their career journey.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, I hereby Confirm!',
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
            const data = {
                studentID: $(this).parents('tr').find('td[id]').attr("id"),
                id: $(this).parents('tr').find('td[courseID]').attr("courseID"),
                _method: 'PATCH'
            };
            async function APIrequest() {
                return await axios.post('/api/update/graduate-student', data, {
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $('.processing').hide(100);
                $('#enrollment-data').html(response.data.Enrollees);
                $('#schedule-list').html(response.data.Schedule);
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

$(document).on('click', '#edit-employment-status', function() {
   
    var id = $(this).parents('tr').find('td[id]').attr("id");
    var courseID = $(this).parents('tr').find('td[courseID]').attr("courseID");
    var company = $(this).parents('tr').find('td[company]').attr("company");
    var dateHired = $(this).parents('tr').find('td[dateHired]').attr("dateHired");
    var employmentStatus = $(this).parents('tr').find('td[employmentStatus]').attr("employmentStatus");
   
    $('#student-id').val(id);
    $('#course-id').val(courseID);
    $('#graduate-employment-status').val(employmentStatus)
    $('#date-hired').val(dateHired)
    $('#company').val(company)
    $('#edit-employment-status-modal').modal('show');
});

$(document).on('submit', "#update-employment-status", function(e){
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
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/employment-status', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#edit-employment-status-modal").modal('hide');
            $('#view-graduates-data').html(response.data.Graduates);
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
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('click', '#edit-student-information', function() {
   
    var id = $(this).parents('tr').find('td[id]').attr("id");
    var courseID = $(this).parents('tr').find('td[courseID]').attr("courseID");
    var RFID = $(this).parents('tr').find('td[RFID]').attr("RFID");
    var ULI = $(this).parents('tr').find('td[ULI]').attr("ULI");
   
    $('#student-id').val(id);
    $('#course-id').val(courseID);
    $('#RFID').val(RFID)
    $('#ULI').val(ULI)
    $('#edit-student-information-modal').modal('show');
});

$(document).on('submit', "#update-student-information", function(e){
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
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/student-information', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#edit-student-information-modal").modal('hide');
            $('#view-rfid-information-data').html(response.data.Undergraduates);
            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            });
        })
        .catch(error => {
            console.error('Error:', error);
            $('.processing').hide(100);
            $("#edit-student-information-modal").modal('hide');
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>RFID Card Number is already taken!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('keyup', "#search-unscheduled", function(e){
  
    const formData = new FormData();
    formData.append('search', $(this).val());
    async function APIrequest() {
        return await axios.post('/api/search/unscheduled', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#unscheduled-data').html(response.data.Search); 
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });

});

$(document).on('keyup', "#search-exam", function(e){
  
    const formData = new FormData();
    formData.append('search', $(this).val());
    async function APIrequest() {
        return await axios.post('/api/search/exam', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#exam-data').html(response.data.Search); 
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });

});

$(document).on('keyup', "#search-interview", function(e){
  
    const formData = new FormData();
    formData.append('search', $(this).val());
    async function APIrequest() {
        return await axios.post('/api/search/interview', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#interview-data').html(response.data.Search); 
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });

});

$(document).on('keyup', "#search-final-result", function(e){
  
    const formData = new FormData();
    formData.append('search', $(this).val());
    async function APIrequest() {
        return await axios.post('/api/search/final-result', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#final-result-data').html(response.data.Search); 
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });

});

$(document).on('keyup', "#search-enrollment", function(e){
  
    const formData = new FormData();
    formData.append('search', $(this).val());
    formData.append('id', $(this).data('id'));
    async function APIrequest() {
        return await axios.post('/api/search/enrollment', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#enrollment-data').html(response.data.Search); 
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });

});

$(document).on('keyup', "#search-grades", function(e){
  
    const formData = new FormData();
    formData.append('search', $(this).val());
    formData.append('id', $(this).data('id'));
    async function APIrequest() {
        return await axios.post('/api/search/grades', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#grades-data').html(response.data.Search); 
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });

});

$(document).on('keyup', "#search-graduates", function(e){
  
    const formData = new FormData();
    formData.append('search', $(this).val());
    formData.append('id', $(this).data('id'));
    async function APIrequest() {
        return await axios.post('/api/search/graduates', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#view-graduates-data').html(response.data.Search); 
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });

});

$(document).on('keyup', "#search-undergraduates", function(e){
  
    const formData = new FormData();
    formData.append('search', $(this).val());
    formData.append('id', $(this).data('id'));
    async function APIrequest() {
        return await axios.post('/api/search/undergraduates', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#view-undergraduates-data').html(response.data.Search); 
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });

});


$(document).on('keyup', "#search-rfid-information", function(e){
  
    const formData = new FormData();
    formData.append('search', $(this).val());
    formData.append('id', $(this).data('id'));
    async function APIrequest() {
        return await axios.post('/api/search/rfid-information', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#view-rfid-information-data').html(response.data.Search); 
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });

});

$(document).on('keyup', "#search-attendance", function(e){
  
    const formData = new FormData();
    formData.append('search', $(this).val());
    formData.append('id', $(this).data('id'));
    async function APIrequest() {
        return await axios.post('/api/search/attendance', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#view-attendance-data').html(response.data.Search); 
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });

});

$(document).on('click', '#add-course', function() {
    $('#create-course-modal').modal('show');
});

$(document).on('submit', "#create-course", function(e){
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
            return await axios.post('/api/create/course', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#create-course-modal").modal('hide');
            $('input').val('');
            $('#course-data').html(response.data.Courses);
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
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('click', "#edit-course", function(e){

    var id = $(this).parents('tr').find('td[id]').attr("id");
    var sector = $(this).parents('tr').find('td[sector]').attr("sector");
    var qualification = $(this).parents('tr').find('td[qualification]').attr("qualification");
    var status = $(this).parents('tr').find('td[status]').attr("status");
    var copr = $(this).parents('tr').find('td[copr]').attr("copr");

    $('#course-id').val(id);
    $('#sector').val(sector);
    $('#qualification').val(qualification);
    $('#status').val(status);
    $('#copr').val(copr);

    $("#edit-course-modal").modal('show');
});

$(document).on('submit', "#update-course", function(e){
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
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/course', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#edit-course-modal").modal('hide');
            $('input').val('');
            $('#course-data').html(response.data.Courses);
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
    }, 1500);
});

$(document).on('click', "#delete-course", function(e){
    SweetAlert.fire({
        icon: 'warning',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will remove the course permanently.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete it!',
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
            const data = {id: $(this).parents('tr').find('td[id]').attr("id")};
            async function APIrequest() {
                return await axios.delete('/api/delete/course', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $('#course-data').html(response.data.Courses);
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

$(document).on('click', '#add-course-info', function() {
    var id = $(this).data('id');
    $('.course-id').val(id);
    $('#create-course-info-modal').modal('show');
});

$(document).on('click', '#edit-course-info', function() {
    var id = $(this).data('id');
    var courseInfoID = $(this).parents('tr').find('td[courseInfoID]').attr("courseInfoID");
    var yearLevel = $(this).parents('tr').find('td[yearLevel]').attr("yearLevel");
    var semester = $(this).parents('tr').find('td[semester]').attr("semester");

    $('.course-id').val(id);
    $('.course-info-id').val(courseInfoID);
    $('#edit-year-level').val(yearLevel);
    $('#edit-semester').val(semester);

    const data = { courseInfoID: courseInfoID };
    async function APIrequest() {
        return await axios.post('/api/create/course-info-subject', data, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $(".edit-course-subject-list-data").html(response.data.Subjects);
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

    $('#edit-course-info-modal').modal('show');
});

document.addEventListener('livewire:navigated', () => { 
    let checkboxIndex = 0;

$(document).ready(function() {
    // Add new set of input fields
    $('.add-subject').click(function() {
        // Get the current number of checkboxes with name "NC[]"
         checkboxIndex++;
        
        let newInput = `
            <div class="subject-group mb-2 d-flex">
                <input type="text" name="subjectCode[]" class="form-control me-2" placeholder="Code" required>
                <input type="text" name="description[]" class="form-control me-2" placeholder="Description" required>
                <input type="number" name="units[]" class="form-control" placeholder="Units" required>
            </div>
    
            <div class="form-check form-switch my-3">
                <input type="checkbox" name="NC[${checkboxIndex}]" value="1" class="form-check-input me-2">
                <label for="" style="font-size: 12px;">Resultant Subject (NC II)</label>
            </div>
        `;
    
        $('#subject-wrapper').append(newInput);
    });

    $('.edit-add-subject').click(function() {
        let newInput = `
            <div class="subject-group mb-2 d-flex">
                <input type="text" name="subjectCode[]" class="form-control me-2" placeholder="Code" required>
                <input type="text" name="description[]" class="form-control me-2" placeholder="Description" required>
                <input type="number" name="units[]" class="form-control" placeholder="Units" required>
            </div>

            <div class="form-check form-switch my-3">
                <input type="checkbox" name="NC[]" value="1" class="form-check-input me-2">
                <label for="" style="font-size: 12px;">Resultant Subject (NC II)</label>
              </div>
            
            `;
        $('#edit-subject-wrapper').append(newInput);
    });

    // Remove the last set of input fields
    $('.remove-subject').click(function() {
        if ($('#subject-wrapper .subject-group').length > 1) {
            $('#subject-wrapper .subject-group:last').remove();
        }
        if ($('#subject-wrapper .form-check').length > 1) {
            $('#subject-wrapper .form-check:last').remove();
        }
    });
    });
});


$(document).on('submit', "#create-course-info", function(e){
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
            return await axios.post('/api/create/course-info', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#create-course-info-modal").modal('hide');
            $('input').val('');
            $('#course-info-data').html(response.data.CoursesInfo);
            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            }).then((result) => {
                // Check if the user clicked the confirm button
                if (result.isConfirmed) {
                    // Reload the page
                    location.reload();
                }
            });            
        })
        .catch(error => {
            console.error('Error:', error);
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('submit', "#update-course-info", function(e){
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
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/course-info', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#edit-course-info-modal").modal('hide');
            $('input').val('');
            $('#course-info-data').html(response.data.CoursesInfo);
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
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('click', '#add-schedule', function() {
    var id = $(this).data('id');
    $('#course-id').val(id);
    $('#create-schedule-modal').modal('show');
});

$(document).on('change', ".yearLevel", function(e){

    const data = { id: $(this).val() };
    async function APIrequest() {
        return await axios.post('/api/create/subjects', data, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $(".subject-list-data").html(response.data.Subjects);
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

$(document).on('submit', "#create-schedule", function(e){
    e.preventDefault();
    $('.processing').show(100);
    $('.processing').html(`
        <div class="col d-flex">
            <div>
                <div class="sk-pulse sk-primary"></div>
            </div>
            <div class="text-sm mt-1 ms-4">Processing...</div>
        </div>
    `);
    
    setTimeout(() => {
        const formData = new FormData(this);
        async function APIrequest() {
            return await axios.post('/api/create/schedule', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        
        APIrequest().then(response => {
            $('.processing').hide(100);
            $('.error-sched').hide(100);
            $("#create-schedule-modal").modal('hide');
            $('input').val('');
            $('#schedule-subject-course-data').html(response.data.Schedule);
            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            }).then(() => {
                window.location.reload();
            });
        })
        .catch(error => {
            $('.processing').hide(100);
            $('.error-sched').show(100);
        
            const errorMessage = error.response && error.response.data 
                ? error.response.data.Message || 'An unexpected error occurred.'
                : 'An unexpected error occurred.';
        
            // Log the full response for debugging
            console.log("Full error response:", JSON.stringify(error.response.data));
        
            // Display conflicts if any
            if (error.response && error.response.data.Conflicts) {
                try {
                    // Map conflicts and conflicting schedules together into rows
                    const conflictRows = error.response.data.Conflicts.map((conflict, index) => {
                        const activeDaysConflict = Object.keys(conflict.days)
                            .filter(day => conflict.days[day]) // Only include true/1 days
                            .map(day => day.charAt(0).toUpperCase() + day.slice(1)) // Capitalize day names
                            .join(', ');
        
                        const conflictHtml = `
                            <strong>Instructor:</strong> ${conflict.instructor}<br>
                            <strong>Subject:</strong> ${conflict.subject}<br>
                            <strong>Room:</strong> ${conflict.room}<br>
                            <strong>Days:</strong> ${activeDaysConflict}<br>
                            <strong>Time:</strong> ${conflict.fromTime} to ${conflict.toTime}
                        `;
        
                        // Find the corresponding `schedThatConflicts` entry by index
                        const sched = error.response.data.schedThatConflicts[index];
                        const activeDaysSched = Object.keys(sched.days)
                            .filter(day => sched.days[day]) // Only include true/1 days
                            .map(day => day.charAt(0).toUpperCase() + day.slice(1)) // Capitalize day names
                            .join(', ');
        
                        const schedHtml = `
                            <strong>Instructor:</strong> ${sched.instructor}<br>
                            <strong>Subject:</strong> ${sched.subject}<br>
                            <strong>Room:</strong> ${sched.room}<br>
                            <strong>Days:</strong> ${activeDaysSched}<br>
                            <strong>Time:</strong> ${sched.fromTime} to ${sched.toTime}
                        `;
        
                        return `
                            <tr>
                                <td>${conflictHtml}</td>
                                <td>${schedHtml}</td>
                            </tr>
                        `;
                    }).join('');
        
                    $('.error-sched').html(`
                        <div class="col d-flex">
                            <div class="text-sm mt-1">${errorMessage}</div>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>Conflicting Schedules</th>
                                    <th>Schedules That Conflict</th>
                                </tr>
                            </thead>
                                <tbody>
                                    ${conflictRows}
                                </tbody>
                            </table>
                        </div>
                    `);
                } catch (e) {
                    console.log("Mapping error:", e);
                    $('.error-sched').html(`
                        <div class="col d-flex">
                            <div class="text-sm mt-1">${errorMessage}</div>
                        </div>
                        <div class="col">${JSON.stringify(error.response.data.Conflicts, null, 2)}</div>
                    `);
                }
            } else {
                $('.error-sched').html(`
                    <div class="col d-flex">
                        <div class="text-sm mt-1">${errorMessage}</div>
                    </div>
                `);
            }
        });
        
        
        
    }, 1500);
});


$(document).on('click', "#edit-schedule", function(e){

    var id = $(this).parents('tr').find('td[id]').attr("id");
    var courseID = $(this).parents('tr').find('td[courseID]').attr("courseID");
    var schoolYear = $(this).parents('tr').find('td[schoolYear]').attr("schoolYear");
    var yearLevel = $(this).parents('tr').find('td[yearLevel]').attr("yearLevel");
    var section = $(this).parents('tr').find('td[section]').attr("section");
    var slots = $(this).parents('tr').find('td[slots]').attr("slots");

    $('#schedule-id').val(id);
    $('#school-year').val(schoolYear);
    $('.course-id').val(courseID);
    $('#yearLevel').val(yearLevel);
    $('#section').val(section);
    $('#slots').val(slots);

    const data = { id: id };
    async function APIrequest() {
        return await axios.post('/api/create/subject-schedule', data, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $(".edit-subject-list-data").html(response.data.Subjects);
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

    $("#edit-schedule-modal").modal('show');
});

$(document).on('submit', "#update-schedule", function(e){
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
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/schedule', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#edit-schedule-modal").modal('hide');
            $('input').val('');
            $('#schedule-subject-course-data').html(response.data.Schedule)
            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            }).then(() => {
                window.location.reload();
              });
        })
        .catch(error => {
            $('.processing').hide(100);
            $('.error-sched').show(100);
        
            const errorMessage = error.response && error.response.data 
                ? error.response.data.Message || 'An unexpected error occurred.'
                : 'An unexpected error occurred.';
        
            // Log the full response for debugging
            console.log("Full error response:", JSON.stringify(error.response.data));
        
            // Display conflicts if any
            if (error.response && error.response.data.Conflicts) {
                try {
                    // Map conflicts and conflicting schedules together into rows
                    const conflictRows = error.response.data.Conflicts.map((conflict, index) => {
                        const activeDaysConflict = Object.keys(conflict.days)
                            .filter(day => conflict.days[day]) // Only include true/1 days
                            .map(day => day.charAt(0).toUpperCase() + day.slice(1)) // Capitalize day names
                            .join(', ');
        
                        const conflictHtml = `
                            <strong>Instructor:</strong> ${conflict.instructor}<br>
                            <strong>Subject:</strong> ${conflict.subject}<br>
                            <strong>Room:</strong> ${conflict.room}<br>
                            <strong>Days:</strong> ${activeDaysConflict}<br>
                            <strong>Time:</strong> ${conflict.fromTime} to ${conflict.toTime}
                        `;
        
                        // Find the corresponding `schedThatConflicts` entry by index
                        const sched = error.response.data.schedThatConflicts[index];
                        const activeDaysSched = Object.keys(sched.days)
                            .filter(day => sched.days[day]) // Only include true/1 days
                            .map(day => day.charAt(0).toUpperCase() + day.slice(1)) // Capitalize day names
                            .join(', ');
        
                        const schedHtml = `
                            <strong>Instructor:</strong> ${sched.instructor}<br>
                            <strong>Subject:</strong> ${sched.subject}<br>
                            <strong>Room:</strong> ${sched.room}<br>
                            <strong>Days:</strong> ${activeDaysSched}<br>
                            <strong>Time:</strong> ${sched.fromTime} to ${sched.toTime}
                        `;
        
                        return `
                            <tr>
                                <td>${conflictHtml}</td>
                                <td>${schedHtml}</td>
                            </tr>
                        `;
                    }).join('');
        
                    $('.error-sched').html(`
                        <div class="col d-flex">
                            <div class="text-sm mt-1">${errorMessage}</div>
                        </div>
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                            <thead>
                                <tr>
                                    <th>Conflicting Schedules</th>
                                    <th>Schedules That Conflict</th>
                                </tr>
                            </thead>
                                <tbody>
                                    ${conflictRows}
                                </tbody>
                            </table>
                        </div>
                    `);
                } catch (e) {
                    console.log("Mapping error:", e);
                    $('.error-sched').html(`
                        <div class="col d-flex">
                            <div class="text-sm mt-1">${errorMessage}</div>
                        </div>
                        <div class="col">${JSON.stringify(error.response.data.Conflicts, null, 2)}</div>
                    `);
                }
            } else {
                $('.error-sched').html(`
                    <div class="col d-flex">
                        <div class="text-sm mt-1">${errorMessage}</div>
                    </div>
                `);
            }
        });
    }, 1500);
});

$(document).on('click', "#archive-schedule", function(e){
    SweetAlert.fire({
        icon: 'warning',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will archive the schedules permanently.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Archive!',
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
            const data = {
                id: $(this).parents('tr').find('td[courseID]').attr("courseID"),
                scheduleID: $(this).parents('tr').find('td[id]').attr("id")
            };
            async function APIrequest() {
                return await axios.delete('/api/delete/schedule', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $('#schedule-subject-course-data').html(response.data.Schedule);
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

$(document).on('keyup', "#search-course-info", function(e){
  
        const formData = new FormData();
        formData.append('search', $(this).val());
        formData.append('id', $(this).data('id'));
        async function APIrequest() {
            return await axios.post('/api/search/course-info', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('#course-info-data').html(response.data.CoursesInfo);
            
        })
        .catch(error => {
            console.error('Error:', error);
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
 
});

$(document).on('submit', "#search-schedule", function(e){
    e.preventDefault();
    const formData = new FormData(this);
    async function APIrequest() {
        return await axios.post('/api/search/schedule', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#schedule-subject-course-data').html(response.data.schedule);
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('change', "#search-year-semester", function(e){
    const formData = new FormData();
    formData.append('search', $(this).val());
    formData.append('id', $(this).data('id'));

    console.log($(this).val())
    console.log($(this).data('id'))
    async function APIrequest() {
        return await axios.post('/api/search/grades-year-semester', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#edit-grades-data').html(response.data.Grades);
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('submit', "#search-student-attendance", function(e){
    e.preventDefault();
    const formData = new FormData(this);
    async function APIrequest() {
        return await axios.post('/api/search/student-attendance', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#view-student-attendance-data').html(response.data.Attendance);
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });
});

$(document).on('click', '#add-instructor', function() {
    $('#create-instructor-modal').modal('show');
});

$(document).on('submit', "#create-instructor", function(e){
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
            return await axios.post('/api/create/instructor', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#create-instructor-modal").modal('hide');
            $('input').val('');
            $('#instructors-data').html(response.data.Instructors);
            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            });
        })
        .catch(error => {
            console.error('Error:', error);
            $('.processing').hide(100);
            $("#create-instructor-modal").modal('hide');
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>Email is already taken!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('click', "#edit-instructor", function(e){

    var id = $(this).parents('tr').find('td[id]').attr("id");
    var instructor = $(this).parents('tr').find('td[instructor]').attr("instructor");
    var address = $(this).parents('tr').find('td[address]').attr("address");
    var contactNumber = $(this).parents('tr').find('td[contactNumber]').attr("contactNumber");
    var degree = $(this).parents('tr').find('td[degree]').attr("degree");
    var email = $(this).parents('tr').find('td[email]').attr("email");

    $('#instructor-id').val(id);
    $('#instructor').val(instructor);
    $('#address').val(address);
    $('#contactNumber').val(contactNumber);
    $('#degree').val(degree);
    $('#email').val(email);

    $("#edit-instructor-modal").modal('show');
});

$(document).on('submit', "#update-instructor", function(e){
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
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/instructor', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#edit-instructor-modal").modal('hide');
            $('input').val('');
            $('#instructors-data').html(response.data.Instructors);
            SweetAlert.fire({
                icon: 'success',
                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                confirmButtonColor: "#3a57e8"
            });
        })
        .catch(error => {
            console.error('Error:', error);
            $('.processing').hide(100);
            $("#edit-instructor-modal").modal('hide');
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>Email is already taken!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('click', "#delete-instructor", function(e){
    SweetAlert.fire({
        icon: 'warning',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will remove the instructor permanently.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete it!',
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
            const data = {id: $(this).parents('tr').find('td[id]').attr("id")};
            async function APIrequest() {
                return await axios.delete('/api/delete/instructor', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $('#instructors-data').html(response.data.Instructors);
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



    function loadSubjects(schoolYear, semesterId) {
        // Function to load subjects based on selected school year and semester
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + $('meta[name="token"]').attr('content');
        axios.get('/api/search/get-subjects-for-grades', {
            params: {
                schoolYear: schoolYear,
                semesterId: semesterId
            }
        })
        .then(function(response) {
            // Clear current options
            $('#subject').empty().append('<option value="">Select Subject</option>');
            // Populate subjects
            response.data.subjects.forEach(function(subject) {
                $('#subject').append('<option value="' + subject.id + '">' + subject.description + '</option>');
            });
        })
        .catch(function(error) {
            console.error(error);
        });
    }

    // Function to load sections based on selected school year and semester
    function loadSections(schoolYear, semesterId) {
        // Function to load subjects based on selected school year and semester
        axios.defaults.headers.common['Authorization'] = 'Bearer ' + $('meta[name="token"]').attr('content');
        axios.get('/api/search/get-sections-for-grades', {
            params: {
                schoolYear: schoolYear,
                semesterId: semesterId
            }
        })
        .then(function(response) {
            // Clear current options
            $('#section').empty().append('<option value="">Select Section</option>');
            // Populate sections
            response.data.sections.forEach(function(section) {
                $('#section').append('<option value="' + section.id + '">' + section.section + '</option>');
            });
        })
        .catch(function(error) {
            console.error(error);
        });
    }

    // Event listener for school year and semester change
    $(document).on('change', '#schoolYear-grades, #yearSemester-grades', function() {
        var schoolYear = $('#schoolYear-grades').val();
        var semesterId = $('#yearSemester-grades').val();

        // Check if both fields have values
        if (schoolYear && semesterId) {
            loadSubjects(schoolYear, semesterId);
            loadSections(schoolYear, semesterId);
        } else {
            // Clear options if one of the fields is not selected
            $('#subject').empty().append('<option value="">Select Subject</option>');
            $('#section').empty().append('<option value="">Select Section</option>');
        }
    });

    function gradesDataTable() {
        $('#grades-data-table').DataTable(
            {
                language: {
                  'paginate': {
                    'previous': '<span class="prev-icon"><i class="fas fa-angle-double-left"></i></span>',
                    'next': '<span class="next-icon"><i class="fas fa-angle-double-right"></i></span>'
                  },
                  'lengthMenu': `Show 
                                <select class="form-select form-select-sm pe-5">
                                    <option value="10">10</option>
                                    <option value="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select> 
                               entries`
                },
                pageLength: 20
              }
        );
        $('.dataTables_wrapper .dataTables_filter input').css('width', '200px')
    }
    
    document.addEventListener('livewire:navigated', () => { 
        $(document).ready(function () {
            
        });
    });

$(document).on('submit', "#search-student-for-grading", function(e){
    e.preventDefault();
    const formData = new FormData(this);
    async function APIrequest() {
        return await axios.post('/api/search/students-for-grading', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        $('#grades-data-table').html(response.data.Grades);
        $('#search-input').prop('disabled', false)
        
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });
});


$(document).on('keyup', '#search-input', function() {
    var searchTerm = $(this).val().toLowerCase().replace(/^\s+|\s+$/g, ''); // Remove leading/trailing spaces only
    var noResults = true;

    // Filter through each row in the tbody except those with the 'exclude-from-search' class
    $('#grades-data-table tbody tr').not('.exclude-from-search').each(function() {
        var rowText = $(this).text().toLowerCase();

        // Check if row contains the search term
        if (rowText.includes(searchTerm)) {
            $(this).show();  // Show rows that match the search term
            noResults = false; // At least one row matches
        } else {
            $(this).hide();  // Hide rows that don’t match
        }
    });

    // Show 'No data found' message if no rows match
    if (noResults) {
        $('#grades-data-table tbody').append('<tr class="no-data"><td colspan="7" class="text-center">No data found</td></tr>');
    } else {
        $('#grades-data-table tbody .no-data').remove(); // Remove 'No data found' message if there are matching rows
    }
});

$(document).on('click', '#update-grades-value', function() {
    var id = $(this).parents('tr').find('td[id]').attr("id");
    var gradeID = $(this).parents('tr').find('td[gradeID]').attr("gradeID");
    var schoolYear = $(this).parents('tr').find('td[schoolYear]').attr("schoolYear");
    var semester = $(this).parents('tr').find('td[semester]').attr("semester");
    var subject = $(this).parents('tr').find('td[subject]').attr("subject");
    var section = $(this).parents('tr').find('td[section]').attr("section");
    var mt = $(this).parents('tr').find('td[mt]').attr("mt");
    var ft = $(this).parents('tr').find('td[ft]').attr("ft");
    var nc = $(this).parents('tr').find('td[nc]').attr("nc");
    var assessment = $(this).parents('tr').find('td[assessment]').attr("assessment");
    

    $('#update-id').val(id);
    $('#update-grade-id').val(gradeID);
    $('#update-school-year').val(schoolYear);
    $('#update-semester').val(semester);
    $('#update-subject').val(subject);
    $('#update-section').val(section);
    $('#update-mt').val(mt);
    $('#update-ft').val(ft);

    if(nc == 1) {
        $('#update-assessment').val(assessment);
        $('.resultant-subject').show(200);
    }
    else {
        $('.resultant-subject').hide(200);
    }

    $('#update-grades-modal').modal('show');
});

$(document).on('submit', "#update-grades-data-value", function(e){
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
        formData.append('_method', 'PATCH');
        async function APIrequest() {
            return await axios.post('/api/update/grades-data-value', formData, {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                }
            })
        }
        APIrequest().then(response => {
            $('.processing').hide(100);
            $("#update-grades-modal").modal('hide');
            $('input').val('');
            $('#grades-data-table').html(response.data.Grades);
            $('#search-input').prop('disabled', false);
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
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        });
    }, 1500);
});

$(document).on('click', '#download-ORF', function() {
    var name = $(this).data('name');
    var id = $(this).data('id');
    var student = $(this).data('student');
    
    // Send the id as a query parameter
    axios.get('/registrar/download-orf', {
        params: {
            id: id,
            student: student
        }
    })
    .then(function(response) {
        var data = response.data;
        var tempDiv = $('<div></div>').html(data);
        $('#body-orf').append(tempDiv);

        var style = $(`
            <style>
                #body-orf, h1, h2, h3, h4, h5, h6 {
                    color: black !important;
                }
            </style>
        `);
        tempDiv.append(style);

        html2pdf().from(tempDiv[0]).set({
            margin: 0.5,
            filename: name + '-ORF.pdf',
            html2canvas: { scale: 5 },
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

// Attach change and keyup event listeners using document delegation
$(document).on('change', '.subject-list-data input, .subject-list-data select', function () {
    checkConflicts();
});

$(document).on('keyup', '.subject-list-data input[name="room[]"]', function () {
    checkConflicts();
});

function checkConflicts() {
    let rows = $('.subject-list-data tbody tr');
    let conflictFound = false;

    // Clear any previous error messages
    $('.conflict-alert').remove();

    // Loop through each row and check for conflicts
    rows.each(function (index, row) {
        let current = $(row);
        let currentInstructor = current.find('select[name="instructor[]"]').val();
        let currentRoom = current.find('input[name="room[]"]').val().toLowerCase(); // Convert to lowercase
        let currentSubject = current.find('input[name="subjectID[]"]').val();
        let currentDays = current.find('input[type="checkbox"]:checked').map(function () { return $(this).next().text(); }).get();
        let currentFromTime = current.find('input[name="fromTime[]"]').val();
        let currentToTime = current.find('input[name="toTime[]"]').val();

        // Check that toTime is at least 30 minutes ahead of fromTime
        if (currentFromTime && currentToTime) {
            let fromTime = new Date(`1970-01-01T${currentFromTime}:00`);
            let toTime = new Date(`1970-01-01T${currentToTime}:00`);
            let minToTime = new Date(fromTime.getTime() + 30 * 60000); // 30 minutes ahead

            if (toTime <= fromTime) {
                conflictFound = true;
                current.after(`
                    <tr class="conflict-alert">
                        <td colspan="5">
                            <div class="alert alert-danger mt-2">Error: "To Time" must be later than "From Time".</div>
                        </td>
                    </tr>
                `);
            } else if (toTime < minToTime) {
                conflictFound = true;
                current.after(`
                    <tr class="conflict-alert">
                        <td colspan="5">
                            <div class="alert alert-danger mt-2">Error: "To Time" must be at least 30 minutes after "From Time".</div>
                        </td>
                    </tr>
                `);
            }
        }

        // Loop through each row and compare it with every other row
        rows.each(function (i, otherRow) {
            if (i === index) return; // Skip the current row
            
            let other = $(otherRow);
            let otherInstructor = other.find('select[name="instructor[]"]').val();
            let otherRoom = other.find('input[name="room[]"]').val().toLowerCase(); // Convert to lowercase
            let otherSubject = other.find('input[name="subjectID[]"]').val();
            let otherDays = other.find('input[type="checkbox"]:checked').map(function () { return $(this).next().text(); }).get();
            let otherFromTime = other.find('input[name="fromTime[]"]').val();
            let otherToTime = other.find('input[name="toTime[]"]').val();

            // Check for overlapping days
            let overlapDays = currentDays.some(day => otherDays.includes(day));
            
            // Check for overlapping time ranges
            let overlapTimes = (
                (currentFromTime < otherToTime) && (currentToTime > otherFromTime)
            );

            // If there are overlapping days and times, check for conflict conditions
            if (overlapDays && overlapTimes) {
                let conflictMessage = '';
                conflictFound = true;

                if (currentInstructor === otherInstructor && currentRoom === otherRoom && currentSubject === otherSubject) {
                    conflictMessage = "Conflict: Same instructor, schedule, room, and subject.";
                }
                else if (currentInstructor === otherInstructor && currentRoom === otherRoom && currentSubject !== otherSubject) {
                    conflictMessage = "Conflict: Same instructor, schedule, and room but different subjects.";
                }
                else if (currentInstructor === otherInstructor && currentRoom !== otherRoom && currentSubject !== otherSubject) {
                    conflictMessage = "Conflict: Same instructor and schedule, different room, and different subjects.";
                }
                else if (currentInstructor === otherInstructor && currentRoom !== otherRoom && currentSubject === otherSubject) {
                    conflictMessage = "Conflict: Same instructor, schedule, different room, and same subject.";
                }
                else if (currentInstructor !== otherInstructor && currentRoom === otherRoom && currentSubject === otherSubject) {
                    conflictMessage = "Conflict: Different instructor, same schedule, room, and subject.";
                }
                else if (currentInstructor !== otherInstructor && currentRoom === otherRoom && currentSubject !== otherSubject) {
                    conflictMessage = "Conflict: Different instructor, same schedule and room but different subjects.";
                }

                // Insert the conflict alert row after the current row
                if (conflictMessage) {
                    current.after(`
                        <tr class="conflict-alert">
                            <td colspan="5">
                                <div class="alert alert-danger mt-2">${conflictMessage}</div>
                            </td>
                        </tr>
                    `);
                }
            }
        });
    });

    if (!conflictFound) {
        console.log("No conflicts found.");
    }
}

// Attach change and keyup event listeners using document delegation
$(document).on('change', '.edit-subject-list-data input, .edit-subject-list-data select', function () {
    editcheckConflicts();
});

$(document).on('keyup', '.edit-subject-list-data input[name="room[]"]', function () {
    editcheckConflicts();
});

function editcheckConflicts() {
    let rows = $('.edit-subject-list-data tbody tr');
    let conflictFound = false;

    // Clear any previous error messages
    $('.edit-conflict-alert').remove();

    // Loop through each row and check for conflicts
    rows.each(function (index, row) {
        let current = $(row);
        let currentInstructor = current.find('select[name="instructor[]"]').val();
        let currentRoom = current.find('input[name="room[]"]').val().toLowerCase(); // Convert to lowercase
        let currentSubject = current.find('input[name="subjectID[]"]').val();
        let currentDays = current.find('input[type="checkbox"]:checked').map(function () { return $(this).next().text(); }).get();
        let currentFromTime = current.find('input[name="fromTime[]"]').val();
        let currentToTime = current.find('input[name="toTime[]"]').val();

        // Check that toTime is at least 30 minutes ahead of fromTime
        if (currentFromTime && currentToTime) {
            let fromTime = new Date(`1970-01-01T${currentFromTime}:00`);
            let toTime = new Date(`1970-01-01T${currentToTime}:00`);
            let minToTime = new Date(fromTime.getTime() + 30 * 60000); // 30 minutes ahead

            if (toTime <= fromTime) {
                conflictFound = true;
                current.after(`
                    <tr class="edit-conflict-alert">
                        <td colspan="5">
                            <div class="alert alert-danger mt-2">Error: "To Time" must be later than "From Time".</div>
                        </td>
                    </tr>
                `);
            } else if (toTime < minToTime) {
                conflictFound = true;
                current.after(`
                    <tr class="edit-conflict-alert">
                        <td colspan="5">
                            <div class="alert alert-danger mt-2">Error: "To Time" must be at least 30 minutes after "From Time".</div>
                        </td>
                    </tr>
                `);
            }
        }

        // Loop through each row and compare it with every other row
        rows.each(function (i, otherRow) {
            if (i === index) return; // Skip the current row
            
            let other = $(otherRow);
            let otherInstructor = other.find('select[name="instructor[]"]').val();
            let otherRoom = other.find('input[name="room[]"]').val().toLowerCase(); // Convert to lowercase
            let otherSubject = other.find('input[name="subjectID[]"]').val();
            let otherDays = other.find('input[type="checkbox"]:checked').map(function () { return $(this).next().text(); }).get();
            let otherFromTime = other.find('input[name="fromTime[]"]').val();
            let otherToTime = other.find('input[name="toTime[]"]').val();

            // Check for overlapping days
            let overlapDays = currentDays.some(day => otherDays.includes(day));
            
            // Check for overlapping time ranges
            let overlapTimes = (
                (currentFromTime < otherToTime) && (currentToTime > otherFromTime)
            );

            // If there are overlapping days and times, check for conflict conditions
            if (overlapDays && overlapTimes) {
                let conflictMessage = '';
                conflictFound = true;

                if (currentInstructor === otherInstructor && currentRoom === otherRoom && currentSubject === otherSubject) {
                    conflictMessage = "Conflict: Same instructor, schedule, room, and subject.";
                }
                else if (currentInstructor === otherInstructor && currentRoom === otherRoom && currentSubject !== otherSubject) {
                    conflictMessage = "Conflict: Same instructor, schedule, and room but different subjects.";
                }
                else if (currentInstructor === otherInstructor && currentRoom !== otherRoom && currentSubject !== otherSubject) {
                    conflictMessage = "Conflict: Same instructor and schedule, different room, and different subjects.";
                }
                else if (currentInstructor === otherInstructor && currentRoom !== otherRoom && currentSubject === otherSubject) {
                    conflictMessage = "Conflict: Same instructor, schedule, different room, and same subject.";
                }
                else if (currentInstructor !== otherInstructor && currentRoom === otherRoom && currentSubject === otherSubject) {
                    conflictMessage = "Conflict: Different instructor, same schedule, room, and subject.";
                }
                else if (currentInstructor !== otherInstructor && currentRoom === otherRoom && currentSubject !== otherSubject) {
                    conflictMessage = "Conflict: Different instructor, same schedule and room but different subjects.";
                }

                // Insert the conflict alert row after the current row
                if (conflictMessage) {
                    current.after(`
                        <tr class="edit-conflict-alert">
                            <td colspan="5">
                                <div class="alert alert-danger mt-2">${conflictMessage}</div>
                            </td>
                        </tr>
                    `);
                }
            }
        });
    });

    if (!conflictFound) {
        console.log("No conflicts found.");
    }
}

