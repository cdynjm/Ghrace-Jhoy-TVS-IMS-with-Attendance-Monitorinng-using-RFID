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

$(document).on('click', '#downloadPDF', function() {
    var name = $(this).find('i').data('value');
    
    axios.get('/student/registration-form')
        .then(function(response) {
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

document.addEventListener('livewire:navigated', () => { 

    var selectedFiles = [];
    $('#file-input-psa').on('change', function() {
        selectedFiles = []; // Clear previous files
        $.each(this.files, function(index, file) {
            if (!selectedFiles.map(f => f.name).includes(file.name)) {
                selectedFiles.push(file);
            }
        });
        updateFileList();
    });

    $('#add-more-files-psa').on('click', function() {
        var count = $('#psa-data ul').data('psa-count');
        if(count == 0)
            $('#file-input-psa').click();
        else {
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss..</h4><small>You can upload a file only once. If you wish to re-upload, please remove the previously uploaded file and then select a new one.</small>`,
                confirmButtonColor: "#3a57e8"
            });
        }
    });

    $('#upload-attachments-psa').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData();
        $.each(selectedFiles, function(index, file) {
            formData.append('files[]', file);
        });

        if(selectedFiles.length === 0) {
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss..</h4><small>Please select a file to upload!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        } else {
            SweetAlert.fire({
                icon: 'info',
                html: 
                `
                    <h4 class="mb-0">Are you sure?</h4>
                    <small>This will submit your attachment to the registrar.</small>
                `,
                confirmButtonColor: '#160e45',
                showCancelButton: true,
                confirmButtonText: 'Yes, Upload!'
            }).then((result) => {
                if (result.value) {
                    SweetAlert.fire({
                        position: 'center',
                        icon: 'info',
                        html: `<h4 class="mb-0">Uploading...</h4>`,
                        allowOutsideClick: true,
                        showConfirmButton: false
                    });
                    async function APIrequest() {
                        return await axios.post('/api/create/upload-psa', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                            }
                        });
                    }
                    APIrequest().then(response => {
                            $("#psa-data").html(response.data.Attachments);
                            $("#proceed-data").html(response.data.Proceed);
                            $("#file-list-psa").html('');
                            $("#file-list-psa li").html('');
                            $("#file-input-psa").val('');
                            selectedFiles = [];
                            SweetAlert.fire({
                                icon: 'success',
                                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                                confirmButtonColor: "#3a57e8"
                            });
                    });
                }
            });
        }
    });

    function updateFileList() {
        var $listElement = $('#file-list-psa');
        $listElement.empty();
        $.each(selectedFiles, function(index, file) {
            var $li = $('<li class="text-sm">');
            var $icon = $(`
            <span class="ms-3" style="vertical-align: middle;">
                <lord-icon
                    src="https://cdn.lordicon.com/ghhwiltn.json"
                    trigger="in"
                    stroke="bold"
                    style="width:25px;height:25px">
                </lord-icon>
            </span>
            `);
            $li.append($icon);
            $li.append(document.createTextNode(` ${file.name}`));
            $listElement.append($li);
        });
    }

});

$(document).on('click', "#delete-psa", function(e){
    SweetAlert.fire({
        icon: 'warning',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will remove the document permanently.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Remove it!',
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
            const data = {id: $(this).closest('li').data('value')};
            async function APIrequest() {
                return await axios.delete('/api/delete/psa', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $("#psa-data").html(response.data.Attachments);
                $("#proceed-data").html(response.data.Proceed);
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

document.addEventListener('livewire:navigated', () => { 

    var selectedFiles = [];

    $('#file-input-form').on('change', function() {
        selectedFiles = []; // Clear previous files
        $.each(this.files, function(index, file) {
            if (!selectedFiles.map(f => f.name).includes(file.name)) {
                selectedFiles.push(file);
            }
        });
        updateFileList();
    });

    $('#add-more-files-form').on('click', function() {
        var count = $('#form137-data ul').data('form137-count');
        if(count == 0)
            $('#file-input-form').click();
        else {
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss..</h4><small>You can upload a file only once. If you wish to re-upload, please remove the previously uploaded file and then select a new one.</small>`,
                confirmButtonColor: "#3a57e8"
            });
        }
    });

    $('#upload-attachments-form').on('submit', function(e) {
        e.preventDefault();
        const formData = new FormData();
        $.each(selectedFiles, function(index, file) {
            formData.append('files[]', file);
        });

        if(selectedFiles.length === 0) {
            SweetAlert.fire({
                icon: 'error',
                html: `<h4 class="mb-0">Opss..</h4><small>Please select a file to upload!</small>`,
                confirmButtonColor: "#3a57e8"
            });
        } else {
            var id = $("#id").val();
            formData.append('id', id);
            console.log(formData);
            SweetAlert.fire({
                icon: 'info',
                html: 
                `
                    <h4 class="mb-0">Are you sure?</h4>
                    <small>This will submit your attachment to the registrar.</small>
                `,
                confirmButtonColor: '#160e45',
                showCancelButton: true,
                confirmButtonText: 'Yes, Upload!'
            }).then((result) => {
                if (result.value) {
                    SweetAlert.fire({
                        position: 'center',
                        icon: 'info',
                        html: `<h4 class="mb-0">Uploading...</h4>`,
                        allowOutsideClick: true,
                        showConfirmButton: false
                    });
                    async function APIrequest() {
                        return await axios.post('/api/create/upload-form137', formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data',
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                            }
                        });
                    }
                    APIrequest().then(response => {
                            $("#form137-data").html(response.data.Attachments);
                            $("#proceed-data").html(response.data.Proceed);
                            $("#file-list-form").html('');
                            $("#file-list-form li").html('');
                            $("#file-input-form").val('');
                            selectedFiles = [];
                            SweetAlert.fire({
                                icon: 'success',
                                html: `<h4 class="mb-0">Done</h4><small>${response.data.Message}</small>`,
                                confirmButtonColor: "#3a57e8"
                            });
                    });
                }
            });
        }
    });

    function updateFileList() {
        var $listElement = $('#file-list-form');
        $listElement.empty();
        $.each(selectedFiles, function(index, file) {
            var $li = $('<li class="text-sm">');
            var $icon = $(`
            <span class="ms-3" style="vertical-align: middle;">
                <lord-icon
                    src="https://cdn.lordicon.com/ghhwiltn.json"
                    trigger="in"
                    stroke="bold"
                    style="width:25px;height:25px">
                </lord-icon>
            </span>
            `);
            $li.append($icon);
            $li.append(document.createTextNode(` ${file.name}`));
            $listElement.append($li);
        });
    }

});

$(document).on('click', "#delete-form137", function(e){
    SweetAlert.fire({
        icon: 'warning',
        html: 
        `
            <h4 class="mb-0">Are you sure?</h4>
            <small>This will remove the document permanently.</small>
        `,
        confirmButtonColor: '#160e45',
        showCancelButton: true,
        confirmButtonText: 'Yes, Remove it!',
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
            const data = {id: $(this).closest('li').data('value')};
            async function APIrequest() {
                return await axios.delete('/api/delete/form137', {
                    data: data,
                    headers: {
                        'Content-Type': 'application/json', 
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                        "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
                    }
                })
            }
            APIrequest().then(response => {
                $("#form137-data").html(response.data.Attachments);
                $("#proceed-data").html(response.data.Proceed);
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

$(document).on('click', "#proceed-review", function(e){
    SweetAlert.fire({
        position: 'center',
        icon: 'info',
        html: `<h4 class="mb-0">Processing</h4>`,
        allowOutsideClick: false,
        showConfirmButton: false
    });
    formData = new FormData();
    formData.append('_method', 'PATCH');
    formData.append('status', true);
    async function APIrequest() {
        return await axios.post('/api/update/proceed-review', formData, {
            headers: {
                'Content-Type': 'application/json', 
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                "Authorization": "Bearer " + $('meta[name="token"]').attr('content')
            }
        })
    }
    APIrequest().then(response => {
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        SweetAlert.fire({
            icon: 'error',
            html: `<h4 class="mb-0">Opss..</h4><small>Something went wrong!</small>`,
            confirmButtonColor: "#3a57e8"
        });
    });
});