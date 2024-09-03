var SweetAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-sm btn-primary',
        cancelButton: 'btn btn-sm btn-secondary ms-2'
    },
    buttonsStyling: false
});

$(document).on('click', "#admission-status", function(e){
    const status = $(this).is(':checked') ? $(this).val() : 'q0CwLsWJBelHrDYiAuk-xgVVFtLpyPnkGPiDKIk7oC0HMfeSbTU8QnQ49oSI7FfEi1-oTPyckxEcbK4l5UbB3YstLUe1vDtwHWk8BcNl-Oa5qrYVSEd9gbUMifkKmRzZ6xOJqjpf4tXZcreBWVK5vQ:ISlAKCMqZiYlXjEyMzQ1Ng';
    const formData = new FormData();
    formData.append('status', status);
    formData.append('_method', 'PATCH');
    async function APIrequest() {
        return await axios.post('/api/update/admin/admission-status', formData, {
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

    $('#id').val(id);
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
$(document).ready(function() {
    // Add new set of input fields
    $('.add-subject').click(function() {
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
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
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

    $('#instructor-id').val(id);
    $('#instructor').val(instructor);
    $('#address').val(address);
    $('#contactNumber').val(contactNumber);

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
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss...</h4><small>Something went wrong!</small>`,
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
                <!-- Pluse -->
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
            $("#create-schedule-modal").modal('hide');
            $('input').val('');
            $('#schedule-subject-course-data').html(response.data.Schedule)
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