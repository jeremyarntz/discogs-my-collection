@extends('layouts.master')

@section('content')
  <div class="btn-group" role="group" aria-label="...">
  @foreach ($data['folders'] as $folder)
    @if ($folder['id'] == $data['collection']['folder'])
      <a class="btn btn-primary" href="#" role="button">{{ $folder['name'] }}</a>
    @else
      <a class="btn btn-default" href="/{{ $folder['id'] }}/1/" role="button">{{ $folder['name'] }}</a>
    @endif
  @endforeach
  </div>

  <table class="table table-striped">
    <thead>
      <tr>
        <th>&nbsp;</th>
        <th>Title</th>
        <th>Artist</th>
        <th>Year</th>
      </tr>
    </thead>
  @foreach ($data['collection']['releases'] as $release)
    <tr>
      <td><img src="{{ $release['thumb'] }}" height="50px" width="50px" /></td>
      <td>{{ $release['title'] }}</td>
      <td>{{ $release['artists'] }}</td>
      <td>{{ $release['year'] }}</td>
    </tr>
  @endforeach
  </table>

  <div style="text-align: center;">
    <ul class="pagination" style="display: inline-block;">
    @for ($i = 1; $i <= $data['collection']['pages']; $i++)
      @if ($i === $data['collection']['page'])
        <li class="active"><a href="/{{ $i }}">{{ $i }}</a></li>
      @else
        <li><a href="/{{ $data['collection']['folder'] }}/{{ $i }}">{{ $i }}</a></li>
      @endif
    @endfor
    </ul>
  </div>
@endsection
