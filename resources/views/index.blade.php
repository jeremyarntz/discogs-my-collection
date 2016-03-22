@foreach ($releases as $release)
  <div>
    <img src="{{ $release['basic_information']['thumb'] }}" height="50px" width="50px" />
    {{ $release['basic_information']['artists'][0]['name'] }} - {{ $release['basic_information']['title'] }}
  </div>
@endforeach
