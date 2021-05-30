@foreach($friends as $friend)
  {{ $friend->name }} <a href="{{ route('birthday.show', ['id' => $friend->id ]) }}">詳細を見る</a> 
  <br>
@endforeach

<a href="{{ route('birthday.create') }}">新規作成</a>