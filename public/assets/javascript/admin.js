var SweetAlert = Swal.mixin({
    customClass: {
        confirmButton: 'btn btn-sm btn-primary',
        cancelButton: 'btn btn-sm btn-secondary ms-2'
    },
    buttonsStyling: false
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
