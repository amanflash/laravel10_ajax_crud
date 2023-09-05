<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\employee;
use App\Http\Controllers\datatables;
use GuzzleHttp\Psr7\Response;

class EmployeeControler extends Controller
{
    public function index()
    {
        // Check if the request is made via AJAX
        if (request()->ajax()) {
            // Initialize DataTables and configure it
            return datatables()->of(employee::select('*'))
                ->addColumn('action', 'employee-action') // Add an "action" column with content from the "employee-action" view
                ->rawColumns(['action']) // Specify that the "action" column contains raw HTML
                ->addIndexColumn() // Add an index column with sequential numbers
                ->make(true); // Generate the DataTable and return it as a JSON response
        }
    
        // If not an AJAX request, render the "index" view
        return view('index');
    }
    

    public function store(Request $request)
    {  
  
        $employeeId = $request->id;
  
        $employee   =   employee::updateOrCreate(
                    [
                     'id' => $employeeId
                    ],
                    [
                    'name' => $request->name, 
                    'email' => $request->email,
                    'address' => $request->address
                    ]);    
                          
        return Response()->json($employee);
    }  
    
   
    public function edit(request $request){
        $where = array('id' => $request->id);
        $employee = employee::where($where)->first();

        return Response()->json($employee);

    }

    public function destroy(request $request){
        $employee = employee::where('id', $request->id)->delete();
        return response()->json($employee);

    }

}
