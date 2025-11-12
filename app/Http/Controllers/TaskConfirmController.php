<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskConfirmController extends Controller
{
    // セッションへ保存する
    public function store(Request $request)
    {
        $data = $request->only(['title', 'content', 'person_in_charge']);

        session()->put('task.confirm', $data);
        

        return response()->json([
            'status' => 'ok',
            'data' => $data,
        ], 200);
    }

    public function show()
    {
        $data = session()->get('task.confirm');
                if ($data) {
            return response()->json([
                'status' => 'ok',
                'data'   => $data,
            ], 200);
        } else {
            return response()->json([
                'status' => 'empty',
                'data'   => $data, 
            ], 200);
        }
    }
}