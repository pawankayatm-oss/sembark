
@extends('layouts.app')

@section('main-section')
<main class="app-content">
    <div class="app-title">
      <div>
        <h1><i class="bi bi-ui-checks"></i> Short Url</h1>
      </div>

      <ul class="app-breadcrumb breadcrumb side">
        <a href="{{route('shorturl.index')}}" class="btn btn-primary">ShortUrls List</a>
      </ul>

    </div>
    <div class="row">
        <div class="col-md-3"></div>
      <div class="col-md-6">
        <div class="tile">
          <h3 class="tile-title">Create ShortUrl</h3>


            <div class="alert alert-success alert-dismissible fade hide" id="successMessage" role="alert"></div>
            <div class="alert alert-danger alert-dismissible fade hide" id="errorMessage" role="alert"></div>


          <div class="tile-body">
            <form method="POST" id="shortUrlForm">
                @csrf
                <div class="mb-3">
                    <label class="form-label">URL</label>
                    <input class="form-control @error('original_url') is-invalid @enderror" type="text" name="original_url" placeholder="Enter url"  value="{{ old('original_url') }}">
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

    $('#shortUrlForm').validate({

        rules: {
            original_url: {
                required: true,
                url: true
            }
        },

        messages: {
            original_url: {
                required: "The url field is required.",
                url: "The url field must be a valid URL."
            }
        },

        submitHandler: function(form) {

            $('#successMessage,#errorMessage').removeClass('show');
            $('#successMessage,#errorMessage').addClass('hide');
            $('#successMessage,#errorMessage').html('');
            $('.invalid-feedback').html('');

            $.ajax({
                url: "{{ route('shorturl.store') }}",
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
