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
        ? Task::with('category') // اذا كان ادمن اظهرلي كل المهام تاعة كل المستخدمين
        : Task::where('user_id', Auth::id())->with('category'); //  تاعهid اذا كان مستخدم بس اظهر المهام تاعة هذا المستخدم فقط من خلال 

    $tasks     = (clone $query)->orderBy('is_starred', 'desc')->latest()->take(3)->get();
    $total     = (clone $query)->count();
    $completed = (clone $query)->where('status', 'Completed')->count();

    return view('dashboard', compact('tasks', 'total', 'completed'));
}

public function index(Request $request)
{
    $query = Auth::guard('admin')->check()
        ? Task::with(['category', 'comments', 'user'])
        : Task::where('user_id', Auth::id())->with(['category', 'comments']);

    // فلتر الحالة
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // فلتر التصنيف (Category)
    if ($request->filled('category_id')) {
        $query->where('category_id', $request->category_id);
    }

    // البحث بالاسم (Server-side)
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $tasks = $query->orderBy('is_starred', 'desc') // النجوم أولاً
                   ->orderBy('due_date', 'asc')    // ثم الأقرب موعداً
                   ->paginate(5);

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
        'user_id'     => Auth::guard('admin')->check() ? null : Auth::id()
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
    $query = Auth::guard('admin')->check()
        ? Task::query()  
        : Task::where('user_id', Auth::id());
// اذا كان ادمن هات كل المهام واذا مستخدم هات المهام الخاصة فيه عن طريقة رقم المستخدم
    $query->delete();

    return response()->json([
        'icon'  => 'success',
        'title' => 'All Tasks Moved to Trash!'
    ]);
}

public function trashed()
{
    $tasks = Auth::guard('admin')->check()
        ? Task::onlyTrashed()->with('category')->get()
        : Task::onlyTrashed()->where('user_id', Auth::id())->with('category')->get();

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
// حذف بشكل دائم للمهمة
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
    if (Auth::guard('admin')->check()) {
        //إذا كان أدمن: استرجع كل المهام المحذوفة
        Task::onlyTrashed()->restore();
    } else {
        // إذا كان مستخدم عادي: استرجع مهامه فقط
        Task::onlyTrashed()->where('user_id', Auth::id())->restore();
    }

    return response()->json([
        'icon' => 'success',
        'title' => 'All Tasks Restored Successfully!',
        'redirect' => route('tasks.index')
    ]);
}
public function forceDeleteAll()
{
    if (Auth::guard('admin')->check()) {
        // إذا كان أدمن: احذف نهائياً كل المهام المحذوفة
        Task::onlyTrashed()->forceDelete();
    } else {
        // إذا كان مستخدم عادي: احذف مهامه فقط
        Task::onlyTrashed()->where('user_id', Auth::id())->forceDelete();
    }

    return response()->json([
        'icon'  => 'success',
        'title' => 'All Tasks Permanently Deleted!'
    ]);
}




//عند النقر على الصح  سيتم تنفيذ الاجراء التالي للمهمة
public function toggleStatus($id) {
    $task = Task::findOrFail($id);
    $task->status = ($task->status == 'Pending') ? 'Completed' : 'Pending';
    //  والعكسCompleted خليها Pending اذا حالة المهمة 
    $task->save();
    return response()->json(['success' => true, 'new_status' => $task->status]);
}
// تشيل أو تحط علامة نجمة 
public function toggleStar(Task $task)
{
    // والعكس  !is_starredخليها is_starred عند النقر على النجمة اذا كانت 
    $task->is_starred = !$task->is_starred;
    $task->save();

    return response()->json([
        'success'    => true,
        'is_starred' => $task->is_starred,
    ]);
}

}
