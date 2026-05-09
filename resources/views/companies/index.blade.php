@extends('layouts.app')

@section('main-section')

<main class="app-content">

    <div class="app-title">

        <div>
            <h1><i class="bi bi-table"></i> Companies List</h1>
        </div>

        <ul class="app-breadcrumb breadcrumb side">
            <a href="{{route('companies.create')}}" class="btn btn-primary">Add Company</a>
          </ul>
    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body">

                    <div class="table-responsive">

                        <table
                            class="table table-hover table-bordered" id="companies_list">

                            <thead>

                                <tr>

                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Total Users</th>
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
    $('#companies_list').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('companies.index') }}",

        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'company_website_url',
                name: 'company_website_url'
            },
            {
                data: 'users_count',
                name: 'users_count'
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
