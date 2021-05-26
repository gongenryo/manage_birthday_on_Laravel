名前 {{ $friend->name}}
<br>
誕生日 {{ $friend->birthday }}
<br>
<form method="GET" action="{{ route('birthday.edit', [ 'id' => $friend->id ]) }}">
@csrf
<input class="btn btn-primary" type="submit" value="変更する">
</form>

<form method="POST" action="{{ route('birthday.destroy', [ 'id' => $friend->id ]) }}">
@csrf
<input class="btn btn-danger" type="submit" value="削除する">                 
</form>