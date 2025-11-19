<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskConfirmController extends Controller
{
  //セッションに保存
    public function storeCreate(Request $request)
    {
        $data = [
            'title'=>$request->input('title', ''),
            'content'=>$request->input('content', ''),
            'person_in_charge'=>$request->input('person_in_charge', ''),
        ];
        $request->session()->put('draft_create', $data);
        return response()->json(['ok' => true]);
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
      public function storeEdit(Request $request)
      {
          $data = [
              'id'=>$request->input('id', ''),
              'title'=>$request->input('title', ''),
              'content'=>$request->input('content', ''),
              'person_in_charge'=>$request->input('person_in_charge', ''),
          ];
          $request->session()->put('draft_edit', $data);
          return response()->json(['ok' => true]);
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