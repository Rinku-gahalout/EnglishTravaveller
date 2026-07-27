<header class="main-header">
    <div class="container">
        <nav class="navbar navbar-expand-lg">

            <!-- Logo -->
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/Group (1).png') }}" alt="Logo">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Menu -->
            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav mx-auto">

                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/') }}">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about') }}">About Us</a>
                    </li>

                    @foreach ($categories as $category)
                        @if ($category->subcategories->count())
                            {{-- Category WITH subcategories → dropdown --}}
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle"
                                   href="{{ route('categoryblogs', ['cate_subcate' => $category->subcategories->first()->slug]) }}"
                                   id="dropdown-{{ $category->slug }}"
                                   role="button"
                                   data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    {{ $category->name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="dropdown-{{ $category->slug }}">
                                    @foreach ($category->subcategories as $subcategory)
                                        <li>
                                            <a class="dropdown-item"
                                               href="{{ route('categoryblogs', ['cate_subcate' => $subcategory->slug]) }}">
                                                {{ $subcategory->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            {{-- Category WITHOUT subcategories → plain link --}}
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('categoryblogs', ['cate_subcate' => $category->slug]) }}">
                                    {{ $category->name }}
                                </a>
                            </li>
                        @endif
                    @endforeach

                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact</a>
                    </li>

                    {{-- <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog') }}">Blog</a>
                    </li> --}}
                </ul>

                <a href="tel:+18444263868" class="phone-btn">
                    <img src="{{ asset('images/call-calling.png') }}" alt="Phone" class="phone-icon">
                    +1-844-426-3868
                </a>

            </div>

        </nav>
    </div>
</header>