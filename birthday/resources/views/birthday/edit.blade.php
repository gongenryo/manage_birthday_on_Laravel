<form method="POST" action="{{ route('birthday.update', ['id' => $friend->id]) }}">
@csrf
名前
<input type="text" name="name" value="{{ $friend->name }}">
<br>
誕生日
<input type="date" name="birthday" value="{{ $friend->birthday }}">

<input class="btn btn-primary" type="submit" value="更新する">
</form>

