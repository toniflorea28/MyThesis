<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- <link rel="icon" href="<%= BASE_URL %>favicon.ico"> -->

  <title>Workbook</title>

  <!-- Splash Screen/Loader Styles -->
  <link rel="stylesheet" type="text/css" href="{{ asset(mix('css/loader.css')) }}" />

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}">

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('logo.png') }}">

  <!-- Font -->
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400&display=swap"
    rel="stylesheet">
</head>

<body>
  <noscript>
    <strong>Ne pare rău, Workbook nu funcționează pe un dispozitiv fără JavaScript.</strong>
  </noscript>
  <div id="loading-bg">
    <div class="loading-logo">
      <img src="{{ asset('logo.png') }}" alt="Logo" />
    </div>
    <div class="loading">
      <div class="effect-1 effects"></div>
      <div class="effect-2 effects"></div>
      <div class="effect-3 effects"></div>
    </div>
  </div>
  <div id="app">
  </div>

  <script src="{{ asset(mix('js/app.js')) }}"></script>
  <script>window.Laravel = {csrfToken: '{{ csrf_token() }}'}</script>
</body>

</html>
