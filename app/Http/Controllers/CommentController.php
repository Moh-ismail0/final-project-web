<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    // إضافة comment على task
    public function storeForTask(Request $request, $taskId)
    {
        $request->validate(['body' => 'required']);

        $task = Task::findOrFail($taskId);
        $task->comments()->create(['body' => $request->body]);

        return response()->json([
            'icon' => 'success',
            'title' => 'Comment Added!'
        ]);
    }

    // إضافة comment على category
    public function storeForCategory(Request $request, $categoryId)
    {
        $request->validate(['body' => 'required']);

        $category = Category::findOrFail($categoryId);
        $category->comments()->create(['body' => $request->body]);

        return response()->json([
            'icon' => 'success',
            'title' => 'Comment Added!'
        ]);
    }

    // حذف comment
    public function destroy($id)
    {
        Comment::findOrFail($id)->delete();
        return response()->json([
            'icon' => 'success',
            'title' => 'Comment Deleted!'
        ]);
    }
}
