@extends('layouts.admin-dashboard')

@section('title') Banner {{ (isset($banner) && $banner->count()) > 0 ? 'Update' : 'Add' }} page || Admin, Ecommerce @endsection

@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Banner {{ (isset($banner) && $banner->count()) > 0 ? 'Update' : 'Add' }}</h3>
                </div>

                <div class="title_right">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Banner {{ (isset($banner) && $banner->count()) > 0 ? 'Update' : 'Add' }} Form</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(isset($banner) )
                                {{ Form::open(['url'=>route('banner.update', $banner->id), 'class'=>'form', 'enctype'=>'multipart/form-data']) }}
                                    @method('PUT')
                            @else
                                {{ Form::open(['url'=>route('banner.store'), 'class'=>'form', 'enctype'=>'multipart/form-data']) }}
                            @endif

                                <div class="form-group row">
                                    {{ Form::label('title','Title: ', ['class'=>'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::text('title', @$banner->title, ['class'=>'form-control', 'id'=>'title']) }}
                                        @if($errors->has('title'))
                                            <span class="alert-danger">{{ $errors->first('title') }}</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="form-group row">
                                    {{ Form::label('link','Link: ', ['class'=>'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::url('link', @$banner->link, ['class'=>'form-control', 'id'=>'url']) }}
                                        @if($errors->has('url'))
                                            <span class="alert-danger">{{ $errors->first('url') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('status','Status: ', ['class'=>'col-sm-3']) }}
                                    <div class="col-sm-9">
                                        {{ Form::select('status',['active' => 'Active','inactive' =>'Inactive'], @$banner->status, ['class'=>'form-control', 'id'=>'status','required'=>true]) }}
                                        @if($errors->has('status'))
                                            <span class="alert-danger">{{ $errors->first('status') }}</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('image','Image: ', ['class'=>'col-sm-3']) }}
                                    <div class="col-sm-4">
                                        {{ Form::file('image', ['id'=>'image','required'=> (isset($banner)) ? false : true, 'accept'=>'image/*']) }}
                                        @if($errors->has('image'))
                                            <span class="alert-danger">{{ $errors->first('image') }}</span>
                                        @endif
                                    </div>

                                    @if(isset($banner) && file_exists(public_path().'/uploads/banners/'.$banner->image))
                                        <div class="col-sm-4">
                                            <img src="{{ asset('uploads/banners/'.$banner->image) }}" alt="" class="img img-responsive img-thumbnail">
                                        </div>
                                    @endif
                                </div>
                                <div class="form-group row">
                                    {{ Form::label('submit','', ['class'=>'col-sm-3']) }}
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
