<!DOCTYPE html>
<html lang="en">
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Status</title>
    <meta http-equiv = "refresh" content = "2; url = http://192.168.1.19:8000" />
</head>
<body>
    <div style="width: 1366px;">
        <div class="mx-auto" style="width: 1360px; text-align:center; margin-top:20%;">
            @if ($status[0]==='DONE!')
                <h1>Purchased Successfully! :)</h1>
            @else
                <h1>Something Failed! :(</h1>
            @endif
        </div>
    </div>    
</body>
</html>