<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class TaskController extends Controller
{
    // عرض كل المهام - Dashboard
public function dashboard()
{
    $query = Auth::guard('admin')->check()
        ? Task::with('category')
        : Task::where('user_id', Auth::id())->with('category');

    $tasks = $query->latest()->take(3)->get();
    $total = $query->count();
    $completed = $query->where('status', 'Completed')->count();

    return view('dashboard', compact('tasks', 'total', 'completed'));
}
public function index()
{
    $query = Auth::guard('admin')->check()
        ? Task::with(['category', 'comments', 'user'])
        : Task::where('user_id', Auth::id())->with(['category', 'comments']);

    if (request('status')) {
        $query->where('status', request('status'));
    }

    $tasks = $query->paginate(5);
    $categories = Category::all();

    return view('tasks', compact('tasks', 'categories'));
}

    // فورم إضافة مهمة
public function create()
{
    $categories = Category::all();
    return view('add-task', compact('categories'));
}

    // حفظ مهمة جديدة
public function store(Request $request)
{
    $request->validate([
        'title'       => 'required',
        'category_id' => 'required|exists:categories,id',
    ]);

    Task::create([
        'title'       => $request->title,
        'description' => $request->description,
        'status'      => $request->status,
        'due_date'    => $request->due_date,
        'category_id' => $request->category_id,
        'user_id'     => Auth::id()
    ]);

    return response()->json([
        'icon'     => 'success',
        'title'    => 'Task Added Successfully!',
        'redirect' => route('tasks.index')
    ]);
}

    // فورم تعديل مهمة
public function edit(Task $task)
{
    $categories = Category::all();
    return view('edit-task', compact('task', 'categories'));
}

    // حفظ التعديل
public function update(Request $request, $id)
{
    $request->validate([
        'title' => 'required',
    ]);

    $task = Task::findOrFail($id);
    $task->update($request->all());

    return response()->json([
        'icon'     => 'success',
        'title'    => 'Task Updated Successfully!',
        'redirect' => route('tasks.index')
    ]);
}

    // حذف مهمة
public function destroy(Task $task)
{
    $task->delete();
    return response()->json([
        'icon'  => 'success',
        'title' => 'Task Deleted!'
    ]);
}
public function destroyAll()
{
    Task::where('user_id', Auth::id())->delete();
    return response()->json([
        'icon'  => 'success',
        'title' => 'All Tasks Moved to Trash!'
    ]);
}

public function trashed()
{
    $tasks = Task::onlyTrashed()->where('user_id', Auth::id())->with('category')->get();
    return view('tasks-trashed', compact('tasks'));
}

public function restore($id)
{
    Task::onlyTrashed()->findOrFail($id)->restore();
    return response()->json([
        'icon' => 'success',
        'title' => 'Task Restored!'
    ]);
}

public function forceDelete($id)
{
    Task::onlyTrashed()->findOrFail($id)->forceDelete();
    return response()->json([
        'icon' => 'success',
        'title' => 'Task Deleted Permanently!'
    ]);
}
public function restoreAll()
{
    Task::onlyTrashed()->where('user_id', Auth::id())->restore();
    return response()->json([
        'redirect' => route('tasks.index')
    ]);
}

public function forceDeleteAll()
{
    Task::onlyTrashed()->where('user_id', Auth::id())->forceDelete();
    return response()->json([
        'icon'  => 'success',
        'title' => 'All Tasks Permanently Deleted!'
    ]);
}

}
