@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <div class="row">
            @include('partials.sidenavbar')

            <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Create A Post</h1>
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="blog_form" name="blog_form" action="{{ route('store_post') }}" method="POST" enctype="multipart/form-data">
                    {{  csrf_field() }}
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control"  aria-describedby="emailHelp" placeholder="Enter blog title" name="title" value="{{ old('title') }}">
                    </div>
                    <div class="form-group">
                        <label for="body">Blog Content</label>
                        <textarea class="form-control" rows="5" id="body" name="body" value="{{ old('body') }}"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlFile1">Feature Image</label>
                        <input type="file" class="form-control-file" id="image" name="image" value="{{ old('image') }}">
                    </div>
                    <input type="submit" value="Submit" class="btn btn-primary">
                </form>
            </main>
        </div>
    </div>
@endsection
