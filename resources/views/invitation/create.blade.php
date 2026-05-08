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

            @if(session('success'))
              <div class="alert alert-success alert-dismissible fade show" role="alert">
                  {{ session('success') }}
          
                  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
              </div>
            @endif


            @if($errors->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ $errors->first('error') }}
            
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <form action="{{ route('invitation.store') }}" method="POST" id="userForm">
                @method('post')
                @csrf

                <div class="mb-3">  
                    <label class="form-label">Name <span class="error">*</span></label>
                    <input required class="form-control @error('name') is-invalid @enderror" name="name" type="text" placeholder="Enter full name" value="{{ old('name') }}">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label class="form-label">Email <span class="error">*</span></label>
                    <input required class="form-control @error('email') is-invalid @enderror" name="email" type="email" placeholder="Enter Your Email" value="{{ old('email') }}">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
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
                @error('company_id')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
              @enderror
             </div>


            <div class="mb-3">
              <label class="form-label">Role <span class="error">*</span></label>
              <select required class="form-control @error('role') is-invalid @enderror" id="role" name="role" @error('role') is-invalid @enderror>
                @foreach($roles as $role)
                    <option value="{{ $role }}">
                        {{ $role }}
                    </option>
                @endforeach
              </select>
              @error('role')
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
          }
      });
  
  });
  </script>
@endsection