@extends('layouts.admin-dashboard')

@section('title') User {{ (isset($user) && $user->count()) > 0 ? 'Update' : 'Add' }} page || Admin, Ecommerce @endsection

@section('scripts')
    <script>
        $('#change_password').change(function(e){
            var checked = $('#change_password').prop('checked');
            if(checked){
                $('#password').attr('required');
                $('#password-confirm').attr('required');
                $('#change_password_div').removeClass('hidden');
            } else {
                $('#password').removeAttr('required');
                $('#password-confirm').removeAttr('required');
                $('#change_password_div').addClass('hidden');

            }
        });
    </script>

@endsection
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>User {{ (isset($user) && $user->count()) > 0 ? 'Update' : 'Add' }}</h3>
                </div>

                <div class="title_right">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>User {{ (isset($user) && $user->count()) > 0 ? 'Update' : 'Add' }} Form</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                                {{ Form::open(['url'=>route('admin-update', $user->id), 'class'=>'form', 'enctype'=>'multipart/form-data']) }}
                                @method('PUT')


                            <div class="form-group row">
                                {{ Form::label('name','Name: ', ['class'=>'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('name', @$user->name, ['class'=>'form-control', 'id'=>'name']) }}
                                    @if($errors->has('name'))
                                        <span class="alert-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group row">
                                {{ Form::label('address','Address: ', ['class'=>'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('address', @$user->address, ['class'=>'form-control', 'id'=>'address', 'rows'=> '5', 'style' => 'resize:none']) }}
                                    @if($errors->has('address'))
                                        <span class="alert-danger">{{ $errors->first('address') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('change_password','Change Password: ', ['class'=>'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::checkbox('change_password', 1, false,['id'=>'change_password']) }}
                                    @if($errors->has('change_password'))
                                        <span class="alert-danger">{{ $errors->first('change_password') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="hidden" id="change_password_div">
                                <div class="form-group row">
                                    {{ Form::label('password','Password: ', ['class'=>'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::password('password', ['class'=>'form-control', 'id'=>'password']) }}
                                        @if($errors->has('password'))
                                            <span class="alert-danger">{{ $errors->first('password') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{ Form::label('confirm_password','Re-Password: ', ['class'=>'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::password('password_confirmation', ['class'=>'form-control', 'id'=>'confirm_password']) }}
                                        @if($errors->has('confirm_password'))
                                            <span class="alert-danger">{{ $errors->first('confirm_password') }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('phone','Phone: ', ['class'=>'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::tel('phone', @$user->phone, ['class'=>'form-control', 'id'=>'phone']) }}
                                    @if($errors->has('phone'))
                                        <span class="alert-danger">{{ $errors->first('phone') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('','', ['class'=>'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::button('<i class="fas fa-paper-plane"></i> Submit', ['id'=>'submit', 'class'=> 'btn btn-success', 'type'=>'submit']) }}
                                    {{ Form::button('<i class="fas fa-trash"></i> Cancel', ['id'=>'cancel', 'class'=> 'btn btn-danger', 'type'=>'reset']) }}
                                </div>
                            </div>
                            {{ Form::close() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
