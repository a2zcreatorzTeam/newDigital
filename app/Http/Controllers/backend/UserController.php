<?php

namespace App\Http\Controllers\backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Spatie\Permission\Models\Role;
use DB;
use Hash;
use Illuminate\Support\Arr;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class UserController extends Controller
{    
    public function index(Request $request)
    {
        $query = User::latest();

       
        if ($request->role) {
            $query->role($request->role);
        }
      
        if ($request->user_detail_search) {

            $search = $request->user_detail_search;

            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }
        
      
        $sortBy = $request->sorting ?? 'id';
        $direction = $request->direction ?? 'desc';

        $query->orderBy($sortBy, $direction);

        //export
        if ($request->has('export')) {
            
            $filename = 'User.csv';
            $headers = [
                "Content-Type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
            ];
            $user = $query->get();
            $callback = function () use ($user) {
    
                $file = fopen('php://output', 'w');
                // Header row
                fputcsv($file, ['Name', 'Province']);
                foreach ($user as $data) {
                        fputcsv($file, [
                            ucwords($data->name), 
                            $data->email
                        ]);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, $headers);
        }
        
       
        $data = $query->latest()->paginate($request->qty ?? 10);
       
         //AJAX RESPONSE (ONLY ROWS)
        if ($request->ajax()) {
            return view('backend.users.rows', compact('data'))->render();
        }
        $roles = Role::orderBy('id','ASC')->get();
        return view('backend.users.index', compact('data','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): View
    {
        $roles = Role::pluck('name', 'name')->all();

        return view('backend.users.create', compact('roles'));
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
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);


        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $input['user_type'] = intval($input['user_type']);
        $input['email_verified_at'] = now();


        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id): View
    {
        $user = User::find($id);

        return view('backend.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id): View
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();

        return view('backend.users.edit', compact('user', 'roles', 'userRole'));
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
            'email' => 'required|email|unique:users,email,' . $id,
            'password' => 'same:confirm-password',
            'roles' => 'required'
        ]);

        $input = $request->all();
        if (!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }

        $user = User::find($id);
        $user->update($input);
        DB::table('model_has_roles')->where('model_id', $id)->delete();

        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): RedirectResponse
    {
        User::find($id)->delete();
        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully');
    }
}
