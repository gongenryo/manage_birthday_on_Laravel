@foreach($friends as $friend)
  {{ $friend->name }} <a href="{{ route('birthday.show', ['id' => $friend->id ]) }}">詳細を見る</a> 
  <br>
@endforeach