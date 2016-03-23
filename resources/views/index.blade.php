@extends('layouts.master')

@section('content')
  <table class="table table-striped">
    <thead>
      <tr>
        <th>&nbsp;</th>
        <th>Title</th>
        <th>Artist</th>
        <th>Year</th>
      </tr>
    </thead>
  @foreach ($releases['releases'] as $release)
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
    @for ($i = 1; $i <= $releases['pages']; $i++)
      @if ($i === $releases['page'])
        <li class="active"><a href="/{{ $i }}">{{ $i }}</a></li>
      @else
        <li><a href="/{{ $i }}">{{ $i }}</a></li>
      @endif
    @endfor
    </ul>
  </div>
@endsection
