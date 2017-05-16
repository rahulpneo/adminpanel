<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;

use App\User;
use App\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$users = User::where('is_admin',0)->orderBy('id', 'desc')->paginate(10);
        $users = User::orderBy('id', 'desc')->paginate(10);
		
		return view('admin.users.index', compact('users','roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$roles = Role::orderBy('id', 'desc')->paginate(10);
        return view('admin.users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
	        'name' => 'required',
	        'email' => 'required|email|unique:users,email',
	        'password' => 'required|min:6',
	        'confirm_password' => 'required|min:6|same:password',
	    ]);
		
		$file = $request->file('image');
		$user = new User();
		//$data = $request->all();
		$data['name'] = $request->input('name');
		$data['email'] = $request->input('email');
		$data['password'] = bcrypt($request->input('password'));
		//$data['is_admin'] = $request->input('is_admin');
		$data['is_admin'] = 1;
		if($request->input('role') == 4)
		{
			$data['is_admin'] = 0;
		}
		$data['created_at'] = date('Y-m-d i:h:s');
		$data['updated_at'] = date('Y-m-d i:h:s');
		
		$created_user = $user->create($data);
		if($created_user)
		{
			$created_user->attachRole(Role::where('id',$request->input('role'))->first());
		
			if(!empty($file))
			{
				$time = time();
				$data['image'] = $time.'_'.$file->getClientOriginalName();
				
				//Move Uploaded File
			    $destinationPath = 'uploads/users/profile';
			    $file->move($destinationPath,$time.'_'.$file->getClientOriginalName());
				$profile_data['profile_image'] = $time.'_'.$file->getClientOriginalName();
			}
			
			$profile_data['about_me'] = $request->input('about_me');
			$created_user->user_profile()->create($profile_data);
			
			$request->session()->flash('success', 'User created successfully!');
		}
		else {
			$request->session()->flash('error', 'Sorry some error has occured!');
		}
		
		return redirect()->route('admin.users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::with('roles')->findOrFail($id);
		
		$roles = Role::orderBy('id', 'desc')->paginate(10);
		return view('admin.users.edit', compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
	        'name' => 'required',
	        'email' => 'sometimes|required|email|unique:users,email,'.$id.',id',
	        'password' => 'min:6',
	        'confirm_password' => 'same:password',
	    ]);
		
		$user = User::findOrFail($id);
		
		$data['name'] = $request->input('name');
		//$data['email'] = $request->input('email');
		if(!empty($request->input('password')))
		{
			$data['password'] = bcrypt($request->input('password'));
		}
		
		$data['is_admin'] = 1;
		if($request->input('role') == 4)
		{
			$data['is_admin'] = 0;
		}
		
		//$data['is_admin'] = $request->input('is_admin');
		
		$data['updated_at'] = date('Y-m-d i:h:s');
		
		$updated_user = $user->update($data);
		if($updated_user)
		{
			$roleKeys = array($request->input('role'));
			$user->roles()->sync($roleKeys);
			$request->session()->flash('success', 'User\'s record updated successfully!');
		}
		else {
			$request->session()->flash('error', 'Sorry some error has occured!');
		}
		
		return redirect()->route('admin.users.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request,$id)
    {
        $user = User::findOrFail($id);
		
		if($user->delete())
		{
			$request->session()->flash('success', 'User\'s record deleted successfully!');
		}
		else {
			$request->session()->flash('error', 'Sorry some error has occured!');
		}
		
		return redirect()->route('admin.users.index');
    }
	
	
	public function ajax_get_user()
	{
		$logged_in_user = Auth::user();
		
		//$users = User::where('is_admin',0)->orderBy('id', 'desc')->get();
		$users = User::with('roles')->orderBy('id', 'desc')->get();
		
		$users = $users->toArray();
		//echo "<pre>";print_r($users);echo "</pre>";
		$res['data'] = array();
		
		$i = 1;
		foreach($users as $user)
		{
			$data['sr_no'] = $i;
			$data['name'] = $user['name'];
			$data['email'] = $user['email'];
			//$data['created_date'] = date('d-m-Y',strtotime($user['created_at']));
			//$data['user_type'] = ($user['is_admin'] == 1)?'Admin':'Normal User';
			$data['user_type'] = (!empty($user['roles']) && isset($user['roles'][0]))?$user['roles'][0]['display_name']:'';
			$actions = '<a class="btn btn-xs btn-warning" href="'.route('admin.users.edit', $user['id']).'"><i class="glyphicon glyphicon-edit"></i> Edit</a>';
			
			if( $logged_in_user->id != $user['id'])
			{
				$actions .= '<form action="'.route('admin.users.destroy', $user['id']).'" method="POST" style="display: inline;" onsubmit="if(confirm(\'Delete? Are you sure?\')) { return true } else {return false };">
                                <input type="hidden" name="_method" value="DELETE">
                                <input type="hidden" name="_token" value="'.csrf_token().'">
                                <button type="submit" class="btn btn-xs btn-danger"><i class="glyphicon glyphicon-trash"></i> Delete</button>
                            </form>';
			}	
                                
            $data['actions'] = $actions;
			 
			$res['data'][] = $data; 
			$i++;
		}
		
		//echo "<pre>";print_r($res);
		
		return json_encode($res);
		//return json_encode($data);
		//return $users;
	}
}
