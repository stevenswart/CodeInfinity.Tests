<DOCTYPE html>
<html>
<head>
    <title>Success!</title>
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
