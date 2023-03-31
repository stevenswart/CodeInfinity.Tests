<!DOCTYPE html>
<html>
<head>
    <title>Add Person</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
    <link id="bs-css" href="https://netdna.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css" rel="stylesheet">
    <link id="bsdp-css" href="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/css/bootstrap-datepicker3.min.css" rel="stylesheet">
    <style>
        .nobr { white-space: nowrap }
    </style>
</head>
<body>
  <div>
  @if(session('status'))
    <div class="alert alert-success">
        {{ session('status') }}
    </div>
  @endif
  <div>
    <div>
      Add Person
    </div>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div>
      <form name="add-person" id="add-person" method="post" action="{{url('new-person')}}"/>
       @csrf
        <div>
          <label>First Name</label>
          <input type="text" id="firstName" name="firstName" required="" value="{{ old('firstName') }}"/>
        </div>
        <div>
          <label>Last Name</label>
          <input type="text" id="lastName" name="lastName" required="" value="{{ old('lastName') }}"/>
        </div>
        <div>
          <label>South African ID Number</label>
          <input type="text" id="idNumber" name="idNumber" required="" size="13" maxlength="13 value="{{ old('idNumber') }}"/>
        </div>
        <div class="container">
            <div class="row">
                <div class='col-sm-6'>
                    <div class="form-group">
                        <div class='input-group date' id='datetimepicker1'>
                            <table><tr>
                            <td><label>Date of Birth<br>(dd/mm/yyyy)</label></td>
                            <td><input type='text' id="dob" name="dob" required="" class="form-control" size="10" maxlength="10" value="{{ old('dob') }}"/>
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span></td>
                            </tr></table>
                        </div>
                    </div>
                </div>
                <script type="text/javascript">
                    $(function () {
                        $('#datetimepicker1').datepicker({
                            format: "dd/mm/yyyy",
                            weekStart: 0,
                            calendarWeeks: true,
                            autoclose: true,
                            todayHighlight: true, 
                            orientation: "auto"
                        });
                    });
                </script>
            </div>
        </div>
        <div>
            <button type="reset">Cancel</button>
            <button type="submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
  <script src="https://unpkg.com/bootstrap-datepicker@1.9.0/dist/js/bootstrap-datepicker.min.js"></script>
</body>
</html>
