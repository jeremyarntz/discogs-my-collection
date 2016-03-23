@extends('layouts.master')

@section('content')
  @foreach ($releases['releases'] as $release)
    <div>
      <img src="{{ $release['thumb'] }}" height="50px" width="50px" />
      {{ $release['artists'] }} - {{ $release['title'] }} {{ $release['year'] }}
    </div>
  @endforeach
@endsection
