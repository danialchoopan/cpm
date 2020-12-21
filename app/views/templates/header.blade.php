<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ assets('css/style.css')}}">
    <link rel="stylesheet" href="{{ assets('css/bootstrap-rtl.min.css')}}">


    <title>@yield('title')|{{get_setting()['site_name']}}</title>
</head>
<body>
<div class=" cp-container">
    <header class="cp-header">
@include('templates.menu')