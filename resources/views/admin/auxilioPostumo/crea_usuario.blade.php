<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <form action='/auxiliopostumo/save' method="POST">
        @csrf
        <input type="text" name='c_cliente' id='c_cliente'>
        <button type="submit">Crear</button>
    </form>

</body>

</html>
