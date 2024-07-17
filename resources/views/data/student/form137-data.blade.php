<div id="form137-data" class="mt-4">
    <ul class="list-unstyled" data-form137-count="{{ $form137->count() }}">
    @php
        $count = false;
    @endphp
    @foreach ($form137 as $fr)
       
        <li class="mb-4 text-center" data-value="{{ $aes->encrypt($fr->id) }}">
            <span class="" style="vertical-align: middle;">
                <lord-icon
                    src="https://cdn.lordicon.com/yqiuuheo.json"
                    trigger="in"
                    delay="0"
                    state="in-unfold"
                    colors="primary:#ffffff,secondary:#66d7ee"
                    style="width:25px;height:25px">
                </lord-icon>
            </span>
            <a class="" href="{{ asset('storage/documents/Form137/'.$fr->filename) }}" target="_blank">
                <small class="text-dark">{{ $fr->filename }}</small>
                <div>
                    <small class="text-xs fw-normal">Date Submitted: {{ date('M. d, Y | h:i a', strtotime($fr->created_at)) }}</small>
                </div>
            </a>
            <div class="text-sm mt-2"><a href="javascript:;" class="text-danger" id="delete-form137"><small><i class="fas fa-times"></i> Remove</small></a></div>
            <hr class="my-1">
        </li>
        @php
            $count = true;
        @endphp
    @endforeach
    @if ($count == false)
        <div class="text-danger text-sm text-center">No Submissions Yet</div>
    @endif
    </ul>
</div>
