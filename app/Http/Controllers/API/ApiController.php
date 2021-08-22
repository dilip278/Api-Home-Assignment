<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Models\Employee;
use App\Models\Department;
use Symfony\Component\HttpKernel\Exception\HttpException;
class ApiController extends BaseController
{

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    //api to login user which will authenticate and give bearer token which will be further used to authenticate other apis
    public function login(Request $request)
    {
        //authenticate user based on email and password 
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password,'role'=>'Admin'])) {
            $user = Auth::user();
            //generate bearer token 
            $success['token'] =  'Bearer '.$user->createToken('MyApp')-> accessToken;
            //get name of user after authentication
            $success['name'] =  $user->name;

            //send success response
            return $this->sendResponse($success, 'User login successfully.');
        } else {
            //send failure response
            return $this->sendError('Email or Paswword Incorrect', ['error'=>'Unauthorised']);
        }
    }

    //api function to create department details
    public function creatDepartmentDetails(Request $request){
        //function to valiate request
        $validator = Validator::make($request->all(), [
            "name"=>"required|string"
        ]);

        //check if validation fails or not
        if ($validator->fails()) {

            //send validation fail reqponse
            $response = [
                'status'=>400,
                'message' =>'Bad Request',
                'error'=>$validator->errors()
            ];
            return response($response,400);
        }else{
            //create data array to save in department table
            $requested_data=array(
                "name" => $request['name'],
                "employee_count" =>  $request['employee_count'],
            );
           //save request data to department table
            Department::create($requested_data);

            //send success response
            $response = [
                'status'=>200,
                'success' => true,
                'message' => "Successfully created department details",
            ];
            return response($response,200);
        }
    }

    //api function to create employee details
    public function creatEmployeeDetails(Request $request){
        //function to valiate request
       $validator = Validator::make($request->all(), [
            "emp_code"=>"required|string",
            "email"=>"required|email",
            "first_name" => "required|string",
            "last_name" => "required|string",
            "date_of_joining"=>"required|date",
            "profile"=>"required|string",
            "qualification"=>"required|string",
            "department_code"=>"required|integer",
            "ctc"=>"required|between:0,99.99",
            "in_hand_salary"=>"required|between:0,99.99",
            "phone_no"=>"required|array",
            "address"=>"required|array",
            "status"=>"required|string"
        ]);
        //check if validation fails or not
        if ($validator->fails()) {

            //send validation fail reqponse
            $response = [
                'status'=>400,
                'message' =>'Bad Request',
                'error'=>$validator->errors()
            ];
            return response($response,400);
        }else{
            //create data array to save in employee table
            $requested_data=array(
                "emp_code"=>$request['emp_code'],
                "email"=>$request['email'],
                "first_name" => $request['first_name'],
                "last_name" =>  $request['last_name'],
                "date_of_joining"=> $request['date_of_joining'],
                "profile"=> $request['profile'],
                "qualification"=> $request['qualification'],
                "department_code"=> $request['department_code'],
                "ctc"=> $request['ctc'],
                "in_hand_salary"=> $request['in_hand_salary'],
                "phone_no"=>json_encode($request['phone_no']) ,
                "address"=> $request['address'],
                "status"=> $request['status']
            );
           //save request data to employee table
            Employee::create($requested_data);

            //send success response
            $response = [
                'status'=>200,
                'success' => true,
                'message' => "Successfully created employee details",
            ];
            return response($response,200);
        }
    }

    //api to get emploee details based on employee id
    public function getEmployeeDetails($emp_code){
           //fetch employee data based on employee code
            $data=Employee::where('emp_code',$emp_code)->with(array('departmentData'=>function($query){$query->select('id','name');}))->first();

            //check if data exist or not
            if($data!=null){
                //parse the phone number staring array as jaon array 
                $data['phone_no']=json_decode($data['phone_no']);
                //send success response
                $response = [
                    'status'=>200,
                    'success' => true,
                    'message' => 'Employee data',
                    'data'=>$data
                ];
                return response($response,200);   
            }else{
                //send success response
                $response = [
                    'status'=>404,
                    'success' => false,
                    'message' => "No employee found for this employee code",
                    'data'=>null
                ];
                return response($response,404);   
            }
                       
    } 

    //api to update employee details
    public function updateEmployeeDetails(Request $request){
        try {
            //function to valiate request
            $validator = Validator::make($request->all(), [
                    "emp_code"=>"required|string",
                    "first_name" => "required|string",
                    "last_name" => "required|string",
                    "date_of_joining"=>"required|date",
                    "profile"=>"required|string",
                    "qualification"=>"required|string",
                    "department_code"=>"required|integer",
                    "ctc"=>"required|between:0,99.99",
                    "in_hand_salary"=>"required|between:0,99.99",
                    "phone_no"=>"required|array",
                    "address"=>"required|array",
                    "status"=>"required|string"
                ]);
                //check if validation fails or not
                if ($validator->fails()) {

                    //send validation fail reqponse
                    $response = [
                        'status'=>400,
                        'message' =>'Bad Request',
                        'error'=>$validator->errors()
                    ];
                    return response($response,400);
                }else{
                    $employee=Employee::where('emp_code',$request->emp_code)->first();
                    //check if employee exist or not
                    if($employee!=null){
                        //create data array to update in employee table
                        $requested_data=array(
                            "first_name" => $request['first_name'],
                            "last_name" =>  $request['last_name'],
                            "date_of_joining"=> $request['date_of_joining'],
                            "profile"=> $request['profile'],
                            "qualification"=> $request['qualification'],
                            "department_code"=> $request['department_code'],
                            "ctc"=> $request['ctc'],
                            "in_hand_salary"=> $request['in_hand_salary'],
                            "phone_no"=>json_encode($request['phone_no']) ,
                            "address"=> $request['address'],
                            "status"=> $request['status']
                        );
                        //update request data to employee table
                        Employee::where('emp_code', $request->emp_code)->update($requested_data);

                        //send success response
                        $response = [
                            'status'=>200,
                            'success' => true,
                            'message' => "Successfully updated employee details",
                        ];
                        return response($response,200);
                    }else{
                       //send failure response
                        $response = [
                            'status'=>404,
                            'success' => false,
                            'message' => "No employee found for this employee code",
                            'data'=>null
                        ];
                        return response($response,404);    
                    }
                }
            } catch (\Exception $e) {
                throw new HttpException(500, $e->getMessage());
            }
      
    }
  
}
