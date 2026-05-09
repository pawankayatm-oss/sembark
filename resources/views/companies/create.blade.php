@extends('layouts.app')

@section('main-section')
<main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="bi bi-ui-checks"></i> Company</h1>
      </div>

      <ul class="app-breadcrumb breadcrumb side">
        <a href="{{route('companies.index')}}" class="btn btn-primary">Company List</a>
      </ul>

    </div>
    <div class="row">
        <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">Add Company</h3>

            <div class="alert alert-success alert-dismissible fade hide" id="successMessage" role="alert"></div>
            <div class="alert alert-danger alert-dismissible fade hide" id="errorMessage" role="alert"></div>


          <div class="tile-body">
            <form method="POST" id="companyForm">

                @csrf

              <div class="mb-3">
                <label class="form-label">Company Name <span>*</span></label>
                <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" placeholder="Enter company name" value="{{ old('name') }}">
                <div class="invalid-feedback"></div>
              </div>

              <div class="mb-3">
                <label class="form-label">URL</label>
                <input class="form-control @error('company_website_url') is-invalid @enderror" type="text" name="company_website_url" placeholder="Enter website url"  value="{{ old('company_website_url') }}">
                <div class="invalid-feedback"></div>
              </div>

              <div class="tile-footer">
                <button class="btn btn-primary" type="submit" id="submitBtn"><i class="bi bi-check-circle-fill me-2"></i>Submit</button>
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
@endsection


@section('scripts')
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
          },
        submitHandler: function(form) {

            $('#successMessage,#errorMessage').removeClass('show');
            $('#successMessage,#errorMessage').addClass('hide');
            $('#successMessage,#errorMessage').html('');
            $('.invalid-feedback').html('');

            $.ajax({
                url: "{{ route('companies.store') }}",
                type: "POST",
                data: $(form).serialize(),

                beforeSend: function () {
                    $('#submitBtn').html('<span class="spinner-border spinner-border-sm"></span> Processing...').prop('disabled', true);
                },

                success: function(response) {
                    if(response.status == true){
                        $('#successMessage').removeClass('hide');
                        $('#successMessage').addClass('show');
                        $('#successMessage').html(response.message);
                        form.reset();
                    }else{
                        $('#errorMessage').removeClass('hide');
                        $('#errorMessage').addClass('show');
                        $('#errorMessage').html(response.message);
                    }
                },

                error: function(xhr) {
                    if(xhr.status === 422){
                        var errors = xhr.responseJSON.errors;
                        $.each(errors, function(key, value){
                            $('[name="'+key+'"]').addClass('is-invalid');
                            $('[name="'+key+'"]').next('.invalid-feedback').html(value[0]);
                        });
                    }
                },

                complete: function () {
                    $('#submitBtn').html('<i class="bi bi-check-circle-fill me-2"></i>Submit').prop('disabled', false);
                }

            });

        }

      });

  });
  </script>
@endsection
