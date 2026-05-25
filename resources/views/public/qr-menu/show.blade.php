<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} | QR Menu</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0
        }

        body {
            background: #edf2f3;
            font-family: Inter, system-ui, -apple-system, "Segoe UI", sans-serif;
            color: #111827
        }

        button {
            font-family: inherit;
            cursor: pointer;
            border: none
        }

        a {
            text-decoration: none;
            color: inherit
        }

        .app {
            width: 100%;
            max-width: 520px;
            margin: 0 auto;
            min-height: 100vh;
            background: #fffaf2;
            position: relative;
            overflow-x: hidden;
            padding-bottom: 156px;
            box-shadow: 0 0 0 1px rgba(15, 23, 42, .08)
        }

        .hero {
            height: 340px;
            padding: 18px;
            color: #fff;
            position: relative;
            overflow: hidden;
            border-bottom-left-radius: 36px;
            border-bottom-right-radius: 36px;
            background: linear-gradient(180deg, rgba(0, 0, 0, .18), rgba(0, 0, 0, .78)), url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80') center/cover
        }

        .hero:after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 20%, rgba(16, 185, 129, .25), transparent 34%)
        }

        .top {
            position: relative;
            z-index: 2;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .round {
            width: 48px;
            height: 48px;
            border-radius: 18px;
            background: rgba(0, 56, 45, .78);
            color: #fff;
            font-size: 23px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(255, 255, 255, .2);
            backdrop-filter: blur(14px)
        }

        .lang {
            height: 48px;
            padding: 0 16px;
            border-radius: 18px;
            background: rgba(0, 30, 24, .78);
            color: #fff;
            font-weight: 900;
            border: 1px solid rgba(255, 255, 255, .2)
        }

        .brand {
            text-align: center;
            position: relative;
            z-index: 2;
            padding-top: 28px
        }

        .logo {
            width: 74px;
            height: 74px;
            margin: 0 auto 8px;
            border-radius: 28px;
            display: grid;
            place-items: center;
            color: #d9a743;
            font-size: 38px;
            font-weight: 950
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 24px
        }

        .name {
            font-family: Georgia, serif;
            font-size: 38px;
            line-height: 1;
            font-weight: 900;
            text-transform: uppercase
        }

        .type {
            margin-top: 8px;
            color: #e5b85c;
            letter-spacing: 7px;
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase
        }

        .table {
            display: inline-flex;
            margin-top: 15px;
            padding: 9px 17px;
            border-radius: 999px;
            background: linear-gradient(135deg, #064236, #0b6b50);
            font-weight: 950;
            box-shadow: 0 14px 30px rgba(0, 60, 45, .34)
        }

        .welcome {
            margin-top: 14px;
            font-size: 16px;
            font-weight: 800;
            color: rgba(255, 255, 255, .92)
        }

        .bill {
            position: relative;
            z-index: 4;
            margin: -64px 14px 18px;
            border-radius: 30px;
            padding: 20px;
            color: #fff;
            background: radial-gradient(circle at top right, rgba(72, 187, 120, .28), transparent 34%), linear-gradient(135deg, #063b31, #083326 60%, #0b4d3d);
            box-shadow: 0 22px 45px rgba(6, 44, 35, .34)
        }

        .bill-grid {
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            gap: 16px
        }

        .bill-left {
            border-right: 1px solid rgba(255, 255, 255, .14);
            padding-right: 14px
        }

        .bill-title {
            font-size: 20px;
            font-weight: 950;
            display: flex;
            gap: 10px;
            align-items: center
        }

        .open {
            margin-top: 14px;
            display: flex;
            gap: 8px;
            align-items: center;
            font-size: 14px;
            font-weight: 850;
            color: rgba(255, 255, 255, .86)
        }

        .dot {
            width: 9px;
            height: 9px;
            border-radius: 99px;
            background: #4ade80
        }

        .badge {
            background: #d7a950;
            border-radius: 99px;
            padding: 3px 10px;
            color: #fff;
            font-weight: 950
        }

        .last {
            margin-top: 13px;
            display: grid;
            gap: 9px
        }

        .last-row {
            display: grid;
            grid-template-columns: 40px 1fr auto;
            align-items: center;
            gap: 9px;
            font-size: 13px;
            font-weight: 850
        }

        .last-img {
            width: 40px;
            height: 40px;
            border-radius: 13px;
            background: #ecfdf5;
            display: grid;
            place-items: center
        }

        .last-price {
            color: #4ade80;
            white-space: nowrap
        }

        .bill-label {
            font-size: 15px;
            font-weight: 850;
            color: rgba(255, 255, 255, .83)
        }

        .bill-total {
            font-size: 40px;
            font-weight: 950;
            color: #f1c86a;
            white-space: nowrap;
            margin-top: 8px
        }

        .check {
            width: 100%;
            height: 54px;
            border-radius: 19px;
            margin-top: 18px;
            background: linear-gradient(135deg, #f3c96a, #dba13e);
            font-size: 15px;
            font-weight: 950;
            color: #1d1a13
        }

        .actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            padding: 0 18px
        }

        .action {
            height: 76px;
            border-radius: 24px;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            color: #084437;
            font-size: 15px;
            font-weight: 950;
            box-shadow: 0 14px 32px rgba(15, 23, 42, .08)
        }

        .head {
            padding: 24px 18px 12px;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .title {
            font-size: 22px;
            font-weight: 950;
            color: #0f172a
        }

        .all {
            font-size: 13px;
            font-weight: 900;
            color: #083326
        }

        .cats {
            display: flex;
            gap: 12px;
            overflow-x: auto;
            padding: 0 18px 4px;
            scrollbar-width: none
        }

        .cats::-webkit-scrollbar {
            display: none
        }

        .cat {
            min-width: 82px;
            height: 86px;
            border-radius: 23px;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-weight: 900;
            box-shadow: 0 13px 28px rgba(15, 23, 42, .07);
            white-space: nowrap
        }

        .cat.active {
            background: linear-gradient(135deg, #064236, #0d5a46);
            color: #fff
        }

        .cat span:first-child {
            font-size: 25px
        }

        .products-head {
            padding: 20px 18px 10px;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .sort {
            height: 38px;
            padding: 0 13px;
            border-radius: 99px;
            background: #fff;
            border: 1px solid #eef0f2;
            font-weight: 900;
            box-shadow: 0 8px 22px rgba(15, 23, 42, .05)
        }

        .grid {
            padding: 0 18px 20px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 14px
        }

        .card {
            background: #fff;
            border-radius: 24px;
            overflow: hidden;
            text-align: left;
            box-shadow: 0 14px 34px rgba(15, 23, 42, .09);
            position: relative
        }

        .img {
            height: 136px;
            margin: 9px;
            border-radius: 20px;
            overflow: hidden;
            background: linear-gradient(135deg, #f8fafc, #ecfdf5);
            position: relative
        }

        .img img {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .fallback {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            font-size: 38px
        }

        .tag {
            position: absolute;
            left: 10px;
            top: 10px;
            height: 28px;
            padding: 0 10px;
            border-radius: 99px;
            background: #22c55e;
            color: #fff;
            font-size: 12px;
            font-weight: 950;
            display: flex;
            align-items: center
        }

        .fav {
            position: absolute;
            right: 10px;
            top: 10px;
            width: 34px;
            height: 34px;
            border-radius: 99px;
            background: rgba(255, 255, 255, .72);
            display: grid;
            place-items: center;
            font-size: 18px
        }

        .info {
            padding: 3px 13px 14px
        }

        .pname {
            font-size: 16px;
            font-weight: 950;
            line-height: 1.2
        }

        .desc {
            margin-top: 7px;
            min-height: 38px;
            font-size: 12px;
            color: #667085;
            font-weight: 650;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden
        }

        .price {
            margin-top: 12px;
            font-size: 18px;
            font-weight: 950
        }

        .add {
            width: 100%;
            height: 42px;
            margin-top: 12px;
            border-radius: 15px;
            background: linear-gradient(135deg, #064236, #0d5a46);
            color: #fff;
            font-size: 14px;
            font-weight: 950
        }

        .empty {
            grid-column: 1/-1;
            border-radius: 24px;
            padding: 28px;
            background: #fff;
            text-align: center;
            color: #667085;
            font-weight: 800
        }

        .cart {
            position: fixed;
            left: 50%;
            bottom: 74px;
            transform: translateX(-50%);
            width: calc(100% - 24px);
            max-width: 496px;
            min-height: 78px;
            border-radius: 28px;
            background: linear-gradient(135deg, #05392f, #064236 58%, #0b5b47);
            color: #fff;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 13px;
            padding: 13px;
            box-shadow: 0 18px 44px rgba(6, 44, 35, .38);
            z-index: 50
        }

        .bag {
            width: 54px;
            height: 54px;
            border-radius: 22px;
            background: rgba(0, 0, 0, .22);
            display: grid;
            place-items: center;
            position: relative;
            font-size: 24px
        }

        .count {
            position: absolute;
            top: -7px;
            right: -4px;
            min-width: 25px;
            height: 25px;
            border-radius: 99px;
            background: #fff;
            color: #064236;
            font-size: 12px;
            font-weight: 950;
            display: grid;
            place-items: center
        }

        .clabel {
            font-size: 13px;
            color: rgba(255, 255, 255, .83);
            font-weight: 850
        }

        .ctotal {
            margin-top: 3px;
            color: #f1c86a;
            font-size: 24px;
            font-weight: 950
        }

        .send {
            height: 54px;
            padding: 0 18px;
            border-radius: 20px;
            background: linear-gradient(135deg, #f3c96a, #dba13e);
            color: #1d1a13;
            font-size: 14px;
            font-weight: 950;
            white-space: nowrap
        }

        .nav {
            position: fixed;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 100%;
            max-width: 520px;
            height: 76px;
            background: rgba(255, 255, 255, .96);
            border-top-left-radius: 28px;
            border-top-right-radius: 28px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            align-items: center;
            z-index: 45;
            box-shadow: 0 -10px 30px rgba(15, 23, 42, .08)
        }

        .nav div {
            text-align: center;
            color: #667085;
            font-size: 12px;
            font-weight: 900
        }

        .nav .active {
            color: #0b5b47
        }

        .nav span {
            display: block;
            font-size: 22px;
            margin-bottom: 3px
        }

        .overlay {
            position: fixed;
            inset: 0;
            z-index: 200;
            background: rgba(2, 6, 23, .48);
            display: none;
            justify-content: center
        }

        .overlay.active {
            display: flex
        }

        .detail {
            width: 100%;
            max-width: 520px;
            min-height: 100vh;
            background: #fffaf2;
            overflow-y: auto;
            position: relative;
            padding-bottom: 106px;
            animation: slide .22s ease-out
        }

        @keyframes slide {
            from {
                transform: translateX(28px);
                opacity: .7
            }

            to {
                transform: translateX(0);
                opacity: 1
            }
        }

        .dhero {
            height: 390px;
            position: relative;
            overflow: hidden;
            border-bottom-left-radius: 36px;
            border-bottom-right-radius: 36px;
            background: #111827
        }

        .dhero img,
        .dfallback {
            width: 100%;
            height: 100%;
            object-fit: cover
        }

        .dfallback {
            display: grid;
            place-items: center;
            font-size: 96px;
            background: radial-gradient(circle, #fff7ed, #ecfdf5)
        }

        .dhero:after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, .35), transparent 45%, rgba(0, 0, 0, .18))
        }

        .dtop {
            position: absolute;
            z-index: 3;
            top: 18px;
            left: 18px;
            right: 18px;
            display: flex;
            justify-content: space-between
        }

        .dacts {
            display: flex;
            gap: 10px
        }

        .dcard {
            position: relative;
            z-index: 4;
            margin: -36px 0 0;
            background: #fffaf2;
            border-top-left-radius: 36px;
            border-top-right-radius: 36px;
            padding: 25px 18px
        }

        .drow {
            display: flex;
            align-items: center;
            gap: 10px
        }

        .dname {
            font-size: 28px;
            font-weight: 950;
            line-height: 1.08
        }

        .popular {
            height: 30px;
            padding: 0 11px;
            border-radius: 99px;
            background: #22c55e;
            color: #fff;
            display: flex;
            align-items: center;
            font-size: 12px;
            font-weight: 950
        }

        .stars {
            margin-top: 12px;
            color: #f59e0b;
            font-weight: 900
        }

        .rating {
            color: #111827;
            margin-left: 8px
        }

        .ddesc {
            margin-top: 18px;
            color: #667085;
            font-size: 15px;
            line-height: 1.62;
            font-weight: 650
        }

        .dprice-row {
            margin-top: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center
        }

        .dprice {
            font-size: 34px;
            font-weight: 950
        }

        .qty {
            height: 50px;
            border-radius: 20px;
            background: #fff;
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 0 17px;
            box-shadow: 0 12px 28px rgba(15, 23, 42, .08);
            font-size: 18px;
            font-weight: 950
        }

        .qty button {
            background: transparent;
            font-size: 25px;
            font-weight: 900
        }

        .sub {
            margin-top: 28px;
            font-size: 18px;
            font-weight: 950
        }

        .ingredients {
            margin-top: 14px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap
        }

        .ing {
            width: 74px;
            min-height: 74px;
            border-radius: 19px;
            background: #fff;
            display: grid;
            place-items: center;
            text-align: center;
            gap: 4px;
            padding: 9px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .06);
            font-size: 11px;
            font-weight: 900
        }

        .ing span {
            font-size: 24px
        }

        .addons {
            margin-top: 14px;
            display: grid;
            gap: 12px
        }

        .addon {
            min-height: 48px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 11px;
            border-bottom: 1px solid rgba(226, 232, 240, .9);
            font-size: 15px;
            font-weight: 850
        }

        .addon input {
            width: 21px;
            height: 21px
        }

        .aprice {
            color: #0b7c50;
            font-weight: 950
        }

        .iboxes {
            margin-top: 18px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px
        }

        .ibox {
            height: 72px;
            border-radius: 22px;
            background: #fff;
            display: grid;
            place-items: center;
            text-align: center;
            font-size: 13px;
            font-weight: 900;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .04)
        }

        .dbottom {
            position: fixed;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 100%;
            max-width: 520px;
            min-height: 96px;
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
            background: linear-gradient(135deg, #05392f, #064236);
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: center;
            gap: 14px;
            padding: 17px 18px;
            z-index: 230
        }

        .dadd {
            height: 58px;
            border-radius: 22px;
            background: linear-gradient(135deg, #f3c96a, #dba13e);
            color: #1d1a13;
            font-size: 15px;
            font-weight: 950
        }

        @media(max-width:430px) {
            .name {
                font-size: 31px
            }

            .bill-grid {
                grid-template-columns: 1fr
            }

            .bill-left {
                border-right: 0;
                border-bottom: 1px solid rgba(255, 255, 255, .13);
                padding-right: 0;
                padding-bottom: 15px
            }

            .img {
                height: 116px
            }

            .cart {
                grid-template-columns: auto 1fr
            }

            .send {
                grid-column: 1/-1;
                width: 100%
            }
        }
    </style>
</head>

<body>
    @php
    $allProducts = collect();
    foreach ($categories as $category) {
    foreach ($category->products as $product) {
    $allProducts->push($product);
    }
    }
    foreach ($uncategorizedProducts as $product) {
    $allProducts->push($product);
    }
    @endphp

    <div class="app">
        <section class="hero">
            <div class="top">
                <button class="round" type="button">☰</button>
                <button class="lang" type="button">🌐 AZ⌄</button>
            </div>
            <div class="brand">
                <div class="logo">
                    @if($restaurant->logo)
                    <img src="{{ asset('storage/' . $restaurant->logo) }}" alt="{{ $restaurant->name }}">
                    @else
                    DQ
                    @endif
                </div>
                <div class="name">{{ $restaurant->name }}</div>
                <div class="type">Restoran</div>
                <div class="table">🛒 {{ $table->name ?: $table->code }}</div>
                <div class="welcome">Xoş gəldiniz! Nəfis təamlarımızdan dadın.</div>
            </div>
        </section>

        <section class="bill">
            <div class="bill-grid">
                <div class="bill-left">
                    <div class="bill-title"><span>💳</span><span>Cari hesab</span></div>
                    <div class="open"><span class="dot"></span><span>Açıq çek</span><span class="badge">{{ $openOrders->count() }}</span></div>
                    <div class="open" style="margin-top:16px;">Son sifarişlər</div>
                    <div class="last">
                        @php $lastShown = 0; @endphp
                        @foreach($openOrders as $order)
                        @foreach($order->items as $item)
                        @if($lastShown < 2)
                            @php $lastShown++; @endphp
                            <div class="last-row">
                            <div class="last-img">🍽</div>
                            <div>{{ number_format((float) $item->qty, 0) }} × {{ $item->product_name }}</div>
                            <div class="last-price">{{ number_format((float) $item->total_price, 2) }} ₼</div>
                    </div>
                    @endif
                    @endforeach
                    @endforeach
                    @if($lastShown === 0)
                    <div class="last-row">
                        <div class="last-img">✓</div>
                        <div>Açıq sifariş yoxdur</div>
                        <div class="last-price">0.00 ₼</div>
                    </div>
                    @endif
                </div>
            </div>
            <div>
                <div class="bill-label">Ümumi məbləğ</div>
                <div class="bill-total">{{ number_format((float) $currentBillTotal, 2) }} ₼</div>
                <button class="check" type="button">Çeki göstər ›</button>
            </div>
    </div>
    </section>

    <div class="actions">
        <button class="action" type="button"><span style="font-size:25px;">🛎</span> Ofisiant çağır</button>
        <button class="action" type="button"><span style="font-size:25px;">🧾</span> Hesab istə</button>
    </div>

    <div class="head">
        <h2 class="title">Kateqoriyalar</h2>
        <a class="all" href="#products">Hamısına bax ›</a>
    </div>
    <div class="cats">
        <a href="#products" class="cat active"><span>▦</span><small>Hamısı</small></a>
        @foreach($categories as $category)
        <a href="#category-{{ $category->id }}" class="cat"><span>{{ $category->icon ?: '🍽' }}</span><small>{{ $category->name }}</small></a>
        @endforeach
        @if($uncategorizedProducts->count())
        <a href="#category-other" class="cat"><span>⋯</span><small>Digər</small></a>
        @endif
    </div>

    <div id="products" class="products-head">
        <h2 class="title">Məhsullar</h2>
        <button class="sort" type="button">Populyar⌄</button>
    </div>

    <div class="grid">
        @forelse($allProducts as $product)
        @php
        $imageUrl = $product->image ? asset('storage/' . $product->image) : '';
        $desc = $product->description ?: 'Restoran menyusundan seçilmiş dadlı məhsul.';
        $categoryName = optional($product->menuCategory)->name ?: 'Məhsul';
        @endphp
        <article class="card" onclick="openProductDetail({
                id: {{ $product->id }},
                name: @js($product->name),
                description: @js($desc),
                price: {{ (float) $product->sale_price }},
                image: @js($imageUrl),
                category: @js($categoryName)
            })">
            <div class="img">
                @if($product->image)
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                @else
                <div class="fallback">🍽</div>
                @endif
                @if($loop->first)
                <div class="tag">Populyar</div>
                @elseif($loop->iteration === 2)
                <div class="tag" style="background:#f59e0b;">Yeni</div>
                @endif
                <div class="fav">♡</div>
            </div>
            <div class="info">
                <div class="pname">{{ $product->name }}</div>
                <div class="desc">{{ $desc }}</div>
                <div class="price">{{ number_format((float) $product->sale_price, 2) }} ₼</div>
                <button type="button" class="add" onclick="event.stopPropagation(); addToCart(@js($product->name), {{ (float) $product->sale_price }})">+ Əlavə et</button>
            </div>
        </article>
        @empty
        <div class="empty">QR menyuda göstəriləcək məhsul yoxdur.</div>
        @endforelse
    </div>
    </div>

    <div class="cart">
        <div class="bag">🛒<span id="cartCount" class="count">0</span></div>
        <div>
            <div id="cartLabel" class="clabel">Səbət boşdur</div>
            <div id="cartTotal" class="ctotal">0.00 ₼</div>
        </div>
        <button type="button" class="send">Sifarişi göndər ›</button>
    </div>

    <nav class="nav">
        <div class="active"><span>⌂</span>Menyu</div>
        <div><span>🛒</span>Səbət</div>
        <div><span>♡</span>Seçilənlər</div>
        <div><span>ⓘ</span>Haqqımızda</div>
    </nav>

    <div id="productDetailOverlay" class="overlay">
        <div class="detail">
            <section class="dhero">
                <div id="detailImageWrap"></div>
                <div class="dtop">
                    <button class="round" type="button" onclick="closeProductDetail()">‹</button>
                    <div class="dacts">
                        <button class="round" type="button">♡</button>
                        <button class="round" type="button">↗</button>
                    </div>
                </div>
            </section>
            <section class="dcard">
                <div class="drow">
                    <h1 id="detailName" class="dname">Məhsul</h1>
                    <div class="popular">Populyar</div>
                </div>
                <div class="stars">★ ★ ★ ★ ☆ <span class="rating">4.8 (126 rəy)</span></div>
                <p id="detailDesc" class="ddesc"></p>
                <div class="dprice-row">
                    <div id="detailPrice" class="dprice">0.00 ₼</div>
                    <div class="qty">
                        <button type="button" onclick="changeQty(-1)">−</button>
                        <span id="detailQty">1</span>
                        <button type="button" onclick="changeQty(1)">+</button>
                    </div>
                </div>
                <h3 class="sub">Tərkibi</h3>
                <div class="ingredients">
                    <div class="ing"><span>🍅</span>Pomidor</div>
                    <div class="ing"><span>🥒</span>Xiyar</div>
                    <div class="ing"><span>🧅</span>Soğan</div>
                    <div class="ing"><span>🌿</span>Göyərti</div>
                    <div class="ing"><span>🫒</span>Zeytun yağı</div>
                </div>
                <h3 class="sub">Əlavə seçimlər</h3>
                <div class="addons">
                    <label class="addon"><input type="checkbox"><span>Zeytun əlavə et</span><span class="aprice">+1.00 ₼</span></label>
                    <label class="addon"><input type="checkbox"><span>Pendir əlavə et</span><span class="aprice">+2.00 ₼</span></label>
                    <label class="addon"><input type="checkbox"><span>Acılı sous 🌶</span><span class="aprice">+0.50 ₼</span></label>
                </div>
                <div class="iboxes">
                    <div class="ibox">
                        <div>Kalori<br><strong>120 kcal</strong></div>
                    </div>
                    <div class="ibox">
                        <div>Hazırlanma vaxtı<br><strong>10-15 dəq</strong></div>
                    </div>
                </div>
            </section>
            <div class="dbottom">
                <div class="qty">
                    <button type="button" onclick="changeQty(-1)">−</button>
                    <span id="detailQtyBottom">1</span>
                    <button type="button" onclick="changeQty(1)">+</button>
                </div>
                <button type="button" id="detailAddBtn" class="dadd">Səbətə əlavə et</button>
            </div>
        </div>
    </div>

    <script>
        let cartCount = 0;
        let cartTotal = 0;
        let currentProduct = null;
        let currentQty = 1;

        function money(amount) {
            return Number(amount || 0).toFixed(2) + ' ₼';
        }

        function updateCart() {
            document.getElementById('cartCount').textContent = cartCount;
            document.getElementById('cartTotal').textContent = money(cartTotal);
            document.getElementById('cartLabel').textContent = cartCount > 0 ?
                'Səbətdə ' + cartCount + ' məhsul var' :
                'Səbət boşdur';
        }

        function addToCart(name, price, qty = 1) {
            cartCount += qty;
            cartTotal += Number(price) * qty;
            updateCart();
        }

        function openProductDetail(product) {
            currentProduct = product;
            currentQty = 1;
            document.getElementById('detailName').textContent = product.name;
            document.getElementById('detailDesc').textContent = product.description;
            document.getElementById('detailPrice').textContent = money(product.price);
            document.getElementById('detailQty').textContent = currentQty;
            document.getElementById('detailQtyBottom').textContent = currentQty;

            const imageWrap = document.getElementById('detailImageWrap');
            if (product.image) {
                imageWrap.innerHTML = '<img src="' + product.image + '" alt="' + product.name + '">';
            } else {
                imageWrap.innerHTML = '<div class="dfallback">🍽</div>';
            }

            document.getElementById('detailAddBtn').textContent = 'Səbətə əlavə et • ' + money(product.price);
            document.getElementById('productDetailOverlay').classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeProductDetail() {
            document.getElementById('productDetailOverlay').classList.remove('active');
            document.body.style.overflow = '';
        }

        function changeQty(delta) {
            currentQty = Math.max(1, currentQty + delta);
            document.getElementById('detailQty').textContent = currentQty;
            document.getElementById('detailQtyBottom').textContent = currentQty;

            if (currentProduct) {
                document.getElementById('detailAddBtn').textContent =
                    'Səbətə əlavə et • ' + money(currentProduct.price * currentQty);
            }
        }

        document.getElementById('detailAddBtn').addEventListener('click', function() {
            if (!currentProduct) return;
            addToCart(currentProduct.name, currentProduct.price, currentQty);
            closeProductDetail();
        });

        document.getElementById('productDetailOverlay').addEventListener('click', function(event) {
            if (event.target.id === 'productDetailOverlay') closeProductDetail();
        });

        updateCart();
    </script>
</body>

</html>