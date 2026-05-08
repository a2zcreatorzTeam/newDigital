<?php
    
namespace App\Http\Controllers\backend;


use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\District;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
    
class DistrictController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:district-list|district-create|district-edit|district-delete', ['only' => ['index','store']]);
         $this->middleware('permission:district-create', ['only' => ['create','store']]);
         $this->middleware('permission:district-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:district-delete', ['only' => ['destroy']]);
    }
    public function index(Request $request)
    {
        $query = District::with('city');
        
        //provincefilter
        if ($request->city) {
            $query->where('city_id', $request->city);
        }

        //city_name filter
        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }
        // Sorting
        $sortBy = $request->sorting ?? 'id';
        $direction = $request->direction ?? 'asc';

        $query->orderBy($sortBy, $direction);

        $districts = $query->paginate($request->qty ?? 10);
        
        //AJAX RESPONSE (ONLY ROWS)
        if ($request->ajax()) {
            return view('backend.district.table', compact('districts'))->render();
        }
        $cities = City::get();

        return view('backend.district.index',compact('districts','cities'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $cities = City::get();
        return view('backend.district.create',compact('cities'));
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required|unique:districts,name',
            'city_id' => 'required',
        ]);

        District::create(['name' => $request->input('name'),'city_id' => $request->input('city_id')]);
    
        return redirect()->route('district.index')
                        ->with('success','district created successfully');
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $district = District::find($id);
        $cities = City::get();
        return view('backend.district.edit',compact('district','cities'));
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'city_id' => 'required',
        ]);
    
        $district = district::find($id);
        $district->name = $request->input('name');
        $district->city_id = $request->input('city_id');
        $district->save();

        return redirect()->route('district.index')
                        ->with('success','district updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        District::find($id)->delete();
        return redirect()->route('district.index')
                        ->with('success','district deleted successfully');
    }
}