<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;

class TaskConfirmController extends Controller
{
  //セッションに保存
    public function storeCreate(TaskRequest $request)
    {
      // バリデーションの結果を格納する
      $validated = $request->validated();

      //保存
        // $data = [
        //     'title'=>$request->input('title', ''),
        //     'content'=>$request->input('content', ''),
        //     'person_in_charge'=>$request->input('person_in_charge', ''),
        // ];
        // $request->session()->put('draft_create', $data);
        // return response()->json(['ok' => true]);

      // セッションに「確認用ドラフト」として保存する
      $request -> session()->put('draft_create', $validated);

      return response()->json([
        'status' => 'ok',
      ]);
      
    }

  //セッションから取得
    public function showCreate(Request $request)
    {
        return response()->json([
            'draft'=>$request->session()->get('draft_create', null),
        ]);
    }

  //セッションクリア
    public function clearCreate(Request $request)
    {
        $request->session()->forget('draft_create');
        return response()->json(['ok' => true]);
    }

    
    //セッションに保存
      public function storeEdit(TaskRequest $request)
      {
        // バリデーションの結果を格納する
        $validated = $request->validated();
        //保存
          // $data = [
          //     'id'=>$request->input('id', ''),
          //     'title'=>$request->input('title', ''),
          //     'content'=>$request->input('content', ''),
          //     'person_in_charge'=>$request->input('person_in_charge', ''),
          // ];
          // $request->session()->put('draft_edit', $data);
          // return response()->json(['ok' => true]);

        // セッションに「確認用ドラフト」として保存する
        $request -> session()->put('draft_edit', $validated);

        return response()->json([
          'status' => 'ok',
        ]);
      }
  
    //セッションから取得
      public function showEdit(Request $request)
      {
          return response()->json([
              'draft'=>$request->session()->get('draft_edit', null),
          ]);
      }
  
    //セッションクリア
      public function clearEdit(Request $request)
      {
          $request->session()->forget('draft_edit');
          return response()->json(['ok' => true]);
      }
  }