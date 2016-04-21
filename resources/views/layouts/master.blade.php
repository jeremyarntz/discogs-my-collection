<html>
  <head>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <title>My Collection</title>
  </head>
  <body>
    <div style="width: 960px; margin: 0 auto;">Header</div>
    <div style="width: 960px; margin: 0 auto;">
      <div style="float: left; width: 20%;">
        <a href="/">My Collection</a>
      </div>

      <div style="float: left; width: 20%;">
        What I'm listening to:
      </div> 

      <div style="float: left; width: 15%; text-align: center;">
        <a href="/recent">Recent Songs</a>
      </div>

      <div style="float: left; width: 15%; text-align: center;">
        <a href="/recent/albums">Top Albums</a>
      </div>

      <div style="float: left; width: 15%; text-align: center;">
        <a href="/recent/artists">Top Artists</a>
      </div>

      <div style="float: left; width: 15%; text-align: center;">
        <a href="/recent/songs">Top Songs</a>
      </div>
    </div>
    <div style="width: 960px; margin: 0 auto;">
        @yield('content')
    </div>
    <div style="width: 960px; margin: 0 auto;">Footer</div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
  </body>
</html>
