<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if(Auth::user()->hasRole('Super Admin')):
            $data = User::get();
        else:
        $data = User::role(['Admin','Operator'])->get();
        endif;
        if($request->ajax())
        { 
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('role', function($row){
                if(!empty($row->getRoleNames())):
                    foreach($row->getRoleNames() as $v):
                        return '<label class="badge badge-success">'. $v .'</label>';
                    endforeach;
                endif;
            })
            ->addColumn('action', function($row){
                $actionBtn = '
                    <form action="'.route('users.destroy',$row->id).'" method="POST">
                        <a class="btn btn-sm" href="'.route('users.show',$row->id).'"><i class="far fa-eye fa-sm text-secondary"></i></a>
                        <a class="btn btn-sm" href="'.route('users.edit',$row->id).'"><i class="far fa-edit fa-sm text-secondary"></i></a>
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-sm delete">
                            <i class="far fa-trash-alt fa-sm"></i>
                        </button>
                    </form>';
                return $actionBtn;
            })
            ->rawColumns(['role', 'action'])
            ->make(true);
    	}

        $context = [
            'title' => 'Users',
            'subtitle' => 'List',
            /** CSS Vendor */
            'css_vendor' => '
                <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">',
            /** JS Vendor */
            'js_vendor' => '
                <script src="vendor/datatables/jquery.dataTables.min.js"></script>
                <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>',
            /** JS Script */
            'js_script' => '
                <script>
                    $(function(){
                        $("#dataTable").DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: "'.route('users.index').'",
                            columns: [
                                {"data": "DT_RowIndex", name: "DT_RowIndex", "className": "text-center", orderable: false},
                                {data: `name`, name: `name`},
                                {data: `email`, name: `email`},
                                {data: `role`, name: `role`},
                                {
                                    data: "action", 
                                    name: "action", 
                                    className: "text-center",
                                    orderable: false, 
                                    searchable: false
                                },
                            ],
                            order: [[1, "asc"]],
                            columnDefs: [{
                                "targets": [4],
                                "orderable": false
                            }]
                        });
                    });
                </script>'
        ];

        return view('users.index', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $context = [
            'title' => 'Users',
            'subtitle' => 'Create',
            /** Data */
            'roles' => Role::where('name','!=','Super Admin')->get(),
            /** CSS Vendor */
            'css_vendor' => '
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
            /** JS Vendor */
            'js_vendor' => '
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
            /** JS Script */
            'js_script' => '
                <script>
                    $(function() {
                        "use strict";
                        $("#userRole").select2();
                    });
                </script>'
        ];

        return view('users.create', $context);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|same:confirm-password',
            'roles' => 'required'
        ]);
    
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
    
        $user = User::create($input);
        $user->assignRole($request->roles);
    
        return redirect()->route('users.index')->with('success','User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $context = [
            'title' => 'Users',
            'subtitle' => 'Update',
            /** Data */
            'roles' => Role::where('name','!=','Super Admin')->get(),
            'userRole' => $user->roles->pluck('name','name')->all(),
            /** CSS Vendor */
            'css_vendor' => '
                <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />',
            /** JS Vendor */
            'js_vendor' => '
                <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>',
            /** JS Script */
            'js_script' => '
                <script>
                    $(function() {
                        "use strict";
                        $("#userRole").select2();
                    });
                </script>'
        ];

        return view('users.edit', compact('user'), $context);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
