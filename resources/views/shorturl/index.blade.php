@extends('layouts.app')

@section('main-section')

<main class="app-content">

    <div class="app-title">

        <div>
            <h1><i class="bi bi-table"></i> ShortUrls List</h1>
        </div>

            @role('Admin|Member')
        <ul class="app-breadcrumb breadcrumb side">
            <a href="{{route('shorturl.create')}}" class="btn btn-primary">Add ShortUrl</a>
          </ul>
          @endrole
    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body">

                    @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}

                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endif

                    @session('error')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                    @endsession

                    <div class="table-responsive">

                        <table class="table table-hover table-bordered" id="shorturl_list">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Original Url</th>
                                    <th>Short Url</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</main>

@endsection

@section('scripts')
<script>
$(document).on('click', '.copy-btn', function () {

     var shorturl = $(this).data('copy');
     var createShortUrlWithCode = "{{url('/u')}}"+'/'+shorturl;
    var $temp = $("<input>");
    $("body").append($temp);
    $temp.val(createShortUrlWithCode).select();
    document.execCommand("copy");
    $temp.remove();
    alert('Url Copied');
});
</script>

<script>
    $('#shorturl_list').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('shorturl.index') }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'original_url',
                name: 'original_url'
            },
            {
                data: 'short_url',
                name: 'short_url'
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });
</script>

@endsection
