<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainClass;
use Illuminate\Support\Facades\Storage;

class MainClassController extends Controller
{
    public function index()
    {
        $classes = MainClass::latest()->get();
        return view('backend.mainclass.index', compact('classes'));
    }

    public function create()
    {
        return view('backend.mainclass.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        $logoPath = null;

        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('mainclasses', 'public');
        }

        MainClass::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'status' => $request->status,
        ]);

        return redirect()->route('class.index')
            ->with('success', 'Main Class created successfully');
    }

    public function edit($id)
    {
        $class = MainClass::findOrFail($id);
        return view('backend.mainclass.edit', compact('class'));
    }

    public function update(Request $request, $id)
    {
        $class = MainClass::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpg,png,jpeg,svg|max:2048',
            'status' => 'required|boolean',
        ]);

        $logoPath = $class->logo;

        if ($request->hasFile('logo')) {

            if ($class->logo && Storage::disk('public')->exists($class->logo)) {
                Storage::disk('public')->delete($class->logo);
            }

            $logoPath = $request->file('logo')->store('mainclasses', 'public');
        }

        $class->update([
            'name' => $request->name,
            'logo' => $logoPath,
            'status' => $request->status,
        ]);

        return redirect()->route('mainclasses.index')
            ->with('success', 'Main Class updated successfully');
    }

    public function destroy($id)
    {
        $class = MainClass::findOrFail($id);

        if ($class->logo && Storage::disk('public')->exists($class->logo)) {
            Storage::disk('public')->delete($class->logo);
        }

        $class->delete();

        return redirect()->route('mainclasses.index')
            ->with('success', 'Main Class deleted successfully');
    }

    // 🔥 OPTIONAL: quick toggle active/inactive
    public function toggleStatus($id)
    {
        $class = MainClass::findOrFail($id);
        $class->status = !$class->status;
        $class->save();

        return back()->with('success', 'Status updated successfully');
    }
}