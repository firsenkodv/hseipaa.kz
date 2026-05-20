@extends('layouts.layout')
<x-seo.meta
    title="Контакты"
    description="Контакты компании — адреса, телефоны и email по городам"
    keywords="контакты"
/>
@section('content')

    <section class="unitedStates catalogContacts our-services pad_b1">
        <div class="block">
            <div class="block_content__breadcrumbs">{{ Breadcrumbs::render('contacts') }}</div>
            <div class="page_title pad_t1_important">
                <h1 class="h1">Контакты</h1>
            </div>
        </div>
            @if($cities->count())
            <div class="block">

                <div class="catalogContacts__tabs contactTabs">

                    <div class="tabs contactTabs__top">
                        @foreach($cities as $k => $city)
                            <div data-tab="G_tab{{ $k }}"
                                 class="contactTabs__tab contactTabs__tab__js G_tab{{ $k }} {{ $loop->first ? 'active' : '' }}">
                                {{ $city->title }}
                            </div>
                        @endforeach
                    </div>

                    <div class="contactTabs__bottom contactTabsBody contactTabsBody__js">
                        @foreach($cities as $k => $city)
                            <div data-tab="G_tab{{ $k }}"
                                 class="contact_area contact_area__js contactTabsBody__tab G_tab{{ $k }} {{ $loop->first ? 'active' : '' }}">

                                @if($city->subtitle)
                                    <div class="contact_area__subtitle">{{ $city->subtitle }}</div>
                                @endif

                                <div class="contact_area__flex">
                                    <div class="contact_area__left">
                                        <div class="color_grey_16 color_grey contact_area__label">Телефон:</div>
                                        @if($city->phone)
                                            <div class="property">{{ format_phone($city->phone) }}</div>
                                        @endif
                                        @if($city->phone2)
                                            <div class="property">{{ format_phone($city->phone2) }}</div>
                                        @endif
                                        @if($city->phone3)
                                            <div class="property">{{ format_phone($city->phone3) }}</div>
                                        @endif
                                        @if($city->phone4)
                                            <div class="property">{{ format_phone($city->phone4) }}</div>
                                        @endif
                                    </div>

                                    @if($city->address)
                                        <div class="contact_area__center">
                                            <div class="color_grey_16 color_grey contact_area__label">Адрес:</div>
                                            <div class="property">{{ $city->address }}</div>
                                        </div>
                                    @endif

                                    @if($city->email || $city->email2 || $city->email3)
                                        <div class="contact_area__right">
                                            <div class="color_grey_16 color_grey contact_area__label">E-mail:</div>
                                            @if($city->email)
                                                <div class="property">{{ $city->email }}</div>
                                            @endif
                                            @if($city->email2)
                                                <div class="property">{{ $city->email2 }}</div>
                                            @endif
                                            @if($city->email3)
                                                <div class="property">{{ $city->email3 }}</div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                @if($city->desc)
                                    <div class="contact_area__desc desc">{!! $city->desc !!}</div>
                                @endif

                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
                <div class="relative">
                    <div id="loader_wrapper" class="loader_wrapper active">
                        <div class="loader_map">Loading...</div>
                    </div>
                    <div class="JFormFieldMap_wrapper">
                        <div id="JFormFieldMap" class="JFormFieldMap" style="width: 100%; height: 450px;"></div>
                    </div>
                </div>

                <script>
                    var myMap;

                    function getYaMap() {
                        var firstCity = @json($cities->first()?->coordinates ?? '51.1801, 71.4460');

                        myMap = new ymaps.Map("JFormFieldMap", {
                            center: firstCity.split(',').map(Number),
                            zoom: 5,
                            controls: ['zoomControl', 'typeSelector', 'fullscreenControl']
                        }, {searchControlProvider: 'yandex#search'});

                        @foreach($cities as $k => $city)
                            @if($city->coordinates)
                                var myPlacemark{{ $k }} = new ymaps.Placemark(
                                    [{{ $city->coordinates }}],
                                    {
                                        balloonContent: '<h5>{{ $city->title }}</h5>'
                                            + '<p class="jt_ph">{{ format_phone($city->phone) }}</p>'
                                            @if($city->address)
                                            + '<p class="jt_ph">{{ $city->address }}</p>'
                                            @endif
                                    },
                                    {
                                        iconLayout: 'default#image',
                                        iconImageHref: '{{ asset('/storage/contacts/myIcon.svg') }}',
                                        iconImageSize: [58, 55],
                                        iconImageOffset: [-28, -48]
                                    }
                                );
                                myMap.geoObjects.add(myPlacemark{{ $k }});
                            @endif
                        @endforeach

                        var tabArrow = Array.from(document.querySelectorAll('.contactTabs__tab__js'));
                        var areaArrow = Array.from(document.querySelectorAll('.contact_area__js'));

                        var coordinates = {
                            @foreach($cities as $k => $city)
                                @if($city->coordinates)
                                    'G_tab{{ $k }}': '{{ $city->coordinates }}'{{ !$loop->last ? ',' : '' }}
                                @endif
                            @endforeach
                        };

                        tabArrow.forEach(function(arrow) {
                            arrow.addEventListener('click', function(e) {
                                tabArrow.forEach(function(t) { t.classList.remove('active'); });
                                e.currentTarget.classList.add('active');

                                var dataTab = e.currentTarget.dataset.tab;

                                areaArrow.forEach(function(a) {
                                    a.classList.contains(dataTab)
                                        ? a.classList.add('active')
                                        : a.classList.remove('active');
                                });

                                if (coordinates[dataTab]) {
                                    myMap.panTo(coordinates[dataTab].split(',').map(Number), {
                                        duration: 1000,
                                        checkZoomRange: true
                                    });
                                }
                            });
                        });
                    }
                </script>

            @endif


    </section>

@endsection
