<DOCTYPE html>
<html>
<head>
    <title>Upload CSV</title>
<head>
<body>
  @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
    <br>
    <a href="/">Go back to main page</a>
</body>
</head>

@php

var_dump($_FILES);

@endphp
