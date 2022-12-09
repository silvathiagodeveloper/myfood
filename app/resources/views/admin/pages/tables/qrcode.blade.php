<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QrCode</title>
</head>
<body>
    <div class="visible-print text-center">
        {!! QrCode::size(100)->generate($uri) !!}
    </div>
</body>
</html>