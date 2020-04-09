<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h3>A new movie is added to the system.</h3>
    <img src="{{$movie->image_url}}" alt="">
    <img src="{{'http://localhost:8000/storage/'.'thumbnail_'.$fileName}}" alt="">
    <h4>Title:</h4>
    <label>{{$movie->title}}</label>
    <h4>Description:</h4>
    <label>{{$movie->description}}</label>
</body>
</html>