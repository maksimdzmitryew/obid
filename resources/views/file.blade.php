<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
    Загрузить картинку
    <form action="{{ route('api.upload.image') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="image">
        <input type="submit">
    </form>
    Загрузить файл
    <form action="{{ route('api.upload.file') }}" method="post" enctype="multipart/form-data">
        @csrf
        <input type="file" name="file">
        <input type="submit">
    </form>
</body>
</html>