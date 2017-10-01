@extends('layouts.app')

@section('template_title')
	{{ trans('profile.templateTitle') }}
@endsection

@section('content')
	<div class="container">
		<div class="row">
			<div class="col-md-10 col-md-offset-1">
				<div class="panel panel-default">
					<div class="panel-heading">
						<div class="btn-group pull-right btn-group-xs">
							<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
								<i class="fa fa-ellipsis-v fa-fw" aria-hidden="true"></i>
								<span class="sr-only">{{ trans('profile.editTriggerAlt') }}</span>
							</button>
							<ul class="dropdown-menu">
								<li class="active">
									<a data-toggle="pill" href=".edit_profile" class="profile-trigger">
										{{ trans('profile.editProfileTitle') }}
									</a>
								</li>
								<li>
									<a data-toggle="pill" href=".edit_settings" class="settings-trigger">
										{{ trans('profile.editAccountTitle') }}
									</a>
								</li>
								<li>
									<a data-toggle="pill" href=".edit_account" class="admin-trigger">
										{{ trans('profile.editAccountAdminTitle') }}
									</a>
								</li>
							</ul>
						</div>
						<div class="tab-content">
							<span class="tab-pane active edit_profile">
								{{ trans('profile.editProfileTitle') }}
							</span>
							<span class="tab-pane edit_settings">
								{{ trans('profile.editAccountTitle') }}
							</span>
							<span class="tab-pane edit_account">
								{{ trans('profile.editAccountAdminTitle') }}
							</span>
						</div>
					</div>
					<div class="panel-body">
						@if ($user->profile)
							@if (Auth::user()->id == $user->id)
								<div class="tab-content">
									<div class="tab-pane fade in active edit_profile">
										<div class="row">
											<div class="col-sm-12">
												<div id="avatar_container">
													<div class="collapseOne panel-collapse collapse @if($user->profile->avatar_status == 0) in @endif">
														<div class="panel-body">
															<img src="{{  Gravatar::get('test@test.ch') }}" alt="{{ $user->name_gen }}" class="user-avatar">
														</div>
													</div>
													<div class="collapseTwo panel-collapse collapse @if($user->profile->avatar_status == 1) in @endif">
														<div class="panel-body">
															<div class="dz-preview"></div>
															{!! Form::open(array('route' => 'avatar.upload', 'method' => 'POST', 'name' => 'avatarDropzone','id' => 'avatarDropzone', 'class' => 'form single-dropzone dropzone single', 'files' => true)) !!}
																<img id="user_selected_avatar" class="user-avatar" src="@if ($user->profile->avatar != NULL) {{ $user->profile->avatar }} @endif" alt="{{ $user->name_gen }}">
															{!! Form::close() !!}
														</div>
													</div>
												</div>
											</div>
										</div>
										{!! Form::model($user->profile, ['method' => 'PATCH', 'route' => ['profile.update', $user->name_gen],  'class' => 'form-horizontal', 'role' => 'form', 'enctype' => 'multipart/form-data'  ]) !!}
											{{ csrf_field() }}
											<div class="row">
												<div class="col-sm-5 col-sm-offset-4 margin-bottom-1">
													<div class="row" data-toggle="buttons">
														<div class="col-xs-6 right-btn-container">
															<label class="btn btn-primary @if($user->profile->avatar_status == 0) active @endif btn-block btn-sm" data-toggle="collapse" data-target=".collapseOne:not(.in), .collapseTwo.in">
																<input type="radio" name="avatar_status" id="option1" autocomplete="off" value="0" @if($user->profile->avatar_status == 0) checked @endif> Use Gravatar
															</label>
														</div>
														<div class="col-xs-6 left-btn-container">
															<label class="btn btn-primary @if($user->profile->avatar_status == 1) active @endif btn-block btn-sm" data-toggle="collapse" data-target=".collapseOne.in, .collapseTwo:not(.in)">
																<input type="radio" name="avatar_status" id="option2" autocomplete="off" value="1" @if($user->profile->avatar_status == 1) checked @endif> Use My Image
															</label>
														</div>
													</div>
												</div>
											</div>
											<div class="form-group has-feedback {{ $errors->has('theme') ? ' has-error ' : '' }}">
												{!! Form::label('theme', trans('profile.label-theme') , array('class' => 'col-sm-4 control-label')); !!}
												<div class="col-sm-6">
													<select class="form-control" name="theme_id" id="theme_id">
														@if ($themes->count())
															@foreach($themes as $theme)
															  <option value="{{ $theme->id }}"{{ $currentTheme->id == $theme->id ? 'selected="selected"' : '' }}>{{ $theme->name }}</option>
															@endforeach
														@endif
													</select>
													<span class="glyphicon {{ $errors->has('theme') ? ' glyphicon-asterisk ' : ' ' }} form-control-feedback" aria-hidden="true"></span>
											        @if ($errors->has('theme'))
											            <span class="help-block">
											                <strong>{{ $errors->first('theme') }}</strong>
											            </span>
											        @endif
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-6 col-sm-offset-4">
													{!! Form::button(
														'<i class="fa fa-fw fa-save" aria-hidden="true"></i> ' . trans('profile.submitButton'),
														 array(
															'class' 		 	=> 'btn btn-success disableddd',
															'type' 			 	=> 'button',
															'data-target' 		=> '#confirmForm',
															'data-modalClass' 	=> 'modal-success',
															'data-toggle' 		=> 'modal',
															'data-title' 		=> trans('modals.edit_user__modal_text_confirm_title'),
															'data-message' 		=> trans('modals.edit_user__modal_text_confirm_message')
													)) !!}
												</div>
											</div>
										{!! Form::close() !!}
									</div>
									<div class="tab-pane fade edit_settings">
										{!! Form::model($user, array('action' => array('ProfilesController@updateUserAccount', $user->id), 'method' => 'PUT', 'id' => 'user_basics_form')) !!}
											{!! csrf_field() !!}
								            <div class="form-group has-feedback row {{ $errors->has('name') ? ' has-error ' : '' }}">
								                {!! Form::label('scoutname', 'Pfadiname' , array('class' => 'col-md-3 control-label')); !!}
								                <div class="col-md-9">
								                  	<div class="input-group">
								                    	{!! Form::text('scoutname', old('scoutname'), array('id' => 'scoutname', 'class' => 'form-control', 'placeholder' => trans('forms.ph-scoutname'))) !!}
								                    	<label class="input-group-addon" for="scoutname"><i class="fa fa-fw fa-user }}" aria-hidden="true"></i></label>
								                  	</div>
								                </div>
								            </div>
								            <div class="form-group has-feedback row {{ $errors->has('first_name') ? ' has-error ' : '' }}">
								                {!! Form::label('first_name', trans('forms.create_user_label_firstname'), array('class' => 'col-md-3 control-label')); !!}
								                <div class="col-md-9">
								                  	<div class="input-group">
								                    	{!! Form::text('first_name', NULL, array('id' => 'first_name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_firstname'))) !!}
								                    	<label class="input-group-addon" for="first_name"><i class="fa fa-fw {{ trans('forms.create_user_icon_firstname') }}" aria-hidden="true"></i></label>
								                  	</div>
								                  	@if ($errors->has('first_name'))
								                    	<span class="help-block">
								                        	<strong>{{ $errors->first('first_name') }}</strong>
								                    	</span>
								                  	@endif
								                </div>
								            </div>
								            <div class="form-group has-feedback row {{ $errors->has('last_name') ? ' has-error ' : '' }}">
								                {!! Form::label('last_name', trans('forms.create_user_label_lastname'), array('class' => 'col-md-3 control-label')); !!}
								                <div class="col-md-9">
								                  	<div class="input-group margin-bottom-1">
								                    	{!! Form::text('last_name', NULL, array('id' => 'last_name', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_lastname'))) !!}
								                    	<label class="input-group-addon" for="last_name"><i class="fa fa-fw {{ trans('forms.create_user_icon_lastname') }}" aria-hidden="true"></i></label>
								                  	</div>
								                  	@if ($errors->has('last_name'))
								                    	<span class="help-block">
								                        	<strong>{{ $errors->first('last_name') }}</strong>
								                    	</span>
								                  	@endif
								                </div>
								            </div>
										    <div class="form-group row">
											    <div class="col-md-9 col-md-offset-3">
													{!! Form::button(
														'<i class="fa fa-fw fa-save" aria-hidden="true"></i> ' . trans('profile.submitProfileButton'),
														 array(
															'class' 		 	=> 'btn btn-success',
															'id' 				=> 'account_save_trigger',
															'disabled'			=> true,
															'type' 			 	=> 'button',
															'data-submit'       => trans('profile.submitProfileButton'),
															'data-target' 		=> '#confirmForm',
															'data-modalClass' 	=> 'modal-success',
															'data-toggle' 		=> 'modal',
															'data-title' 		=> trans('modals.edit_user__modal_text_confirm_title'),
															'data-message' 		=> trans('modals.edit_user__modal_text_confirm_message')
													)) !!}
												</div>
											</div>
										{!! Form::close() !!}
									</div>
									<div class="tab-pane fade edit_account">
										<ul class="nav nav-pills nav-justified margin-bottom-3">
											<li class="bg-info change-pw active">
												<a data-toggle="pill" href="#changepw" class="warning-pill-trigger">
													{{ trans('profile.changePwPill') }}
												</a>
											</li>
											<li class="bg-info delete-account">
												<a data-toggle="pill" href="#deleteAccount" class="danger-pill-trigger">
													{{ trans('profile.deleteAccountPill') }}
												</a>
											</li>
										</ul>
										<div class="tab-content">
										    <div id="changepw" class="tab-pane fade in active">
												<h3 class="margin-bottom-1">
													{{ trans('profile.changePwTitle') }}
												</h3>
												{!! Form::model($user, array('action' => array('ProfilesController@updateUserPassword', $user->id), 'method' => 'PUT', 'autocomplete' => 'new-password')) !!}
												    <div class="pw-change-container margin-bottom-2">
														<div class="form-group has-feedback row {{ $errors->has('password') ? ' has-error ' : '' }}">
														  	{!! Form::label('password', trans('forms.create_user_label_password'), array('class' => 'col-md-3 control-label')); !!}
														  	<div class="col-md-9">
																{!! Form::password('password', array('id' => 'password', 'class' => 'form-control ', 'placeholder' => trans('forms.create_user_ph_password'), 'autocomplete' => 'new-password')) !!}
														        @if ($errors->has('password'))
														            <span class="help-block">
														                <strong>{{ $errors->first('password') }}</strong>
														            </span>
														        @endif
														  	</div>
														</div>
												        <div class="form-group has-feedback row {{ $errors->has('password_confirmation') ? ' has-error ' : '' }}">
												          	{!! Form::label('password_confirmation', trans('forms.create_user_label_pw_confirmation'), array('class' => 'col-md-3 control-label')); !!}
												          	<div class="col-md-9">
												              	{!! Form::password('password_confirmation', array('id' => 'password_confirmation', 'class' => 'form-control', 'placeholder' => trans('forms.create_user_ph_pw_confirmation'))) !!}
																<span id="pw_status"></span>
																@if ($errors->has('password_confirmation'))
																    <span class="help-block">
																        <strong>{{ $errors->first('password_confirmation') }}</strong>
																    </span>
																@endif
												          	</div>
												        </div>
												    </div>
												    <div class="form-group row">
													    <div class="col-md-9 col-md-offset-3">
															{!! Form::button(
																'<i class="fa fa-fw fa-save" aria-hidden="true"></i> ' . trans('profile.submitPWButton'),
																 array(
																	'class' 		 	=> 'btn btn-warning',
																	'id' 				=> 'pw_save_trigger',
																	'disabled'			=> true,
																	'type' 			 	=> 'button',
																	'data-submit'       => trans('profile.submitButton'),
																	'data-target' 		=> '#confirmForm',
																	'data-modalClass' 	=> 'modal-warning',
																	'data-toggle' 		=> 'modal',
																	'data-title' 		=> trans('modals.edit_user__modal_text_confirm_title'),
																	'data-message' 		=> trans('modals.edit_user__modal_text_confirm_message')
															)) !!}
														</div>
													</div>
												{!! Form::close() !!}
	    									</div>
										    <div id="deleteAccount" class="tab-pane fade">
										      	<h3 class="margin-bottom-1 text-center text-danger">
										      		{{ trans('profile.deleteAccountTitle') }}
										      	</h3>
										      	<p class="margin-bottom-2 text-center">
													<i class="fa fa-exclamation-triangle fa-fw" aria-hidden="true"></i>
														<strong>Deleting</strong> your account is <u><strong>permanent</strong></u> and <u><strong>cannot</strong></u> be undone.
													<i class="fa fa-exclamation-triangle fa-fw" aria-hidden="true"></i>
										      	</p>
												<hr/>
												<div class="row">
													<div class="col-sm-6 col-sm-offset-3 margin-bottom-3 text-center">
														{!! Form::model($user, array('action' => array('ProfilesController@deleteUserAccount', $user->id), 'method' => 'DELETE')) !!}
															<div class="btn-group btn-group-vertical margin-bottom-2" data-toggle="buttons">
																<label class="btn no-shadow" for="checkConfirmDelete" >
																	<input type="checkbox" name='checkConfirmDelete' id="checkConfirmDelete">
																	<i class="fa fa-square-o fa-fw fa-2x"></i>
																	<i class="fa fa-check-square-o fa-fw fa-2x"></i>
																	<span class="margin-left-2"> Confirm Account Deletion</span>
																</label>
															</div>
														    {!! Form::button(
														    	'<i class="fa fa-trash-o fa-fw" aria-hidden="true"></i> ' . trans('profile.deleteAccountBtn'),
																array(
																	'class' 			=> 'btn btn-block btn-danger',
																	'id' 				=> 'delete_account_trigger',
																	'disabled'			=> true,
																	'type' 				=> 'button',
																	'data-toggle' 		=> 'modal',
																	'data-submit'       => trans('profile.deleteAccountBtnConfirm'),
																	'data-target' 		=> '#confirmForm',
																	'data-modalClass' 	=> 'modal-danger',
																	'data-title' 		=> trans('profile.deleteAccountConfirmTitle'),
																	'data-message' 		=> trans('profile.deleteAccountConfirmMsg')
																)
														    ) !!}
														{!! Form::close() !!}
													</div>
												</div>
										    </div>
										</div>
									</div>
								</div>
							@else
								<p>{{ trans('profile.notYourProfile') }}</p>
							@endif
						@else
							<p>{{ trans('profile.noProfileYet') }}</p>
						@endif
					</div>
				</div>
			</div>
		</div>
	</div>
	@include('modals.modal-form')
@endsection

@section('footer_scripts')
	@include('scripts.form-modal-script')
	@include('scripts.gmaps-address-lookup-api3')
	@include('scripts.user-avatar-dz')

	<script type="text/javascript">
		$('.dropdown-menu li a').click(function() {
			$('.dropdown-menu li').removeClass('active');
		});

		$('.profile-trigger').click(function() {
			$('.panel').alterClass('panel-*', 'panel-default');
		});

		$('.settings-trigger').click(function() {
			$('.panel').alterClass('panel-*', 'panel-info');
		});

		$('.admin-trigger').click(function() {
			$('.panel').alterClass('panel-*', 'panel-warning');
			$('.edit_account .nav-pills li, .edit_account .tab-pane').removeClass('active');
			$('#changepw')
				.addClass('active')
				.addClass('in');
			$('.change-pw').addClass('active');
		});

		$('.warning-pill-trigger').click(function() {
			$('.panel').alterClass('panel-*', 'panel-warning');
		});

		$('.danger-pill-trigger').click(function() {
			$('.panel').alterClass('panel-*', 'panel-danger');
		});

		$('#user_basics_form').on('keyup change', 'input, select, textarea', function(){
		    $('#account_save_trigger').attr('disabled', false);
		});

		$('#checkConfirmDelete').change(function() {
		    var submitDelete = $('#delete_account_trigger');
		    var self = $(this);

		    if (self.is(':checked')) {
		        submitDelete.attr('disabled', false);
		    }
		    else {
		    	submitDelete.attr('disabled', true);
		    }
		});

		$("#password_confirmation").keyup(function() {
			checkPasswordMatch();
		});

		$("#password, #password_confirmation").keyup(function() {
			enableSubmitPWCheck();
		});

		$('#password, #password_confirmation').hidePassword(true);

		$('#password').password({
			shortPass: 'Das Passwort ist zu kurz',
			badPass: 'Weak - Try combining letters & numbers',
			goodPass: 'Medium - Try using special charecters',
			strongPass: 'Strong password',
			containsUsername: 'The password contains the username',
			enterPass: false,
			showPercent: false,
			showText: true,
			animate: true,
			animateSpeed: 50,
			username: false, // select the username field (selector or jQuery instance) for better password checks
			usernamePartialMatch: true,
			minimumLength: 6
		});

		function checkPasswordMatch() {
		    var password = $("#password").val();
		    var confirmPassword = $("#password_confirmation").val();
		    if (password != confirmPassword) {
		        $("#pw_status").html("Passwords do not match!");
		    }
		    else {
		        $("#pw_status").html("Passwords match.");
		    }
		}

		function enableSubmitPWCheck() {
		    var password = $("#password").val();
		    var confirmPassword = $("#password_confirmation").val();
		    var submitChange = $('#pw_save_trigger');
		    if (password != confirmPassword) {
		       	submitChange.attr('disabled', true);
		    }
		    else {
		        submitChange.attr('disabled', false);
		    }
		}
	</script>
@endsection
