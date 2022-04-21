@extends('layout.layout')
<input type="text" name="firstname" />
@php
use App\Models\LastFm as LastFm;
session_start();

//$firstname = $_POST["firstname"];

$lastFM = new lastFm("oscartoomey1");

$_SESSION["streaming"] = "lastFM";
$_SESSION["lastfm"] = true;

header('Location: run');
die();

@endphp