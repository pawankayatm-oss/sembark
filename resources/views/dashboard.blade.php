@extends('layouts.app')

@section('main-section')
<main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="bi bi-speedometer"></i> Dashboard</h1>
      </div>
    </div>
    <div class="row">

        @role('SuperAdmin')
            <div class="col-md-6 col-lg-3">
                <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
                <div class="info">
                    <h4>Companies</h4>
                    <p><b>{{ $companyCount }}</b></p>
                </div>
                </div>
            </div>
        @endrole

        @role('SuperAdmin|Admin')
            <div class="col-md-6 col-lg-3">
                <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
                <div class="info">
                    <h4>Invited Users</h4>
                    <p><b>{{ $totalInvitedUsrs }}</b></p>
                </div>
                </div>
            </div>
        @endrole


            <div class="col-md-6 col-lg-3">
                <div class="widget-small primary coloured-icon"><i class="icon bi bi-people fs-1"></i>
                <div class="info">
                    <h4>Short Urls</h4>
                    <p><b>{{ $totalShortUrls }}</b></p>
                </div>
                </div>
            </div>

    </div>

  </main>
@endsection
