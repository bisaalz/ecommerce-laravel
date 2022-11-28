@extends('layouts.admin-dashboard')

@section('title') Product List page || Admin, Ecommerce @endsection

@section('links')
    <link rel="stylesheet" href="{{ asset('assets/admin/css/jquery.dataTables.min.css') }}">
@endsection
@section('scripts')
    <script src="{{ asset('/assets/admin/js/jquery.dataTables.min.js') }}"></script>
    <script>
        $('.table').dataTable();
    </script>
@endsection
@section('content')
    <!-- page content -->
    <div class="right_col" role="main">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Product List</h3>
                </div>

                <div class="title_right">
                    <a href="{{ route('product.create') }}" class="btn btn-success pull-right">
                        <i class="fas fa-plus"></i> Add Product
                    </a>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>All Products</h2>
                            <div class="clearfix"></div>
                            @include('admin.section.notification')
                        </div>
                        <div class="x_content">
                            <table class="table jambo_table">
                                <thead>
                                    <th>Title</th>
                                    <th>Category</th>
                                    <th>Sub-category</th>
                                    <th>Price(NPR.)</th>
                                    <th>Discount(%)</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                @if($product_data)
                                    @foreach($product_data as $key=>$value)
                                        <tr>
                                            <td>{{ $value->title }}</td>
                                            <td>{{ $value->category_info['title'] }}</td>
                                            <td>{{ $value->child_category_info['title']}}</td>
                                            <td>{{ "NPR. ".number_format($value->price) }}</td>
                                            <td>{{ $value->discount.' % ' }}</td>
                                            <td>
                                                @if($value->image != null && file_exists(public_path().'/uploads/product/'.$value->image))
                                                    <img style="max-width: 75px;" src="{{ asset('uploads/product/'.$value->image) }}" alt="" class="img img-responsive img-thumbnail">
                                                @endif
                                            </td>
                                            <td>{{ ucfirst($value->status) }}</td>
                                            <td>
                                                <a href="{{ route('product.edit', $value->id) }}" style="border-radius: 50%" class="btn btn-success">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form onsubmit="return confirm('Are you sure you want to delete this product?')" action="{{ route('product.destroy', $value->id) }}" method="post">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger" style="border-radius: 50%">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->
@endsection
