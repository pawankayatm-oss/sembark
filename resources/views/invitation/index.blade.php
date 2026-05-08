@extends('layouts.app')

@section('main-section')

<main class="app-content">

    <div class="app-title">

        <div>
            <h1><i class="bi bi-table"></i> Invitation List</h1>
        </div>

        <ul class="app-breadcrumb breadcrumb side">
            <a href="{{route('invitation.create')}}" class="btn btn-primary">Add Invitee</a>
          </ul>
    </div>

    <div class="row">

        <div class="col-md-12">

            <div class="tile">

                <div class="tile-body">
                    @if(session('invite-success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('invite-success') }}
                        <br>
                        <small>
                            Note: If you haven't received the email, please contact the admin or use the invitation link manually.
                        </small>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                  @endif
                    <div class="table-responsive">

                        <table
                            class="table table-hover table-bordered"
                            id="invitation_list">

                            <thead>

                                <tr>

                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Invitee Url</th>
                                    <th>Action</th>
                                </tr>

                            </thead>

                            <tbody>

                                @forelse($invitation_list as $key => $invitee)

                                    <tr>
                                        <td>{{ ($key+1) }}</td>
                                        <td>{{ $invitee->name }}</td>
                                        <td>{{ $invitee->email }}</td>
                                        <td>{{ $invitee->role }}</td>
                                        <td>
                                            @if($invitee->accept_status != 0)
                                            <badge class="badge badge-info text-primary">Accepted</badge>
                                            @else
                                            <badge class="badge badge-info text-warning">Pending</badge>
                                            @endif
                                        <td>{{ url('/accept-invitation/'.$invitee->token) }}</td>
                                        <td>
                                            @if($invitee->accept_status == 0)
                                            <a href="{{url('/accept-invitation/'.$invitee->token)}}" class="btn btn-primary btn-sm" target="_blank">
                                                <i class="bi bi-share fs-5"></i>
                                            </a>
                                            @endif
                                        </td>
                                    </tr>

                                @empty

                                    <tr>

                                        <td colspan="4" class="text-center">

                                            No Invitee found.

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
<script type="text/javascript">$('#invitation_list').DataTable();</script>
@endsection
