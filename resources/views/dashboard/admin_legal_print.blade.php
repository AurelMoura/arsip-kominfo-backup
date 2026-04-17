<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Dokumen {{ $label }}</title>
    <style>
        body, html { margin: 0; padding: 0; height: 100%; }
        .viewer { width: 100vw; height: 100vh; border: none; }
    </style>
</head>
<body>
    <object class="viewer" data="{{ $url }}" type="application/pdf">
        <p>Anda tidak dapat melihat PDF. <a href="{{ $url }}" target="_blank">Buka dokumen</a></p>
    </object>
    <script>
        window.onload = function() {
            window.print();
        };
    </script>
</body>
</html>
