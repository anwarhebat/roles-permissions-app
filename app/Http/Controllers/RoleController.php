<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class RoleController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
         $this->middleware('permission:role-create', ['only' => ['create','store']]);
         $this->middleware('permission:role-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Role::where('name', '!=', 'Super Admin')->get();
        if($request->ajax())
        { 
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '
                    <form action="'.route('roles.destroy',$row->id).'" method="POST">
                        <a class="btn btn-sm" href="'.route('roles.show',$row->id).'"><i class="far fa-eye fa-sm text-secondary"></i></a>
                        <a class="btn btn-sm" href="'.route('roles.edit',$row->id).'"><i class="far fa-edit fa-sm text-secondary"></i></a>
                        <input type="hidden" name="_token" value="'.csrf_token().'" />
                        '.method_field('DELETE').'
                        <button type="submit" class="btn btn-sm delete">
                            <i class="far fa-trash-alt fa-sm"></i>
                        </button>
                    </form>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
    	}

        $context = [
            'title' => 'Roles',
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
                            ajax: "'.route('roles.index').'",
                            columns: [
                                {"data": "DT_RowIndex", name: "DT_RowIndex", "className": "text-center", orderable: false},
                                {data: `name`, name: `name`},
                                {data: `guard_name`, name: `guard_name`},
                                {
                                    data: "action", 
                                    name: "action", 
                                    className: "text-center",
                                    orderable: false, 
                                    searchable: false
                                },
                            ],
                            columnDefs: [{
                                "targets": [3],
                                "orderable": false
                            }]
                        });
                    });
                </script>'
        ];

        return view('roles.index', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $context = [
            'title' => 'Roles',
            'subtitle' => 'Create',
            //
            'permission' => Permission::get()
        ];

        return view('roles.create', $context);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required'
        ]);

        Role::create($request->all());

        return redirect()->route('roles.index')->with('success', 'Role saved successfully.');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        
        $context = [
            'title' => 'Roles',
            'subtitle' => 'Show',
        ];
    
        return view('roles.show',compact('role','permission','rolePermissions'),$context);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$role->id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
        
        $context = [
            'title' => 'Roles',
            'subtitle' => 'Update',
            //
            'permission' => Permission::get()
        ];
    
        return view('roles.edit',compact('role','permission','rolePermissions'),$context);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            "name" => 'required'
        ]);

        $role->update($request->all());

        $role->syncPermissions($request->permission);

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        $role->delete();
        return redirect()->route('roles.index')->with('success','Role deleted successfully');
    }
}
