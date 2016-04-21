@extends('layouts.master')

@section('content')
  	<table class="table table-striped">
    	<thead>
      		<tr>
        		<th>&nbsp;</th>
        		<th>Track</th>
        		<th>Artist</th>
        		<th>Album</th>
      		</tr>
    	</thead>
  		@foreach ($data['data'] as $release)
    		<tr>
      			<td><img src="{{ $release['image'] }}" height="50px" width="50px" /></td>
      			<td>{{ $release['name'] }}</td>
      			<td>{{ $release['artist']['name'] }}</td>
      			<td>{{ $release['album'] }}</td>
    		</tr>
  		@endforeach
  	</table>

	@if ($data['pagination']['totalPages'] > 1)
   	<div style="text-align: center;">
    	<ul class="pagination" style="display: inline-block;">
    	@for ($i = 1; $i <= $data['pagination']['totalPages']; $i++)
    		@if ($i <= 20)
      			@if ($i == $data['pagination']['page'])
        			<li class="active"><a href="/recent/songs/{{ $i }}">{{ $i }}</a></li>
      			@else
        			<li><a href="/recent/{{ $i }}">{{ $i }}</a></li>
      			@endif
      		@endif
    	@endfor
   		 </ul>
  	</div>
 	@endif
@endsection