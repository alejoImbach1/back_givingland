<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restablecer Contraseña</title>
    <style>
        /* Importar Tailwind CSS */
        @import url('https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css');
    </style>
</head>
<body class="bg-gray-100">
    <div class="max-w-3xl mx-auto my-8 p-4 bg-white shadow-md rounded-md">
        <div class="text-center">
            <h2 class="text-2xl font-bold mb-4">Hola, {{ $user->name }}</h2>
            <p class="text-gray-700 mb-6">Has solicitado restablecer tu contraseña. Haz clic en el botón de abajo para proceder.</p>
            <a href="{{ $resetUrl }}" class="inline-block px-6 py-2 text-white bg-blue-500 rounded-full hover:bg-blue-700">
                Restablecer Contraseña
            </a>
            <p class="text-gray-600 mt-6">Si no solicitaste este cambio, puedes ignorar este correo.</p>
            <p class="text-gray-600">Gracias,</p>
            <p class="text-gray-600">{{ config('app.name') }}</p>
        </div>
    </div>
</body>
</html>