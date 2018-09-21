<!-- @if(count($errors) > 0 )
  @foreach($errors->all() as $error)
    <div class ="alert alert-danger">
      {{$error}}
    </div>
  @endforeach
@endif -->

@if(count($errors) > 0 )
    <div class="alert alert-danger alert-dismissible fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        @foreach($errors->all() as $error)
            <strong>{{ $error }}</strong></br>
        @endforeach
    </div>
@endif
