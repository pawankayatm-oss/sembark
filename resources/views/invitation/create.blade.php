@extends('layouts.app')

@section('main-section')
<main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="bi bi-ui-checks"></i> Invitation</h1>
      </div>

      <ul class="app-breadcrumb breadcrumb side">
        <a href="{{route('invitation.index')}}" class="btn btn-primary">Invitation List</a>
      </ul>

    </div>
    <div class="row">

      <div class="col-md-2"></div>
      <div class="col-md-8">
        <div class="tile">
          <h3 class="tile-title">Add Invitation</h3>

          <div class="tile-body">

            <div class="alert alert-success alert-dismissible fade hide" id="successMessage" role="alert"></div>
            <div class="alert alert-danger alert-dismissible fade hide" id="errorMessage" role="alert"></div>

            @if($errors->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form method="POST" id="userForm">
                @method('post')
                @csrf

                <div class="mb-3">
                    <label class="form-label">Name <span class="error">*</span></label>
                    <input required class="form-control @error('name') is-invalid @enderror" name="name" type="text" placeholder="Enter full name" value="{{ old('name') }}">
                    <div class="invalid-feedback"></div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="error">*</span></label>
                    <input required class="form-control @error('email') is-invalid @enderror" name="email" type="email" placeholder="Enter Your Email" value="{{ old('email') }}">
                    <div class="invalid-feedback"></div>
                </div>

              <div class="mb-3">
                <label class="form-label">Company <span class="error">*</span></label>
                <select required class="form-control @error('company_id') is-invalid @enderror" id="company_id" name="company_id"  >
                    <option value="" selected disabled>--SELECT--</option>
                  @foreach($companies as $company)
                      <option value="{{ $company->id }}" {{ old('company_id') == $company->id ? 'selected' : '' }}>
                          {{ $company->name }}
                      </option>
                  @endforeach
                </select>
                <div class="invalid-feedback"></div>
             </div>


            <div class="mb-3">
              <label class="form-label">Role <span class="error">*</span></label>
              <select required class="form-control @error('role') is-invalid @enderror" id="role" name="role" @error('role') is-invalid @enderror>
                    <option value="" selected disabled>--SELECT--</option>

                @foreach($roles as $role)
                    <option value="{{ $role }}">
                        {{ $role }}
                    </option>
                @endforeach
              </select>
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
      <div class="col-md-2"></div>
    </div>
</main>
@endsection

@section('scripts')
<script>
  $(function () {

      $('#userForm').validate({
          rules: {
              name: "required",
              email: {
                  required: true,
                  email: true
              },
              company_id: "required",
              role: "required"
          },
          messages: {
              name: "Name is required.",
              email: "Email is required.",
              company_id : "Company is required.",
              role : "Role is required."
          },
          submitHandler: function(form) {
            $('#successMessage,#errorMessage').removeClass('show');
            $('#successMessage,#errorMessage').addClass('hide');
            $('#successMessage,#errorMessage').html('');
            $('.invalid-feedback').html('');


            $.ajax({
                url: "{{ route('invitation.store') }}",
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
