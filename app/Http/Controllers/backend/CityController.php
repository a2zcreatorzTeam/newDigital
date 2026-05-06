<?php
    
namespace App\Http\Controllers\backend;


use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Provinces;
use DB;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
    
class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
         $this->middleware('permission:city-list|city-create|city-edit|city-delete', ['only' => ['index','store']]);
         $this->middleware('permission:city-create', ['only' => ['create','store']]);
         $this->middleware('permission:city-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:city-delete', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request): View
    {
        $cities = City::with('province')->orderBy('id','ASC')->paginate(10);
        return view('backend.city.index',compact('cities'));
    }
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $provinces = Provinces::get();
        return view('backend.city.create',compact('provinces'));
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
            'name' => 'required|unique:cities,name',
            'province' => 'required',
        ]);

        $city = City::create(['name' => $request->input('name'),'province_id' => $request->input('province')]);
    
        return redirect()->route('city.index')
                        ->with('success','city created successfully');
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
        $city = City::find($id);
        $provinces = Provinces::get();
        return view('backend.city.edit',compact('city','provinces'));
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
            'province' => 'required',
        ]);
    
        $city = City::find($id);
        $city->name = $request->input('name');
        $city->province_id = $request->input('province');
        $city->save();

        return redirect()->route('city.index')
                        ->with('success','city updated successfully');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        City::find($id)->delete();
        return redirect()->route('city.index')
                        ->with('success','city deleted successfully');
    }
}