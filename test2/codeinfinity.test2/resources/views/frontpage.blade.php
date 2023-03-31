<!DOCTYPE html>
<html>
<head>
    <title>CSV File Generation and Importing</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
      Generate or Import CSV Files
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
      Welcome! What do you want to do?
    </div>
    <br/><br/><br/>
    <div>
      Generate a new CSV file?
    </div>
    <div>
      <form name="generate-csv" id="generate-csv" method="post" action="{{url('generate-csv')}}"/>
       @csrf
        <div>
          <label>How many rows would you like to generate?</label>
          <input type="text" id="rows" name="rows" required="" value="{{ old('rows') }}"/>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
      </form>
    </div>
    <br/><br/><br/>
    <div>
    Or, upload a local CSV file to import to an SQLite database?
    </div>
    <div>
      <form name="upload-csv" id="upload-csv" method="post" action="{{url('upload-csv')}}" enctype="multipart/form-data"/>
       @csrf
        <div>
          <label>Please select a file from you local device to upload?</label>
          <input type="file" id="file" name="file" required="" value="{{ old('file') }}"/>
        </div>
        <div>
            <button type="submit">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
