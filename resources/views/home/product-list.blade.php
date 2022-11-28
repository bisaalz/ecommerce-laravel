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
