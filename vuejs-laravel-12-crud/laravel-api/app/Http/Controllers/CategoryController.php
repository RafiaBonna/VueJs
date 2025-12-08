<?php

namespace App\Http\Controllers;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
       public function index()
    {
        return response()->json([
            'status' => true,
            'data' => Category::orderBy('id', 'desc')->get()
        ]);
    }

    // POST: /api/tasks
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'completed' => 'boolean'
        ]);

        $task = Category::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Category created successfully',
            'data' => $task
        ], 201);
    }

     public function show($id)
    {
        $task = Category::find($id);

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $task
        ]);
    }

    // PUT/PATCH: /api/tasks/{id}
    public function update(Request $request, $id)
    {
        $task = Category::find($id);

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Category not found'
            ], 404);
        }

        $task->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Category updated successfully',
            'data' => $task
        ]);
    }

    // DELETE: /api/tasks/{id}
    public function destroy($id)
    {
        $task = Category::find($id);

        if (!$task) {
            return response()->json([
                'status' => false,
                'message' => 'Task not found'
            ], 404);
        }

        $task->delete();

        return response()->json([
            'status' => true,
            'message' => 'Category deleted successfully'
        ]);
    }
}
