<DOCTYPE html>
<html>
<head>
    <title>Generate CSV</title>
<head>
<body>
  @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
    <br>
          <a href=/storage/output.csv>Download your generated CSV file here!<a>
    <br>
    <a href="/">Go back to main page</a>
</body>
</head>
@php

use App\Console\Commands\GenerateCsv;

$genCsv = New GenerateCsv();
$genCsv->generateTheCsv(Request::input('rows'));

@endphp
