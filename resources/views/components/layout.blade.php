<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <title>{{ $title }}</title>
    </head>
    <body class="bg-gray-900 text-gray-50">
        {{ $slot }}
    </body>
</html>