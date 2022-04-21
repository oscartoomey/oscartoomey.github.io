@extends('layout.layout')
@php 
use App\Http\Controllers\UserController;
@endphp

<h1>
  Choose a streaming service:
</h1>
Spotify and LastFM recommended for best analysis

<div class="boxes">
  <a class="btn btn-outline-dark" href="/project/public/signin"> <img src = img/spotify.png alt="logo" height=100> </a>
  <a class="btn btn-outline-dark" href="/project/public/lastfm"> <img src = img/lastfm.png alt="logo" height=100></a>
</div>
