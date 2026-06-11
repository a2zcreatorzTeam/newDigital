<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubClass;
use App\Models\MainClass;
use Illuminate\Support\Facades\Storage;

class SubClassController extends Controller
{


    public function index()
    {
        $subClasses = SubClass::with('mainClass')->latest()->get();
        return view('backend.subclass.index', compact('subClasses'));
    }


    public function filter()
    {
        $Classes = MainClass::latest()->get();
        return view('backend.subclass.filter', compact('Classes'));
    }




    public function list(Request $request)
    {

        $page = $request->get('ayis_page');
        $qty = $request->get('qty');
        $custom_pagination_path = '';
        $sorting = $request->get('sorting');
        $order = $request->get('direction');
        $class_id = $request->get('main_class');



 
        $subclass = SubClass::query();
        if ($request->has('main_class') && $request->get('main_class') != null) {
            $subclass->where('class_id', $class_id);
        }
        $data = $subclass->paginate($qty, ['*'], 'page', $page)->setPath($custom_pagination_path);
       
        return view('backend.subclass.index', ['data' => $data]);
    }


    public function create()
    {
        $classes = MainClass::where('status', 1)->get();
        return view('backend.subclass.create', compact('classes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'class_id' => 'required|exists:main_classes,id',
            'name'     => 'required|string|max:255',
            'logo'     => 'nullable|image|mimes:jpg,png,jpeg,svg|max:2048',
            'status'   => 'required|boolean',
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('subclasses', 'public');
        }

        SubClass::create([
            'class_id' => $request->class_id,
            'name'     => $request->name,
            'logo'     => $logoPath,
            'status'   => $request->status,
            'table_no'=>$request->table_no
        ]);

        return redirect()->route('subclass.filter')
            ->with('success', 'Policy created successfully');
    }

    public function edit($id)
    {
        $subclass = SubClass::findOrFail($id);

        $classes = MainClass::where('status', 1)->get();

        return view('backend.subclass.edit', compact('subclass', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $subClass = SubClass::findOrFail($id);

        $request->validate([
            'class_id' => 'required|exists:main_classes,id',
            'name'     => 'required|string|max:255',
            'logo'     => 'nullable|image|mimes:jpg,png,jpeg,svg|max:2048',
            'status'   => 'required|boolean',
            'table_no'   => 'required',
        ]);

        $logoPath = $subClass->logo;

        if ($request->hasFile('logo')) {

            if ($subClass->logo && Storage::disk('public')->exists($subClass->logo)) {
                Storage::disk('public')->delete($subClass->logo);
            }

            $logoPath = $request->file('logo')->store('subclasses', 'public');
        }

        $subClass->update([
            'class_id' => $request->class_id,
            'name'     => $request->name,
            'logo'     => $logoPath,
            'status'   => $request->status,
            'table_no'   => $request->table_no,
        ]);

        return redirect()->route('subclass.filter')
            ->with('success', 'Policy updated successfully');
    }

    public function destroy($id)
    {
        $subClass = SubClass::findOrFail($id);

        if ($subClass->logo && Storage::disk('public')->exists($subClass->logo)) {
            Storage::disk('public')->delete($subClass->logo);
        }

        $subClass->delete();

        return redirect()->route('subclass.filter')
            ->with('success', 'Policy deleted successfully');
    }

    public function toggleStatus($id)
    {
        $subClass = SubClass::findOrFail($id);
        $subClass->status = !$subClass->status;
        $subClass->save();

        return back()->with('success', 'Status updated successfully');
    }
}
