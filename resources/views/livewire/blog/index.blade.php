@section("name", $blog_category ? $blog_category->translate_name : trans("page.{$menu_name}"))
@section("icon", $menu_icon)

@section("{$menu_slug}-active", "active")

<div>
    <div class="container margin_60_35">

        @include("layouts.alert")

        <div class="row">
            <div class="col-lg-9">
                @foreach ($data_blog as $blog)
                    <article class="blog wow-delete fadeIn-delete">
                        <div class="row g-0">
                            <div class="col-lg-7">
                                <figure>
                                    <a draggable="false" href="{{ route("{$menu_slug}.view", ["blog_slug" => $blog->slug]) }}">
                                        <img draggable="false" src="{{ $blog->assetImage() }}" class="img-fluid w-100"
                                            alt="{{ trans("index.Blog") }} - {{ $blog->translate_name }} - {{ env("APP_TITLE") }}">
                                        <div class="preview">
                                            <span>{{ trans("index.Read More") }}</span>
                                        </div>
                                    </a>
                                </figure>
                            </div>

                            <div class="col-lg-5">
                                <div class="post_info">
                                    <small>{{ Date::parse($blog->date)->format("d F Y") }}</small>
                                    <h3><a draggable="false" href="{{ route("{$menu_slug}.view", ["blog_slug" => $blog->slug]) }}">{{ $blog->translate_name }}</a></h3>
                                    <p>{{ strip_tags(Str::limit($blog->translate_description, 300)) }}</p>
                                    <ul>
                                        <li>
                                            <div class="thumb">
                                                <img draggable="false" src="{{ asset("images/logo.png") }}" class="img-fluid w-100"
                                                    alt="{{ trans("index.Logo") }} - {{ env("APP_TITLE") }}">
                                            </div>
                                            Administrator
                                        </li>
                                        <li>
                                            <a draggable="false" href="{{ route("{$menu_slug}.view", ["blog_slug" => $blog->slug]) }}#comments">
                                                <i class="icon_comment_alt"></i>
                                                99
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </article>
                @endforeach

                {{ $data_blog->links("vendor.livewire.bootstrap") }}

            </div>

            @include("livewire.{$menu_slug}.sidebar")
        </div>
    </div>
</div>