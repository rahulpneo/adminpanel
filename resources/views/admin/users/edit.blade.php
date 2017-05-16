@extends('layouts.admin.base')
@section('styles')
<link href="{{asset('admin_design/css/validationEngine.jquery.css')}}" rel="stylesheet" type="text/css" />
@stop

@section('content')
    

    <div class="page-content">
    <div class="row">
        <div class="col-md-12">
        	
            <div class="tabbable-line boxless tabbable-reversed">
                <div class="portlet box blue-hoki">
                    <div class="portlet-title">
                    	<div class="caption">Edit User</div>
                    </div>
                    <div class="portlet-body form" style="display: block;">
                    	@include('error')
                        <!-- BEGIN FORM-->
                        <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="form-horizontal" id="update_user">
                            <input type="hidden" name="_method" value="PUT">
                            {{csrf_field()}}
                            <div class="form-body">
                                
                                <div class="form-group @if($errors->has('name')) has-error @endif">
									<label class="col-md-3 control-label" for="name-field">Name *</label>
									<div class="col-md-4">
									<input type="text" id="name-field" name="name" class="form-control validate[required]" value="{{ is_null(old("name")) ? $user->name : old("name") }}"/>
				                    @if($errors->has("name"))
				                        <span class="help-block">{{ $errors->first("name") }}</span>
				                    @endif
				                   </div>
			                    </div>
			                    
			                    <div class="form-group @if($errors->has('email')) has-error @endif">
									<label class="col-md-3 control-label" for="email-field">Email *</label>
									<div class="col-md-4">
									<input type="text" id="email-field" name="email" class="form-control validate[required,custom[email]]" readonly value="{{ is_null(old("email")) ? $user->email : old("email") }}"/>
				                    @if($errors->has("email"))
				                        <span class="help-block">{{ $errors->first("email") }}</span>
				                    @endif
				                   </div>
			                    </div>
			                    
			                    <div class="form-group @if($errors->has('password')) has-error @endif">
									<label class="col-md-3 control-label" for="password-field">Password</label>
									<div class="col-md-4">
									<input type="password" id="password-field" name="password" class="form-control " />
				                    @if($errors->has("password"))
				                        <span class="help-block">{{ $errors->first("password") }}</span>
				                    @endif
				                   </div>
			                    </div>
			                    <div class="form-group @if($errors->has('confirm_password')) has-error @endif">
									<label class="col-md-3 control-label" for="c_password-field">Confirm Password</label>
									<div class="col-md-4">
									<input type="password" id="c_password-field" name="confirm_password" class="form-control "/>
				                    @if($errors->has("confirm_password"))
				                        <span class="help-block">{{ $errors->first("confirm_password") }}</span>
				                    @endif
				                   </div>
			                    </div>
			                    
                                <!--<div class="form-group @if($errors->has('is_admin')) has-error @endif">
									<label class="col-md-3 control-label" for="role-field">User Role *</label>
									<div class="col-md-4">
									<select id="role-field" name="is_admin" class="form-control">
										<option value="0" {{ ($user->is_admin == 0 )? 'selected' : '' }}>Normal User</option>
										<option value="1" {{ ($user->is_admin == 1 )? 'selected' : '' }}>Admin</option>
									</select>
									
				                    @if($errors->has("is_admin"))
				                        <span class="help-block">{{ $errors->first("is_admin") }}</span>
				                    @endif
				                   </div>
			                    </div>-->
			                    <div class="form-group @if($errors->has('role')) has-error @endif">
									<label class="col-md-3 control-label" for="role">User Role *</label>
									<div class="col-md-4">
									@php 
										$old_role_id = (is_null(old("role")) && count($user->roles)>0)?$user->roles[0]->id:old("role");
									@endphp		
									<select id="is_admin" name="role" class="form-control">
										<!-- <option value="0" selected>Normal User</option>
										<option value="1" >Admin</option> -->
										@php $r=0 @endphp
										@foreach($roles as $role)
											<option value="{{$role->id}}" {{($old_role_id == $role->id)?'selected':''}}>{{$role->display_name}}</option>
										@php $r++ @endphp	
										@endforeach
									</select>
									
				                    @if($errors->has("is_admin"))
				                        <span class="help-block">{{ $errors->first("role") }}</span>
				                    @endif
				                   </div>
			                    </div>
                            </div>
                            
                            <div class="form-actions">
                                <div class="row">
                                    <div class="col-md-offset-3 col-md-9">
                                        <button type="submit" class="btn green">Update</button>
                                        <a class="btn default" href="{{ route('admin.users.index') }}">Back</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- END FORM-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
    
                        
@endsection

@section('scripts')
<script src="{{asset('admin_design/js/jquery.validationEngine.js')}}" type="text/javascript"></script>
<script src="{{asset('admin_design/js/jquery.validationEngine-en.js')}}" type="text/javascript"></script>
<script src="{{asset('admin_design/js/custom-jquery.js')}}" type="text/javascript"></script>

<script>
	$(document).ready(function(){
		$("#update_user").validationEngine({scroll: false});
	});
</script>
@stop
