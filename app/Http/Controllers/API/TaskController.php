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

            if ($tasks->isEmpty()) {
                return response()->json(['response' => 'No tasks'], 404);
            }

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

            if (!$task) {
                return response()->json(['response' => 'Could not find task for this id'], 404);
            }

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

            if ($tasks->isEmpty()) {
                return response()->json(['response' => 'You don\'t have tasks yet'], 404);
            }

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
        $task = Task::findOrFail($taskId);

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

            if (!$task) {
                return response()->json(['response' => 'Could not find task for this id'], 404);
            }

            $task->delete();

            return response()->json(['message' => 'Task deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['response' => 'Error: ' . $e->getMessage()], 503);
        }
    }
}
