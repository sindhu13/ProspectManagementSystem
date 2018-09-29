<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

use App\User;
use App\Employee;
use App\MarketingGroup;
use App\Departement;
use Auth;

//Importing laravel-permission models
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

//Enables us to output flash messaging
use Session;

class UserController extends Controller {

    public function __construct() {
        $this->middleware(['auth', 'role:Super User']); //isAdmin middleware lets only users with a //specific permission permission to access these resources
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function index() {
    //Get all users and pass it to the view
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function create() {
    //Get all roles and pass it to the view
        $roles = Role::get();
        $employees = Employee::selectRaw('CONCAT (employees.name, " - ", departements.name) as colums, employees.id')
            ->join('departements', 'departements.id', 'employees.departement_id')
            ->pluck('colums', 'id');
        return view('users.create', compact('roles', 'employees'));
    }

    /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return \Illuminate\Http\Response
    */
    public function store(Request $request) {
    //Validate name, email and password fields
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6|confirmed',
            'employee_id' => 'required|unique:users'
        ]);

        $user = User::create($request->only('email', 'name', 'password', 'employee_id')); //Retrieving only the email and password data

        $roles = $request['roles']; //Retrieving the roles field
    //Checking if a role was selected
        if (isset($roles)) {

            foreach ($roles as $role) {
            $role_r = Role::where('id', '=', $role)->firstOrFail();
            $user->assignRole($role_r); //Assigning role to user
            }
        }
    //Redirect to the users.index view and display message
        $request->session()->flash('alert-success', 'User was successful added!');
        return redirect()->route('users.index');
    }

    /**
    * Display the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function show($id) {
        return redirect('users');
    }

    /**
    * Show the form for editing the specified resource.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function edit($id) {
        $user = User::findOrFail($id); //Get user with specified id
        $employees = Employee::selectRaw('CONCAT (employees.name, " - ", departements.name) as colums, employees.id')
            ->join('departements', 'departements.id', 'employees.departement_id')
            ->pluck('colums', 'id');
        $roles = Role::get(); //Get all roles

        return view('users.edit', compact('user', 'roles', 'employees')); //pass user and roles data to view

    }

    /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function update(Request $request, $id) {
        $user = User::findOrFail($id); //Get role specified by id

    //Validate name, email and password fields
        $this->validate($request, [
            'name'=>'required|max:120',
            'email'=>'required|email|unique:users,email,'.$id,
            'password'=>'required|min:6|confirmed',
            'employee_id'=>'required|unique:users,employee_id,'.$id,
        ]);
        $input = $request->only(['name', 'email', 'password', 'employee_id']); //Retreive the name, email and password fields
        $roles = $request['roles']; //Retreive all roles
        $user->fill($input)->save();

        if (isset($roles)) {
            $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
        }
        else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
        $request->session()->flash('alert-success', 'Unit was successful updates!');
        return redirect()->route('users.index');
    }

    /**
    * Remove the specified resource from storage.
    *
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */
    public function destroy($id) {
    //Find a user with a given id and delete
        $user = User::findOrFail($id);
        $user->delete();
        $request->session()->flash('alert-success', 'Unit was successful deleted!');
        return redirect()->route('users.index');
    }
}
