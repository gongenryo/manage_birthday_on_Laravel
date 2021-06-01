<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\birthday;
use Illuminate\Support\Facades\Db;

use Google_Client;
use Google_Service_Calendar;
use Google_Service_Calendar_Event;

class ApiTestController extends Controller
{
    public function index() //完成
    {

        //同一人物の情報がDB上に複数ある為、1つだけを表示する
        $query = DB::table('birthdays')->pluck('birthday', 'name');
        $keys = $query->keys(); //=[0 => "永野芽郁",1 => "小栗旬",2 => "佐藤健]
        $kazu = $keys->count(); //=3
        $indeto_string_lists = [];

        for($i=0; $i<$kazu; $i++){
            $data = DB::table('birthdays')
                ->where('name', $keys[$i])
                ->select('id', 'name','birthday')
                ->first();

            $index_lists[] = $data;
        }

        return view('birthday.index', compact('index_lists'));

    }

    public function create() //完成
    {
        return view('birthday.create');
    }

    public function store(Request $request) //完成
    {

        //誕生日の前日の午後11:00から1時間の予定をいれるために時間を調整
        $start = strtotime('-1 hour', strtotime($request['birthday'])); //大切
        $end   = strtotime($request['birthday']);
        
        //google calendarを使う準備
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);
        $calendarId = env('GOOGLE_CALENDAR_ID');

        //複数年分入れる為for文を使う
        for( $i = 0; $i <= 1; $i++){

          $to_string = strval($i);
          $start_up = strtotime("+$to_string year", $start);
          $start_time = date('c', $start_u);
          $end_up = strtotime("+$to_string year", $end);
          $end_time = date('c', $end_up);

          $event = new Google_Service_Calendar_Event(array(
            'summary' => $request->input('name'),
            'start' => array(
              'dateTime' => $start_time,
              'timeZone' => 'Asia/Tokyo',
            ),
            'end' => array(
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
        

    public function show($id) //完成
    {

        $friend = Birthday::find($id);
        
        return view('birthday.show', compact('friend'));

    }

    public function edit($id) //完成
    {

        $friend = Birthday::find($id);

        return view('birthday.edit', compact('friend'));
    }

    public function update(Request $request, $id) //完成
    {

        //google calendarを操作する準備
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);
        $calendarId = env('GOOGLE_CALENDAR_ID');

        $get_data = birthday::find($id);
        $get_detailed_data = $get_data['name'];
        $update_recodes = birthday::where('name', $get_detailed_data)->get();
        $number_of_recodes = count($update_recodes);

        //googleカレンダーからの削除（先にやらないとdbから情報取れない？）
        for($i = 0; $i < $number_of_recodes; $i++){
            $update_event_id = $update_recodes[$i]['event_id'];
            $service->events->delete($calendarId, $update_event_id);
        }

        $start = strtotime('-1 hour', strtotime($request['birthday'])); //大切
        $end   = strtotime($request['birthday']);

        for( $i = 0; $i <= 1; $i++){

            $to_string = strval($i);
            $start_up = strtotime("+$to_string year", $start);
            $start_time = date('c', $start_up);
            $end_up = strtotime("+$to_string year", $end);
            $end_time = date('c', $end_up);
  
            $event = new Google_Service_Calendar_Event(array(
              'summary' => $request->input('name'),
              'start' => array(
                'dateTime' => $start_time,
                'timeZone' => 'Asia/Tokyo',
              ),
              'end' => array(
                'dateTime' => $end_time,
                'timeZone' => 'Asia/Tokyo',
              ),
            ));
            
            $event = $service->events->insert($calendarId, $event);
            $event_id = $event->getId();

            $update_id = $update_recodes[$i]['id'];
            
            $birth = Birthday::find($update_id);
            
            $birth->name     = $request->input('name');
            $birth->birthday = $request->input('birthday');
            $birth->event_id = $event_id;
  
            $birth->save();
            
          }

        return redirect('birthday/index');

    }

    public function destroy($id) //完成
    {

        //googleカレンダーから削除する為の用意
        $client = $this->getClient();
        $service = new Google_Service_Calendar($client);
        $calendarId = env('GOOGLE_CALENDAR_ID');

        //削除したいデータのみをbirthdays table から取得
        $get_data = Birthday::find($id);
        $get_detailed_data = $get_data['name'];
        $delete_recodes = Birthday::where('name', $get_detailed_data)->get();
        $number_of_recodes = count($delete_recodes);

        //googleカレンダーからの削除（先にやらないとdbから情報取れない？）
        for($i = 0; $i < $number_of_recodes; $i++){
            $delete_event_id = $delete_recodes[$i]['event_id'];
            $service->events->delete($calendarId, $delete_event_id);
        }

        //birthdays table から削除
        for($i = 0; $i < $number_of_recodes; $i++){
            $delete_id = $delete_recodes[$i]['id'];
            $delete_recode = Birthday::find($delete_id);
            $delete_recode->delete();
        }

        return redirect('birthday/index');

    }

    private function getClient() //完成
    {

        $client = new Google_Client();
        $client->setApplicationName('GoogleCalendarAPIのテスト');
        $client->setScopes(Google_Service_Calendar::CALENDAR_EVENTS);
        $client->setAuthConfig(storage_path('app/api-key/birthday-314802-a0994a6ac05f.json'));

        return $client;

    }
}
