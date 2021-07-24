<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Status</title>
    <meta http-equiv = "refresh" content = "10; url = http://localhost:8000" />
</head>
<body>
    <div>
        @if ($status[0]==='DONE!')
            <h1  class="mx-auto" style="width:99%;">Purchased Successfully! :)</h1>
        @else
            <h1  class="mx-auto" style="width:99%;">Something Failed! :(</h1>
        @endif
    </div>

    
</body>
</html>