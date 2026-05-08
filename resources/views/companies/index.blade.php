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
                            class="table table-hover table-bordered"
                            id="companies_list">

                            <thead>

                                <tr>

                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>URL</th>
                                    <th>Total Users</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse($companies as $key => $company)

                                    <tr>

                                        <td>{{ ($key+1) }}</td>

                                        <td>{{ $company->name }}</td>

                                        <td><a href="{{$company->company_website_url}}" target="_blank">{{ $company->company_website_url }}</a></td>
                                        <td>{{ $company->users_count }}</td>
                                        <td>
                                            {{ $company->created_at}}
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <a class="btn btn-primary" href="{{ route('companies.edit', $company->id) }}"><i class="bi bi-pencil-square fs-5"></i></a>
                                                
                                            </div>
                                        </td>
                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="4" class="text-center">

                                            No companies found.

                                        </td>

                                    </tr>

                                @endforelse

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
<script type="text/javascript">$('#companies_list').DataTable();</script>
@endsection
