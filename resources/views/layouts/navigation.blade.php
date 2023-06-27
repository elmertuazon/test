<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            {{ config('app.name', 'Laravel') }}
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('posts.create') }}">Add a new post</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('links.create') }}">Add a new link</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('home', ['popular'=>1]) }}">Popular Posts</a>
                </li>
                @auth()
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('user.posts') }}">My Post</a>
                    </li>
                @endauth
                <li>
                    <form method="GET" action="{{ route('home', ['search' => request()->input('search')]) }}">
                    <div class="row">
                        <div class="col-6">
                        <input name="search" type="text" class="form-control"
                        value="">
                        </div>
                        <div class="col-6">
                        <button type="submit" class="btn btn-primary">Search</button>
                        </div>
                    </div>
                    </form>


                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Authentication Links -->
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                           data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('home', ['favorite' => 1]) }}">
                                Favorite Posts
                            </a>
                            <a class="dropdown-item" href="{{ route('user.edit') }}">
                                Update Account
                            </a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
