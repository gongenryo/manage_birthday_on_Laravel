<?php
        $start= strtotime('-1 hour', strtotime($request['birthday'])); //大切
        // $start_time= date('c', $start);
        $end=strtotime($request['birthday']);
        // $end_time= date('c', $end);

        
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);
        
        $calendarId = env('GOOGLE_CALENDAR_ID');
        
        for(int i = 0; i <= 30; i++;){

          $a= strtotime('+i year', $start);
          $start_time = date('c', $a);
          $b= strtotime('+i year', $end);
          $end_time = ('c', $b);

          $event = new Google_Service_Calendar_Event(array(
            //タイトル
            'summary' => $request->input('name'),
            'start' => array(
              // 開始日時
              'dateTime' => $start_time,
              'timeZone' => 'Asia/Tokyo',
            ),
            'end' => array(
              // 終了日時
              'dateTime' => $end_time,
              'timeZone' => 'Asia/Tokyo',
            ),
          ));
          
          $event = $service->events->insert($calendarId, $event);
        }
          
        $birth = new Birthday;

        $birth->name     = $request->input('name');
        $birth->birthday = $request->input('birthday');

        $birth->save();
        
        return redirect('birthday/index');
        }

検証成功済み
======================================store==============================================
public function store(Request $request)
{
    $start= strtotime('-1 hour', strtotime($request['birthday'])); //大切
    $start_time= date('c', $start);
    $end=strtotime($request['birthday']);
    $end_time= date('c', $end);
    
    $client = $this->getClient();
    $service = new Google_Service_Calendar($client);

    $calendarId = env('GOOGLE_CALENDAR_ID');

    $event = new Google_Service_Calendar_Event(array(
        //タイトル
        'summary' => $request->input('name'),
        'start' => array(
            // 開始日時
            'dateTime' => $start_time,
            'timeZone' => 'Asia/Tokyo',
        ),
        'end' => array(
            // 終了日時
            'dateTime' => $end_time,
            'timeZone' => 'Asia/Tokyo',
        ),
    ));

    $event = $service->events->insert($calendarId, $event);

    $birth = new Birthday;

    $birth->name     = $request->input('name');
    $birth->birthday = $request->input('birthday');

    $birth->save();
    
    return redirect('birthday/index');
}

========================================index===========================================
$query = DB::table('birthdays');
        $query->select('id', 'name', 'birthday');
        $query->orderBy('birthday', 'asc');

        $friends = $query->paginate(20);

        return view('birthday.index', compact('friends'));

======================================index.blade.php====================================
@foreach($query as $quer)
  {{ $quer->name }} <a href="{{ route('birthday.show', ['id' => $quer->id ]) }}">詳細を見る</a> 
  <br>
@endforeach

<a href="{{ route('birthday.create') }}">新規作成</a>

======================================index(2)===========================================
$query = DB::table('birthdays')->pluck('birthday', 'name');
        // $query->select('id', 'name', 'birthday');
        // $query->orderBy('birthday', 'asc');

        // $friends = $query->paginate(20);

        return view('birthday.index', compact('query'));

======================================index.blade.php(2)=================================

<?php
echo "<pre>";
var_dump($query);
echo "</pre>";
?>

    