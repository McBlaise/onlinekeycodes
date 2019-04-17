{{--   <form action="/locksmith/maxlevel" method="POST" enctype="multipart/form-data" id="upload">
      <input type="hidden" name="_token" value="{{ csrf_token() }}">
      <div class="row">
        <div class="col-md-10 offset-md-1">
          <div class="row">
          <div class="col-md-6">
            <input type="file" name="file[]" multiple="true" class="form-control form-control-sm">
          </div>

          </div>
        </div>
      </div>

      <div class="text-center pad-top">
        <button type="submit" class="btn btn-info">Upload</button>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>

    </form> --}}

<form action="/resetPass" method="POST">
  Email: <input type="email" name="email">
  <button type="submit">Submit</button>
</form>