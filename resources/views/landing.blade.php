@extends('layouts.app')

@section('content')
<div id="app">
    <app></app>
</div>

<noscript>
    This website relies on JavaScript, which you appear to have disabled. You will not be
    able to use many of this website's features without JavaScript enabled.
</noscript>
@endsection

@section('assignAccessToken')
<?php 
if (session()->has('fhive')){
    echo "
    <script type='text/javascript'>
        localStorage.setItem('fhive.jwt', '".session('fhive.jwt') ."')
        localStorage.setItem('fhive.user', '". session('fhive.user') ."')
        alert(localStorage.getItem('fhive.jwt'))
    </script>";
}
?>
@endsection