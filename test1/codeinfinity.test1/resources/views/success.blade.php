<DOCTYPE html>
<html>
<head>
    <title>Successfully Added Person</title>
<head>
<body>
  @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
    <br>
    <a href="/add-person">Add another person</a>
</body>
</head>