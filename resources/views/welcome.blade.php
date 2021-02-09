<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="http://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/css/star-rating.min.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-star-rating/4.0.2/js/star-rating.min.js"></script>
</head>
<body>
<div id="">
    <nav class="navbar navbar-light bg-success justify-content-between">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <a class="navbar-brand" style="color: white" href="{{ route('landing_page') }}">Test Blog General View</a>
            </div>
            <form class="form-inline" action="{{ route('search_blog') }}" method="GET">
                <input class="form-control mr-sm-2" type="search" name="search" id="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit" style="color: white">Search</button>
            </form>
            <ul class="navbar-nav px-3">
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                         document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav>
    <main class="py-4">
        <div class="row container-fluid">
            {{-- main content area--}}
            <div class="col-md-8">
                @foreach($posts as $post)
                    <div class="card mb-3">
                        @if($post->image)
                            <a href="{{ route('view_post', ['post_id' => $post->id]) }}">
                                <img class="card-img-top" src="{{ asset('images/'.$post->image) }}" alt="{{ $post->title }}" style="height: 400px">
                            </a>
                        @endif
                        <div class="card-body">
                            <a href="{{ route('view_post', ['post_id' => $post->id]) }}">
                                <h5 class="card-title">{{ $post->title }}</h5>
                            </a>
                            <p class="card-text">
                                {{ $post->body }}
                            </p>
                            <p class="card-text"><small class="text-muted">{{ $post->writer->name }} </small></p>
                            <p>
                                <input id="input-1" name="input-1" class="rating rating-loading" data-min="0" data-max="5" data-step="0.1" value="{{ $post->averageRating }}" data-size="xs" disabled="">
                            </p>
                        </div>
                    </div>
                @endforeach
                @if(!$is_search)
                    {{ $posts->links() }}
                @endif
            </div>

            {{-- side navbar --}}
            <div class="col-md-4">
                <div class="card" style="width: 22rem;">
                    <div class="card-header">
                        Recent Posts
                    </div>
                    <ul class="list-group list-group-flush">
                        @foreach($latest_posts as $post)
                            <li class="list-group-item">
                                <a href="{{ URL::to('search?search=' . $post->title) }}">{{ $post->title }}</a>
                            </li>
                        @endforeach
                        @if(Route::is('search_blog') )
                            <li class="list-group-item">
                                <a href="{{ route('landing_page') }}">Back to All post</a>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </main>
</div>
</body>
<script type="text/javascript">
    $("#input-id").rating();
</script>
</html>
