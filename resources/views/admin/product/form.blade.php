@extends('layouts.admin-dashboard')

@section('title') Product {{ (isset($product) && $product->count()) > 0 ? 'Update' : 'Add' }} page || Admin, Ecommerce @endsection

@section('content')
<!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Product {{ (isset($product) && $product->count()) > 0 ? 'Update' : 'Add' }}</h3>
                </div>

                <div class="title_right">
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Product {{ (isset($product) && $product->count()) > 0 ? 'Update' : 'Add' }} Form</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(isset($product) )
                                {{ Form::open(['url'=>route('product.update', $product->id), 'class'=>'form', 'enctype'=>'multipart/form-data']) }}
                                @method('PUT')
                            @else
                                {{ Form::open(['url'=>route('product.store'), 'class'=>'form', 'enctype'=>'multipart/form-data']) }}
                            @endif

                            <div class="form-group row">
                                {{ Form::label('title','Title: ', ['class'=>'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::text('title', @$product->title, ['class'=>'form-control', 'id'=>'title']) }}
                                    @if($errors->has('title'))
                                        <span class="alert-danger">{{ $errors->first('title') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('summary','Summary: ', ['class'=>'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::textarea('summary', @$product->summary, ['class'=>'form-control','rows'=>5, 'style'=>'resize:none', 'id'=>'summary']) }}
                                    @if($errors->has('summary'))
                                        <span class="alert-danger">{{ $errors->first('summary') }}</span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                {{ Form::label('description','Description: ', ['class'=>'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::textarea('description', @$product->description, ['class'=>'form-control','rows'=>5, 'style'=>'resize:none', 'id'=>'description']) }}
                                    @if($errors->has('description'))
                                        <span class="alert-danger">{{ $errors->first('description') }}</span>
                                    @endif
                                </div>
                            </div>



                            <div class="row">
                                <div class="{{ isset($product, $product->child_cat_id) ? 'col-sm-6' : 'col-sm-12' }}" id="parent_cat_div">
                                    <div class="form-group row">
                                        {{ Form::label('cat_id','Category: ', ['class'=>'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::select('cat_id', @$parent_cats, @$product->cat_id, ['class'=>'form-control','id'=>'cat_id', 'required' => true, 'placeholder'=>'Select Any One' ]) }}
                                            @if($errors->has('cat_id'))
                                                <span class="alert-danger">{{ $errors->first('cat_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6" style="display: {{ (isset($product, $product->child_cat_id) && $product->child_cat_id != null) ? 'block' : 'none' }};" id="child_cat_div">
                                    <div class="form-group row">
                                        {{ Form::label('child_cat_id','Sub Category: ', ['class'=>'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::select('child_cat_id', (isset($child_cats) ? $child_cats : []), @$product->child_cat_id, ['class'=>'form-control','id'=>'child_cat_id', 'placeholder'=>'Select Any One']) }}
                                            @if($errors->has('child_cat_id'))
                                                <span class="alert-danger">{{ $errors->first('child_cat_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6" >
                                    <div class="form-group row">
                                        {{ Form::label('price','Price: ', ['class'=>'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::number('price', @$product->price, ['class'=>'form-control','id'=>'price', 'required' => true, 'placeholder'=>'Enter Price', 'min'=>'0' ]) }}
                                            @if($errors->has('price'))
                                                <span class="alert-danger">{{ $errors->first('price') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6" >
                                    <div class="form-group row">
                                        {{ Form::label('discount','Discount: ', ['class'=>'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::number('discount', @$product->discount, ['class'=>'form-control','id'=>'discount', 'min'=> 0, 'max'=>100]) }}
                                            @if($errors->has('discount'))
                                                <span class="alert-danger">{{ $errors->first('discount') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6" >
                                    <div class="form-group row">
                                        {{ Form::label('brand','Brand: ', ['class'=>'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::text('brand', @$product->brand, ['class'=>'form-control','id'=>'brand', 'placeholder'=>'Enter Brand' ]) }}
                                            @if($errors->has('brand'))
                                                <span class="alert-danger">{{ $errors->first('brand') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                                <div class="col-sm-6" >
                                    <div class="form-group row">
                                        {{ Form::label('vendor','Vendor: ', ['class'=>'col-sm-12']) }}
                                        <div class="col-sm-12">
                                            {{ Form::select('vendor_id', $vendor,@$product->vendor_id, ['class'=>'form-control','id'=>'vendor_id']) }}
                                            @if($errors->has('vendor_id'))
                                                <span class="alert-danger">{{ $errors->first('vendor_id') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('status','Status: ', ['class'=>'col-sm-12']) }}
                                <div class="col-sm-12">
                                    {{ Form::select('status',['active' => 'Active','inactive' =>'Inactive'], @$product->status, ['class'=>'form-control', 'id'=>'status','required'=>true]) }}
                                    @if($errors->has('status'))
                                        <span class="alert-danger">{{ $errors->first('status') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group row">
                                {{ Form::label('image','Image: ', ['class'=>'col-sm-12']) }}
                                <div class="col-sm-4">
                                    {{ Form::file('image', ['id'=>'image','required'=> (isset($product)) ? false : true, 'accept'=>'image/*']) }}
                                    @if($errors->has('image'))
                                        <span class="alert-danger">{{ $errors->first('image') }}</span>
                                    @endif
                                </div>

                                @if(isset($product) && file_exists(public_path().'/uploads/product/'.$product->image))
                                    <div class="col-sm-4">
                                        <img src="{{ asset('uploads/product/'.$product->image) }}" alt="" class="img img-responsive img-thumbnail">
                                    </div>
                                @endif
                            </div>

                            <div class="form-group row">
                                {{ Form::label('other_images','Other Images: ', ['class'=>'col-sm-12']) }}
                                <div class="col-sm-4">
                                    {{ Form::file('other_images[]', ['id'=>'other_images', 'accept'=>'image/*','multiple'=>true]) }}
                                    @if($errors->has('other_images'))
                                        <span class="alert-danger">{{ $errors->first('other_images') }}</span>
                                    @endif
                                </div>
                            </div>

                            @if(isset($product, $product->product_images))
                                @foreach($product->product_images as $images)
                                    <div class="col-sm-3">
                                        <img src="{{ asset('uploads/product/'.$images->image_name) }}" alt="" class="img img-responsive img-thumbnail">
                                        {{ Form::checkbox('del_image[]', $images->image_name ) }} Delete
                                    </div>
                                @endforeach
                            @endif

                            <div class="form-group row">
                                {{ Form::label('','', ['class'=>'col-sm-12']) }}
                                <div class="col-sm-12">
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
        <script src="{{ asset('assets/admin/tinymce/tinymce.min.js') }}"></script>
        <script>
            tinymce.init({
                selector: '#description',
                plugins: 'print preview searchreplace autolink directionality visualblocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc insertdatetime advlist lists wordcount imagetools textpattern help',
                toolbar: 'formatselect | bold italic strikethrough forecolor backcolor permanentpen formatpainter | link image media pageembed | alignleft aligncenter alignright alignjustify  | numlist bullist outdent indent | removeformat | addcomment',

            });

            $('#cat_id').change(function(){
                var cat_id = $('#cat_id').val();

                if(cat_id != null){
                    $.ajax({
                        url: "{{ route('child-list') }}",
                        type: "post",
                        data: {
                            _token: "{{ csrf_token() }}",
                            category_id: cat_id
                        },
                        success: function(response){
                            if(typeof(response) != "object"){
                                response = $.parseJSON(response);
                            }
                            var html_option = "<option value='' disabled selected>Select Any one</option>";

                            if(response.success == true){
                                $.each(response.data, function(key, value){
                                    html_option += "<option value='"+value.id+"'>"+value.title+"</option>";
                                });
                                $('#parent_cat_div').addClass('col-sm-6').removeClass('col-sm-12');
                                $('#child_cat_div').show();
                            } else {
                                $('#parent_cat_div').removeClass('col-sm-6').addClass('col-sm-12');
                                $('#child_cat_div').hide();
                            }

                            $('#child_cat_id').html(html_option);
                        }
                    });
                }
            });
        </script>
    @endsection
