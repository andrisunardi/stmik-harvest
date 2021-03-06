@section("name", trans("page.{$menu_name}"))
@section("icon", $menu_icon)

@section("{$menu_slug}-active", "active")

<div>
    <section class="our__about__area bg__white pb--80 pt--100">
        <div class="container">
            <div class="row about__wrapper">
                <div class="about">
                    <div class="section__title text-left">
                        <h2 class="title__line">{{ trans("index.Welcome To") }} {{ trans("index.Yayasan STMIK Harvest") }}</h2>
                        <p>{{ trans("index.College for Future Technopreneur") }}</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about">
                        <p class="about__details">
                            {!! html_entity_decode($setting->translate_about_us) !!}
                        </p>
                        <p class="about__details">
                            <h3 class="text-uppercase mb-2">{{ trans("index.Our Vision") }}</h3>
                            {!! html_entity_decode($setting->translate_vision) !!}
                        </p>
                        <p class="about__details">
                            <h3 class="text-uppercase mb-2">{{ trans("index.Our Mission") }}</h3>
                            {!! html_entity_decode($setting->translate_mission) !!}
                        </p>
                        <p class="about__details">
                            <h3 class="text-uppercase mb-2">{{ trans("index.Our History") }}</h3>
                            {!! html_entity_decode($setting->translate_history) !!}
                        </p>
                    </div>
                    <div class="about__thumb mt-3 mb-3 mb-lg-auto">
                        <img draggable="false" class="img-fluid rounded w-100" src="{{ asset("images/our-values-2.webp") }}" alt="{{ trans("page.Our Values") }} - 2 - {{ env("APP_TITLE") }}">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__thumb">
                        <img draggable="false" class="img-fluid rounded w-100" src="{{ asset("images/about-us.webp") }}" alt="{{ trans("page.About Us") }} - {{ env("APP_TITLE") }}">
                    </div>
                    <div class="about__thumb mt-5">
                        <img draggable="false" class="img-fluid rounded w-100" src="{{ asset("images/our-values-1.webp") }}" alt="{{ trans("page.Our Values") }} - 1 - {{ env("APP_TITLE") }}">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="htc__findout__area bg__cat--3">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="findout__wrap my-5 my-sm-auto">
                        <div class="findout__inner">
                            <h2>
                                <span>{{ trans("index.Ready to Join ?") }}</span>
                                {{ trans("index.It easy now to you for being our part, just click the button below and fill out the form with your data.") }}
                            </h2>
                            <div class="findout__btn">
                                {{-- <a draggable="false" class="htc__btn btn--yellow" href="{{ route("online-registration.index") }}">{{ trans("index.Register") }}</a> --}}
                                <a draggable="false" class="htc__btn btn--yellow" href="https://pmb.stmik-kuwera.civitas.id" target="_blank">{{ trans("index.Register") }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="htc__service__area bg__white ptb--80">
        <div class="container">
            <div class="row htc__service__wrap">

                @foreach ($data_value as $value)
                    <div class="col-lg-3 col-md-6">
                        <div class="service text-center {{ !$loop->first ? "service__color--{$loop->iteration}" : null }}">
                            <div class="service__icon">
                                <i class="{{ $value->icon }}"></i>
                            </div>
                            <div class="service__details">
                                <h2><a draggable="false" href="javascript:;">{{ $value->translate_name }}</a></h2>
                                <p>{!! html_entity_decode($value->translate_description) !!}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

                {{-- <div class="col-lg-3 col-md-4">
                    <div class="service text-center">
                        <div class="service__icon">
                            <i class="flaticon-student"></i>
                        </div>
                        <div class="service__details">
                            <h2><a draggable="false" href="javascript:;">Future Technology</a></h2>
                            <p>Mahasiswa akan mempelajari teknologi terdepan yang sangat dibutuhkan industri pada 5-10 tahun mendatang, seperti Cloud Computing, Mobile Technology, Big Data, Internet of Things, Business Intelligence, dll.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="service text-center service__color--2">
                        <div class="service__icon">
                            <i class="flaticon-graduation-cap"></i>
                        </div>
                        <div class="service__details">
                            <h2><a draggable="false" href="javascript:;">Future Technopreneur</a></h2>
                            <p>Mahasiswa akan dibekali dengan pengetahuan dan skill untuk menjadi technopreneur atau pemimpin bisnis TI melalui Harvest Start-up Center.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="service text-center service__color--3">
                        <div class="service__icon">
                            <i class="flaticon-classroom"></i>
                        </div>
                        <div class="service__details">
                            <h2><a draggable="false" href="javascript:;">21st Century Skills</a></h2>
                            <p>Mahasiswa akan diperlengkapi dengan soft skills yang sangat diperlukan untuk berkarir, yaitu Communication, Collaboration, Critical Thinking, Creativity and Innovation Skills.</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3 col-md-4">
                    <div class="service text-center service__color--4">
                        <div class="service__icon">
                            <i class="flaticon-graduate-diploma"></i>
                        </div>
                        <div class="service__details">
                            <h2><a draggable="false" href="javascript:;">International Enrichment Program</a></h2>
                            <p>Bagi mahasiswa yang berprestasi, tersedia kesempatan magang di luar negeri seperti di Singapore, Australia, Korea Selatan dan Amerika Serikat.</p>
                        </div>
                    </div>
                </div> --}}
            </div>
        </div>
    </section>

    <section class="our__about__area bg__white pb--80 pt--100 bg-light">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section__title text-center">
                        <h2 class="title__line">{{ trans("page.Our Network") }}</h2>
                        <p>
                            {{ trans("index.STMIK HARVEST cooperates with several universities abroad.") }}<br>
                            {{ trans("index.Some of the cooperation agendas include lecturer and curriculum development programs, as well as student exchange programs.") }}
                            {{-- STMIK HARVEST bekerjasama dengan beberapa perguruan tinggi di luar negeri.<br>
                            Beberapa agenda kerjasama antara lain program pengembangan dosen dan kurikulum, serta program pertukaran mahasiswa. --}}
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="shop__content__wrap">
                        <div role="tabpanel" class="single__shop__view clearfix tab-pane fade show active" id="shop-view">
                            <div class="row">
                                @foreach ($data_network as $network)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="shop">
                                            <div class="shop__thumb">
                                                <a draggable="false" href="{{ $network->link }}" target="_blank">
                                                    <img draggable="false" src="{{ $network->assetImage() }}" class="img-fluid img-thumbnail rounded w-100" alt="{{ trans("page.Our Network") }} - {{ $network->name }} - {{ env("APP_TITLE") }}">
                                                </a>
                                            </div>
                                            <div class="shop__details">
                                                <h2><a draggable="false" href="{{ $network->link }}" target="_blank">{{ $network->name }}</a></h2>
                                                <span class="product__price">{!! html_entity_decode($network->description) !!}</span>
                                                <div class="shop__btn">
                                                    <a class="htc__btn btn--transparent" href="{{ $network->link }}" target="_blank">
                                                        <i class="icon ion-link"></i>
                                                        <span class="text-lowercase">{{ Str::replace(["https://", "http://"], "", $network->link) }}</span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
