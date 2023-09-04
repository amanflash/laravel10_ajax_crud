<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\employee;
use Datatables;
use GuzzleHttp\Psr7\Response;

class EmployeeControler extends Controller
{
    public function index(){
        if(request()->ajax()){
            return datatables()->of(employee::select('*'))
            ->addColumn('action','employee-action')
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
            
        };

        
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
