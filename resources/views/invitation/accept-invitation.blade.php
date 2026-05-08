<!DOCTYPE html>
<html lang="en">
  <head>
    <meta name="description" content="Vali is a responsive and free admin theme built with Bootstrap 5, SASS and PUG.js. It's fully customizable and modular.">

    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Vali Admin">
    <meta property="og:title" content="Vali - Free Bootstrap 5 admin theme">
    <meta property="og:url" content="http://pratikborsadiya.in/blog/vali-admin">
    <meta property="og:image" content="http://pratikborsadiya.in/blog/vali-admin/hero-social.png">
    <meta property="og:description" content="Vali is a responsive and free admin theme built with Bootstrap 5, SASS and PUG.js. It's fully customizable and modular.">
    <title>Form Samples - Vali Admin</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/main.css')}}">
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <!-- Page specific javascripts-->
    <link rel="stylesheet" href="https://cdn.datatables.net/v/bs5/dt-1.13.4/datatables.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/css/style.css')}}">
  </head>
  <body class="app sidebar-mini">

<main class="app-content remove-sidebar">

    <div class="row">
        <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="tile">

           @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if(session('error'))
            <div class="alert alert-error alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            @endif

            <h3 class="tile-title">Complete Your Invitation</h3>
          <div class="tile-body">
            
            <form action="{{ url('/accept-invitation') }}" method="POST" id="companyForm">
              
            @csrf
            <input type="hidden" name="token" value="{{ $invitation->token }}">
              <div class="mb-3">
                <label class="form-label">Password<span>*</span></label>
                <input class="form-control @error('password') is-invalid @enderror" name="password" type="password" placeholder="Enter Password" value="{{ old('password') }}">
                @error('password')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input class="form-control @error('password_confirmation') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Confirm Password"  value="">
                @error('password_confirmation')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror 
              </div>

              <div class="tile-footer">
                <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Submit</button>
                &nbsp;&nbsp;&nbsp;<button type="reset" class="btn btn-secondary">
                    <i class="bi bi-x-circle-fill me-2"></i>
                    Cancel
                </button>
              </div>

            </form>
          </div>

        </div>
      </div>
      <div class="col-md-3"></div>
    </div>
</main>
  <!-- Essential javascripts for application to work-->
  <script src="{{asset('assets/js/jquery-3.7.0.min.js')}}"></script>
  <script src="{{asset('assets/js/bootstrap.min.js')}}"></script>
  <script src="{{asset('assets/js/main.js')}}"></script>
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    @yield('scripts')
  
  <!-- Page specific javascripts-->
</body>
</html>


<script>
  $(function () {
      $('#companyForm').validate({
          rules: {
              name: "required",
              company_website_url: {
                  required: false,
                  url: true
              }
          },
  
          messages: {
              name: "Please enter company name",
              company_website_url: {
                  required: "Please enter website URL",
                  url: "Please enter valid URL"
              }
          }
      });
  });
  </script>
