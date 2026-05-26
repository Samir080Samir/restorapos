<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $restaurant->name }} | QR Menu</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Playfair+Display:wght@700;800;900&display=swap');

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
            scrollbar-gutter: stable;
        }

        body {
            min-height: 100vh;
            background: #edf2f3;
            color: #111827;
            overflow-x: hidden;
            font-family: "Manrope", ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        body.qr-modal-open {
            overflow: hidden;
            width: 100%;
        }

        button {
            border: 0;
            cursor: pointer;
            font-family: inherit;
        }

        a {
            color: inherit;
            text-decoration: none;
        }

        .app {
            width: 100%;
            max-width: 430px;
            min-height: 100vh;
            margin: 0 auto;
            background: #fffaf2;
            position: relative;
            overflow-x: hidden;
            padding-bottom: 132px;
            box-shadow: 0 0 0 1px rgba(15, 23, 42, .08);
        }

        .hero {
            height: 250px;
            padding: 14px;
            color: #fff;
            position: relative;
            overflow: hidden;
            border-bottom-left-radius: 28px;
            border-bottom-right-radius: 28px;
            background:
                linear-gradient(180deg, rgba(0, 0, 0, .18), rgba(0, 0, 0, .78)),
                url('https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80') center/cover;
        }

        .hero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at 20% 20%, rgba(16, 185, 129, .22), transparent 34%);
        }

        .top {
            position: relative;
            z-index: 2;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .round {
            width: 38px;
            height: 38px;
            border-radius: 15px;
            background: rgba(0, 56, 45, .78);
            color: #fff;
            display: grid;
            place-items: center;
            font-size: 19px;
            border: 1px solid rgba(255, 255, 255, .18);
            backdrop-filter: blur(14px);
        }

        .lang-wrap {
            position: relative;
        }

        .lang {
            height: 36px;
            min-width: 56px;
            padding: 0 10px;
            border-radius: 14px;
            background: rgba(0, 30, 24, .78);
            color: #fff;
            font-size: 12px;
            font-weight: 900;
            border: 1px solid rgba(255, 255, 255, .18);
            backdrop-filter: blur(14px);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
        }

        .lang-list {
            position: absolute;
            top: 42px;
            right: 0;
            width: 70px;
            padding: 6px;
            border-radius: 16px;
            background: rgba(0, 30, 24, .94);
            border: 1px solid rgba(255, 255, 255, .16);
            backdrop-filter: blur(16px);
            display: none;
            z-index: 20;
            box-shadow: 0 18px 38px rgba(2, 6, 23, .24);
        }

        .lang-list.active {
            display: grid;
            gap: 5px;
        }

        .lang-option {
            width: 100%;
            height: 32px;
            border-radius: 12px;
            background: transparent;
            color: rgba(255, 255, 255, .86);
            font-size: 12px;
            font-weight: 850;
            text-align: center;
            padding: 0 8px;
        }

        .lang-option.active,
        .lang-option:hover {
            background: rgba(255, 255, 255, .12);
            color: #f1c86a;
        }

        .brand {
            position: relative;
            z-index: 2;
            padding-top: 16px;
            text-align: center;
        }

        .logo {
            width: 50px;
            height: 50px;
            margin: 0 auto 7px;
            border-radius: 21px;
            display: grid;
            place-items: center;
            color: #d9a743;
            font-size: 30px;
            font-weight: 950;
        }

        .logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 19px;
        }

        .name {
            font-family: "Playfair Display", Georgia, "Times New Roman", serif;
            font-size: 27px;
            line-height: 1.04;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: .3px;
        }

        .type {
            margin-top: 7px;
            color: #e5b85c;
            letter-spacing: 5px;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .table {
            display: inline-flex;
            margin-top: 10px;
            padding: 7px 12px;
            border-radius: 999px;
            background: linear-gradient(135deg, #064236, #0b6b50);
            color: #fff;
            font-size: 13px;
            font-weight: 950;
            box-shadow: 0 12px 26px rgba(0, 60, 45, .32);
        }

        .welcome {
            margin-top: 9px;
            font-size: 12px;
            font-weight: 800;
            color: rgba(255, 255, 255, .92);
        }

        .bill {
            position: relative;
            z-index: 4;
            margin: -62px 12px 12px;
            border-radius: 22px;
            padding: 13px;
            color: #fff;
            background:
                radial-gradient(circle at top right, rgba(72, 187, 120, .28), transparent 34%),
                linear-gradient(135deg, #063b31, #083326 60%, #0b4d3d);
            box-shadow: 0 18px 36px rgba(6, 44, 35, .28);
        }

        .bill-grid {
            display: grid;
            grid-template-columns: 1.08fr .92fr;
            gap: 12px;
        }

        .bill-left {
            border-right: 1px solid rgba(255, 255, 255, .14);
            padding-right: 12px;
        }

        .bill-title {
            font-size: 14px;
            font-weight: 950;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .open {
            margin-top: 9px;
            display: flex;
            align-items: center;
            gap: 7px;
            color: rgba(255, 255, 255, .86);
            font-size: 12px;
            font-weight: 850;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 99px;
            background: #4ade80;
        }

        .badge {
            min-width: 23px;
            height: 22px;
            padding: 0 8px;
            border-radius: 99px;
            background: #d7a950;
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 950;
        }

        .last {
            margin-top: 10px;
            display: grid;
            gap: 7px;
        }

        .last-row {
            display: grid;
            grid-template-columns: 34px 1fr auto;
            align-items: center;
            gap: 7px;
            font-size: 11px;
            font-weight: 850;
        }

        .last-img {
            width: 34px;
            height: 34px;
            border-radius: 11px;
            background: #ecfdf5;
            display: grid;
            place-items: center;
            overflow: hidden;
        }

        .last-price {
            color: #4ade80;
            white-space: nowrap;
        }

        .bill-label {
            font-size: 12px;
            color: rgba(255, 255, 255, .84);
            font-weight: 850;
        }

        .bill-total {
            margin-top: 6px;
            color: #f1c86a;
            font-size: 30px;
            font-weight: 950;
            letter-spacing: -.8px;
            white-space: nowrap;
        }

        .check {
            width: 100%;
            height: 36px;
            margin-top: 11px;
            border-radius: 13px;
            background: linear-gradient(135deg, #f3c96a, #dba13e);
            color: #1d1a13;
            font-size: 12px;
            font-weight: 950;
            box-shadow: 0 8px 18px rgba(219, 161, 62, .22);
        }

        .actions {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
            padding: 0 12px;
        }

        .action {
            height: 58px;
            border-radius: 19px;
            background: #fff;
            color: #084437;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            font-size: 13px;
            font-weight: 950;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .07);
        }

        .head,
        .products-head {
            padding: 19px 12px 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .products-head {
            padding-top: 18px;
        }

        .title {
            font-size: 18px;
            font-weight: 950;
            color: #0f172a;
            letter-spacing: -.3px;
        }

        .all {
            color: #083326;
            font-size: 12px;
            font-weight: 900;
        }

        .cats {
            display: flex;
            flex-wrap: nowrap;
            gap: 9px;
            overflow-x: auto;
            overflow-y: hidden;
            padding: 0 12px 2px;
            scrollbar-width: none;
            cursor: grab;
            user-select: none;
            -webkit-overflow-scrolling: touch;
            scroll-behavior: smooth;
        }

        .cats.dragging {
            cursor: grabbing;
            scroll-behavior: auto;
        }

        .cats::-webkit-scrollbar {
            display: none;
        }

        .cat {
            min-width: 62px;
            height: 64px;
            border-radius: 17px;
            background: #fff;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-size: 10.5px;
            font-weight: 900;
            white-space: nowrap;
            box-shadow: 0 10px 22px rgba(15, 23, 42, .06);
            flex: 0 0 auto;
        }

        .cat.active {
            background: linear-gradient(135deg, #064236, #0d5a46);
            color: #fff;
        }

        .cat span:first-child {
            font-size: 20px;
        }

        .badge-filter-row {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .badge-info-chip {
            height: 32px;
            padding: 0 11px;
            border-radius: 999px;
            background: #fff;
            color: #083326;
            font-size: 11px;
            font-weight: 950;
            border: 1px solid rgba(6, 66, 54, .10);
            box-shadow: 0 8px 18px rgba(15, 23, 42, .05);
        }

        .badge-info-chip.new {
            color: #b45309;
            background: #fffbeb;
            border-color: rgba(245, 158, 11, .20);
        }

        .badge-toast {
            position: fixed;
            left: 50%;
            bottom: 145px;
            transform: translateX(-50%) translateY(16px);
            width: calc(100% - 34px);
            max-width: 390px;
            padding: 13px 14px;
            border-radius: 18px;
            background:
                radial-gradient(circle at top right, rgba(72, 187, 120, .28), transparent 34%),
                linear-gradient(135deg, #063b31, #083326 60%, #0b4d3d);
            color: #fff;
            box-shadow: 0 18px 38px rgba(6, 44, 35, .30);
            z-index: 320;
            opacity: 0;
            pointer-events: none;
            transition: .22s ease;
            font-size: 12px;
            line-height: 1.45;
            font-weight: 800;
        }

        .badge-toast.show {
            opacity: 1;
            transform: translateX(-50%) translateY(0);
        }

        .badge-toast strong {
            display: block;
            margin-bottom: 4px;
            color: #f1c86a;
            font-size: 13px;
            font-weight: 950;
        }

        .sort {
            height: 34px;
            padding: 0 12px;
            border-radius: 999px;
            background: #fff;
            color: #111827;
            font-size: 12px;
            font-weight: 900;
            border: 1px solid #eef0f2;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .05);
        }

        .grid {
            padding: 0 12px 18px;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 11px;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            overflow: hidden;
            text-align: left;
            position: relative;
            box-shadow: 0 11px 26px rgba(15, 23, 42, .08);
        }

        .img {
            height: 108px;
            margin: 7px;
            border-radius: 16px;
            overflow: hidden;
            position: relative;
            background: linear-gradient(135deg, #f8fafc, #ecfdf5);
        }

        .img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .fallback {
            width: 100%;
            height: 100%;
            display: grid;
            place-items: center;
            font-size: 31px;
        }

        .tag {
            position: absolute;
            left: 8px;
            top: 8px;
            height: 23px;
            padding: 0 8px;
            border-radius: 999px;
            display: flex;
            align-items: center;
            background: #22c55e;
            color: #fff;
            font-size: 10px;
            font-weight: 950;
        }

        .fav {
            position: absolute;
            right: 8px;
            top: 8px;
            width: 28px;
            height: 28px;
            border-radius: 999px;
            background: rgba(255, 255, 255, .76);
            color: #111827;
            display: grid;
            place-items: center;
            font-size: 15px;
            backdrop-filter: blur(10px);
        }

        .info {
            padding: 2px 10px 11px;
        }

        .pname {
            color: #111827;
            font-size: 14px;
            font-weight: 950;
            line-height: 1.2;
        }

        .desc {
            margin-top: 6px;
            min-height: 34px;
            color: #667085;
            font-size: 11px;
            line-height: 1.45;
            font-weight: 650;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .price {
            margin-top: 10px;
            color: #0f172a;
            font-size: 15px;
            font-weight: 950;
        }

        .add {
            width: 100%;
            height: 36px;
            margin-top: 10px;
            border-radius: 13px;
            background: linear-gradient(135deg, #064236, #0d5a46);
            color: #fff;
            font-size: 12px;
            font-weight: 950;
        }

        .empty {
            grid-column: 1 / -1;
            background: #fff;
            border-radius: 20px;
            padding: 24px;
            text-align: center;
            color: #667085;
            font-size: 13px;
            font-weight: 800;
            box-shadow: 0 10px 22px rgba(15, 23, 42, .06);
        }

        .cart {
            position: fixed;
            left: 50%;
            bottom: 63px;
            transform: translateX(-50%);
            width: calc(100% - 34px);
            max-width: 390px;
            min-height: 62px;
            border-radius: 21px;
            background: linear-gradient(135deg, #05392f, #064236 58%, #0b5b47);
            color: #fff;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            z-index: 50;
            box-shadow: 0 16px 36px rgba(6, 44, 35, .34);
        }

        .bag {
            width: 42px;
            height: 42px;
            border-radius: 18px;
            background: rgba(0, 0, 0, .22);
            display: grid;
            place-items: center;
            position: relative;
            font-size: 20px;
        }

        .count {
            position: absolute;
            top: -7px;
            right: -4px;
            min-width: 22px;
            height: 22px;
            border-radius: 999px;
            background: #fff;
            color: #064236;
            display: grid;
            place-items: center;
            font-size: 11px;
            font-weight: 950;
        }

        .clabel {
            color: rgba(255, 255, 255, .83);
            font-size: 11px;
            font-weight: 850;
        }

        .ctotal {
            margin-top: 2px;
            color: #f1c86a;
            font-size: 19px;
            font-weight: 950;
        }

        .send {
            height: 45px;
            padding: 0 13px;
            border-radius: 17px;
            background: linear-gradient(135deg, #f3c96a, #dba13e);
            color: #1d1a13;
            font-size: 12px;
            font-weight: 950;
            white-space: nowrap;
        }

        .nav {
            position: fixed;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 100%;
            max-width: 430px;
            height: 65px;
            background: rgba(255, 255, 255, .96);
            border-top-left-radius: 24px;
            border-top-right-radius: 24px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            align-items: center;
            z-index: 45;
            box-shadow: 0 -8px 24px rgba(15, 23, 42, .08);
            backdrop-filter: blur(16px);
        }

        .nav div {
            text-align: center;
            color: #667085;
            font-size: 10px;
            font-weight: 900;
        }

        .nav .active {
            color: #0b5b47;
        }

        .nav span {
            display: block;
            font-size: 18px;
            margin-bottom: 2px;
        }


        .nav-svg {
            width: 22px;
            height: 22px;
            margin: 0 auto 3px;
            display: grid !important;
            place-items: center;
            font-size: 0 !important;
        }

        .nav-svg svg {
            width: 22px;
            height: 22px;
            display: block;
            margin: auto;
        }


        .nav div {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
        }

        .nav-svg.favorite-active,
        #favoriteNavIcon {
            display: flex !important;
            align-items: center;
            justify-content: center;
        }

        #favoriteNavIcon svg {
            transform: translateY(0);
        }

        .novapos-info-svg svg {
            width: 23px;
            height: 23px;
        }

        .nav-svg.favorite-active svg path {
            fill: #ef4444;
            stroke: #ef4444;
        }

        .cart-list {
            margin-top: 16px;
            display: grid;
            gap: 10px;
        }

        .cart-item {
            min-height: 58px;
            border-radius: 18px;
            background: #fff;
            border: 1px solid rgba(15, 23, 42, .06);
            padding: 11px 12px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            align-items: center;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .05);
        }

        .cart-item strong {
            display: block;
            color: #111827;
            font-size: 13px;
            font-weight: 950;
        }

        .cart-item span {
            display: block;
            margin-top: 3px;
            color: #667085;
            font-size: 11px;
            font-weight: 800;
        }

        .cart-item-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 7px;
        }

        .cart-qty-control {
            height: 34px;
            border-radius: 13px;
            background: #f8fafc;
            border: 1px solid rgba(15, 23, 42, .07);
            display: inline-flex;
            align-items: center;
            overflow: hidden;
        }

        .cart-qty-btn {
            width: 32px;
            height: 32px;
            background: transparent;
            color: #064236;
            font-size: 17px;
            font-weight: 950;
        }

        .cart-qty-number {
            min-width: 28px;
            text-align: center;
            color: #111827;
            font-size: 12px;
            font-weight: 950;
        }

        .cart-remove-btn,
        .favorite-remove-btn {
            height: 34px;
            min-width: 34px;
            border-radius: 13px;
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid rgba(225, 29, 72, .12);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 950;
        }

        .favorite-remove-btn {
            padding: 0 10px;
        }

        .cart-total-row {
            margin-top: 14px;
            border-radius: 20px;
            padding: 14px;
            background: linear-gradient(135deg, #05392f, #064236);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            font-weight: 950;
        }

        .overlay {
            position: fixed;
            inset: 0;
            z-index: 200;
            background: rgba(2, 6, 23, .48);
            display: none;
            justify-content: center;
        }

        .overlay.active {
            display: flex;
        }

        .detail {
            width: 100%;
            max-width: 430px;
            min-height: 100vh;
            background: #fffaf2;
            overflow-y: auto;
            position: relative;
            padding-bottom: 90px;
            animation: slide .22s ease-out;
        }

        @keyframes slide {
            from {
                transform: translateX(24px);
                opacity: .7;
            }

            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        .dhero {
            height: 315px;
            position: relative;
            overflow: hidden;
            border-bottom-left-radius: 30px;
            border-bottom-right-radius: 30px;
            background: #111827;
        }

        .dhero img,
        .dfallback {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .dfallback {
            display: grid;
            place-items: center;
            font-size: 78px;
            background: radial-gradient(circle, #fff7ed, #ecfdf5);
        }

        .dhero::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(0, 0, 0, .34), transparent 48%, rgba(0, 0, 0, .18));
        }

        .dtop {
            position: absolute;
            z-index: 3;
            top: 14px;
            left: 14px;
            right: 14px;
            display: flex;
            justify-content: space-between;
        }

        .dacts {
            display: flex;
            gap: 8px;
        }

        .dcard {
            position: relative;
            z-index: 4;
            margin: -30px 0 0;
            background: #fffaf2;
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
            padding: 20px 14px;
        }

        .drow {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .dname {
            color: #0f172a;
            font-size: 24px;
            line-height: 1.08;
            font-weight: 950;
        }

        .popular {
            height: 26px;
            padding: 0 9px;
            border-radius: 999px;
            background: #22c55e;
            color: #fff;
            display: flex;
            align-items: center;
            font-size: 11px;
            font-weight: 950;
            white-space: nowrap;
        }

        .stars {
            margin-top: 10px;
            color: #f59e0b;
            font-size: 13px;
            font-weight: 900;
        }

        .rating {
            margin-left: 6px;
            color: #111827;
            font-weight: 850;
        }

        .ddesc {
            margin-top: 14px;
            color: #667085;
            font-size: 13px;
            line-height: 1.58;
            font-weight: 650;
        }

        .dprice-row {
            margin-top: 19px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .dprice {
            color: #0f172a;
            font-size: 28px;
            font-weight: 950;
        }

        .qty {
            height: 42px;
            border-radius: 17px;
            background: #fff;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0 14px;
            box-shadow: 0 10px 23px rgba(15, 23, 42, .08);
            font-size: 16px;
            font-weight: 950;
        }

        .qty button {
            background: transparent;
            color: #111827;
            font-size: 22px;
            font-weight: 900;
        }

        .sub {
            margin-top: 22px;
            color: #111827;
            font-size: 16px;
            font-weight: 950;
        }

        .ingredients {
            margin-top: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
        }

        .ing {
            width: 64px;
            min-height: 65px;
            padding: 8px;
            border-radius: 16px;
            background: #fff;
            display: grid;
            place-items: center;
            text-align: center;
            gap: 3px;
            color: #111827;
            font-size: 10px;
            font-weight: 900;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .05);
        }

        .ing span {
            font-size: 20px;
        }

        .addons {
            margin-top: 12px;
            display: grid;
            gap: 10px;
        }

        .addon {
            min-height: 43px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 9px;
            border-bottom: 1px solid rgba(226, 232, 240, .9);
            font-size: 13px;
            font-weight: 850;
        }

        .addon input {
            width: 18px;
            height: 18px;
        }

        .aprice {
            color: #0b7c50;
            font-weight: 950;
        }

        .iboxes {
            margin-top: 15px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .ibox {
            height: 62px;
            border-radius: 18px;
            background: #fff;
            display: grid;
            place-items: center;
            text-align: center;
            color: #111827;
            font-size: 12px;
            font-weight: 900;
            box-shadow: 0 8px 18px rgba(15, 23, 42, .04);
        }

        .dbottom {
            position: fixed;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            width: 100%;
            max-width: 430px;
            min-height: 82px;
            border-top-left-radius: 26px;
            border-top-right-radius: 26px;
            background: linear-gradient(135deg, #05392f, #064236);
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: center;
            gap: 12px;
            padding: 14px;
            z-index: 230;
            box-shadow: 0 -14px 34px rgba(6, 44, 35, .22);
        }

        .dadd {
            height: 50px;
            border-radius: 19px;
            background: linear-gradient(135deg, #f3c96a, #dba13e);
            color: #1d1a13;
            font-size: 13px;
            font-weight: 950;
        }


        .menu-sheet {
            width: 100%;
            max-width: 430px;
            min-height: 100vh;
            background: #fffaf2;
            overflow-y: auto;
            position: relative;
            padding: 18px 14px 96px;
            animation: slide .22s ease-out;
        }

        .menu-sheet-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(15, 23, 42, .08);
        }

        .menu-sheet-title {
            min-width: 0;
        }

        .menu-sheet-title h2 {
            font-size: 22px;
            line-height: 1.12;
            color: #0f172a;
            font-weight: 950;
            letter-spacing: -.4px;
        }

        .menu-sheet-title p {
            margin-top: 5px;
            color: #667085;
            font-size: 12px;
            font-weight: 850;
        }

        .info-list {
            margin-top: 18px;
            display: grid;
            gap: 12px;
        }

        .info-card {
            background: #fff;
            border: 1px solid rgba(15, 23, 42, .06);
            border-radius: 22px;
            padding: 14px;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .06);
        }

        .info-kicker {
            color: #9a6a12;
            font-size: 10px;
            font-weight: 950;
            letter-spacing: 1.4px;
            text-transform: uppercase;
        }

        .info-value {
            margin-top: 7px;
            color: #111827;
            font-size: 14px;
            line-height: 1.45;
            font-weight: 850;
            word-break: break-word;
        }

        .social-row {
            margin-top: 10px;
            display: flex;
            flex-wrap: wrap;
            gap: 9px;
        }

        .social-link {
            min-width: 42px;
            height: 38px;
            padding: 0 12px;
            border-radius: 15px;
            background:
                radial-gradient(circle at top right, rgba(72, 187, 120, .28), transparent 34%),
                linear-gradient(135deg, #063b31, #083326 60%, #0b4d3d);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            font-size: 12px;
            font-weight: 950;
            box-shadow: 0 10px 22px rgba(6, 66, 54, .18);
        }

        .social-link svg {
            width: 15px;
            height: 15px;
            flex-shrink: 0;
        }

        .info-action-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #064236;
            font-weight: 950;
        }

        .info-action-link svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .menu-note {
            margin-top: 14px;
            border-radius: 20px;
            padding: 14px;
            color: #fff;
            background: linear-gradient(135deg, #05392f, #064236 60%, #0b5b47);
            box-shadow: 0 14px 30px rgba(6, 44, 35, .22);
        }

        .menu-note strong {
            display: block;
            font-size: 15px;
            font-weight: 950;
        }

        .menu-note span {
            display: block;
            margin-top: 5px;
            color: rgba(255, 255, 255, .82);
            font-size: 12px;
            line-height: 1.45;
            font-weight: 750;
        }


        .bill-sheet {
            width: 100%;
            max-width: 430px;
            max-height: 86vh;
            margin-top: auto;
            background: #fffaf2;
            overflow-y: auto;
            border-top-left-radius: 30px;
            border-top-right-radius: 30px;
            padding: 16px 14px 96px;
            animation: billUp .22s ease-out;
            box-shadow: 0 -18px 45px rgba(2, 6, 23, .22);
        }

        @keyframes billUp {
            from {
                transform: translateY(32px);
                opacity: .75;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .bill-sheet-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 14px;
            border-bottom: 1px solid rgba(15, 23, 42, .08);
        }

        .bill-sheet-head h2 {
            color: #0f172a;
            font-size: 21px;
            font-weight: 900;
            letter-spacing: -.4px;
        }

        .bill-sheet-head p {
            margin-top: 4px;
            color: #667085;
            font-size: 12px;
            font-weight: 750;
        }

        .bill-items {
            margin-top: 14px;
            display: grid;
            gap: 10px;
        }

        .bill-item {
            min-height: 58px;
            border-radius: 18px;
            background: #fff;
            border: 1px solid rgba(15, 23, 42, .06);
            padding: 11px;
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 10px;
            align-items: center;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .05);
        }

        .bill-item-name {
            color: #111827;
            font-size: 13px;
            font-weight: 900;
            line-height: 1.25;
        }

        .bill-item-meta {
            margin-top: 4px;
            color: #667085;
            font-size: 11px;
            font-weight: 750;
        }

        .bill-item-price {
            color: #0b5b47;
            font-size: 13px;
            font-weight: 950;
            white-space: nowrap;
        }

        .bill-final {
            position: sticky;
            bottom: -80px;
            margin-top: 14px;
            border-radius: 22px;
            padding: 14px;
            color: #fff;
            background: linear-gradient(135deg, #05392f, #064236 60%, #0b5b47);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            box-shadow: 0 14px 30px rgba(6, 44, 35, .20);
        }

        .bill-final span {
            display: block;
            color: rgba(255, 255, 255, .78);
            font-size: 11px;
            font-weight: 800;
        }

        .bill-final strong {
            display: block;
            margin-top: 3px;
            color: #f1c86a;
            font-size: 24px;
            font-weight: 950;
        }


        .fav.active,
        .detail-fav.active {
            background: rgba(255, 255, 255, .92);
            color: #ef4444;
            box-shadow: 0 8px 20px rgba(239, 68, 68, .20);
        }

        .other-list,
        .favorite-list {
            margin-top: 16px;
            display: grid;
            gap: 10px;
        }

        .other-category-btn,
        .favorite-item {
            width: 100%;
            min-height: 58px;
            border-radius: 18px;
            background: #fff;
            border: 1px solid rgba(15, 23, 42, .06);
            color: #111827;
            padding: 10px 12px;
            display: grid;
            grid-template-columns: auto 1fr auto;
            gap: 10px;
            align-items: center;
            text-align: left;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .05);
        }

        .other-category-icon,
        .favorite-thumb {
            width: 38px;
            height: 38px;
            border-radius: 14px;
            background: #ecfdf5;
            display: grid;
            place-items: center;
            overflow: hidden;
            font-size: 19px;
        }

        .favorite-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .other-category-title,
        .favorite-name {
            font-size: 13px;
            font-weight: 950;
            color: #111827;
        }

        .other-category-sub,
        .favorite-price {
            margin-top: 3px;
            font-size: 11px;
            font-weight: 800;
            color: #667085;
        }

        .empty-soft {
            margin-top: 16px;
            border-radius: 20px;
            padding: 20px 14px;
            background: #fff;
            color: #667085;
            font-size: 13px;
            font-weight: 850;
            text-align: center;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .05);
        }

        .request-success {
            margin-top: 16px;
            border-radius: 22px;
            padding: 18px 14px;
            background: linear-gradient(135deg, #05392f, #064236 60%, #0b5b47);
            color: #fff;
            text-align: center;
            box-shadow: 0 14px 30px rgba(6, 44, 35, .22);
        }

        .request-success .big {
            width: 54px;
            height: 54px;
            margin: 0 auto 10px;
            border-radius: 22px;
            background: rgba(255, 255, 255, .12);
            display: grid;
            place-items: center;
            font-size: 25px;
        }

        .request-success strong {
            display: block;
            font-size: 17px;
            font-weight: 950;
        }

        .request-success span {
            display: block;
            margin-top: 6px;
            color: rgba(255, 255, 255, .80);
            font-size: 12px;
            line-height: 1.45;
            font-weight: 750;
        }



        .novapos-hero-card {
            margin-top: 14px;
            border-radius: 24px;
            padding: 18px 16px;
            color: #fff;
            background:
                radial-gradient(circle at top right, rgba(72, 187, 120, .28), transparent 34%),
                linear-gradient(135deg, #063b31, #083326 60%, #0b4d3d);
            box-shadow: 0 18px 38px rgba(6, 44, 35, .26);
        }

        .novapos-hero-card h3 {
            font-size: 20px;
            line-height: 1.12;
            font-weight: 950;
            letter-spacing: -.4px;
        }

        .novapos-hero-card p {
            margin-top: 9px;
            color: rgba(255, 255, 255, .82);
            font-size: 12.5px;
            line-height: 1.58;
            font-weight: 750;
        }

        .novapos-section-card {
            margin-top: 12px;
            border-radius: 22px;
            padding: 15px;
            background: #fff;
            border: 1px solid rgba(15, 23, 42, .06);
            box-shadow: 0 10px 24px rgba(15, 23, 42, .06);
        }

        .novapos-section-card h4 {
            color: #083326;
            font-size: 14px;
            font-weight: 950;
        }

        .novapos-section-card p,
        .novapos-section-card li {
            margin-top: 8px;
            color: #475569;
            font-size: 12.5px;
            line-height: 1.58;
            font-weight: 750;
        }

        .novapos-section-card ul {
            margin-top: 8px;
            padding-left: 18px;
        }

        .novapos-final-card {
            margin-top: 12px;
            border-radius: 22px;
            padding: 15px;
            color: #fff;
            background: linear-gradient(135deg, #0b4d3d, #063b31);
            box-shadow: 0 14px 30px rgba(6, 44, 35, .20);
        }

        .novapos-final-card strong {
            display: block;
            color: #f1c86a;
            font-size: 14px;
            font-weight: 950;
        }

        .novapos-final-card span {
            display: block;
            margin-top: 8px;
            color: rgba(255, 255, 255, .84);
            font-size: 12.5px;
            line-height: 1.55;
            font-weight: 750;
        }

        @media (max-width: 370px) {
            .name {
                font-size: 26px;
            }

            .bill-grid {
                grid-template-columns: 1fr;
            }

            .bill-left {
                border-right: 0;
                border-bottom: 1px solid rgba(255, 255, 255, .13);
                padding-right: 0;
                padding-bottom: 12px;
            }

            .img {
                height: 98px;
            }

            .cart {
                grid-template-columns: auto 1fr;
            }

            .send {
                grid-column: 1 / -1;
                width: 100%;
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

    $qrHeroImage = data_get($restaurant, 'qr_background_image')
    ? asset('storage/' . data_get($restaurant, 'qr_background_image'))
    : 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=80';

    $qrWelcomeText = data_get($restaurant, 'qr_welcome_text')
    ?: ($table ? 'Xoş gəldiniz! Nəfis təamlarımızdan dadın.' : 'Menyumuza baxın və seçimlərinizi rahat edin.');

    $qrAboutTitle = data_get($restaurant, 'qr_about_title') ?: 'Restoran məlumatları';

    $qrAboutDescription = data_get($restaurant, 'qr_about_description')
    ?: 'Əlaqə, ünvan və sosial şəbəkə məlumatları bu bölmədə göstərilir.';

    $qrContactPhone = data_get($restaurant, 'qr_contact_phone')
    ?: data_get($restaurant, 'phone')
    ?: data_get($restaurant, 'contact_phone')
    ?: data_get($restaurant, 'mobile');

    $qrAddress = data_get($restaurant, 'qr_address')
    ?: data_get($restaurant, 'address')
    ?: data_get($restaurant, 'location');

    $qrInstagram = data_get($restaurant, 'qr_instagram') ?: data_get($restaurant, 'instagram');
    $qrFacebook = data_get($restaurant, 'qr_facebook') ?: data_get($restaurant, 'facebook');
    $qrTiktok = data_get($restaurant, 'qr_tiktok') ?: data_get($restaurant, 'tiktok');
    $qrWebsite = data_get($restaurant, 'qr_website') ?: data_get($restaurant, 'website');

    $qrPhoneHref = $qrContactPhone ? preg_replace('/[^0-9+]/', '', $qrContactPhone) : null;
    $qrMapHref = $qrAddress ? 'https://www.google.com/maps/search/?api=1&query=' . urlencode($qrAddress) : null;
    @endphp

    <div class="app">
        <section class="hero"
            style="background:
                linear-gradient(180deg, rgba(0, 0, 0, .18), rgba(0, 0, 0, .78)),
                url('{{ $qrHeroImage }}') center/cover;">
            <div class="top">
                <button class="round" type="button" onclick="openMenuOverlay()">☰</button>
                <div class="lang-wrap">
                    <button class="lang" type="button" onclick="toggleLanguageList(event)">AZ ▾</button>

                    <div id="languageList" class="lang-list">
                        <button class="lang-option active" type="button">AZ</button>
                        <button class="lang-option" type="button">EN</button>
                        <button class="lang-option" type="button">RU</button>
                    </div>
                </div>
            </div>

            <div class="brand">
                @if($restaurant->logo)
                <div class="logo">
                    <img src="{{ asset('storage/' . $restaurant->logo) }}" alt="{{ $restaurant->name }}">
                </div>
                @endif

                <div class="name">{{ $restaurant->name }}</div>
                <div class="type">Restoran</div>

                <div class="table">
                    {{ $table ? '🛒 ' . ($table->name ?: $table->code) : '🍽 Ümumi menyu' }}
                </div>

                <div class="welcome">
                    {{ $qrWelcomeText }}
                </div>
            </div>
        </section>

        @if($table)
        <section class="bill">
            <div class="bill-grid">
                <div class="bill-left">
                    <div class="bill-title">
                        <span>💳</span>
                        <span>Cari hesab</span>
                    </div>

                    <div class="open">
                        <span class="dot"></span>
                        <span>Aktiv hesab</span>
                        <span class="badge">{{ $openOrders->count() }}</span>
                    </div>

                    <div class="open" style="margin-top: 13px;">Son sifarişlər</div>

                    @php
                    $latestItem = null;
                    $latestItemCreatedAt = null;

                    foreach ($openOrders as $order) {
                    foreach ($order->items as $item) {
                    $itemCreatedAt = $item->created_at ?? $order->created_at ?? $order->opened_at;

                    if (! $latestItem || ($itemCreatedAt && $latestItemCreatedAt && $itemCreatedAt->gt($latestItemCreatedAt)) || (! $latestItemCreatedAt && $itemCreatedAt)) {
                    $latestItem = $item;
                    $latestItemCreatedAt = $itemCreatedAt;
                    }
                    }
                    }

                    $latestProductImage = null;

                    if ($latestItem && $latestItem->product_id) {
                    $latestProduct = \App\Models\Product::find($latestItem->product_id);

                    if ($latestProduct && $latestProduct->image) {
                    $latestProductImage = asset('storage/' . $latestProduct->image);
                    }
                    }
                    @endphp

                    <div class="last">
                        @if($latestItem)
                        <div class="last-row">
                            <div class="last-img">
                                @if($latestProductImage)
                                <img src="{{ $latestProductImage }}" alt="{{ $latestItem->product_name }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                                @else
                                🍽
                                @endif
                            </div>

                            <div>{{ number_format((float) $latestItem->qty, 0) }} × {{ $latestItem->product_name }}</div>
                            <div class="last-price">{{ number_format((float) $latestItem->total_price, 2) }} ₼</div>
                        </div>
                        @else
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

                    <button class="check" type="button" onclick="openBillOverlay()">Hesabı görüntülə →</button>
                </div>
            </div>
        </section>

        <div class="actions">
            <button class="action" type="button" onclick="callWaiter()">
                <span style="font-size: 22px;">🛎</span>
                <span>Ofisiant çağır</span>
            </button>

            <button class="action" type="button" onclick="requestBill()">
                <span style="font-size: 22px;">🧾</span>
                <span>Hesab istə</span>
            </button>
        </div>
        @endif

        <div class="head">
            <h2 class="title">Kateqoriyalar</h2>
        </div>

        <div class="cats" id="categoryTabs">
            <button type="button" class="cat active" data-category="all" onclick="filterProducts('all', this)">
                <span>▦</span>
                <small>Hamısı</small>
            </button>

            @foreach($categories as $category)
            <button type="button" class="cat" data-category="{{ $category->id }}" onclick="filterProducts('{{ $category->id }}', this)">
                <span>{{ $category->icon ?: '🍽' }}</span>
                <small>{{ $category->name }}</small>
            </button>
            @endforeach

            @if($uncategorizedProducts->count())
            <button type="button" class="cat" data-category="other" onclick="filterProducts('other', this)">
                <span>🍽</span>
                <small>Kateqoriyasız</small>
            </button>
            @endif
        </div>

        <div id="products" class="products-head">
            <h2 class="title">Məhsullar</h2>
            <div class="badge-filter-row">
                <button class="badge-info-chip" type="button" onclick="showBadgeInfo('popular')">Populyar</button>
                <button class="badge-info-chip new" type="button" onclick="showBadgeInfo('new')">Yeni</button>
            </div>
        </div>

        <div class="grid">
            @forelse($allProducts as $product)
            @php
            $imageUrl = $product->image ? asset('storage/' . $product->image) : '';
            $desc = $product->description ?: 'Restoran menyusundan seçilmiş dadlı məhsul.';
            $categoryName = optional($product->menuCategory)->name ?: 'Məhsul';
            $isPopularProduct = isset($popularProductIds) && $popularProductIds->contains($product->id);
            $isNewProduct = ! $isPopularProduct && $product->created_at && $product->created_at->gte(now()->subDays(7));
            @endphp

            <article class="card"
                data-category="{{ optional($product->menuCategory)->id ?: (data_get($product, 'menu_category_id') ?: (data_get($product, 'category_id') ?: 'other')) }}"
                onclick="openProductDetail({
                        id: {{ $product->id }},
                        name: @js($product->name),
                        description: @js($desc),
                        price: {{ (float) $product->sale_price }},
                        image: @js($imageUrl),
                        category: @js($categoryName),
                        isPopular: {{ $isPopularProduct ? 'true' : 'false' }},
                        isNew: {{ $isNewProduct ? 'true' : 'false' }}
                    })">

                <div class="img">
                    @if($product->image)
                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                    @else
                    <div class="fallback">🍽</div>
                    @endif

                    @if($isPopularProduct)
                    <div class="tag">Populyar</div>
                    @elseif($isNewProduct)
                    <div class="tag" style="background:#f59e0b;">Yeni</div>
                    @endif

                    <button type="button"
                        class="fav"
                        data-product-id="{{ $product->id }}"
                        onclick="toggleFavorite(event, this, {
                        id: {{ $product->id }},
                        name: @js($product->name),
                        description: @js($desc),
                        price: {{ (float) $product->sale_price }},
                        image: @js($imageUrl),
                        category: @js($categoryName),
                        isPopular: {{ $isPopularProduct ? 'true' : 'false' }},
                        isNew: {{ $isNewProduct ? 'true' : 'false' }}
                    })">♡</button>
                </div>

                <div class="info">
                    <div class="pname">{{ $product->name }}</div>
                    <div class="desc">{{ $desc }}</div>
                    <div class="price">{{ number_format((float) $product->sale_price, 2) }} ₼</div>

                    <button type="button"
                        class="add"
                        onclick="event.stopPropagation(); addToCart(@js($product->name), {{ (float) $product->sale_price }}, 1, {{ $product->id }})">
                        + Əlavə et
                    </button>
                </div>
            </article>
            @empty
            <div class="empty">QR menyuda göstəriləcək məhsul yoxdur.</div>
            @endforelse
        </div>
    </div>

    <div class="cart">
        <div class="bag">
            🛒
            <span id="cartCount" class="count">0</span>
        </div>

        <div>
            <div id="cartLabel" class="clabel">Səbət boşdur</div>
            <div id="cartTotal" class="ctotal">0.00 ₼</div>
        </div>

        <button type="button" class="send" onclick="openCartOverlay()">
            {{ $table ? 'Sifarişi göndər ›' : 'Səbətə bax ›' }}
        </button>
    </div>

    <nav class="nav">
        <div class="active" onclick="goHomeMenu()"><span class="nav-svg"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M4 11.4 12 5l8 6.4V20a1 1 0 0 1-1 1h-5v-6h-4v6H5a1 1 0 0 1-1-1v-8.6Z" stroke="currentColor" stroke-width="1.9" stroke-linejoin="round" />
                </svg></span>Menyu</div>
        <div onclick="openCartOverlay()"><span class="nav-svg"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M6.4 8h13l-1.2 7.2a2 2 0 0 1-2 1.7H9.1a2 2 0 0 1-2-1.6L5.7 5.8H3.8" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M9 21h.01M17 21h.01" stroke="currentColor" stroke-width="3" stroke-linecap="round" />
                </svg></span>Səbət</div>
        <div onclick="openFavoritesOverlay()"><span id="favoriteNavIcon" class="nav-svg"><svg viewBox="0 0 24 24" fill="none">
                    <path d="M12 20.4s-7.2-4.35-9.05-9.05C1.58 7.9 3.72 5 6.88 5c1.88 0 3.34.92 4.12 2.2C11.78 5.92 13.24 5 15.12 5c3.16 0 5.3 2.9 3.93 6.35C19.2 16.05 12 20.4 12 20.4Z" stroke="currentColor" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round" />
                </svg></span>Seçilənlər</div>
        <div onclick="openNovaPosOverlay()"><span class="nav-svg novapos-info-svg"><svg viewBox="0 0 24 24" aria-hidden="true">
                    <circle cx="12" cy="12" r="10" fill="currentColor" opacity="0.92" />
                    <circle cx="12" cy="7.6" r="1.35" fill="#fff" />
                    <path d="M10.85 10.35h2.3v7h-2.3v-7Z" fill="#fff" />
                </svg></span>NovaPOS</div>
    </nav>

    <div id="badgeToast" class="badge-toast"></div>


    <div id="menuOverlay" class="overlay">
        <div class="menu-sheet">
            <div class="menu-sheet-head">
                <div class="menu-sheet-title">
                    <h2>{{ $restaurant->name }}</h2>
                    <p>{{ $table ? ($table->name ?: $table->code) . ' üçün QR menyu' : 'Ümumi QR menyu' }}</p>
                </div>

                <button class="round" type="button" onclick="closeMenuOverlay()">✕</button>
            </div>

            <div class="menu-note">
                <strong>{{ $qrAboutTitle }}</strong>
                <span>{{ $qrAboutDescription }}</span>
            </div>

            <div class="info-list">
                <div class="info-card">
                    <div class="info-kicker">Əlaqə</div>
                    <div class="info-value">
                        @if($qrPhoneHref)
                        <a class="info-action-link" href="tel:{{ $qrPhoneHref }}">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.8 19.8 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.12 4.18 2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72c.12.9.33 1.77.62 2.61a2 2 0 0 1-.45 2.11L8.09 9.63a16 16 0 0 0 6.28 6.28l1.19-1.19a2 2 0 0 1 2.11-.45c.84.29 1.71.5 2.61.62A2 2 0 0 1 22 16.92Z" />
                            </svg>
                            {{ $qrContactPhone }}
                        </a>
                        @else
                        Əlaqə nömrəsi əlavə edilməyib
                        @endif
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-kicker">Yerləşdiyi yer</div>
                    <div class="info-value">
                        @if($qrMapHref)
                        <a class="info-action-link" href="{{ $qrMapHref }}" target="_blank" rel="noopener">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M12 21s7-4.35 7-11a7 7 0 1 0-14 0c0 6.65 7 11 7 11Z" />
                                <circle cx="12" cy="10" r="2.5" />
                            </svg>
                            {{ $qrAddress }}
                        </a>
                        @else
                        Ünvan əlavə edilməyib
                        @endif
                    </div>
                </div>

                <div class="info-card">
                    <div class="info-kicker">Sosial şəbəkələr</div>
                    <div class="info-value">Bizi izləyin və yeniliklərdən xəbərdar olun.</div>

                    <div class="social-row">
                        @if($qrInstagram)
                        <a class="social-link" href="{{ $qrInstagram }}" target="_blank" rel="noopener">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <rect x="3" y="3" width="18" height="18" rx="5" />
                                <circle cx="12" cy="12" r="4" />
                                <path d="M17.5 6.5h.01" />
                            </svg>
                            Instagram
                        </a>
                        @endif

                        @if($qrFacebook)
                        <a class="social-link" href="{{ $qrFacebook }}" target="_blank" rel="noopener">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13.5 22v-8h2.7l.4-3h-3.1V9.1c0-.87.24-1.46 1.5-1.46h1.7V5a22 22 0 0 0-2.45-.13c-2.43 0-4.1 1.48-4.1 4.2V11H7.4v3h2.75v8h3.35Z" />
                            </svg>
                            Facebook
                        </a>
                        @endif

                        @if($qrTiktok)
                        <a class="social-link" href="{{ $qrTiktok }}" target="_blank" rel="noopener">
                            <svg fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16.6 5.8c1.05.78 2.1 1.2 3.4 1.28v3.05a7.3 7.3 0 0 1-3.35-.78v5.83c0 3.35-2.17 5.82-5.6 5.82-3.08 0-5.05-2.04-5.05-4.75 0-3 2.35-5 5.62-4.78v3.1c-1.3-.2-2.35.45-2.35 1.62 0 .95.75 1.58 1.78 1.58 1.2 0 2.05-.72 2.05-2.32V3h3.5v2.8Z" />
                            </svg>
                            TikTok
                        </a>
                        @endif

                        @if($qrWebsite)
                        <a class="social-link" href="{{ $qrWebsite }}" target="_blank" rel="noopener">
                            <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <circle cx="12" cy="12" r="9" />
                                <path d="M3 12h18M12 3c2.2 2.4 3.2 5.4 3.2 9S14.2 18.6 12 21M12 3C9.8 5.4 8.8 8.4 8.8 12S9.8 18.6 12 21" />
                            </svg>
                            Web
                        </a>
                        @endif

                        @if(! $qrInstagram && ! $qrFacebook && ! $qrTiktok && ! $qrWebsite)
                        <span class="social-link">Tezliklə</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="novaPosOverlay" class="overlay">
        <div class="menu-sheet">
            <div class="menu-sheet-head">
                <div class="menu-sheet-title">
                    <h2>NovaPOS</h2>
                    <p>Restoran idarəetməsinin premium rəqəmsal ekosistemi</p>
                </div>

                <button class="round" type="button" onclick="closeNovaPosOverlay()">✕</button>
            </div>

            <div class="novapos-hero-card">
                <h3>NovaPOS — sadəcə bir POS sistemi deyil</h3>
                <p>Müasir restoran biznesinin rəqəmsal ekosistemidir. Biz, qonaqpərvərlik sektorunda fəaliyyət göstərən müəssisələrin mürəkkəb daxili proseslərini intellektual həllərlə sadələşdirir, idarəetməni instinktiv və effektiv səviyyəyə çatdırırıq.</p>
            </div>

            <div class="novapos-section-card">
                <h4>Missiyamız</h4>
                <p>Texnologiyanın gücü ilə sahibkarlara vaxt qazandırmaq və hər bir xidmət nöqtəsini daha gəlirli, şəffaf və sürətli idarə olunan biznes modelinə çevirməkdir. Biz inanırıq ki, innovasiya yalnız mürəkkəb kodlardan deyil, istifadəçi üçün yaradılan maksimum rahatlıqdan ibarətdir.</p>
            </div>

            <div class="novapos-section-card">
                <h4>Niyə NovaPOS?</h4>
                <ul>
                    <li><strong>Tam Nəzarət, Sıfır İtki:</strong> Satışdan inventara, maliyyə hesabatlarından əməkdaşların performansına qədər hər bir detalı tək bir paneldən izləmə imkanı.</li>
                    <li><strong>İntellektual Analitika:</strong> Biznesinizin gələcəyini proqnozlaşdırmaq üçün bugünkü rəqəmləri dərin analiz edir, sizə strateji qərarlar verməkdə kömək edirik.</li>
                    <li><strong>Sərhədsiz Mobil Çeviklik:</strong> QR menyu və bulud əsaslı infrastrukturumuz sayəsində restoranınızın idarəetməsi hər an cibinizdədir.</li>
                    <li><strong>Premium İnterfeys:</strong> İstifadəçi təcrübəsini ön planda tutan, göz yormayan və sürətli keçidləri təmin edən minimalist dizayn yanaşması.</li>
                </ul>
            </div>

            <div class="novapos-final-card">
                <strong>Gələcəyin Texnologiyası İndi Sizinlə</strong>
                <span>NovaPOS olaraq, hər bir müştərimizi partnyorumuz hesab edirik. Hədəfimiz yerli bazarın ehtiyaclarını qlobal standartlarla birləşdirərək Azərbaycanın restoran sektorunda rəqəmsal transformasiyanın lideri olmaqdır.</span>
                <span>Siz biznesinizi böyüdün, qalan hər şeyi NovaPOS-a həvalə edin.</span>
            </div>
        </div>
    </div>



    <div id="billOverlay" class="overlay">
        <div class="bill-sheet">
            <div class="bill-sheet-head">
                <div>
                    <h2>Cari hesab</h2>
                    <p>{{ $table ? ($table->name ?: $table->code) . ' üzrə açıq sifarişlər' : 'Açıq hesab məlumatı' }}</p>
                </div>

                <button class="round" type="button" onclick="closeBillOverlay()">✕</button>
            </div>

            <div class="bill-items">
                @php $billHasItems = false; @endphp

                @foreach($openOrders as $order)
                @foreach($order->items as $item)
                @php $billHasItems = true; @endphp
                <div class="bill-item">
                    <div>
                        <div class="bill-item-name">{{ $item->product_name }}</div>
                        <div class="bill-item-meta">
                            {{ number_format((float) $item->qty, 0) }} ədəd
                            @if(data_get($order, 'order_number'))
                            • Sifariş #{{ data_get($order, 'order_number') }}
                            @endif
                        </div>
                    </div>

                    <div class="bill-item-price">{{ number_format((float) $item->total_price, 2) }} ₼</div>
                </div>
                @endforeach
                @endforeach

                @if(! $billHasItems)
                <div class="empty">Hazırda bu masa üzrə açıq sifariş yoxdur.</div>
                @endif
            </div>

            <div class="bill-final">
                <div>
                    <span>Ümumi məbləğ</span>
                    <strong>{{ number_format((float) $currentBillTotal, 2) }} ₼</strong>
                </div>

                <button class="send" type="button" onclick="closeBillOverlay()">Bağla</button>
            </div>
        </div>
    </div>

    <div id="favoritesOverlay" class="overlay">
        <div class="bill-sheet">
            <div class="bill-sheet-head">
                <div>
                    <h2>Seçilənlər</h2>
                    <p>Bəyəndiyiniz məhsullar bu bölmədə görünəcək.</p>
                </div>

                <button class="round" type="button" onclick="closeFavoritesOverlay()">✕</button>
            </div>

            <div id="favoriteList" class="favorite-list"></div>
        </div>
    </div>

    <div id="requestBillOverlay" class="overlay">
        <div class="bill-sheet">
            <div class="bill-sheet-head">
                <div>
                    <h2>Hesab istəyi</h2>
                    <p>{{ $table ? ($table->name ?: $table->code) . ' üçün' : 'QR menyu üzrə' }}</p>
                </div>

                <button class="round" type="button" onclick="closeRequestBillOverlay()">✕</button>
            </div>

            <div class="request-success">
                <div class="big">✓</div>
                <strong>Hesab istəyi aktivləşdirildi</strong>
                <span>Ofisiant hesab istəyinizi görəcək. İstəsəniz, cari hesab detalları ilə məbləği də görüntüləyə bilərsiniz.</span>
            </div>

            <div class="bill-final">
                <div>
                    <span>Ümumi məbləğ</span>
                    <strong>{{ number_format((float) $currentBillTotal, 2) }} ₼</strong>
                </div>

                <button class="send" type="button" onclick="closeRequestBillOverlay(); openBillOverlay();">Hesaba bax</button>
            </div>
        </div>
    </div>



    <div id="waiterCallOverlay" class="overlay">
        <div class="bill-sheet">
            <div class="bill-sheet-head">
                <div>
                    <h2>Ofisiant çağırıldı</h2>
                    <p>{{ $table ? ($table->name ?: $table->code) . ' üçün çağırış göndərildi' : 'QR menyu üzrə' }}</p>
                </div>

                <button class="round" type="button" onclick="closeWaiterCallOverlay()">✕</button>
            </div>

            <div class="request-success">
                <div class="big">🛎</div>
                <strong>Çağırışınız əməkdaş panelinə göndərildi</strong>
                <span>Ofisiant ən qısa zamanda masanıza yaxınlaşacaq.</span>
            </div>

            <div class="bill-final">
                <div>
                    <span>Status</span>
                    <strong>Gözləmədə</strong>
                </div>

                <button class="send" type="button" onclick="closeWaiterCallOverlay()">Bağla</button>
            </div>
        </div>
    </div>

    <div id="cartOverlay" class="overlay">
        <div class="bill-sheet">
            <div class="bill-sheet-head">
                <div>
                    <h2>Səbət</h2>
                    <p>Seçilən məhsullar</p>
                </div>

                <button class="round" type="button" onclick="closeCartOverlay()">✕</button>
            </div>

            <div id="cartList" class="cart-list"></div>

            <div class="cart-total-row">
                <div>
                    <span style="display:block;font-size:11px;color:rgba(255,255,255,.7);font-weight:800;">
                        Ümumi məbləğ
                    </span>

                    <strong id="cartOverlayTotal" style="display:block;margin-top:4px;font-size:22px;font-weight:950;color:#f1c86a;">
                        0.00 ₼
                    </strong>
                </div>

                <button type="button" class="send" onclick="sendQrOrder()">
                    Sifarişi göndər
                </button>
            </div>
        </div>
    </div>

    <div id="productDetailOverlay" class="overlay">
        <div class="detail">
            <section class="dhero">
                <div id="detailImageWrap"></div>

                <div class="dtop">
                    <button class="round" type="button" onclick="closeProductDetail()">‹</button>

                    <div class="dacts">
                        <button id="detailFavBtn" class="round detail-fav" type="button" onclick="toggleDetailFavorite(event)">♡</button>
                        <button class="round" type="button">↗</button>
                    </div>
                </div>
            </section>

            <section class="dcard">
                <div class="drow">
                    <h1 id="detailName" class="dname">Məhsul</h1>
                    <div id="detailBadge" class="popular" style="display:none;">Populyar</div>
                </div>

                <div class="stars">
                    ★ ★ ★ ★ ☆
                    <span class="rating">4.8 (126 rəy)</span>
                </div>

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
                    <label class="addon">
                        <input type="checkbox">
                        <span>Zeytun əlavə et</span>
                        <span class="aprice">+1.00 ₼</span>
                    </label>

                    <label class="addon">
                        <input type="checkbox">
                        <span>Pendir əlavə et</span>
                        <span class="aprice">+2.00 ₼</span>
                    </label>

                    <label class="addon">
                        <input type="checkbox">
                        <span>Acılı sous 🌶</span>
                        <span class="aprice">+0.50 ₼</span>
                    </label>
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
        let cartItems = [];
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

        function addToCart(name, price, qty = 1, id = null) {
            const existing = cartItems.find(function(item) {
                return item.name === name && Number(item.price) === Number(price);
            });

            if (existing) {
                existing.qty += qty;
            } else {
                cartItems.push({
                    id: id,
                    name: name,
                    price: Number(price),
                    qty: qty
                });
            }

            cartCount += qty;
            cartTotal += Number(price) * qty;
            updateCart();
            renderCartOverlay();
        }

        function openProductDetail(product) {
            currentProduct = product;
            currentQty = 1;

            document.getElementById('detailName').textContent = product.name;
            document.getElementById('detailDesc').textContent = product.description;
            document.getElementById('detailPrice').textContent = money(product.price);

            const detailBadge = document.getElementById('detailBadge');
            if (detailBadge) {
                if (product.isPopular) {
                    detailBadge.textContent = 'Populyar';
                    detailBadge.style.background = '#22c55e';
                    detailBadge.style.display = 'flex';
                } else if (product.isNew) {
                    detailBadge.textContent = 'Yeni';
                    detailBadge.style.background = '#f59e0b';
                    detailBadge.style.display = 'flex';
                } else {
                    detailBadge.style.display = 'none';
                }
            }

            document.getElementById('detailQty').textContent = currentQty;
            document.getElementById('detailQtyBottom').textContent = currentQty;

            const imageWrap = document.getElementById('detailImageWrap');

            if (product.image) {
                imageWrap.innerHTML = '<img src="' + product.image + '" alt="' + product.name + '">';
            } else {
                imageWrap.innerHTML = '<div class="dfallback">🍽</div>';
            }

            document.getElementById('detailAddBtn').textContent =
                'Səbətə əlavə et • ' + money(product.price);

            refreshFavoriteButtons();
            document.getElementById('productDetailOverlay').classList.add('active');
            document.body.classList.add('qr-modal-open');
        }

        function closeProductDetail() {
            document.getElementById('productDetailOverlay').classList.remove('active');
            document.body.classList.remove('qr-modal-open');
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

            addToCart(currentProduct.name, currentProduct.price, currentQty, currentProduct.id);
            closeProductDetail();
        });

        document.getElementById('productDetailOverlay').addEventListener('click', function(event) {
            if (event.target.id === 'productDetailOverlay') {
                closeProductDetail();
            }
        });


        function openMenuOverlay() {
            document.getElementById('menuOverlay').classList.add('active');
            document.body.classList.add('qr-modal-open');
        }

        function closeMenuOverlay() {
            document.getElementById('menuOverlay').classList.remove('active');
            document.body.classList.remove('qr-modal-open');
        }

        function openNovaPosOverlay() {
            document.getElementById('novaPosOverlay').classList.add('active');
            document.body.classList.add('qr-modal-open');
        }

        function closeNovaPosOverlay() {
            document.getElementById('novaPosOverlay').classList.remove('active');
            document.body.classList.remove('qr-modal-open');
        }

        function showBadgeInfo(type) {
            const toast = document.getElementById('badgeToast');
            if (!toast) return;

            if (type === 'popular') {
                toast.innerHTML = '<strong>Populyar məhsul</strong>Son 7 gün ərzində 15 və daha çox satılan məhsullar avtomatik olaraq populyar kimi göstərilir.';
            } else {
                toast.innerHTML = '<strong>Yeni məhsul</strong>Menyunuza yeni əlavə olunan məhsullar 7 gün ərzində Yeni etiketi ilə göstərilir.';
            }

            toast.classList.add('show');
            clearTimeout(window.qrBadgeToastTimer);
            window.qrBadgeToastTimer = setTimeout(function() {
                toast.classList.remove('show');
            }, 3600);
        }


        function toggleLanguageList(event) {
            event.stopPropagation();
            document.getElementById('languageList').classList.toggle('active');
        }

        document.addEventListener('click', function(event) {
            const languageList = document.getElementById('languageList');

            if (languageList && !event.target.closest('.lang-wrap')) {
                languageList.classList.remove('active');
            }
        });

        function filterProducts(categoryId, clickedElement = null) {
            const cards = document.querySelectorAll('.card[data-category]');
            const tabs = document.querySelectorAll('#categoryTabs .cat');

            tabs.forEach(function(tab) {
                tab.classList.remove('active');

                if (String(tab.dataset.category) === String(categoryId)) {
                    tab.classList.add('active');
                }
            });

            if (clickedElement) {
                clickedElement.classList.add('active');
            }

            cards.forEach(function(card) {
                const show = String(categoryId) === 'all' || String(card.dataset.category) === String(categoryId);
                card.style.display = show ? '' : 'none';
            });

            const productsTitle = document.querySelector('#products .title');

            if (productsTitle) {
                productsTitle.textContent = String(categoryId) === 'all' ? 'Məhsullar' : (String(categoryId) === 'other' ? 'Digər məhsullar' : 'Seçilmiş kateqoriya');
            }
        }

        function openBillOverlay() {
            const billOverlay = document.getElementById('billOverlay');

            if (!billOverlay) return;

            billOverlay.classList.add('active');
            document.body.classList.add('qr-modal-open');
        }

        function closeBillOverlay() {
            const billOverlay = document.getElementById('billOverlay');

            if (!billOverlay) return;

            billOverlay.classList.remove('active');
            document.body.classList.remove('qr-modal-open');
        }

        const billOverlay = document.getElementById('billOverlay');

        if (billOverlay) {
            billOverlay.addEventListener('click', function(event) {
                if (event.target.id === 'billOverlay') {
                    closeBillOverlay();
                }
            });
        }


        let favorites = [];

        function goHomeMenu() {
            filterProducts('all');
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        }

        function scrollToProducts() {
            document.getElementById('products').scrollIntoView({
                behavior: 'smooth'
            });
        }

        function renderCartOverlay() {
            const cartList = document.getElementById('cartList');
            const cartOverlayTotal = document.getElementById('cartOverlayTotal');

            if (cartOverlayTotal) {
                cartOverlayTotal.textContent = money(cartTotal);
            }

            if (!cartList) return;

            if (!cartItems.length) {
                cartList.innerHTML = '<div class="empty-soft">Səbət boşdur. Məhsullardan seçim edin.</div>';
                return;
            }

            cartList.innerHTML = cartItems.map(function(item, index) {
                return '<div class="cart-item">' +
                    '<div><strong>' + item.name + '</strong><span>' + item.qty + ' × ' + money(item.price) + '</span></div>' +
                    '<div class="cart-item-actions">' +
                    '<div class="cart-qty-control">' +
                    '<button type="button" class="cart-qty-btn" onclick="changeCartItemQty(' + index + ', -1)">−</button>' +
                    '<span class="cart-qty-number">' + item.qty + '</span>' +
                    '<button type="button" class="cart-qty-btn" onclick="changeCartItemQty(' + index + ', 1)">+</button>' +
                    '</div>' +
                    '<strong>' + money(item.price * item.qty) + '</strong>' +
                    '<button type="button" class="cart-remove-btn" onclick="removeCartItem(' + index + ')">Sil</button>' +
                    '</div>' +
                    '</div>';
            }).join('');
        }

        function recalculateCartTotals() {
            cartCount = cartItems.reduce(function(sum, item) {
                return sum + Number(item.qty || 0);
            }, 0);

            cartTotal = cartItems.reduce(function(sum, item) {
                return sum + (Number(item.price || 0) * Number(item.qty || 0));
            }, 0);
        }

        function changeCartItemQty(index, delta) {
            if (!cartItems[index]) return;

            cartItems[index].qty = Number(cartItems[index].qty || 0) + delta;

            if (cartItems[index].qty <= 0) {
                cartItems.splice(index, 1);
            }

            recalculateCartTotals();
            updateCart();
            renderCartOverlay();
        }

        function removeCartItem(index) {
            if (!cartItems[index]) return;

            cartItems.splice(index, 1);

            recalculateCartTotals();
            updateCart();
            renderCartOverlay();
        }

        function openCartOverlay() {
            renderCartOverlay();
            setOverlay('cartOverlay', true);
        }

        function closeCartOverlay() {
            setOverlay('cartOverlay', false);
        }

        function setOverlay(id, active) {
            const overlay = document.getElementById(id);
            if (!overlay) return;

            overlay.classList.toggle('active', active);
            document.body.classList.toggle('qr-modal-open', active);
        }

        function productIndex(productId) {
            return favorites.findIndex(function(item) {
                return String(item.id) === String(productId);
            });
        }

        function refreshFavoriteButtons() {
            document.querySelectorAll('.fav[data-product-id]').forEach(function(button) {
                const isFavorite = productIndex(button.dataset.productId) !== -1;
                button.classList.toggle('active', isFavorite);
                button.textContent = isFavorite ? '♥' : '♡';
            });
            const navIcon = document.getElementById('favoriteNavIcon');
            if (navIcon) {
                navIcon.classList.toggle('favorite-active', favorites.length > 0);
            }

            const detailFavBtn = document.getElementById('detailFavBtn');
            if (detailFavBtn && currentProduct) {
                const isFavorite = productIndex(currentProduct.id) !== -1;
                detailFavBtn.classList.toggle('active', isFavorite);
                detailFavBtn.textContent = isFavorite ? '♥' : '♡';
            }
        }

        function toggleFavorite(event, button, product) {
            event.stopPropagation();

            const index = productIndex(product.id);

            if (index === -1) {
                favorites.push(product);
            } else {
                favorites.splice(index, 1);
            }

            refreshFavoriteButtons();
            renderFavorites();
        }

        function toggleDetailFavorite(event) {
            event.stopPropagation();
            if (!currentProduct) return;

            const index = productIndex(currentProduct.id);

            if (index === -1) {
                favorites.push(currentProduct);
            } else {
                favorites.splice(index, 1);
            }

            refreshFavoriteButtons();
            renderFavorites();
        }

        function renderFavorites() {
            const favoriteList = document.getElementById('favoriteList');
            if (!favoriteList) return;

            if (!favorites.length) {
                favoriteList.innerHTML = '<div class="empty-soft">Hələ seçilən məhsul yoxdur. Məhsul üzərindəki ürək ikonuna toxunun.</div>';
                return;
            }

            favoriteList.innerHTML = favorites.map(function(product, index) {
                const image = product.image ?
                    '<img src="' + product.image + '" alt="' + product.name + '">' :
                    '🍽';

                return '<div class="favorite-item">' +
                    '<button type="button" style="display:contents;" onclick="openFavoriteProduct(' + product.id + ')">' +
                    '<span class="favorite-thumb">' + image + '</span>' +
                    '<span><span class="favorite-name">' + product.name + '</span>' +
                    '<span class="favorite-price">' + money(product.price) + '</span></span>' +
                    '</button>' +
                    '<button type="button" class="favorite-remove-btn" onclick="removeFavoriteItem(event, ' + product.id + ')">Sil</button>' +
                    '</div>';
            }).join('');
        }

        function removeFavoriteItem(event, productId) {
            if (event) {
                event.stopPropagation();
            }

            const index = productIndex(productId);

            if (index !== -1) {
                favorites.splice(index, 1);
            }

            refreshFavoriteButtons();
            renderFavorites();
        }

        function openFavoriteProduct(productId) {
            const product = favorites.find(function(item) {
                return String(item.id) === String(productId);
            });

            if (!product) return;

            closeFavoritesOverlay();
            openProductDetail(product);
        }

        function openFavoritesOverlay() {
            renderFavorites();
            setOverlay('favoritesOverlay', true);
        }

        function closeFavoritesOverlay() {
            setOverlay('favoritesOverlay', false);
        }

        async function requestBill() {
            @if($table)
            try {
                const response = await fetch(
                    "{{ route('public.qr-menu.request-bill', [$restaurant->slug, $table->code]) }}", {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Content-Type': 'application/json'
                        }
                    }
                );

                const data = await response.json();

                if (data.success) {
                    setOverlay('requestBillOverlay', true);
                } else {
                    alert(data.message || 'Hesab istəyi göndərilə bilmədi');
                }
            } catch (e) {
                alert('Server xətası');
            }
            @else
            alert('Hesab istəmək üçün masa QR kodundan daxil olun.');
            @endif
        }

        function closeRequestBillOverlay() {
            setOverlay('requestBillOverlay', false);
        }


        async function callWaiter() {
            @if($table)
            try {
                const response = await fetch(
                    "{{ url('/menu/' . $restaurant->slug . '/table/' . $table->code . '/call-waiter') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    }
                );

                const data = await response.json();

                if (data.success) {
                    setOverlay('waiterCallOverlay', true);
                } else {
                    alert(data.message || 'Ofisiant çağırışı göndərilə bilmədi');
                }
            } catch (e) {
                alert('Server xətası');
            }
            @else
            alert('Ofisiant çağırmaq üçün masa QR kodundan daxil olun.');
            @endif
        }

        function closeWaiterCallOverlay() {
            setOverlay('waiterCallOverlay', false);
        }

        ['cartOverlay', 'favoritesOverlay', 'requestBillOverlay', 'waiterCallOverlay', 'novaPosOverlay'].forEach(function(id) {
            const overlay = document.getElementById(id);

            if (overlay) {
                overlay.addEventListener('click', function(event) {
                    if (event.target.id === id) {
                        setOverlay(id, false);
                    }
                });
            }
        });

        async function sendQrOrder() {
            if (!cartItems.length) {
                alert('Səbət boşdur');
                return;
            }

            @if($table)
            try {
                const response = await fetch(
                    "{{ route('public.qr-menu.send-order', [$restaurant->slug, $table->code]) }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            items: cartItems.map(function(item) {
                                return {
                                    id: item.id || null,
                                    name: item.name,
                                    qty: item.qty,
                                    price: item.price
                                };
                            })
                        })
                    }
                );

                const data = await response.json();

                if (data.success) {
                    alert(data.message || 'Sifariş göndərildi');

                    cartItems = [];
                    cartCount = 0;
                    cartTotal = 0;

                    updateCart();
                    renderCartOverlay();
                    closeCartOverlay();

                    window.location.reload();
                } else {
                    alert(data.message || 'Xəta baş verdi');
                }
            } catch (e) {
                alert('Server xətası');
            }
            @else
            const whatsappNumber = "{{ preg_replace('/[^0-9]/', '', (string) $qrPhoneHref) }}";

            if (!whatsappNumber) {
                alert('WhatsApp sifarişi üçün məlumat bölməsində əlaqə nömrəsi əlavə edilməyib.');
                return;
            }

            let message = "🍽 {{ $restaurant->name }} - QR Menu sifarişi\n\n";

            cartItems.forEach(function(item) {
                message += "• " + item.qty + "x " + item.name + " - " + money(item.price * item.qty) + "\n";
            });

            message += "\n💳 Ümumi: " + money(cartTotal) + "\n";
            message += "\nSalam, bu məhsulları sifariş etmək istəyirəm.";

            window.open(
                'https://wa.me/' + whatsappNumber + '?text=' + encodeURIComponent(message),
                '_blank'
            );
            @endif
        }

        function enableCategoryDragScroll() {
            const slider = document.getElementById('categoryTabs');
            if (!slider) return;

            let isDown = false;
            let startX = 0;
            let scrollLeft = 0;

            slider.addEventListener('mousedown', function(e) {
                isDown = true;
                slider.classList.add('dragging');
                startX = e.pageX - slider.offsetLeft;
                scrollLeft = slider.scrollLeft;
            });

            slider.addEventListener('mouseleave', function() {
                isDown = false;
                slider.classList.remove('dragging');
            });

            slider.addEventListener('mouseup', function() {
                isDown = false;
                slider.classList.remove('dragging');
            });

            slider.addEventListener('mousemove', function(e) {
                if (!isDown) return;
                e.preventDefault();
                const x = e.pageX - slider.offsetLeft;
                const walk = (x - startX) * 1.35;
                slider.scrollLeft = scrollLeft - walk;
            });
        }

        enableCategoryDragScroll();
        renderFavorites();
        refreshFavoriteButtons();

        updateCart();
    </script>
</body>

</html>