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

use App\Console\Commands\ImportGeneratedCsv;

/*
 * Uncomment this section to debug file uploads, if the file uploading feature is not working properly.
 */

/*

print_r($_FILES);

 // Check to see if POST was used and that its content length is less than // the value in post_max_size

$requestType = $_SERVER['REQUEST_METHOD'];
if($requestType != 'POST'){
    echo 'Request type was ' . $requestType . ' - File uploads will only work with POST. Are you using method="post" in your form element?<br>';
    exit;
} else{

    if(isset($_SERVER['CONTENT_TYPE'])){
        $contentType = strtolower($_SERVER['CONTENT_TYPE']);
        if(!stristr($contentType, 'multipart/form-data')){
            echo 'Could not find multipart/form-data in Content-Type. Did you use enctype="multipart/form-data" in your form element?<br>';
        }
    }

    if(isset($_SERVER['CONTENT_LENGTH'])){
        $postSize = $_SERVER['CONTENT_LENGTH'];
        $maxPostSize = ini_get('post_max_size');
        if($maxPostSize == 0){
            echo 'post_max_size is set to 0 - unlimited.<br>';
        } else{
            if(strlen($maxPostSize) > 1){
                $lastChar = substr($maxPostSize, -1);
                $maxPostSize = substr($maxPostSize, 0, -1);
                if($lastChar == 'G'){
                    $maxPostSize = $maxPostSize * 1024 * 1024 * 1024;
                }
                if($lastChar == 'M'){
                    $maxPostSize = $maxPostSize * 1024 * 1024;
                }
                if($lastChar == 'K'){
                    $maxPostSize = $maxPostSize * 1024;
                }
                if($postSize > $maxPostSize){
                    echo 'The size of the POST request (' . $postSize . ' bytes) exceeded the limit of post_max_size (' . $maxPostSize . ' bytes) in your php.ini file<br>';
                    exit;
                }
            } else{
                if($postSize > $maxPostSize){
                    echo 'The size of the POST request (' . $postSize . ' bytes) exceeded the limit of post_max_size (' . $maxPostSize . ' bytes) in your php.ini file<br>';
                    exit;
                }
            }

        }
    } else{
        echo 'CONTENT_LENGTH not found. Make sure that your POST request is smaller than the ' . ini_get('post_max_size') . ' post_max_size in php.ini<br>';
    }
}


$tempFolder = ini_get('upload_tmp_dir');
if(strlen(trim($tempFolder)) == 0){
    echo 'upload_tmp_dir was blank. No temporary upload directory has been set in php.ini<br>';
    exit;
} else{
    echo 'upload_tmp_dir is set to: ' . $tempFolder . '<br>';
}

if(!is_dir($tempFolder)){
    echo 'The temp upload directory specified in upload_tmp_dir does not exist: ' . $tempFolder . '<br>';
    exit;
} else{
    echo $tempFolder . ' is a valid directory<br>';
}

if(!is_writable($tempFolder)){
    echo 'The temp upload directory specified in upload_tmp_dir is not writeable: ' . $tempFolder . '<br>';
    echo 'Does PHP have permission to write to this directory?<br>';
    exit;
} else{
    echo $tempFolder . ' is writeable<br>';
}

$write = file_put_contents($tempFolder . '/' . uniqid(). '.tmp', 'test');
if($write === false){
    echo 'PHP could not create a file in ' . $tempFolder . '<br>';
    exit;
} else{
    echo 'PHP successfully created a test file in: ' . $tempFolder . '<br>';
}

if(ini_get('file_uploads') == 1){
    echo 'The file_uploads directive in php.ini is set to 1, which means that your PHP configuration allows file uploads<br>';
} else{
    echo 'The file_uploads directive in php.ini has been set to 0 - Uploads are disabled on this PHP configuration.<br>';
    exit;
}

if(empty($_FILES)){
    echo 'The $_FILES array is empty. Is your form using method="post" and enctype="multipart/form-data"? Did the size of the file exceed the post_max_size in PHP.ini?';
    exit;
} else{
    foreach($_FILES as $file){
        if($file['error'] !== 0){
            echo 'There was an error uploading ' . $file['name'] . '<br>';
            switch($file['error']){
                case 1:
                    echo 'Size exceeds the upload_max_filesize directive in php.ini<br>';
                    break;
                case 2:
                    echo 'Size exceeds the MAX_FILE_SIZE field in your HTML form<br>';
                    break;
                case 3:
                    echo 'File was only partially uploaded<br>';
                    break;
                case 4:
                    echo 'No file was selected by the user<br>';
                    break;
                case 6:
                    echo 'PHP could not find the temporary upload folder<br>';
                    break;
                case 7:
                    echo 'PHP failed to write to disk. Possible permissions issue?<br>';
                    break;
                case 8:
                    echo 'A PHP extension prevented the file from being uploaded.<br>';
                    break;
                default:
                    echo 'An unknown error occured: ' . $file['error'] . '<br>';
                    break;
            }
        } else{
            echo $file['name'] . ' was successfully uploaded to ' . $file['tmp_name'] . '<br>';
        }
    }
}

  */

if (!isset($_FILES["file"])) {
    die("There is no file to upload.");
}

$filepath = $_FILES['file']['tmp_name'];
$fileSize = filesize($filepath);
$fileinfo = finfo_open(FILEINFO_MIME_TYPE);
$filetype = finfo_file($fileinfo, $filepath);

if ($fileSize === 0) {
    die("The file is empty.");
}

if ($fileSize > 52428800) { // 50 MB (1 byte * 1024 * 1024 * 50 (for 50 MB))
    die("The file is too large");
}

$allowedTypes = [
   'text/plain' => 'csv',
];


if (!in_array($filetype, array_keys($allowedTypes))) {
    die("File not allowed.");
}

$filename = basename($filepath); // I'm using the original name here, but you can also change the name of the file here
$extension = $allowedTypes[$filetype];
$targetDirectory = __DIR__ . "/../../../storage/app/uploads"; // __DIR__ is the directory of the current PHP file

$newFilepath = $targetDirectory . "/" . $filename . "." . $extension;

if (!copy($filepath, $newFilepath)) { // Copy the file, returns false if failed
    die("Can't move file.");
}
unlink($filepath); // Delete the temp file

echo "<br>File uploaded successfully.<br>";
echo "Running database import command.<br>";

$command = new ImportGeneratedCsv();
$recordCount = $command->importTheGeneratedCsv($newFilepath);

echo "CSV file successully imported! (Total records: ".$recordCount.")<br>";

@endphp
