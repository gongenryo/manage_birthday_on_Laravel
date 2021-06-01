@foreach($index_lists as $index_list)
  {{ $index_list->name }}
  {{ $index_list->birthday }}
  <a href="{{ route('birthday.show', ['id' => $index_list->id]) }}">詳細を見る</a>
  <br>
@endforeach
<a href="{{ route('birthday.create') }}">新規作成</a>


<?php
$alkfj = count($a); 
dd($alkfj);
echo $a[0]['id'];

?>