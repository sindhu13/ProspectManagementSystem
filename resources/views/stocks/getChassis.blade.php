<option>--- Select State ---</option>
@if(!empty($stocks))
    @foreach($stocks as $key => $value)
        <option value="{{ $key }}">{{ $value }}</option>
    @endforeach
@endif
