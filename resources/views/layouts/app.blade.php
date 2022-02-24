<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'User Signup') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <script src="https://api.tiles.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.js"></script>
<link
href="https://api.tiles.mapbox.com/mapbox-gl-js/v2.6.1/mapbox-gl.css"
rel="stylesheet"
/>
<script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.min.js"></script>
<link
rel="stylesheet"
href="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.7.0/mapbox-gl-geocoder.css"
type="text/css"
/>
<style>
body {
margin: 0;
padding: 0;
}

</style>

</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">


                <div class="collapse navbar-collapse" id="navbarSupportedContent">


                    <!-- Right Side Of Navbar -->
                    <div class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @guest
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                                </li>
                            @endif

                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else

                               <!-- <div style="align:left"><h3>User Created Successfully</h3></div>
                                <div>{{ Auth::user()->name }} <br><br>
                                {{ Auth::user()->email }}<br></div>-->

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown" style="padding-bottom:30px;">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>

                        @endguest
                    </div>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
    @if (Route::has('register'))
    <div style="width:250px;height:250px;position:relative; padding-left:50px;float:right;" id="map"></div>
    @endif
 <script>
 mapboxgl.accessToken = 'pk.eyJ1IjoiYmhhcmdhdmkxMjM0NTYiLCJhIjoiY2wwMGNkdGc5MGl5OTNjczB1cDFqdmN2OSJ9.NJNLcP7HBK3sao0p7TkrJw';
 const map = new mapboxgl.Map({
 container: 'map', // Container ID
 style: 'mapbox://styles/mapbox/streets-v11', // Map style to use
 center: [-122.25948, 37.87221], // Starting position [lng, lat]
 zoom: 12 // Starting zoom level
 });

 const marker = new mapboxgl.Marker() // Initialize a new marker
 .setLngLat([-122.25948, 37.87221]) // Marker [lng, lat] coordinates
 .addTo(map); // Add the marker to the map

 const geocoder = new MapboxGeocoder({
 // Initialize the geocoder
 accessToken: mapboxgl.accessToken, // Set the access token
 mapboxgl: mapboxgl, // Set the mapbox-gl instance
 marker: false, // Do not use the default marker style
 placeholder: 'Search for places in Berkeley', // Placeholder text for the search bar
 bbox: [-122.30937, 37.84214, -122.23715, 37.89838], // Boundary for Berkeley
 proximity: {
 longitude: -122.25948,
 latitude: 37.87221
 } // Coordinates of UC Berkeley
 });

 // Add the geocoder to the map
 map.addControl(geocoder);

 // After the map style has loaded on the page,
 // add a source layer and default styling for a single point
 map.on('load', () => {
 map.addSource('single-point', {
 'type': 'geojson',
 'data': {
 'type': 'FeatureCollection',
 'features': []
 }
 });

 map.addLayer({
 'id': 'point',
 'source': 'single-point',
 'type': 'circle',
 'paint': {
 'circle-radius': 10,
 'circle-color': '#448ee4'
 }
 });

 // Listen for the `result` event from the Geocoder // `result` event is triggered when a user makes a selection
 //  Add a marker at the result's coordinates
 geocoder.on('result', (event) => {
 map.getSource('single-point').setData(event.result.geometry);
 });
 });
 </script>
</body>
</html>
