@extends('layouts.admin-dashboard')

@section('title') Category List page || Admin, Ecommerce @endsection

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
                    <h3>Category List</h3>
                </div>

                <div class="title_right">
                    <a href="{{ route('category.create') }}" class="btn btn-success pull-right">
                        <i class="fas fa-plus"></i> Add Category
                    </a>
                </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>All Categories</h2>
                            <div class="clearfix"></div>
                            @include('admin.section.notification')
                        </div>
                        <div class="x_content">
                            <table class="table jambo_table">
                                <thead>
                                <th>Title</th>
                                <th>Is parent</th>
                                <th>Parent Cat</th>
                                <th>Image</th>
                                <th>Status</th>
                                <th>Action</th>
                                </thead>
                                <tbody>
                                @if($category_data)
                                    @foreach($category_data as $key=>$value)
                                        <tr>
                                            <td>{{ $value->title }}</td>
                                            <td>{{ ($value->is_parent == 1) ? 'Yes' : 'No' }}</td>
                                            <td>{{ $value->parent_info['title'] }}</td>
                                            <td>
                                                @if($value->image != null && file_exists(public_path().'/uploads/categories/'.$value->image))
                                                    <img style="max-width: 150px;" src="{{ asset('uploads/categories/'.$value->image) }}" alt="" class="img img-responsive img-thumbnail">
                                                @endif
                                            </td>
                                            <td>{{ ucfirst($value->status) }}</td>
                                            <td>
                                                <a href="{{ route('category.edit', $value->id) }}" style="border-radius: 50%" class="btn btn-success">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>
                                                <form onsubmit="return confirm('Are you sure you want to delete this category?')" action="{{ route('category.destroy', $value->id) }}" method="post">
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
