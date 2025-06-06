<div class="col-md-12">
    <div class="card">
        <div class="card-header">
            <h6>Upload Required Documents</h6>
            <hr class="my-2">
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6 mb-4">
                    <div class="alert alert-solid-danger alert-dismissible d-flex align-items-center" role="alert">
                        <div>
                            <i class='bx bxs-info-circle me-1' ></i>
                            <small>
                                Please attach a scanned PDF file or a clear picture of your NSO/PSA Birth Certificate. Make sure the document is legible and all details are clearly visible.
                            </small>
                        </div>
                    </div>

                    <label for="" style="font-size: 12px">PSA/NSO/Birth Certificate</label>
                    <input type="file" class="form-control mb-4 d-none" accept=".jpg, .pdf" id="file-input-psa">
                    <button type="button" class="btn btn-sm w-100 mb-1" id="add-more-files-psa">
                        <span class="ms-3" style="vertical-align: middle;">
                        <lord-icon
                            src="https://cdn.lordicon.com/dxnllioo.json"
                            trigger="in"
                            stroke="bold"
                            style="width:25px;height:25px">
                        </lord-icon>
                        </span>
                        Choose a File</button>
                    <hr class="my-0">
                    <form id="upload-attachments-psa" class="mt-0" enctype="multipart/form-data">
                    @csrf
                        <ul id="file-list-psa" class="list-unstyled my-3 text-start"></ul>
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-primary">Upload File</button>
                        </div>
                    </form>

                    <div>
                        @include('data.student.psa-data')
                    </div>

                </div>
                <div class="col-md-6 mb-4">
                    <div class="alert alert-solid-danger alert-dismissible d-flex align-items-center" role="alert">
                        <div>
                            <i class='bx bxs-info-circle me-1' ></i>
                            <small>
                                Please attach a scanned PDF file or a clear picture of your Form 137. Make sure the document is legible and all details are clearly visible.
                            </small>
                        </div>
                    </div>

                    <label for="" style="font-size: 12px">Form 137</label>
                    <input type="file" class="form-control mb-4 d-none" accept=".jpg, .pdf" id="file-input-form">
                    <button type="button" class="btn btn-sm w-100 mb-1" id="add-more-files-form">
                        <span class="ms-3" style="vertical-align: middle;">
                        <lord-icon
                            src="https://cdn.lordicon.com/dxnllioo.json"
                            trigger="in"
                            stroke="bold"
                            style="width:25px;height:25px">
                        </lord-icon>
                        </span>
                        Choose a File</button>
                    <hr class="my-0">
                    <form id="upload-attachments-form" class="mt-0" enctype="multipart/form-data">
                    @csrf
                        <ul id="file-list-form" class="list-unstyled my-3 text-start"></ul>
                        <div class="text-center">
                            <button type="submit" class="btn btn-sm btn-primary">Upload File</button>
                        </div>
                    </form>

                  <!--  <script>
                        document.addEventListener('livewire:navigated', () => { 
                        const compressImage = async (file, {
                            quality = 1,
                            type = file.type
                        }) => {
    
                            const imageBitmap = await createImageBitmap(file);
    
                            const canvas = document.createElement('canvas');
                            canvas.width = imageBitmap.width;
                            canvas.height = imageBitmap.height;
                            const ctx = canvas.getContext('2d');
                            ctx.drawImage(imageBitmap, 0, 0);
    
                            const blob = await new Promise((resolve) =>
                                canvas.toBlob(resolve, type, quality)
                            );
    
                            return new File([blob], file.name, {
                                type: blob.type,
                            });
                        };
    
                        const handleFileInputChange = async (e) => {
                            const {
                                files
                            } = e.target;
    
                            if (!files.length) return;
    
                            const dataTransfer = new DataTransfer();
    
                            for (const file of files) {
    
                                if (!file.type.startsWith('image')) {
    
                                    dataTransfer.items.add(file);
                                    continue;
                                }
    
                                const compressedFile = await compressImage(file, {
                                    quality: 0.3,
                                    type: 'image/jpeg'
                                });
    
                                dataTransfer.items.add(compressedFile);
                            }
    
                            e.target.files = dataTransfer.files;
                        };
    
                        const fileInputs = [
                            document.querySelector('#file-input-form'),
                            
                        ];
    
                        fileInputs.forEach(input => {
                            input.addEventListener('change', handleFileInputChange);
                        });
                    });
                    </script> -->

                    <div>
                        @include('data.student.form137-data')
                    </div>

                </div>
                
                @include('data.student.proceed-data')
            

            </div>
        </div>
    </div>
</div>