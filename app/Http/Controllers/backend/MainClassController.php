<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MainClass;
use Illuminate\Support\Facades\Storage;

class MainClassController extends Controller
{
    public function index(Request $request)
    {
        $query = MainClass::latest();
        if ($request->has('export')) {
            
            $filename = 'Policies-Category.csv';
            $headers = [
                "Content-Type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
            ];
            $classes = $query->get();
            $callback = function () use ($classes) {
    
                $file = fopen('php://output', 'w');
                // Header row
                fputcsv($file, ['Name', 'status']);
                foreach ($classes as $data) {
                        fputcsv($file, [
                            ucwords($data->name), 
                            $data->status==1 ? 'Active' : 'In active'
                        ]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        } 
        $classes =$query->paginate(10);
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
            ->with('success', 'Category created successfully');
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

        return redirect()->route('class.index')
            ->with('success', 'Category updated successfully');
    }

    public function destroy($id)
    {
        $class = MainClass::findOrFail($id);

        if ($class->logo && Storage::disk('public')->exists($class->logo)) {
            Storage::disk('public')->delete($class->logo);
        }

        $class->delete();

        return redirect()->route('class.index')
            ->with('success', 'Category deleted successfully');
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