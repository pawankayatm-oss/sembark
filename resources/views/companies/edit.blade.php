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
          <h3 class="tile-title">Update Company</h3>
          @if(session('success'))
          <div class="alert alert-success alert-dismissible fade show" role="alert">
              {{ session('success') }}
      
              <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
          </div>
      @endif

          <div class="tile-body">
            <form action="{{ route('companies.update', $company->id) }}" method="POST" id="companyForm">
              
                @csrf
                @method('PUT')

              <div class="mb-3">
                <label class="form-label">Company Name <span>*</span></label>
                <input class="form-control @error('name') is-invalid @enderror" name="name" type="text" placeholder="Enter company name" value="{{ old('name', $company->name) }}">
                @error('name')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror
              </div>

              <div class="mb-3">
                <label class="form-label">URL</label>
                <input class="form-control @error('company_website_url') is-invalid @enderror" type="text" name="company_website_url" placeholder="Enter website url"  value="{{ old('company_website_url', $company->company_website_url) }}">
                @error('company_website_url')
                  <div class="invalid-feedback">
                      {{ $message }}
                  </div>
                @enderror 
              </div>

              <div class="tile-footer">
                <button class="btn btn-primary" type="submit"><i class="bi bi-check-circle-fill me-2"></i>Update</button>
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
          }
  
      });
  
  });
  </script>
@endsection