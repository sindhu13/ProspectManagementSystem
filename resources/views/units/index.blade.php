{{-- \resources\views\units\index.blade.php --}}
@extends('layouts.app')

@section('title', '| Units')

@section('content')

<div class="col-lg-10 col-lg-offset-1">
  <h1><i class="fa fa-users"></i> Units <a href="{{ route('units.create') }}" class="btn btn-default pull-right">Add Units</a></h1>
  <hr>
  <div class="table-responsive">
      <table class="table table-bordered table-striped">

          <thead>
              <tr>
                <th>No</th>
                <th>Unit</th>
                <th>Katashiki</th>
                <th>Suffix</th>
                <th>Last Modified</th>
                <th>Operations</th>
              </tr>
          </thead>

          <tbody>
              @php ($i = 0)
              @foreach ($units as $unit)
              @php ($i++)
              <tr>
                <td>{{ $i }}</td>
                <td>{{ $unit->unit }}</td>
                <td>{{ $unit->katashiki }}</td>
                <td>{{ $unit->suffix }}</td>
                <td>{{ date('d m Y', strtotime($unit->created_at))}}</td>
                <td>
                <a href="{{ route('units.edit', $unit->id) }}" class="btn btn-info pull-left" style="margin-right: 3px;">Edit</a>

                {!! Form::open(['method' => 'DELETE', 'route' => ['units.destroy', $unit->id], 'class' => 'delete' ]) !!}
                {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}

                </td>
              </tr>
              @endforeach
          </tbody>
      </table>
      <div class="text-center">
          {!! $units->links() !!}
      </div>
  </div>
</div>

<script>
  $(".delete").on("submit", function(){
    return confirm("Do you want to delete this item ?");
  });
</script>
@endsection
