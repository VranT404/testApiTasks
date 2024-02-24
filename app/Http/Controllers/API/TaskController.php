<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Get all tasks.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $tasks = Task::orderBy('id', 'asc')->get();

            return response()->json(['tasks' => $tasks], 200);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }

    /**
     * Get a specific task by ID.
     *
     * @param int $taskId
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            return response()->json(['task' => $task], 200);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }

    /**
     * Get tasks for the authenticated user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showUserTasks()
    {
        $user = auth()->user();

        if (!$user) {
            $response = [
                'success' => false,
                'message' => 'Unauthorized',
            ];
            return response()->json($response, 400);
        }

        try {
            $tasks = Task::where('user_id', $user->id)->get();

            return response()->json(['tasks' => $tasks], 200);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }

    /**
     * Create a new task.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
            return response()->json($response, 400);
        }

        try {
            $task = Task::create([
                'user_id' => auth()->user()->id,
                'title' => $request->title,
                'description' => $request->description,
                'status' => 'pending',
            ]);

            return response()->json(['task' => $task, 'message' => 'Task created successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }

    /**
     * Update an existing task.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $taskId
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $taskId)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:pending,completed',
        ]);

        if ($validator->fails()) {
            $response = [
                'success' => false,
                'message' => $validator->errors()->first(),
            ];
            return response()->json($response, 400);
        }

        try {
            $task = Task::findOrFail($taskId);

            $task->update([
                'title' => $request->title,
                'description' => $request->description,
                'status' => $request->status,
            ]);

            return response()->json(['task' => $task, 'message' => 'Task updated successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }

    /**
     * Delete a task by ID.
     *
     * @param int $taskId
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($taskId)
    {
        try {
            $task = Task::findOrFail($taskId);

            $task->delete();

            return response()->json(['message' => 'Task deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }
}
