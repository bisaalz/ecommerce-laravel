@extends('layouts.admin-dashboard')

@section('title') Category {{ (isset($category) && $category->count()) > 0 ? 'Update' : 'Add' }} page || Admin, Ecommerce @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Category {{ (isset($category) && $category->count()) > 0 ? 'Update' : 'Add' }}</h3>
                </div>

                <div class="title_right">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Category {{ (isset($category) && $category->count()) > 0 ? 'Update' : 'Add' }} Form</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(isset($category) )
                                {{ Form::open(['url'=>route('category.update', $category->id), 'class'=>'form', 'enctype'=>'multipart/form-data']) }}
                                @method('PUT')
                            @else
                                {{ Form::open(['url'=>route('category.store'), 'class'=>'form', 'enctype'=>'multipart/form-data']) }}
                            @endif

                            <div class="form-group row">
                                {{ Form::label('title','Title: ', ['class'=>'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::text('title', @$category->title, ['class'=>'form-control', 'id'=>'title']) }}
                                    @if($errors->has('title'))
                                        <span class="alert-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('summary','Summary: ', ['class'=>'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::textarea('summary', @$category->summary, ['class'=>'form-control','rows'=>5, 'style'=>'resize:none', 'id'=>'summary']) }}
                                    @if($errors->has('summary'))
                                        <span class="alert-danger">{{ $errors->first('summary') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('is_parent','Is Parent: ', ['class'=>'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::checkbox('is_parent', 1, true, ['id'=>'is_parent']) }} Yes
                                    @if($errors->has('is_parent'))
                                        <span class="alert-danger">{{ $errors->first('is_parent') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row" style="display:none" id="parent_id_div">
                                {{ Form::label('parent_id','Parent Id: ', ['class'=>'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('parent_id', $parent_cats, @$category->parent_id, ['class'=>'form-control','id'=>'parent_id']) }}
                                    @if($errors->has('parent_id'))
                                        <span class="alert-danger">{{ $errors->first('parent_id') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('status','Status: ', ['class'=>'col-sm-3']) }}
                                <div class="col-sm-9">
                                    {{ Form::select('status',['active' => 'Active','inactive' =>'Inactive'], @$category->status, ['class'=>'form-control', 'id'=>'status','required'=>true]) }}
                                    @if($errors->has('status'))
                                        <span class="alert-danger">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('image','Image: ', ['class'=>'col-sm-3']) }}
                                <div class="col-sm-4">
                                    {{ Form::file('image', ['id'=>'image','required'=> (isset($category)) ? false : true, 'accept'=>'image/*']) }}
                                    @if($errors->has('image'))
                                        <span class="alert-danger">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>

                                @if(isset($category) && file_exists(public_path().'/uploads/categories/'.$category->image))
                                    <div class="col-sm-4">
                                        <img src="{{ asset('uploads/categories/'.$category->image) }}" alt="" class="img img-responsive img-thumbnail">
                                    </div>
                                @endif
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

@section('scripts')
    <script>

        $('#is_parent').change(function(){
            var prop = $('#is_parent').prop('checked'); // true
            if(prop == false){
                $('#parent_id_div').slideDown('fast');
            } else {
                $('#parent_id_div').slideUp('fast');
            }
        });
    </script>
@endsection
