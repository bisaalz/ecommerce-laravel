@extends('layouts.home')

@section('meta')
    <meta content="sasto, nepali ecommerce, ecommerce, nepal, online shopping, first ecommerece of nepal, mt. everest, lumbini, nepal, politics, electronics" name="keywords">
    <meta content="The one and only nepali ecommerce website which provides you all sort of goods in an afforadable price with in nepal." name="description">

    <meta content="The one and only nepali ecommerce website which provides you all sort of goods in an afforadable price with in nepal." property="og:description">
    <meta content="Ecommerce.com, the first nepali online ecommerce portal" property="og:title">
    <meta content="{{ asset('assets/home/images/icons/logo-01.png') }}" property="og:image">
    <meta content="website" property="og:type">
    <meta content="{{ route('homepage') }}" property="og:url">
@endsection
@section('content')
    <!-- Slider -->
    <section class="section-slide">
        <div class="wrap-slick1">
            <div class="slick1">
                @if($banner)
                    @foreach($banner as $banner_data)
                        <div class="item-slick1" style="background-image: url({{ asset('uploads/banners/'.$banner_data->image) }});">
                            <div class="container h-full">
                                <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                                    {{--<div class="layer-slick1 animated visible-false" data-appear="rotateInDownLeft" data-delay="0">
                                        <span class="ltext-101 cl2 respon2">

                                        </span>
                                    </div>--}}

                                    <div class="layer-slick1 animated visible-false" data-appear="rotateInUpRight" data-delay="800">
                                        <h2 class="ltext-201 cl2 p-t-19 p-b-43 respon1">
                                            {{ $banner_data->title }}
                                        </h2>
                                    </div>

                                    @if($banner_data->link != null)
                                    <div class="layer-slick1 animated visible-false" data-appear="rotateIn" data-delay="1600">
                                        <a href="{{ $banner_data->link }}" target="_slider" class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                            Shop Now
                                        </a>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        </div>
    </section>


    <!-- Banner -->
    <div class="sec-banner bg0 p-t-80 p-b-50">
        <div class="container">
            <div class="row">
                @if($category)
                    @foreach($category as $cat_info)
                        <div class="col-md-3 col-xl-3 p-b-30 m-lr-auto">
                            <!-- Block1 -->
                            <div class="block1 wrap-pic-w">
                                <img src="{{ asset('uploads/categories/'.$cat_info->image) }}" alt="IMG-BANNER">

                                <a href="{{ route('category-list', $cat_info->slug) }}" class="block1-txt ab-t-l s-full flex-col-l-sb p-lr-38 p-tb-34 trans-03 respon3">
                                    <div class="block1-txt-child1 flex-col-l">
								<span class="block1-name ltext-102 trans-04 p-b-8">
									{{ $cat_info->title }}
								</span>

                                        <span class="block1-info stext-102 trans-04">
									Spring 2018
								</span>
                                    </div>

                                    <div class="block1-txt-child2 p-b-4 trans-05">
                                        <div class="block1-link stext-101 cl0 trans-09">
                                            Shop Now
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                    @endforeach
                @endif



            </div>
        </div>
    </div>


    <!-- Product -->
    <section class="bg0 p-t-23 p-b-140">
        <div class="container">
            <div class="p-b-10">
                <h3 class="ltext-103 cl5">
                    Product Overview
                </h3>
            </div>

            @include('home.section.category')

            @include('home.section.product-list')


        </div>
    </section>
@endsection
