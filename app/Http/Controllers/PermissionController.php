<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;

class PermissionController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:permission-list|permission-create|permission-edit|permission-delete', ['only' => ['index','store']]);
        $this->middleware('permission:permission-create', ['only' => ['create','store']]);
        $this->middleware('permission:permission-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:permission-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = Permission::get();
        if($request->ajax())
        { 
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '
                    <form action="'.route('permissions.destroy',$row->id).'" method="POST">
                        <a class="btn btn-sm" href="'.route('permissions.show',$row->id).'"><i class="far fa-eye fa-sm text-secondary"></i></a>
                        <a class="btn btn-sm" href="'.route('permissions.edit',$row->id).'"><i class="far fa-edit fa-sm text-secondary"></i></a>
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
            'title' => 'Permissions',
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
                            ajax: "'.route('permissions.index').'",
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

        return view('permissions.index', $context);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $context = [
            'title' => 'Permissions',
            'subtitle' => 'Create',
        ];

        return view('permissions.create', $context);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name" => 'required'
        ]);

        Permission::create($request->all());

        return redirect()->route('permissions.index')->with('success', 'Permission saved successfully.');
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
    public function edit(string $id)
    {
        //
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
