<!DOCTYPE html>
<head>
<meta charset="utf-8">
</head>
<body>
<form method="POST" action="{{ route('birthday.store') }}">
    @csrf
    氏名
    <input type="text" name="name">
    <br>
    誕生日
    <input type="date" name="birthday" value="1999-04-01">
    <br>
    <input class="btn btn-primary" type="submit" value="登録する">
</body>
</html>