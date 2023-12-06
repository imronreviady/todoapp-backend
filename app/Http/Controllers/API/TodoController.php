<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Helpers\ResponseFormatter;

use App\Models\Todo;

class TodoController extends Controller
{
    public function __construct()
    {
        request()->headers->set("Accept", "application/json");
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->user()->id;

        $todos = Todo::where('user_id', $user_id)->orderBy('created_at', 'desc')->get();

        return ResponseFormatter::success($todos, 'Todo list');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user_id = auth()->user()->id;

        $rules = [
            'title' => 'required',
            'description' => 'nullable',
            'is_done' => 'nullable',
            'is_fav' => 'nullable',
            'is_trash' => 'nullable',
            'category' => 'required',
        ];

        $data = $request->only(['title', 'description', 'is_done', 'is_fav', 'is_trash', 'category']);

        $validator = Validator::make($data, $rules);

        if ($validator->fails()) {
            $message = $validator->getMessageBag()->first();

            return ResponseFormatter::error(null, $message, 400);
        }

        $data['user_id'] = $user_id;

        $todo = Todo::create($data);

        return ResponseFormatter::success($todo, 'Todo created', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // update todo by id based on request
        $todo = Todo::find($id);

        if (!$todo) {
            return ResponseFormatter::error(null, 'Todo not found', 404);
        }

        $data = $request->all();

        $todo->update($data);

        return ResponseFormatter::success($todo, 'Todo updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $todo = Todo::find($id);

        if (!$todo) {
            return ResponseFormatter::error(null, 'Todo not found', 404);
        }

        $todo->delete();

        return ResponseFormatter::success(null, 'Todo deleted');
    }
}
