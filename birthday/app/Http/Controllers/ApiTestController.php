<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Birthday;
use Illuminate\Support\Facades\DB;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class ApiTestController extends Controller
{
    public function index()
    {
        $query = DB::table('birthdays')->pluck('birthday', 'name');
        $keys = $query->keys();
        $data = DB::table('birthdays')
                ->where('name', $keys[0])
                ->select('id', 'name','birthday')
                ->first();
                
        // $query->select('id', 'name', 'birthday');
        // $query->orderBy('birthday', 'asc');

        // $friends = $query->paginate(20);

        return view('birthday.index', compact('keys', 'data'));
    }

    public function create()
    {
        return view('birthday.create');
    }

    public function store(Request $request)
    {
        $start= strtotime('-1 hour', strtotime($request['birthday'])); //大切
        // $start_time= date('c', $start);
        $end=strtotime($request['birthday']);
        // $end_time= date('c', $end);

        
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);
        
        $calendarId = env('GOOGLE_CALENDAR_ID');
        
        for( $i = 0; $i <= 1; $i++){

          $x=strval($i);
          $a= strtotime("+$x year", $start);
          $start_time = date('c', $a);
          $b= strtotime("+$x year", $end);
          $end_time = date('c', $b);

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
          $event_id = $event->getId();
          
          $birth = new Birthday;
          
          $birth->name     = $request->input('name');
          $birth->birthday = $request->input('birthday');
          $birth->event_id = $event_id;

          $birth->save();
          
          
        }
        
        return redirect('birthday/index');
    }
        

    public function show($id)
    {
        $friend = Birthday::find($id);
        
        return view('birthday.show', compact('friend'));
    }

    public function edit($id)
    {
        $friend = Birthday::find($id);

        return view('birthday.edit', compact('friend'));
    }

    public function update(Request $request, $id)
    {
        $birthday = Birthday::find($id);

        $birthday->name = $request->input('name');
        $birthday->birthday = $request->input('birthday');

        $birthday->save();

        return redirect('birthday/index');
    }

    public function destroy($id)
    {
        $birthday = Birthday::find($id);
        $birthday->delete();

        return redirect('birthday/index');
    }

    private function getClient()
    {
        $client = new Google_Client();

        //アプリケーション名
        $client->setApplicationName('GoogleCalendarAPIのテスト');
        //権限の指定
        $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
        //JSONファイルの指定
        $client->setAuthConfig(storage_path('app/api-key/birthday-314802-a0994a6ac05f.json'));

        return $client;
    }
}
