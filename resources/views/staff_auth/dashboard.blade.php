<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaPOS | POS</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body,
        button,
        input,
        select,
        textarea,
        a,
        span,
        div,
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system,
                BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        body {
            background: linear-gradient(180deg, #eef2ff 0%, #f8fafc 52%, #eef7f3 100%);
            color: #071143;
            overflow: hidden;
            font-weight: 500;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        .pos-wrapper {
            width: 100%;
            height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .pos-navbar {
            height: 60px;
            background: linear-gradient(90deg, #251d55, #171545);
            color: #fff;
            display: flex;
            align-items: center;
            padding: 0 14px;
            gap: 10px;
            flex-shrink: 0;
        }

        .nav-btn {
            height: 40px;
            border-radius: 10px;
            padding: 0 16px;
            color: #fff;
            background: rgba(255, 255, 255, .04);
            border: 1px solid rgba(255, 255, 255, .12);
            font-size: 14px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 9px;
            cursor: pointer;
        }

        .nav-btn.green {
            background: linear-gradient(90deg, #18b978, #20d68f);
            border: none;
            min-width: 145px;
            justify-content: center;
            font-weight: 700;
        }

        .nav-btn svg {
            width: 19px;
            height: 19px;
        }

        .nav-icon-btn {
            width: 48px;
            padding: 0;
            justify-content: center;
        }

        .nav-divider {
            width: 1px;
            height: 34px;
            background: rgba(255, 255, 255, .14);
            margin: 0 4px;
        }

        .restaurant-box {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 250px;
        }

        .restaurant-icon {
            width: 36px;
            height: 36px;
            border: 2px solid rgba(255, 255, 255, .85);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .restaurant-icon svg {
            width: 22px;
            height: 22px;
        }

        .restaurant-name {
            font-size: 15px;
            font-weight: 700;
            line-height: 1.05;
        }

        .staff-line {
            margin-top: 3px;
            font-size: 11px;
            color: rgba(255, 255, 255, .78);
            font-weight: 500;
        }

        .staff-line span {
            color: #20d68f;
            margin-left: 7px;
            font-weight: 600;
        }

        .nav-spacer {
            flex: 1;
        }

        .nav-status {
            height: 60px;
            display: flex;
            align-items: center;
        }

        .nav-status-item {
            height: 34px;
            min-width: 58px;
            border-left: 1px solid rgba(255, 255, 255, .14);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 0 13px;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-status-item svg {
            width: 21px;
            height: 21px;
        }

        .wifi svg {
            width: 24px;
            height: 24px;
            color: #20d68f;
        }

        .pos-content {
            height: calc(100vh - 60px);
            padding: 10px;
            display: grid;
            grid-template-columns: 210px minmax(520px, 1fr) 360px;
            gap: 10px;
            overflow: hidden;
        }

        .panel {
            background: #fff;
            border: 1px solid #dfe7f2;
            border-radius: 16px;
            box-shadow: 0 10px 28px rgba(15, 23, 42, .045);
            overflow: hidden;
        }

        .categories {
            padding: 13px;
            overflow-y: auto;
        }

        .category-link {
            height: 49px;
            border: 1px solid #dfe7f2;
            border-radius: 10px;
            padding: 0 14px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 13.5px;
            font-weight: 600;
            color: #071143;
            margin-bottom: 8px;
            background: #fff;
        }

        .category-link.active {
            border-left: 4px solid #20c985;
            color: #0a9b61;
            background: #f8fffc;
            font-weight: 700;
        }

        .category-icon {
            width: 22px;
            text-align: center;
            font-size: 17px;
        }

        .products-panel {
            padding: 12px;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .product-tools {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            flex-shrink: 0;
        }

        .search-box {
            flex: 1;
            height: 40px;
            border: 1px solid #dfe7f2;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 15px;
            background: #fff;
        }

        .search-box svg {
            width: 18px;
            height: 18px;
            color: #7b8498;
            flex-shrink: 0;
        }

        .search-box input {
            border: none;
            outline: none;
            width: 100%;
            font-size: 13.5px;
            color: #071143;
            font-weight: 500;
            background: transparent;
        }

        .filter-link {
            width: 94px;
            height: 40px;
            border: 1px solid #dfe7f2;
            border-radius: 10px;
            background: #fff;
            font-size: 13.5px;
            font-weight: 600;
            color: #071143;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .filter-link svg {
            width: 18px;
            height: 18px;
        }

        .products-grid {
            flex: 1;
            overflow-y: auto;
            display: grid;
            grid-template-columns: repeat(4, minmax(120px, 1fr));
            gap: 9px;
            padding-right: 3px;
            align-content: start;
        }

        .product-link {
            border: 1px solid #dfe7f2;
            border-radius: 12px;
            background: #fff;
            overflow: hidden;
            height: 185px;
            min-height: 185px;
            transition: .18s;
            display: flex;
            flex-direction: column;
        }

        .product-link:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 22px rgba(15, 23, 42, .08);
        }

        .product-img {
            width: 100%;
            height: 133px;
            background: linear-gradient(135deg, #edf3fa, #dfe8f3);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
            overflow: hidden;
            flex-shrink: 0;
        }

        .product-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center center;
            display: block;
        }

        .product-body {
            flex: 1;
            padding: 8px 11px 9px;
            background: #fff;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 0;
        }

        .product-name {
            font-size: 13px;
            font-weight: 600;
            color: #071143;
            line-height: 1.18;
            min-height: 0;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .product-price {
            margin-top: 4px;
            font-size: 13px;
            font-weight: 700;
            color: #099b62;
            line-height: 1.1;
        }

        .empty-products {
            grid-column: 1 / -1;
            text-align: center;
            padding: 40px 15px;
            color: #7b8498;
            font-weight: 600;
            border: 1px dashed #dfe7f2;
            border-radius: 12px;
            background: #fbfdff;
        }

        .order-panel {
            display: flex;
            flex-direction: column;
            padding: 14px;
            overflow: hidden;
        }

        .order-tabs {
            height: 50px;
            border: 1px solid #dfe7f2;
            border-radius: 10px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            overflow: hidden;
            flex-shrink: 0;
        }

        .order-tab-link {
            background: #fff;
            font-size: 13.5px;
            font-weight: 500;
            color: #4c5570;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            border-right: 1px solid #eef1f6;
        }

        .order-tab-link:last-child {
            border-right: none;
        }

        .order-tab-link.active {
            color: #0aa86b;
            box-shadow: inset 0 -2px 0 #20c985;
            background: #fbfffd;
            font-weight: 600;
        }

        .order-tab-link svg {
            width: 18px;
            height: 18px;
        }

        .order-header {
            margin-top: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .order-title {
            font-size: 16px;
            font-weight: 700;
        }

        .clear-cart-link {
            color: #ff3434;
            font-size: 12px;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .order-list {
            margin-top: 15px;
            flex: 1;
            overflow-y: auto;
            border-top: 1px solid #eef1f6;
        }

        .order-item {
            min-height: 67px;
            border-bottom: 1px solid #eef1f6;
            display: grid;
            grid-template-columns: 96px 1fr 70px 22px;
            gap: 9px;
            align-items: center;
        }

        .qty-box {
            height: 34px;
            border: 1px solid #dfe7f2;
            border-radius: 8px;
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            overflow: hidden;
        }

        .qty-link {
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 700;
            color: #071143;
        }

        .qty-box span {
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 13px;
        }

        .order-product-name {
            font-size: 12.8px;
            font-weight: 600;
            color: #071143;
        }

        .order-note {
            font-size: 11px;
            color: #7b8498;
            margin-top: 3px;
        }

        .order-price {
            text-align: right;
            font-size: 12.8px;
            font-weight: 600;
        }

        .delete-link {
            color: #ff3434;
            font-size: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .summary {
            margin-top: 11px;
            border-top: 1px solid #eef1f6;
            padding-top: 14px;
            flex-shrink: 0;
        }

        .summary-line {
            display: flex;
            justify-content: space-between;
            font-size: 13.5px;
            color: #65708a;
            font-weight: 500;
            margin-bottom: 12px;
        }

        .summary-line strong {
            color: #071143;
            font-weight: 600;
        }

        .summary-total {
            margin-top: 10px;
            padding-top: 14px;
            border-top: 1px solid #eef1f6;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .summary-total span {
            font-size: 15px;
            font-weight: 600;
        }

        .summary-total strong {
            font-size: 24px;
            color: #0aa86b;
            font-weight: 700;
        }

        .action-row {
            margin-top: 17px;
            display: grid;
            grid-template-columns: 1fr 1.1fr;
            gap: 10px;
        }

        .close-order-link {
            height: 52px;
            border: 1px solid #dfe7f2;
            border-radius: 10px;
            background: #fff;
            color: #071143;
            font-size: 14px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-direction: column;
            line-height: 1.1;
        }

        .close-order-link small {
            display: block;
            color: #7b8498;
            font-size: 10.5px;
            font-weight: 500;
        }

        .pay-link {
            height: 52px;
            border-radius: 10px;
            background: linear-gradient(90deg, #17b978, #21c985);
            color: #fff;
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-direction: column;
            line-height: 1.1;
        }

        .pay-link small {
            display: block;
            color: rgba(255, 255, 255, .9);
            font-size: 10.5px;
            font-weight: 500;
        }



        .order-tab-content {
            display: none;
            flex: 1;
            min-height: 0;
            overflow-y: auto;
        }

        .order-tab-content.active {
            display: flex;
            flex-direction: column;
        }

        .table-info-card {
            margin-top: 14px;
            border: 1px solid #eef1f6;
            border-radius: 14px;
            padding: 14px;
            background: linear-gradient(180deg, #ffffff, #fbfdff);
        }

        .table-info-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
        }

        .table-info-title {
            font-size: 18px;
            font-weight: 800;
            color: #071143;
        }

        .table-info-subtitle {
            margin-top: 4px;
            font-size: 12px;
            font-weight: 600;
            color: #7b8498;
        }

        .table-info-status {
            height: 26px;
            padding: 0 10px;
            border-radius: 999px;
            background: rgba(16, 185, 129, .11);
            color: #059669;
            font-size: 11px;
            font-weight: 800;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .table-info-grid {
            margin-top: 14px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .table-info-box {
            border: 1px solid #eef1f6;
            border-radius: 12px;
            padding: 10px;
            background: #fff;
        }

        .table-info-box span {
            display: block;
            font-size: 10.5px;
            color: #7b8498;
            font-weight: 700;
        }

        .table-info-box strong {
            display: block;
            margin-top: 5px;
            font-size: 13px;
            color: #071143;
            font-weight: 800;
        }

        .table-actions-stack {
            margin-top: 12px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .table-action-btn {
            height: 40px;
            border-radius: 10px;
            border: 1px solid #dfe7f2;
            background: #fff;
            color: #071143;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
        }

        .table-action-btn.share {
            color: #2563eb;
            border-color: rgba(37, 99, 235, .28);
            background: #eff6ff;
        }

        .table-info-card,
        .table-info-card button,
        .table-info-card input,
        .table-info-card textarea,
        .reservation-card,
        .reservation-card button,
        .reservation-card input,
        .reservation-card textarea {
            font-family: Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .reservation-card {
            margin-top: 12px;
            border: 1px solid rgba(245, 158, 11, .28);
            border-radius: 14px;
            padding: 13px;
            background: #fffaf0;
        }

        .reservation-title {
            font-size: 13px;
            color: #071143;
            font-weight: 800;
        }

        .reservation-note {
            margin-top: 4px;
            font-size: 11px;
            line-height: 1.45;
            color: #7b8498;
            font-weight: 600;
        }

        .current-reservation-card {
            margin-top: 12px;
            border: 1px solid rgba(14, 165, 233, .28);
            border-radius: 14px;
            padding: 13px;
            background: #f0f9ff;
            display: none;
        }

        .current-reservation-card.show {
            display: block;
        }

        .current-reservation-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .current-reservation-title {
            font-size: 13px;
            color: #071143;
            font-weight: 900;
        }

        .current-reservation-time {
            height: 24px;
            padding: 0 9px;
            border-radius: 999px;
            background: #0ea5e9;
            color: #fff;
            font-size: 11px;
            font-weight: 900;
            display: flex;
            align-items: center;
            white-space: nowrap;
        }

        .current-reservation-info {
            margin-top: 10px;
            display: grid;
            gap: 6px;
        }

        .current-reservation-line {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 11.5px;
            color: #64748b;
            font-weight: 700;
        }

        .current-reservation-line strong {
            color: #071143;
            font-weight: 900;
            text-align: right;
        }

        .reservation-action-row {
            margin-top: 11px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .reservation-action-btn {
            height: 38px;
            border-radius: 10px;
            border: 1px solid transparent;
            font-size: 12px;
            font-weight: 900;
            cursor: pointer;
        }

        .reservation-action-btn.complete {
            background: #10b981;
            color: #fff;
        }

        .reservation-action-btn.cancel {
            background: #fff;
            border-color: rgba(239, 68, 68, .28);
            color: #ef4444;
        }

        .reservation-form {
            margin-top: 10px;
            display: grid;
            gap: 8px;
        }

        .reservation-form input,
        .reservation-form textarea {
            width: 100%;
            min-height: 38px;
            border: 1px solid #dfe7f2;
            border-radius: 10px;
            padding: 0 11px;
            background: #fff;
            color: #071143;
            font-size: 12.5px;
            font-weight: 600;
            outline: none;
        }

        .reservation-form textarea {
            min-height: 58px;
            padding-top: 9px;
            resize: none;
        }

        .reservation-form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .reservation-submit {
            height: 40px;
            border-radius: 10px;
            border: 1px solid rgba(245, 158, 11, .35);
            background: #fff;
            color: #ea580c;
            font-size: 13px;
            font-weight: 900;
            cursor: pointer;
        }

        .reservation-disabled {
            margin-top: 10px;
            padding: 10px;
            border-radius: 12px;
            background: #f8fafc;
            border: 1px solid #eef1f6;
            font-size: 12px;
            line-height: 1.45;
            color: #64748b;
            font-weight: 700;
        }

        .customer-empty-card {
            margin-top: 14px;
            padding: 18px;
            border: 1px dashed #dfe7f2;
            border-radius: 14px;
            background: #fbfdff;
            text-align: center;
            color: #7b8498;
            font-size: 12.5px;
            font-weight: 700;
            line-height: 1.45;
        }

        .check-switcher {
            margin-top: 10px;
            display: flex;
            gap: 7px;
            overflow-x: auto;
            padding-bottom: 2px;
        }

        .check-chip {
            min-height: 34px;
            padding: 0 10px;
            border-radius: 999px;
            border: 1px solid #dfe7f2;
            background: #fff;
            color: #4c5570;
            font-size: 11.5px;
            font-weight: 900;
            cursor: pointer;
            white-space: nowrap;
        }

        .check-chip.active {
            border-color: rgba(32, 201, 133, .45);
            background: rgba(32, 201, 133, .10);
            color: #059669;
        }

        .table-action-btn.success {
            color: #059669;
            border-color: rgba(16, 185, 129, .35);
            background: #f0fdf4;
        }

        .table-action-btn.warning {
            color: #b45309;
            border-color: rgba(245, 158, 11, .35);
            background: #fffbeb;
        }






        /* ================= CUSTOMER PANEL ================= */

        .customer-panel-card {
            margin-top: 14px;
            border: 1px solid #e6edf7;
            border-radius: 16px;
            background: linear-gradient(180deg, #ffffff, #fbfdff);
            padding: 14px;
        }

        .customer-panel-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 12px;
        }

        .customer-panel-title {
            font-size: 16px;
            font-weight: 900;
            color: #071143;
        }

        .customer-panel-subtitle {
            margin-top: 4px;
            font-size: 11.5px;
            color: #7b8498;
            font-weight: 700;
            line-height: 1.35;
        }

        .customer-search-box {
            height: 40px;
            border: 1px solid #dfe7f2;
            border-radius: 12px;
            background: #fff;
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 11px;
        }

        .customer-search-box svg {
            width: 17px;
            height: 17px;
            color: #7b8498;
            flex-shrink: 0;
        }

        .customer-search-box input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            color: #071143;
            font-size: 12.5px;
            font-weight: 700;
        }

        .customer-search-results {
            margin-top: 8px;
            display: grid;
            gap: 7px;
            max-height: 175px;
            overflow-y: auto;
        }

        .customer-result-btn {
            width: 100%;
            min-height: 46px;
            border: 1px solid #e6edf7;
            border-radius: 12px;
            background: #fff;
            color: #071143;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            cursor: pointer;
            text-align: left;
        }

        .customer-result-btn strong {
            display: block;
            font-size: 12.5px;
            font-weight: 900;
        }

        .customer-result-btn span {
            display: block;
            margin-top: 3px;
            font-size: 11px;
            color: #7b8498;
            font-weight: 700;
        }

        .customer-result-btn em {
            font-style: normal;
            color: #ef4444;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .customer-selected-card {
            margin-top: 10px;
            border: 1px solid rgba(32, 201, 133, .28);
            border-radius: 14px;
            background: rgba(32, 201, 133, .08);
            padding: 12px;
            display: none;
        }

        .customer-selected-card.show {
            display: block;
        }

        .customer-selected-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
        }

        .customer-selected-name {
            font-size: 14px;
            color: #071143;
            font-weight: 900;
        }

        .customer-selected-phone {
            margin-top: 4px;
            font-size: 11.5px;
            color: #64748b;
            font-weight: 800;
        }

        .customer-clear-btn {
            width: 30px;
            height: 30px;
            border-radius: 10px;
            border: 1px solid rgba(239, 68, 68, .22);
            background: #fff;
            color: #ef4444;
            font-weight: 900;
            cursor: pointer;
        }

        .customer-info-grid {
            margin-top: 10px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .customer-info-box {
            border: 1px solid rgba(255, 255, 255, .75);
            border-radius: 12px;
            background: rgba(255, 255, 255, .72);
            padding: 9px;
        }

        .customer-info-box span {
            display: block;
            font-size: 10.5px;
            color: #64748b;
            font-weight: 800;
        }

        .customer-info-box strong {
            display: block;
            margin-top: 4px;
            font-size: 13px;
            color: #071143;
            font-weight: 900;
        }

        .customer-create-form {
            margin-top: 12px;
            border-top: 1px solid #eef1f6;
            padding-top: 12px;
            display: grid;
            gap: 8px;
        }

        .customer-create-form input,
        .customer-create-form textarea {
            width: 100%;
            min-height: 38px;
            border: 1px solid #dfe7f2;
            border-radius: 11px;
            padding: 0 11px;
            background: #fff;
            color: #071143;
            font-size: 12.5px;
            font-weight: 700;
            outline: none;
        }

        .customer-create-form textarea {
            min-height: 56px;
            padding-top: 9px;
            resize: none;
        }

        .customer-create-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .customer-save-btn {
            height: 40px;
            border-radius: 11px;
            border: none;
            background: linear-gradient(90deg, #17b978, #21c985);
            color: #fff;
            font-size: 13px;
            font-weight: 900;
            cursor: pointer;
        }

        .customer-help-card {
            margin-top: 10px;
            border: 1px dashed #dfe7f2;
            border-radius: 13px;
            padding: 11px;
            background: #fbfdff;
            color: #64748b;
            font-size: 11.5px;
            font-weight: 700;
            line-height: 1.45;
        }


        /* ================= PAYMENT SCREEN ================= */

        .payment-screen {
            display: none;
            flex: 1;
            min-height: 0;
            overflow-y: auto;
        }

        .payment-screen.active {
            display: flex;
            flex-direction: column;
        }

        .payment-card {
            margin-top: 14px;
            border: 1px solid #e6edf7;
            border-radius: 16px;
            background: linear-gradient(180deg, #ffffff, #fbfdff);
            padding: 14px;
        }

        .payment-head {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 12px;
            margin-bottom: 12px;
        }

        .payment-title {
            font-size: 17px;
            font-weight: 900;
            color: #071143;
        }

        .payment-subtitle {
            margin-top: 3px;
            font-size: 11.5px;
            font-weight: 700;
            color: #7b8498;
        }

        .payment-total-badge {
            min-width: 112px;
            height: 48px;
            border-radius: 14px;
            background: rgba(16, 185, 129, .10);
            border: 1px solid rgba(16, 185, 129, .22);
            color: #059669;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: 900;
            white-space: nowrap;
        }

        .payment-section-title {
            margin: 12px 0 8px;
            font-size: 12px;
            color: #071143;
            font-weight: 900;
        }

        .payment-method-grid,
        .discount-type-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .payment-method-grid {
            grid-template-columns: repeat(4, 1fr);
        }

        .payment-choice-btn {
            height: 42px;
            border-radius: 12px;
            border: 1px solid #dfe7f2;
            background: #fff;
            color: #071143;
            font-size: 12.5px;
            font-weight: 900;
            cursor: pointer;
        }

        .payment-choice-btn.active {
            background: #171545;
            border-color: #171545;
            color: #fff;
            box-shadow: 0 10px 22px rgba(23, 21, 69, .14);
        }

        .payment-amount-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
        }

        .payment-input-box {
            border: 1px solid #e6edf7;
            border-radius: 13px;
            background: #fff;
            padding: 10px;
            cursor: pointer;
        }

        .payment-input-box.active {
            border-color: rgba(32, 201, 133, .48);
            box-shadow: 0 0 0 3px rgba(32, 201, 133, .09);
        }

        .payment-input-box span {
            display: block;
            font-size: 10.5px;
            color: #7b8498;
            font-weight: 800;
        }

        .payment-input-box strong {
            display: block;
            margin-top: 4px;
            font-size: 17px;
            color: #071143;
            font-weight: 900;
        }

        .payment-input-field {
            width: 100%;
            margin-top: 4px;
            border: none;
            outline: none;
            background: transparent;
            color: #071143;
            font-size: 17px;
            font-weight: 900;
            line-height: 1.2;
            font-family: inherit;
        }

        .payment-input-field:focus {
            color: #059669;
        }

        .payment-input-box.disabled {
            opacity: .55;
            cursor: not-allowed;
            background: #f8fafc;
        }

        .payment-input-box.disabled .payment-input-field {
            color: #94a3b8;
            cursor: not-allowed;
        }


        .payment-summary-box {
            margin-top: 10px;
            display: grid;
            gap: 7px;
            border-top: 1px solid #eef1f6;
            padding-top: 10px;
        }

        .payment-summary-line {
            display: flex;
            justify-content: space-between;
            font-size: 12.5px;
            font-weight: 800;
            color: #65708a;
        }

        .payment-summary-line strong {
            color: #071143;
            font-weight: 900;
        }

        .payment-keypad {
            margin-top: 12px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .payment-key {
            height: 46px;
            border-radius: 13px;
            border: 1px solid #dfe7f2;
            background: #fff;
            color: #071143;
            font-size: 18px;
            font-weight: 900;
            cursor: pointer;
        }

        .payment-key.danger {
            color: #ef4444;
            background: #fff7f7;
            border-color: rgba(239, 68, 68, .22);
        }

        .payment-footer-actions {
            margin-top: 12px;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            gap: 10px;
        }

        .payment-back-btn,
        .payment-complete-btn {
            height: 50px;
            border-radius: 13px;
            font-size: 14px;
            font-weight: 900;
            cursor: pointer;
        }

        .payment-back-btn {
            border: 1px solid #dfe7f2;
            background: #fff;
            color: #071143;
        }

        .payment-complete-btn {
            border: none;
            background: linear-gradient(90deg, #17b978, #21c985);
            color: #fff;
        }

        .payment-complete-btn:disabled {
            opacity: .55;
            cursor: not-allowed;
        }


        /* ================= TABLE SELECTION SCREEN ================= */

        .hidden-pos {
            display: none !important;
        }

        .tables-screen {
            height: calc(100vh - 60px);
            padding: 10px;
            overflow: hidden;
            background:
                radial-gradient(circle at top left, rgba(32, 214, 143, .12), transparent 28%),
                radial-gradient(circle at bottom right, rgba(37, 29, 85, .10), transparent 30%);
        }

        .tables-shell {
            height: 100%;
            background: linear-gradient(180deg, rgba(255, 255, 255, .96), rgba(248, 250, 252, .96));
            border: 1px solid rgba(223, 231, 242, .95);
            border-radius: 20px;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .075);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        .tables-header {
            padding: 12px 16px;
            border-bottom: 1px solid #eef1f6;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            flex-shrink: 0;
        }

        .tables-header-left {
            min-width: 210px;
        }

        .tables-header-right {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 12px;
            min-width: 0;
        }

        .tables-title {
            font-size: 18px;
            font-weight: 800;
            color: #071143;
        }

        .tables-subtitle {
            margin-top: 4px;
            font-size: 12px;
            color: #7b8498;
            font-weight: 500;
        }

        .tables-status-row {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .table-status-pill {
            height: 34px;
            padding: 0 12px;
            border: 1px solid #dfe7f2;
            background: #fff;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 12px;
            font-weight: 600;
            color: #4c5570;
        }

        .status-dot {
            width: 9px;
            height: 9px;
            border-radius: 999px;
            display: block;
        }

        .status-empty {
            background: #10b981;
        }

        .status-busy {
            background: #ef4444;
        }

        .status-reserved {
            background: #0ea5e9;
        }

        .status-waiting {
            background: #f59e0b;
        }

        .status-late {
            background: #ef4444;
        }

        .status-arrived {
            background: #10b981;
        }

        .tables-area-tabs {
            display: flex;
            align-items: center;
            gap: 8px;
            overflow-x: auto;
            flex-shrink: 1;
            min-width: 0;
            max-width: 58%;
            padding-bottom: 2px;
        }

        .table-area-tab {
            height: 36px;
            padding: 0 15px;
            border-radius: 12px;
            background: #fff;
            border: 1px solid #dfe7f2;
            font-size: 12.5px;
            font-weight: 700;
            color: #4c5570;
            white-space: nowrap;
            cursor: pointer;
        }

        .table-area-tab.active {
            background: #171545;
            border-color: #171545;
            color: #fff;
        }

        .tables-layout-wrap {
            flex: 1;
            min-height: 0;
            overflow: hidden;
            padding: 10px 14px 14px;
        }

        .staff-table-area {
            display: none;
        }

        .staff-table-area.active {
            display: block;
        }

        .staff-area-title {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 8px;
        }

        .staff-area-title h3 {
            font-size: 15px;
            font-weight: 800;
            color: #071143;
        }

        .staff-area-title span {
            font-size: 12px;
            font-weight: 600;
            color: #7b8498;
        }

        .staff-table-canvas {
            position: relative;
            min-width: 760px;
            height: calc(100vh - 188px);
            max-height: 520px;
            min-height: 430px;
            border: 1px solid #e2e8f0;
            border-radius: 18px;
            overflow: hidden;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .98), rgba(248, 250, 252, .98)),
                radial-gradient(circle at 20% 20%, rgba(16, 185, 129, .08), transparent 28%);
        }

        .staff-table-item {
            position: absolute;
            border: 2px solid #dfe7f2;
            background: #ffffff;
            box-shadow: 0 10px 24px rgba(15, 23, 42, .08);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: .18s;
            padding: 12px 8px;
        }

        .staff-table-item[data-status="empty"] {
            background: linear-gradient(180deg, #ffffff, #f8fffc);
            border-color: rgba(16, 185, 129, .28);
        }

        .staff-table-item[data-status="busy"] {
            background: linear-gradient(180deg, #fff, #fff5f5);
            border-color: rgba(239, 68, 68, .32);
        }

        .staff-table-item[data-status="waiting_payment"] {
            background: linear-gradient(180deg, #fff, #fffbeb);
            border-color: rgba(245, 158, 11, .35);
        }

        .staff-table-item[data-status="reserved"] {
            background: linear-gradient(180deg, #fff, #f0f9ff);
            border-color: rgba(14, 165, 233, .35);
        }

        .staff-table-item[data-state="reservation_upcoming"] {
            background: linear-gradient(180deg, #ffffff, #eff6ff);
            border-color: rgba(37, 99, 235, .42);
        }

        .staff-table-item[data-state="reservation_due_soon"] {
            background: linear-gradient(180deg, #ffffff, #fffbeb);
            border-color: rgba(245, 158, 11, .58);
            box-shadow: 0 14px 32px rgba(245, 158, 11, .16);
        }

        .staff-table-item[data-state="reservation_late"] {
            background: linear-gradient(180deg, #ffffff, #fff1f2);
            border-color: rgba(239, 68, 68, .58);
            box-shadow: 0 14px 32px rgba(239, 68, 68, .16);
        }

        .staff-table-item[data-state="reservation_arrived"] {
            background: linear-gradient(180deg, #ffffff, #ecfdf5);
            border-color: rgba(16, 185, 129, .52);
        }

        .staff-table-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 16px 34px rgba(15, 23, 42, .14);
            border-color: #10b981;
        }

        .staff-table-square {
            border-radius: 16px;
        }

        .staff-table-circle {
            border-radius: 999px;
        }

        .staff-table-rectangle {
            border-radius: 18px;
        }

        .staff-table-name {
            width: calc(100% - 18px);
            text-align: center;
            font-weight: 800;
            color: #071143;
            line-height: 1.1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .staff-table-meta {
            width: calc(100% - 16px);
            text-align: center;
            font-weight: 600;
            color: #7b8498;
            line-height: 1.15;
        }

        .staff-table-item[data-status="empty"] .staff-table-name {
            position: static;
            transform: none;
            font-size: 17px;
            letter-spacing: -.2px;
        }

        .staff-table-item[data-status="empty"] .staff-table-meta {
            position: static;
            transform: none;
            margin-top: 6px;
            font-size: 11px;
        }

        .staff-table-item:not([data-status="empty"]) .staff-table-name {
            position: absolute;
            top: 13px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
        }

        .staff-table-item:not([data-status="empty"]) .staff-table-meta {
            position: absolute;
            bottom: 12px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 10px;
        }

        .staff-table-waiter {
            display: block;
            color: #071143;
            font-weight: 700;
        }

        .staff-table-time {
            display: block;
            margin-top: 2px;
            color: #7b8498;
            font-weight: 600;
        }

        .staff-table-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 17px;
            height: 17px;
            border-radius: 999px;
            border: 3px solid #fff;
            box-shadow: 0 5px 12px rgba(15, 23, 42, .18);
        }

        .staff-table-seats {
            position: absolute;
            inset: 0;
            pointer-events: none;
        }

        .staff-seat {
            position: absolute;
            width: 18px;
            height: 18px;
        }

        .staff-seat-back {
            position: absolute;
            left: 2px;
            top: 2px;
            width: 14px;
            height: 7px;
            border-radius: 999px;
            background: #10b981;
            box-shadow:
                0 3px 8px rgba(16, 185, 129, .28),
                inset 0 1px 1px rgba(255, 255, 255, .35);
        }

        .staff-reservation-badge {
            position: absolute;
            left: 50%;
            bottom: -10px;
            transform: translateX(-50%);
            height: 20px;
            padding: 0 8px;
            border-radius: 999px;
            background: #0ea5e9;
            color: #fff;
            font-size: 9.5px;
            font-weight: 800;
            display: flex;
            align-items: center;
            white-space: nowrap;
            box-shadow: 0 6px 14px rgba(14, 165, 233, .28);
            z-index: 20;
        }

        .selected-table-chip {
            display: none;
            height: 34px;
            padding: 0 12px;
            border-radius: 12px;
            background: rgba(32, 214, 143, .12);
            border: 1px solid rgba(32, 214, 143, .35);
            color: #20d68f;
            align-items: center;
            font-size: 12px;
            font-weight: 800;
        }

        .selected-table-chip.show {
            display: flex;
        }

        .empty-table-state {
            height: 100%;
            min-height: 420px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: #7b8498;
            padding: 30px;
        }

        .empty-table-state strong {
            color: #071143;
            font-size: 17px;
            margin-top: 12px;
        }

        .empty-table-state span {
            margin-top: 5px;
            font-size: 13px;
        }

        ::-webkit-scrollbar {
            width: 7px;
            height: 7px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(15, 23, 42, .28);
            border-radius: 999px;
        }




        /* ================= PREMIUM TABLE TOP NAV ================= */

        .premium-tables-topbar {
            flex-shrink: 0;
            height: 64px;
            display: grid;
            grid-template-columns: auto minmax(0, 1fr);
            align-items: stretch;
            border-bottom: 1px solid rgba(255, 255, 255, .08);
            background: linear-gradient(90deg, #251d55, #171545);
            border-top-left-radius: 18px;
            border-top-right-radius: 18px;
            overflow: hidden;
        }

        .premium-area-navbar {
            height: 64px;
            display: flex;
            align-items: stretch;
            gap: 0;
            overflow: hidden;
            background: transparent;
            border-top-left-radius: 18px;
            box-shadow: inset 0 -1px 0 rgba(255, 255, 255, .06);
            flex-shrink: 0;
        }

        .premium-area-tab {
            position: relative;
            width: 126px;
            height: 64px;
            padding: 0 8px;
            border: none;
            border-radius: 0;
            background: transparent;
            color: rgba(255, 255, 255, .92);
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: -.15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            cursor: pointer;
            white-space: nowrap;
            transition: background .18s ease, color .18s ease;
            border-right: 1px solid rgba(255, 255, 255, .06);
            flex-shrink: 0;
        }

        .premium-area-tab:first-child {
            border-top-left-radius: 18px;
        }

        .premium-area-tab:hover {
            background: rgba(255, 255, 255, .055);
            color: #ffffff;
        }

        .premium-area-tab.active {
            background: rgba(255, 255, 255, .075);
            color: #ffffff;
        }

        .premium-area-tab.active::after {
            content: '';
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 3px;
            background: #20d68f;
            box-shadow: 0 -7px 18px rgba(32, 214, 143, .36);
        }

        .premium-area-icon {
            width: 13px;
            height: 13px;
            color: currentColor;
            opacity: .96;
            flex-shrink: 0;
        }

        .premium-status-legend {
            height: 64px;
            padding: 0 8px;
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 7px;
            overflow: hidden;
            background: linear-gradient(90deg, #251d55, #171545);
            border-left: 1px solid rgba(255, 255, 255, .06);
            min-width: 0;
        }

        .premium-status-card {
            width: 88px;
            height: 50px;
            border: 1px solid rgba(255, 255, 255, .13);
            border-radius: 12px;
            background: rgba(255, 255, 255, .052);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .06);
            display: grid;
            grid-template-columns: 9px minmax(0, 1fr);
            grid-template-rows: 19px 19px;
            column-gap: 6px;
            align-items: center;
            padding: 6px 9px;
            color: #ffffff;
            backdrop-filter: blur(8px);
            flex: 0 0 88px;
        }

        .premium-status-card .status-dot {
            grid-column: 1;
            grid-row: 1;
            width: 8px;
            height: 8px;
            border-radius: 999px;
            box-shadow: 0 0 0 2px rgba(255, 255, 255, .05);
        }

        .premium-status-card span:last-child {
            grid-column: 2;
            grid-row: 1;
            font-size: 10.7px;
            font-weight: 800;
            color: #ffffff;
            white-space: nowrap;
            line-height: 1;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .premium-status-card strong {
            grid-column: 2;
            grid-row: 2;
            font-size: 17px;
            line-height: 1;
            color: #ffffff;
            font-weight: 900;
            letter-spacing: -.2px;
        }

        @media(max-width: 1100px) {
            .tables-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .tables-header-right {
                width: 100%;
                justify-content: flex-start;
                flex-wrap: wrap;
            }

            .tables-area-tabs {
                max-width: 100%;
            }
        }

        @media(max-width: 1300px) {
            .pos-content {
                grid-template-columns: 195px minmax(430px, 1fr) 340px;
            }

            .products-grid {
                grid-template-columns: repeat(4, minmax(110px, 1fr));
            }

            .product-link {
                height: 145px;
                min-height: 145px;
            }

            .product-img {
                height: 82px;
            }
        }


        .pos-toast-container {
            position: fixed;
            top: 76px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 99999;
            display: grid;
            gap: 9px;
            pointer-events: none;
            width: min(520px, calc(100vw - 32px));
        }

        .pos-toast {
            min-height: 46px;
            padding: 12px 16px;
            border-radius: 14px;
            background: #ffffff;
            color: #071143;
            box-shadow: 0 18px 45px rgba(15, 23, 42, .18);
            border: 1px solid #e6edf7;
            border-left: 4px solid #64748b;
            font-size: 13px;
            font-weight: 800;
            line-height: 1.35;
            display: flex;
            align-items: center;
            gap: 9px;
            opacity: 0;
            transform: translateY(-8px);
            animation: posToastIn .18s ease forwards;
        }

        .pos-toast.success {
            border-left-color: #10b981;
        }

        .pos-toast.error {
            border-left-color: #ef4444;
        }

        .pos-toast.warning {
            border-left-color: #f59e0b;
        }

        .pos-toast.info {
            border-left-color: #171545;
        }

        @keyframes posToastIn {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media(max-width: 1100px) {
            .premium-tables-topbar {
                height: auto;
                grid-template-columns: 1fr;
            }

            .premium-area-navbar {
                height: 58px;
            }

            .premium-area-tab {
                width: 150px;
                height: 58px;
                font-size: 12.5px;
            }

            .premium-status-legend {
                height: 68px;
                padding: 8px 12px;
            }
        }

        @media(max-width: 700px) {
            .premium-area-tab {
                width: 132px;
                font-size: 12px;
            }

            .premium-status-card {
                width: 96px;
                min-width: 96px;
            }
        }


        /* ================= OPEN CHECKS PANEL ================= */

        .checks-overlay {
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .16);
            z-index: 8000;
            display: none;
        }

        .checks-overlay.show {
            display: block;
        }

        .checks-panel {
            position: fixed;
            top: 72px;
            left: 14px;
            width: min(520px, calc(100vw - 28px));
            max-height: calc(100vh - 92px);
            z-index: 8100;
            background: #ffffff;
            border: 1px solid #e5ebf5;
            border-radius: 18px;
            box-shadow: 0 24px 70px rgba(15, 23, 42, .24);
            padding: 14px;
            display: none;
            overflow: hidden;
        }

        .checks-panel.show {
            display: flex;
            flex-direction: column;
        }

        .checks-panel-head {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 12px;
            border-bottom: 1px solid #eef2f7;
        }

        .checks-panel-title {
            color: #071143;
            font-size: 18px;
            font-weight: 900;
            line-height: 1;
        }

        .checks-panel-subtitle {
            margin-top: 6px;
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
        }

        .checks-panel-close {
            width: 34px;
            height: 34px;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
            background: #fff;
            color: #071143;
            font-size: 22px;
            font-weight: 900;
            line-height: 1;
            cursor: pointer;
        }

        .checks-panel-summary {
            margin-top: 12px;
            display: grid;
            grid-template-columns: 1fr 1.4fr;
            gap: 10px;
        }

        .checks-summary-card {
            min-height: 66px;
            border-radius: 14px;
            border: 1px solid #e6edf7;
            background: linear-gradient(180deg, #ffffff, #f8fafc);
            padding: 12px;
        }

        .checks-summary-card span {
            display: block;
            color: #64748b;
            font-size: 11px;
            font-weight: 800;
        }

        .checks-summary-card strong {
            display: block;
            margin-top: 6px;
            color: #071143;
            font-size: 22px;
            font-weight: 900;
        }

        .checks-summary-card.total {
            background: linear-gradient(135deg, rgba(32, 201, 133, .12), rgba(255, 255, 255, 1));
            border-color: rgba(32, 201, 133, .25);
        }

        .checks-summary-card.total strong {
            color: #059669;
        }


        .checks-filter-row {
            margin-top: 12px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
        }

        .checks-filter-btn {
            height: 38px;
            border-radius: 12px;
            border: 1px solid #dfe7f2;
            background: #ffffff;
            color: #334155;
            font-size: 12px;
            font-weight: 900;
            cursor: pointer;
        }

        .checks-filter-btn.active {
            background: #171545;
            border-color: #171545;
            color: #ffffff;
            box-shadow: 0 10px 22px rgba(23, 21, 69, .13);
        }

        .check-status-badge {
            height: 24px;
            padding: 0 8px;
            border-radius: 999px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 10.5px;
            font-weight: 900;
            white-space: nowrap;
            margin-top: 6px;
        }

        .check-status-badge.open {
            background: rgba(16, 185, 129, .10);
            color: #059669;
            border: 1px solid rgba(16, 185, 129, .22);
        }

        .check-status-badge.paid {
            background: rgba(100, 116, 139, .10);
            color: #475569;
            border: 1px solid rgba(100, 116, 139, .20);
        }


        .checks-list {
            margin-top: 12px;
            overflow-y: auto;
            display: grid;
            gap: 9px;
            padding-right: 4px;
        }

        .check-row-card {
            border: 1px solid #e6edf7;
            border-radius: 15px;
            background: #fff;
            padding: 12px;
            cursor: pointer;
            transition: .16s ease;
        }

        .check-row-card:hover {
            border-color: rgba(32, 201, 133, .45);
            box-shadow: 0 14px 30px rgba(15, 23, 42, .09);
            transform: translateY(-1px);
        }

        .check-row-top {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 10px;
        }

        .check-row-title {
            color: #071143;
            font-size: 14px;
            font-weight: 900;
        }

        .check-row-sub {
            margin-top: 4px;
            color: #64748b;
            font-size: 11.5px;
            font-weight: 700;
        }

        .check-row-amount {
            color: #059669;
            font-size: 16px;
            font-weight: 900;
            white-space: nowrap;
        }

        .check-row-meta {
            margin-top: 10px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 7px;
        }

        .check-row-meta span {
            min-height: 30px;
            border-radius: 10px;
            background: #f8fafc;
            border: 1px solid #eef2f7;
            color: #475569;
            font-size: 10.5px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            padding: 0 6px;
        }

        .checks-empty {
            padding: 26px 12px;
            text-align: center;
            border: 1px dashed #dbe3ef;
            border-radius: 14px;
            color: #64748b;
            font-size: 13px;
            font-weight: 800;
            background: #fbfdff;
        }

        @media(max-width: 640px) {
            .checks-panel {
                left: 8px;
                right: 8px;
                width: auto;
            }

            .check-row-meta {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>

    <div id="posToastContainer" class="pos-toast-container"></div>

    <div id="openChecksOverlay" class="checks-overlay"></div>

    <section id="openChecksPanel" class="checks-panel" aria-hidden="true">
        <div class="checks-panel-head">
            <div>
                <div class="checks-panel-title" id="checksPanelTitle">Açıq çeklər</div>
                <div class="checks-panel-subtitle" id="checksPanelSubtitle">Yüklənir...</div>
            </div>

            <button type="button" id="closeChecksPanelBtn" class="checks-panel-close">×</button>
        </div>

        <div class="checks-panel-summary">
            <div class="checks-summary-card">
                <span>Çek sayı</span>
                <strong id="checksTotalCount">0</strong>
            </div>
            <div class="checks-summary-card total">
                <span>Ümumi məbləğ</span>
                <strong id="checksTotalAmount">0.00 ₼</strong>
            </div>
        </div>

        <div class="checks-filter-row">
            <button type="button" class="checks-filter-btn active" data-check-filter="open">Açıq</button>
            <button type="button" class="checks-filter-btn" data-check-filter="paid">Bağlı</button>
            <button type="button" class="checks-filter-btn" data-check-filter="all">Hamısı</button>
        </div>

        <div id="openChecksList" class="checks-list">
            <div class="checks-empty">Açıq çek yoxdur</div>
        </div>
    </section>

    @php
    $restaurantName = session('staff_restaurant_name') ?: 'Restoran';
    $branchName = session('staff_branch_name');

    $displayPlace = $branchName && $branchName !== 'Ümumi restoran'
    ? $branchName
    : $restaurantName;

    $staffName = session('staff_user_name') ?: 'Əməkdaş';
    $staffRole = session('staff_user_role') ?: 'cashier';
    $canUnlockPaymentLock = in_array($staffRole, ['cashier', 'waiter', 'branch_manager']);
    $canTakePayment = in_array($staffRole, ['cashier']);
    @endphp

    <div class="pos-wrapper">

        <header class="pos-navbar">

            <a href="#" id="newOrderBtn" class="nav-btn green">
                <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Yeni sifariş
            </a>

            <a href="#" id="openChecksBtn" class="nav-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                    <path d="M6 3h12v18l-3-2-3 2-3-2-3 2V3z" />
                    <path d="M9 8h6M9 12h6M9 16h3" />
                </svg>
                Çeklər
            </a>

            <a href="#" class="nav-btn nav-icon-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </a>

            <form method="POST" action="{{ route('staff.logout') }}">
                @csrf
                <button class="nav-btn" type="submit">
                    <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                        <path d="M10 17l5-5-5-5" />
                        <path d="M15 12H3" />
                        <path d="M21 4v16" />
                    </svg>
                    Çıxış
                </button>
            </form>

            <div class="nav-divider"></div>

            <div class="restaurant-box">
                <div class="restaurant-icon">
                    <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                        <path d="M4 10h16l-1-5H5l-1 5Z" />
                        <path d="M5 10v9h14v-9" />
                        <path d="M8 19v-5h4v5" />
                        <path d="M14 19v-5h2" />
                    </svg>
                </div>

                <div>
                    <div class="restaurant-name">{{ $displayPlace }}</div>
                    <div class="staff-line">
                        {{ $staffName }}
                        <span>{{ $staffRole }}</span>
                    </div>
                </div>
            </div>

            <div id="selectedTableChip" class="selected-table-chip">
                Masa seçilməyib
            </div>

            <div class="nav-spacer"></div>

            <div class="nav-status">
                <a href="#" class="nav-status-item">
                    <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 7h18s-3 0-3-7" />
                        <path d="M13.7 21a2 2 0 0 1-3.4 0" />
                    </svg>
                </a>

                <div class="nav-status-item">
                    <span id="bakuClock">--:--</span>
                </div>

                <a href="#" class="nav-status-item wifi">
                    <svg fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                        <path d="M2.5 8.5a15 15 0 0 1 19 0" />
                        <path d="M6.5 12.5a9 9 0 0 1 11 0" />
                        <path d="M10 16.5a4 4 0 0 1 4 0" />
                        <path d="M12 20h.01" />
                    </svg>
                </a>
            </div>

        </header>


        @php
        $tableAreas = $areas ?? collect();

        $allTables = $tableAreas->flatMap(function ($area) {
        return $area->tables ?? collect();
        });

        $tableStatusCounts = [
        'empty' => 0,
        'busy' => 0,
        'waiting' => 0,
        'reserved' => 0,
        'due_soon' => 0,
        'late' => 0,
        ];

        foreach ($allTables as $countTable) {
        $state = method_exists($countTable, 'reservationState')
        ? $countTable->reservationState()
        : ($countTable->status ?? 'empty');

        if ($state === 'empty') {
        $tableStatusCounts['empty']++;
        } elseif ($state === 'busy') {
        $tableStatusCounts['busy']++;
        } elseif ($state === 'waiting_payment') {
        $tableStatusCounts['waiting']++;
        } elseif ($state === 'reservation_due_soon') {
        $tableStatusCounts['due_soon']++;
        } elseif ($state === 'reservation_late') {
        $tableStatusCounts['late']++;
        } elseif (in_array($state, ['reserved', 'reservation_upcoming', 'reservation_arrived'], true)) {
        $tableStatusCounts['reserved']++;
        }
        }
        @endphp

        <section id="tablesScreen" class="tables-screen">

            <div class="tables-shell">

                <div class="premium-tables-topbar">

                    @if($tableAreas->count())
                    <div class="premium-area-navbar">
                        @foreach($tableAreas as $area)
                        <button type="button"
                            class="premium-area-tab table-area-tab {{ $loop->first ? 'active' : '' }}"
                            data-area-tab="staff-area-{{ $area->id }}">
                            <svg class="premium-area-icon" fill="none" stroke="currentColor" stroke-width="2.15" viewBox="0 0 24 24">
                                <path d="M4 10h16M6 10v9M18 10v9M8 6h8" />
                            </svg>
                            <span>{{ $area->name }}</span>
                        </button>
                        @endforeach
                    </div>
                    @endif

                    <div class="premium-status-legend">
                        <div class="premium-status-card">
                            <span class="status-dot status-empty"></span>
                            <span>Boş</span>
                            <strong>{{ $tableStatusCounts['empty'] }}</strong>
                        </div>

                        <div class="premium-status-card">
                            <span class="status-dot status-busy"></span>
                            <span>Dolu</span>
                            <strong>{{ $tableStatusCounts['busy'] }}</strong>
                        </div>

                        <div class="premium-status-card">
                            <span class="status-dot status-waiting"></span>
                            <span>Hesab</span>
                            <strong>{{ $tableStatusCounts['waiting'] }}</strong>
                        </div>

                        <div class="premium-status-card">
                            <span class="status-dot status-reserved"></span>
                            <span>Rezerv</span>
                            <strong>{{ $tableStatusCounts['reserved'] }}</strong>
                        </div>

                        <div class="premium-status-card">
                            <span class="status-dot status-waiting"></span>
                            <span>Vaxt</span>
                            <strong>{{ $tableStatusCounts['due_soon'] }}</strong>
                        </div>

                        <div class="premium-status-card">
                            <span class="status-dot status-late"></span>
                            <span>Gecikir</span>
                            <strong>{{ $tableStatusCounts['late'] }}</strong>
                        </div>
                    </div>

                </div>

                @if($tableAreas->count())

                <div class="tables-layout-wrap">

                    @foreach($tableAreas as $area)

                    <div class="staff-table-area {{ $loop->first ? 'active' : '' }}"
                        id="staff-area-{{ $area->id }}">

                        <div class="staff-area-title">
                            <h3>{{ $area->name }}</h3>
                            <span>{{ $area->tables->count() }} masa</span>
                        </div>

                        <div class="staff-table-canvas">

                            @forelse($area->tables as $table)

                            @php
                            $openOrder = $table->openOrder()->with('staff')->first();
                            $openOrdersCount = $table->openOrders()->count();
                            $tableState = $table->reservationState();
                            $tableStateLabel = $table->reservationStateLabel();
                            $visibleReservation = method_exists($table, 'visibleReservation')
                            ? $table->visibleReservation()
                            : ($table->activeReservation()->first() ?: $table->nextReservation()->first());

                            $tableStatus = $openOrdersCount > 0
                            ? (($table->status ?? '') === 'waiting_payment' ? 'waiting_payment' : 'busy')
                            : (in_array($tableState, ['reserved', 'reservation_upcoming', 'reservation_due_soon', 'reservation_late', 'reservation_arrived'], true) ? 'reserved' : 'empty');

                            $statusClass = $table->reservationBadgeClass();
                            @endphp

                            <button type="button"
                                class="staff-table-item staff-table-{{ $table->shape }}"
                                data-id="{{ $table->id }}"
                                data-name="{{ $table->name }}"
                                data-seats="{{ (int) $table->seats }}"
                                data-status="{{ $tableStatus }}"
                                data-payment-locked="{{ $tableStatus === 'waiting_payment' ? '1' : '0' }}"
                                data-state="{{ $tableState }}"
                                data-state-label="{{ $tableStateLabel }}"
                                data-area="{{ $area->name }}"
                                data-staff="{{ $openOrder?->staff?->name ?? '' }}"
                                data-opened-at="{{ optional($openOrder?->opened_at)->toIso8601String() }}"
                                data-opened-at-ms="{{ $openOrder?->opened_at ? $openOrder->opened_at->getTimestampMs() : '' }}"
                                data-check-count="{{ $openOrdersCount }}"
                                data-reservation-id="{{ $visibleReservation?->id ?? '' }}"
                                data-reservation-time="{{ $visibleReservation ? $visibleReservation->formattedStartTime() : '' }}"
                                data-reservation-date="{{ $visibleReservation ? $visibleReservation->formattedDate() : '' }}"
                                data-reservation-customer="{{ $visibleReservation?->customer_name ?? '' }}"
                                data-reservation-phone="{{ $visibleReservation?->customer_phone ?? '' }}"
                                data-reservation-guests="{{ $visibleReservation?->guest_count ?? '' }}"
                                data-reservation-note="{{ $visibleReservation?->note ?? '' }}"
                                onclick="openPosForTable(this)"
                                style="
                                                left: {{ $table->position_x }}px;
                                                top: {{ $table->position_y }}px;
                                                width: {{ $table->width }}px;
                                                height: {{ $table->height }}px;
                                            ">

                                <span class="staff-table-badge {{ $statusClass }}"></span>

                                @if($visibleReservation)
                                <span class="staff-reservation-badge">
                                    {{ $tableStateLabel }} {{ $visibleReservation->formattedStartTime() }}
                                </span>
                                @endif

                                <span class="staff-table-seats"
                                    data-seats="{{ (int) $table->seats }}"
                                    data-show-seats="{{ (bool) ($table->show_seats ?? true) ? '1' : '0' }}">
                                </span>

                                <span class="staff-table-name">{{ $table->name }}</span>

                                <span class="staff-table-meta">
                                    @if($tableStatus === 'empty')
                                    {{ $table->seats }} nəfər
                                    @else
                                    <span class="staff-table-waiter">
                                        {{ $openOrder?->staff?->name ?? 'Əməkdaş' }}
                                    </span>

                                    <span class="staff-table-time"
                                        data-opened-at="{{ optional($openOrder?->opened_at)->toIso8601String() }}"
                                        data-opened-at-ms="{{ $openOrder?->opened_at ? $openOrder->opened_at->getTimestampMs() : '' }}">
                                        00:00
                                    </span>
                                    @endif
                                </span>

                            </button>

                            @empty

                            <div class="empty-table-state">
                                <div style="font-size: 42px;">🍽️</div>
                                <strong>Bu zalda masa yoxdur</strong>
                                <span>Tənzimləmələr → Masa idarəetməsi bölməsindən masa əlavə edin.</span>
                            </div>

                            @endforelse

                        </div>

                    </div>

                    @endforeach

                </div>

                @else

                <div class="empty-table-state">
                    <div style="font-size: 46px;">🍽️</div>
                    <strong>Heç bir masa əlavə edilməyib</strong>
                    <span>Tənzimləmələr → Masa idarəetməsi bölməsindən masa yaradın.</span>
                </div>

                @endif

            </div>

        </section>


        <main id="posScreen" class="pos-content hidden-pos">

            <aside class="panel categories">

                <a href="{{ route('staff.dashboard') }}"
                    class="category-link {{ request('category_id') ? '' : 'active' }}">
                    <span class="category-icon">▦</span>
                    <span>Hamısı</span>
                </a>

                @foreach($categories as $category)
                <a href="{{ route('staff.dashboard', ['category_id' => $category->id]) }}"
                    class="category-link {{ request('category_id') == $category->id ? 'active' : '' }}">
                    <span class="category-icon">{{ $category->icon ?: '•' }}</span>
                    <span>{{ $category->name }}</span>
                </a>
                @endforeach

            </aside>

            <section class="panel products-panel">

                <div class="product-tools">
                    <div class="search-box">
                        <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                            <circle cx="11" cy="11" r="7" />
                            <path d="M20 20l-3-3" />
                        </svg>

                        <input type="text"
                            id="liveProductSearch"
                            placeholder="Məhsul axtar...">
                    </div>

                    <a href="{{ route('staff.dashboard') }}" class="filter-link">
                        <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                            <path d="M4 5h16l-6 7v5l-4 2v-7L4 5z" />
                        </svg>
                        Filtr
                    </a>
                </div>

                <div class="products-grid" id="productsGrid">

                    @forelse($products as $product)
                    <a href="#"
                        class="product-link js-product-card"
                        data-id="{{ $product->id }}"
                        data-name="{{ $product->name }}"
                        data-price="{{ $product->sale_price }}">
                        <div class="product-img">
                            @if($product->image)
                            <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                            @else
                            🍽️
                            @endif
                        </div>

                        <div class="product-body">
                            <div class="product-name">{{ $product->name }}</div>
                            <div class="product-price">{{ number_format($product->sale_price, 2) }} ₼</div>
                        </div>
                    </a>
                    @empty
                    <div class="empty-products">
                        Məhsul tapılmadı
                    </div>
                    @endforelse

                </div>

            </section>

            <aside class="panel order-panel">

                <div class="order-tabs">
                    <a href="#" class="order-tab-link active" data-order-tab="order">
                        <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                            <path d="M6 7h12l-1 13H7L6 7z" />
                            <path d="M9 7a3 3 0 0 1 6 0" />
                        </svg>
                        Sifariş
                    </a>

                    <a href="#" class="order-tab-link" data-order-tab="table">
                        <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                            <path d="M4 10h16M6 10v9M18 10v9M8 6h8" />
                        </svg>
                        Masa
                    </a>

                    <a href="#" class="order-tab-link" data-order-tab="customer">
                        <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                            <circle cx="12" cy="7" r="4" />
                            <path d="M20 21a8 8 0 0 0-16 0" />
                        </svg>
                        Müştəri
                    </a>
                </div>


                <div id="orderTabContent" class="order-tab-content active">

                    <div class="order-header">
                        <h3 class="order-title">Sifariş siyahısı</h3>

                    </div>

                    <div id="checkSwitcher" class="check-switcher"></div>

                    <div class="order-list" id="cartItems">
                        <div style="padding:30px 10px; text-align:center; color:#7b8498; font-weight:800;">
                            Səbət boşdur
                        </div>
                    </div>

                    <div class="summary">
                        <div class="summary-line">
                            <span>Ara məbləğ</span>
                            <strong id="subtotalAmount">0.00 ₼</strong>
                        </div>

                        <div class="summary-line">
                            <span>Endirim</span>
                            <strong id="discountAmount">0.00 ₼</strong>
                        </div>

                        <div class="summary-total">
                            <span>Ümumi</span>
                            <strong id="totalAmount">0.00 ₼</strong>
                        </div>

                        <div class="action-row">
                            <a href="#" id="closeOrderBtn" class="close-order-link">
                                Bağla
                                <small>Masa üzərinə vur</small>
                            </a>

                            <a href="#" id="mainPaymentActionBtn" class="pay-link">
                                Hesab yaz
                                <small>Hesabı çıxar</small>
                            </a>
                        </div>
                    </div>

                </div>



                <div id="paymentTabContent" class="payment-screen">
                    <div class="payment-card">
                        <div class="payment-head">
                            <div>
                                <div class="payment-title">Ödəniş ekranı</div>
                                <div class="payment-subtitle" id="paymentCheckLabel">Çek seçilməyib</div>
                            </div>
                            <div class="payment-total-badge" id="paymentPayableBadge">0.00 ₼</div>
                        </div>

                        <div class="payment-section-title">Endirim</div>
                        <div class="discount-type-grid">
                            <button type="button" class="payment-choice-btn active" data-discount-type="none">Yoxdur</button>
                            <button type="button" class="payment-choice-btn" data-discount-type="percent">%</button>
                            <button type="button" class="payment-choice-btn" data-discount-type="amount">₼</button>
                        </div>

                        <div class="payment-input-box" id="discountInputBox" data-payment-target="discount" style="margin-top:8px;">
                            <span>Endirim dəyəri</span>
                            <input type="text" id="paymentDiscountValue" class="payment-input-field" value="0" autocomplete="off" inputmode="decimal">
                        </div>

                        <div class="payment-section-title">Ödəniş tipi</div>
                        <div class="payment-method-grid">
                            <button type="button" class="payment-choice-btn active" data-payment-method="cash">Nağd</button>
                            <button type="button" class="payment-choice-btn" data-payment-method="card">Kart</button>
                            <button type="button" class="payment-choice-btn" data-payment-method="mixed">Qarışıq</button>
                            <button type="button" class="payment-choice-btn" data-payment-method="debt">Borc</button>
                        </div>

                        <div class="payment-section-title">Məbləğ bölgüsü</div>
                        <div class="payment-amount-grid">
                            <div class="payment-input-box active" data-payment-target="cash">
                                <span>Nağd</span>
                                <input type="text" id="paymentCashAmount" class="payment-input-field" value="0.00" autocomplete="off" inputmode="decimal">
                            </div>
                            <div class="payment-input-box" data-payment-target="card">
                                <span>Kart</span>
                                <input type="text" id="paymentCardAmount" class="payment-input-field" value="0.00" autocomplete="off" inputmode="decimal">
                            </div>
                        </div>

                        <div class="payment-summary-box">
                            <div class="payment-summary-line">
                                <span>Ara məbləğ</span>
                                <strong id="paymentSubtotalText">0.00 ₼</strong>
                            </div>
                            <div class="payment-summary-line">
                                <span>Endirim</span>
                                <strong id="paymentDiscountText">0.00 ₼</strong>
                            </div>
                            <div class="payment-summary-line">
                                <span>Ödəniləcək</span>
                                <strong id="paymentPayableText">0.00 ₼</strong>
                            </div>
                            <div class="payment-summary-line">
                                <span>Qalıq</span>
                                <strong id="paymentRemainingText">0.00 ₼</strong>
                            </div>
                        </div>

                        <div class="payment-keypad">
                            <button type="button" class="payment-key" data-key="1">1</button>
                            <button type="button" class="payment-key" data-key="2">2</button>
                            <button type="button" class="payment-key" data-key="3">3</button>
                            <button type="button" class="payment-key" data-key="4">4</button>
                            <button type="button" class="payment-key" data-key="5">5</button>
                            <button type="button" class="payment-key" data-key="6">6</button>
                            <button type="button" class="payment-key" data-key="7">7</button>
                            <button type="button" class="payment-key" data-key="8">8</button>
                            <button type="button" class="payment-key" data-key="9">9</button>
                            <button type="button" class="payment-key" data-key="0">0</button>
                            <button type="button" class="payment-key" data-key=".">.</button>
                            <button type="button" class="payment-key danger" data-key="back">Sil</button>
                        </div>

                        <div class="payment-footer-actions">
                            <button type="button" id="paymentBackBtn" class="payment-back-btn">Geri</button>
                            <button type="button" id="paymentCompleteBtn" class="payment-complete-btn">Ödənişi tamamla</button>
                        </div>
                    </div>
                </div>

                <div id="tableTabContent" class="order-tab-content">

                    <div class="table-info-card">
                        <div class="table-info-head">
                            <div>
                                <div id="tableInfoName" class="table-info-title">Masa seçilməyib</div>
                                <div id="tableInfoArea" class="table-info-subtitle">Əvvəl masa seçin</div>
                            </div>

                            <div id="tableInfoStatus" class="table-info-status">Boş</div>
                        </div>

                        <div class="table-info-grid">
                            <div class="table-info-box">
                                <span>Oturacaq</span>
                                <strong id="tableInfoSeats">-</strong>
                            </div>

                            <div class="table-info-box">
                                <span>Açan əməkdaş</span>
                                <strong id="tableInfoStaff">-</strong>
                            </div>

                            <div class="table-info-box">
                                <span>Açılış vaxtı</span>
                                <strong id="tableInfoOpenedAt">-</strong>
                            </div>

                            <div class="table-info-box">
                                <span>Açıq müddət</span>
                                <strong id="tableInfoDuration">00:00</strong>
                            </div>
                        </div>

                        <div class="table-actions-stack">
                            <button type="button" id="moveTableBtn" class="table-action-btn">Masanı dəyiş</button>
                            <button type="button" id="mergeTablesBtn" class="table-action-btn warning">Masanı birləşdir</button>
                            <button type="button" id="mergeChecksBtn" class="table-action-btn success">Çekləri birləşdir</button>
                            <button type="button" id="shareTableBtn" class="table-action-btn share">Masanı paylaş</button>
                        </div>
                    </div>

                    <div id="currentReservationCard" class="current-reservation-card">
                        <div class="current-reservation-head">
                            <div>
                                <div class="current-reservation-title">Aktiv rezerv</div>
                                <div class="reservation-note">Bu masaya aid aktiv rezerv məlumatı.</div>
                            </div>

                            <div id="currentReservationTime" class="current-reservation-time">--:--</div>
                        </div>

                        <div class="current-reservation-info">
                            <div class="current-reservation-line">
                                <span>Müştəri</span>
                                <strong id="currentReservationCustomer">-</strong>
                            </div>

                            <div class="current-reservation-line">
                                <span>Telefon</span>
                                <strong id="currentReservationPhone">-</strong>
                            </div>

                            <div class="current-reservation-line">
                                <span>Tarix</span>
                                <strong id="currentReservationDate">-</strong>
                            </div>

                            <div class="current-reservation-line">
                                <span>Qonaq</span>
                                <strong id="currentReservationGuests">-</strong>
                            </div>
                        </div>

                        @if(in_array($staffRole, ['cashier']))
                        <div class="reservation-action-row">
                            <button type="button" id="completeReservationBtn" class="reservation-action-btn complete">
                                Tamamla
                            </button>

                            <button type="button" id="cancelReservationBtn" class="reservation-action-btn cancel">
                                Ləğv et
                            </button>
                        </div>
                        @endif
                    </div>

                    <div class="reservation-card">
                        <div class="reservation-title">Rezervasiya yarat</div>
                        <div class="reservation-note">
                            Aktiv istifadə olunan masalar üçün də gələcək tarix və saat üzrə rezervasiya qəbul edilə bilər.
                        </div>

                        @if(in_array($staffRole, ['cashier']))
                        <form id="reservationForm" class="reservation-form">
                            <input type="hidden" id="reservationTableId" name="table_id">

                            <input type="text" id="reservationCustomerName" placeholder="Müştəri adı">

                            <input type="text" id="reservationCustomerPhone" placeholder="Telefon">

                            <div class="reservation-form-row">
                                <input type="date" id="reservationDate">
                                <input type="time" id="reservationStartTime">
                            </div>

                            <input type="number" id="reservationGuestCount" min="1" placeholder="Qonaq sayı">

                            <textarea id="reservationNote" placeholder="Qeyd"></textarea>

                            <button type="submit" class="reservation-submit">
                                Rezerv et
                            </button>
                        </form>
                        @else
                        <div class="reservation-disabled">
                            Rezerv yaratmaq yalnız kassir və owner panel icazəsi olan istifadəçilər üçündür.
                        </div>
                        @endif
                    </div>

                </div>

                <div id="customerTabContent" class="order-tab-content">
                    <div class="customer-panel-card">
                        <div class="customer-panel-head">
                            <div>
                                <div class="customer-panel-title">Müştəri məlumatları</div>
                                <div class="customer-panel-subtitle">Kassir müştərini seçə, yeni müştəri yarada və borc ödənişində həmin müştərini çeka bağlaya bilər.</div>
                            </div>
                        </div>

                        <div class="customer-search-box">
                            <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                                <path d="M21 21l-4.3-4.3" />
                                <circle cx="11" cy="11" r="7" />
                            </svg>
                            <input type="text" id="customerSearchInput" placeholder="Ad və ya telefon ilə axtar..." autocomplete="off">
                        </div>

                        <div id="customerSearchResults" class="customer-search-results"></div>

                        <div id="selectedCustomerCard" class="customer-selected-card">
                            <div class="customer-selected-top">
                                <div>
                                    <div id="selectedCustomerName" class="customer-selected-name">Müştəri seçilməyib</div>
                                    <div id="selectedCustomerPhone" class="customer-selected-phone">Telefon yoxdur</div>
                                </div>
                                <button type="button" id="clearSelectedCustomerBtn" class="customer-clear-btn">×</button>
                            </div>

                            <div class="customer-info-grid">
                                <div class="customer-info-box">
                                    <span>Bonus</span>
                                    <strong id="selectedCustomerBonus">0.00</strong>
                                </div>
                                <div class="customer-info-box">
                                    <span>Borc</span>
                                    <strong id="selectedCustomerDebt">0.00 ₼</strong>
                                </div>
                            </div>
                        </div>

                        <form id="customerCreateForm" class="customer-create-form">
                            <div class="customer-create-row">
                                <input type="text" id="customerFullNameInput" placeholder="Müştəri adı" autocomplete="off">
                                <input type="text" id="customerPhoneInput" placeholder="Telefon" autocomplete="off">
                            </div>
                            <textarea id="customerNoteInput" placeholder="Qeyd"></textarea>
                            <button type="submit" class="customer-save-btn">Müştərini yadda saxla</button>
                        </form>

                        <div class="customer-help-card">
                            Borc kimi bağlamaq üçün əvvəl buradan müştəri seç və sonra ödəniş ekranında “Borc” seçimini istifadə et.
                        </div>
                    </div>
                </div>

            </aside>

        </main>

    </div>

    <script>
        function showPosToast(message, type = 'info') {
            const container = document.getElementById('posToastContainer');

            if (!container) {
                return;
            }

            const toast = document.createElement('div');
            toast.className = 'pos-toast ' + type;
            toast.textContent = message || 'Əməliyyat icra olundu.';
            container.appendChild(toast);

            setTimeout(function() {
                toast.style.opacity = '0';
                toast.style.transform = 'translateY(-8px)';
                toast.style.transition = '.18s ease';
            }, 2800);

            setTimeout(function() {
                toast.remove();
            }, 3200);
        }

        window.alert = function(message) {
            showPosToast(message, 'info');
        };

        function updateBakuClock() {
            const clockElement = document.getElementById('bakuClock');

            if (!clockElement) {
                return;
            }

            const time = new Intl.DateTimeFormat('az-AZ', {
                timeZone: 'Asia/Baku',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            }).format(new Date());

            clockElement.textContent = time;
        }

        updateBakuClock();
        setInterval(updateBakuClock, 1000);

        const cart = {};
        let selectedOrderId = null;
        let currentChecks = [];
        const staffCanUnlockPaymentLock = @json($canUnlockPaymentLock);
        const staffCanTakePayment = @json($canTakePayment);

        function formatMoney(amount) {
            return Number(amount).toFixed(2) + ' ₼';
        }


        let selectedTable = null;

        let selectedCustomer = null;
        let customerSearchTimer = null;

        function escapeHtml(value) {
            return String(value ?? '')
                .replace(/&/g, '&amp;')
                .replace(/</g, '&lt;')
                .replace(/>/g, '&gt;')
                .replace(/"/g, '&quot;')
                .replace(/'/g, '&#039;');
        }

        function customerDebtValue(customer) {
            return parseFloat(
                customer?.debt_amount ??
                customer?.total_debt ??
                customer?.remaining_debt ??
                customer?.debt ??
                0
            ) || 0;
        }

        function normalizeCustomerPayload(customer) {
            if (!customer) return null;

            return {
                id: customer.id,
                full_name: customer.full_name || customer.name || 'Müştəri',
                phone: customer.phone || customer.customer_phone || '',
                note: customer.note || '',
                bonus_balance: parseFloat(customer.bonus_balance ?? customer.bonus ?? 0) || 0,
                debt_amount: customerDebtValue(customer),
                total_debt: customerDebtValue(customer),
                status: customer.status || 'active',
            };
        }

        function setCustomerSearchText(value) {
            const input = document.getElementById('customerSearchInput');
            if (input) input.value = value || '';
        }

        function selectCustomer(customer) {
            const normalized = normalizeCustomerPayload(customer);

            if (!normalized || !normalized.id) {
                showPosToast('Müştəri seçilə bilmədi.', 'error');
                return;
            }

            selectedCustomer = normalized;
            renderCustomerPanel();
            setCustomerSearchText(normalized.full_name);

            const results = document.getElementById('customerSearchResults');
            if (results) results.innerHTML = '';

            showPosToast('Müştəri seçildi.', 'success');
        }

        function clearSelectedCustomer() {
            selectedCustomer = null;
            renderCustomerPanel();
            setCustomerSearchText('');

            const results = document.getElementById('customerSearchResults');
            if (results) results.innerHTML = '';
        }

        function renderCustomerPanel() {
            const card = document.getElementById('selectedCustomerCard');
            const name = document.getElementById('selectedCustomerName');
            const phone = document.getElementById('selectedCustomerPhone');
            const bonus = document.getElementById('selectedCustomerBonus');
            const debt = document.getElementById('selectedCustomerDebt');

            if (!card) return;

            if (!selectedCustomer) {
                card.classList.remove('show');
                if (name) name.textContent = 'Müştəri seçilməyib';
                if (phone) phone.textContent = 'Telefon yoxdur';
                if (bonus) bonus.textContent = '0.00 ₼';
                if (debt) debt.textContent = '0.00 ₼';
                return;
            }

            card.classList.add('show');
            if (name) name.textContent = selectedCustomer.full_name || 'Müştəri';
            if (phone) phone.textContent = selectedCustomer.phone || 'Telefon yoxdur';
            if (bonus) bonus.textContent = formatMoney(selectedCustomer.bonus_balance || 0);
            if (debt) debt.textContent = formatMoney(selectedCustomer.debt_amount || 0);
        }

        function renderCustomerSearchResults(customers) {
            const results = document.getElementById('customerSearchResults');
            if (!results) return;

            if (!Array.isArray(customers) || customers.length === 0) {
                results.innerHTML = '<div class="customer-help-card">Müştəri tapılmadı. Aşağıdan yeni müştəri yarada bilərsən.</div>';
                return;
            }

            results.innerHTML = customers.map(function(customer) {
                const normalized = normalizeCustomerPayload(customer);

                if (!normalized || !normalized.id) return '';

                return `
                    <button type="button" class="customer-result-btn" data-customer-id="${escapeHtml(normalized.id)}" data-customer-json='${escapeHtml(JSON.stringify(normalized))}'>
                        <span>
                            <strong>${escapeHtml(normalized.full_name)}</strong>
                            <span>${escapeHtml(normalized.phone || 'Telefon yoxdur')}</span>
                        </span>
                        <em>${formatMoney(normalized.debt_amount || 0)}</em>
                    </button>
                `;
            }).join('');
        }

        async function searchCustomers(query) {
            const results = document.getElementById('customerSearchResults');
            const cleanQuery = String(query || '').trim();

            if (!results) return;

            if (cleanQuery.length < 2) {
                results.innerHTML = '<div class="customer-help-card">Müştəri axtarmaq üçün ən azı 2 hərf yaz.</div>';
                return;
            }

            results.innerHTML = '<div class="customer-help-card">Axtarılır...</div>';

            try {
                const response = await fetch("{{ route('staff.customers.search') }}" + '?q=' + encodeURIComponent(cleanQuery), {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!response.ok || !data.success) {
                    results.innerHTML = '<div class="customer-help-card">Müştəri axtarışı zamanı xəta baş verdi.</div>';
                    return;
                }

                const customers = Array.isArray(data.customers) ? data.customers : (Array.isArray(data.data) ? data.data : []);
                renderCustomerSearchResults(customers);
            } catch (error) {
                console.error(error);
                results.innerHTML = '<div class="customer-help-card">Müştəri axtarışı zamanı xəta baş verdi.</div>';
            }
        }

        document.addEventListener('input', function(event) {
            if (event.target && event.target.id === 'customerSearchInput') {
                clearTimeout(customerSearchTimer);
                customerSearchTimer = setTimeout(function() {
                    searchCustomers(event.target.value);
                }, 300);
            }
        });

        document.addEventListener('click', function(event) {
            const customerBtn = event.target.closest('.customer-result-btn');
            const clearCustomerBtn = event.target.closest('#clearSelectedCustomerBtn');

            if (customerBtn) {
                event.preventDefault();

                try {
                    const customer = JSON.parse(customerBtn.dataset.customerJson || '{}');
                    selectCustomer(customer);
                } catch (error) {
                    console.error(error);
                    showPosToast('Müştəri seçilə bilmədi.', 'error');
                }

                return;
            }

            if (clearCustomerBtn) {
                event.preventDefault();
                clearSelectedCustomer();
            }
        });

        const customerCreateForm = document.getElementById('customerCreateForm');
        if (customerCreateForm) {
            customerCreateForm.addEventListener('submit', async function(event) {
                event.preventDefault();

                const fullNameInput = document.getElementById('customerFullNameInput');
                const phoneInput = document.getElementById('customerPhoneInput');
                const noteInput = document.getElementById('customerNoteInput');

                const payload = {
                    full_name: fullNameInput ? fullNameInput.value.trim() : '',
                    phone: phoneInput ? phoneInput.value.trim() : '',
                    note: noteInput ? noteInput.value.trim() : '',
                };

                if (!payload.full_name) {
                    showPosToast('Müştəri adını daxil edin.', 'error');
                    return;
                }

                try {
                    const data = await postJson("{{ route('staff.customers.store') }}", payload);

                    if (!data.success) {
                        showPosToast(data.message || 'Müştəri yaradılmadı.', 'error');
                        return;
                    }

                    const customer = data.customer || data.data || data;
                    selectCustomer(customer);
                    customerCreateForm.reset();

                    const results = document.getElementById('customerSearchResults');
                    if (results) results.innerHTML = '';
                } catch (error) {
                    console.error(error);
                    showPosToast('Müştəri yaradılmadı.', 'error');
                }
            });
        }

        function renderStaffSeats() {
            document.querySelectorAll('.staff-table-seats').forEach(function(container) {
                const table = container.closest('.staff-table-item');
                const totalSeats = parseInt(container.dataset.seats || 0);
                const showSeats = container.dataset.showSeats !== '0';

                container.innerHTML = '';

                if (!table || totalSeats <= 0 || !showSeats) {
                    return;
                }

                let top = 0;
                let right = 0;
                let bottom = 0;
                let left = 0;

                if (totalSeats <= 4) {
                    top = totalSeats >= 1 ? 1 : 0;
                    right = totalSeats >= 2 ? 1 : 0;
                    bottom = totalSeats >= 3 ? 1 : 0;
                    left = totalSeats >= 4 ? 1 : 0;
                } else {
                    const base = Math.floor(totalSeats / 4);
                    const remainder = totalSeats % 4;

                    top = base;
                    right = base;
                    bottom = base;
                    left = base;

                    if (remainder >= 1) top++;
                    if (remainder >= 2) bottom++;
                    if (remainder >= 3) right++;
                }

                function createSeat(side, index, count) {
                    const seat = document.createElement('span');
                    seat.className = 'staff-seat';

                    const back = document.createElement('span');
                    back.className = 'staff-seat-back';

                    seat.appendChild(back);

                    const gap = 100 / (count + 1);
                    const percent = gap * (index + 1);

                    if (side === 'top') {
                        seat.style.top = '-5px';
                        seat.style.left = percent + '%';
                        seat.style.transform = 'translateX(-50%)';
                    }

                    if (side === 'right') {
                        seat.style.right = '-5px';
                        seat.style.top = percent + '%';
                        seat.style.transform = 'translateY(-50%) rotate(90deg)';
                    }

                    if (side === 'bottom') {
                        seat.style.bottom = '-5px';
                        seat.style.left = percent + '%';
                        seat.style.transform = 'translateX(-50%) rotate(180deg)';
                    }

                    if (side === 'left') {
                        seat.style.left = '-5px';
                        seat.style.top = percent + '%';
                        seat.style.transform = 'translateY(-50%) rotate(-90deg)';
                    }

                    container.appendChild(seat);
                }

                for (let i = 0; i < top; i++) createSeat('top', i, top);
                for (let i = 0; i < right; i++) createSeat('right', i, right);
                for (let i = 0; i < bottom; i++) createSeat('bottom', i, bottom);
                for (let i = 0; i < left; i++) createSeat('left', i, left);
            });
        }

        async function openPosForTable(button) {
            const tableData = {
                id: button.dataset.id,
                name: button.dataset.name,
                seats: button.dataset.seats,
                status: button.dataset.status,
                paymentLocked: button.dataset.paymentLocked === '1' || button.dataset.status === 'waiting_payment',
                state: button.dataset.state || button.dataset.status || 'empty',
                stateLabel: button.dataset.stateLabel || '',
                area: button.dataset.area || '',
                staff: button.dataset.staff || '',
                openedAt: button.dataset.openedAt || '',
                openedAtMs: button.dataset.openedAtMs || '',
                checkCount: button.dataset.checkCount || '0',
                reservationId: button.dataset.reservationId || '',
                reservationTime: button.dataset.reservationTime || '',
                reservationDate: button.dataset.reservationDate || '',
                reservationCustomer: button.dataset.reservationCustomer || '',
                reservationPhone: button.dataset.reservationPhone || '',
                reservationGuests: button.dataset.reservationGuests || '',
                reservationNote: button.dataset.reservationNote || ''
            };

            try {
                const response = await fetch("{{ url('/staff/orders/table') }}/" + tableData.id, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!data.success) {
                    alert(data.message || 'Bu masaya daxil olmaq mümkün deyil.');
                    return;
                }

                selectedTable = tableData;
                selectedTable.status = data.table_status || selectedTable.status;
                selectedTable.staff = data.staff_name || selectedTable.staff || '';
                selectedTable.openedAt = data.opened_at || selectedTable.openedAt || '';
                selectedTable.openedAtMs = data.opened_at_ms || selectedTable.openedAtMs || '';
                syncTableButtonOrderInfo(selectedTable.id, selectedTable.staff, selectedTable.openedAt, selectedTable.openedAtMs, selectedTable.status);
                selectedTable.paymentLocked = !!data.payment_locked || selectedTable.status === 'waiting_payment';
                selectedTable.stateLabel = selectedTable.paymentLocked ? 'Hesab gözləyir' : selectedTable.stateLabel;
                selectedOrderId = data.order_id || null;
                currentChecks = Array.isArray(data.checks) ? data.checks : [];

                Object.keys(cart).forEach(id => delete cart[id]);

                if (data.has_order && Array.isArray(data.items)) {
                    data.items.forEach(function(item) {
                        if (!item.id) {
                            return;
                        }

                        cart[item.id] = {
                            id: item.id,
                            product_id: item.product_id || item.id,
                            name: item.name,
                            price: parseFloat(item.price || 0),
                            qty: parseFloat(item.qty || 1),
                            lockedQty: parseFloat(item.locked_qty ?? item.qty ?? 1)
                        };
                    });
                }

                selectedCustomer = null;
                renderCart();
                renderCheckTabs();
                renderTableInfo();
                renderCustomerPanel();

                const tablesScreen = document.getElementById('tablesScreen');
                const posScreen = document.getElementById('posScreen');
                const selectedTableChip = document.getElementById('selectedTableChip');

                if (tablesScreen) {
                    tablesScreen.classList.add('hidden-pos');
                }

                if (posScreen) {
                    posScreen.classList.remove('hidden-pos');
                }

                if (selectedTableChip) {
                    selectedTableChip.textContent = selectedTable.name + ' seçildi';
                    selectedTableChip.classList.add('show');
                }

            } catch (error) {
                console.error(error);
                alert('Masa məlumatı yüklənmədi.');
            }
        }

        function returnToTablesScreen() {
            const tablesScreen = document.getElementById('tablesScreen');
            const posScreen = document.getElementById('posScreen');
            const selectedTableChip = document.getElementById('selectedTableChip');

            if (posScreen) {
                posScreen.classList.add('hidden-pos');
            }

            if (tablesScreen) {
                tablesScreen.classList.remove('hidden-pos');
            }

            if (selectedTableChip) {
                selectedTableChip.textContent = 'Masa seçilməyib';
                selectedTableChip.classList.remove('show');
            }

            selectedTable = null;
            selectedOrderId = null;
            selectedCustomer = null;
            currentChecks = [];
            renderCheckTabs();
            renderCustomerPanel();
        }

        document.querySelectorAll('.table-area-tab').forEach(function(tab) {
            tab.addEventListener('click', function() {
                document.querySelectorAll('.table-area-tab').forEach(function(item) {
                    item.classList.remove('active');
                });

                document.querySelectorAll('.staff-table-area').forEach(function(area) {
                    area.classList.remove('active');
                });

                tab.classList.add('active');

                const target = document.getElementById(tab.dataset.areaTab);

                if (target) {
                    target.classList.add('active');
                }
            });
        });


        function renderCheckTabs() {
            const switcher = document.getElementById('checkSwitcher');

            if (!switcher) {
                return;
            }

            if (!selectedTable) {
                switcher.innerHTML = '';
                return;
            }

            const chips = currentChecks.map(function(check, index) {
                const active = String(check.id) === String(selectedOrderId) ? 'active' : '';
                const total = check.total_amount ? ' · ' + formatMoney(check.total_amount) : '';

                return `<button type="button" class="check-chip ${active}" data-order-id="${check.id}">${check.label || ('Çek #' + (index + 1))}${total}</button>`;
            });

            switcher.innerHTML = chips.join('');
        }

        async function loadOrderCheck(orderId, saveBeforeLoad = true) {
            if (!selectedTable || !orderId) {
                return;
            }

            if (saveBeforeLoad) {
                await saveCurrentOrder(false);
            }

            try {
                const response = await fetch("{{ url('/staff/orders/table') }}/" + selectedTable.id + '?order_id=' + orderId, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (!data.success) {
                    alert(data.message || 'Çek yüklənmədi.');
                    return;
                }

                selectedOrderId = data.order_id || orderId;
                currentChecks = Array.isArray(data.checks) ? data.checks : [];

                if (selectedTable) {
                    selectedTable.staff = data.staff_name || selectedTable.staff || 'Əməkdaş';
                    selectedTable.openedAt = data.opened_at || selectedTable.openedAt || '';
                    selectedTable.openedAtMs = data.opened_at_ms || selectedTable.openedAtMs || '';
                    syncTableButtonOrderInfo(selectedTable.id, selectedTable.staff, selectedTable.openedAt, selectedTable.openedAtMs, selectedTable.status || data.table_status || 'busy');
                }
                Object.keys(cart).forEach(id => delete cart[id]);

                if (Array.isArray(data.items)) {
                    data.items.forEach(function(item) {
                        if (!item.id) return;

                        cart[item.id] = {
                            id: item.id,
                            product_id: item.product_id || item.id,
                            name: item.name,
                            price: parseFloat(item.price || 0),
                            qty: parseFloat(item.qty || 1),
                            lockedQty: parseFloat(item.locked_qty ?? item.qty ?? 1)
                        };
                    });
                }

                renderCart();
                renderCheckTabs();
            } catch (error) {
                console.error(error);
                alert('Çek məlumatı yüklənmədi.');
            }
        }

        async function saveCurrentOrder(showAlert) {
            if (!selectedTable) {
                return false;
            }

            if (selectedTable.paymentLocked) {
                if (showAlert !== false) {
                    alert('Bu masa üçün hesab yazılıb. Əlavə dəyişiklik üçün əvvəl “Kilidi aç” edin.');
                }
                return false;
            }

            const items = Object.values(cart);

            if (!selectedOrderId && items.length === 0) {
                return true;
            }

            const response = await fetch("{{ route('staff.orders.store') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({
                    table_id: selectedTable.id,
                    order_id: selectedOrderId,
                    items: items,
                    clear_table: false
                })
            });

            const data = await response.json();

            if (!data.success) {
                if (showAlert !== false) {
                    alert(data.message || 'Sifariş saxlanılmadı.');
                }
                return false;
            }

            selectedOrderId = data.order_id || selectedOrderId;

            if (selectedTable) {
                if (data.opened_at) {
                    selectedTable.openedAt = data.opened_at;
                }

                if (data.opened_at_ms) {
                    selectedTable.openedAtMs = data.opened_at_ms;
                }

                if (data.staff_name) {
                    selectedTable.staff = data.staff_name;
                }

                if (data.table_status) {
                    selectedTable.status = data.table_status;
                }

                syncTableButtonOrderInfo(
                    selectedTable.id,
                    selectedTable.staff || data.staff_name || 'Əməkdaş',
                    selectedTable.openedAt || data.opened_at || '',
                    selectedTable.openedAtMs || data.opened_at_ms || '',
                    selectedTable.status || data.table_status || 'busy'
                );
            }

            return true;
        }

        document.addEventListener('click', async function(event) {
            const checkChip = event.target.closest('.check-chip[data-order-id]');

            if (checkChip) {
                event.preventDefault();
                await loadOrderCheck(checkChip.dataset.orderId);
            }
        });

        async function refreshSelectedTableChecks() {
            if (!selectedTable) return;

            const response = await fetch("{{ url('/staff/orders/table') }}/" + selectedTable.id + (selectedOrderId ? '?order_id=' + selectedOrderId : ''), {
                method: 'GET',
                headers: {
                    'Accept': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                selectedOrderId = data.order_id || selectedOrderId;
                currentChecks = Array.isArray(data.checks) ? data.checks : [];
                renderCheckTabs();
            }
        }

        async function postJson(url, payload) {
            const response = await fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify(payload)
            });

            const text = await response.text();
            let data = {};

            try {
                data = text ? JSON.parse(text) : {};
            } catch (error) {
                data = {
                    success: false,
                    message: 'Server JSON cavab qaytarmadı. Route və controlleri yoxlayın.'
                };
            }

            if (!response.ok && data.success !== false) {
                data.success = false;
                data.message = data.message || 'Server xətası baş verdi.';
            }

            return data;
        }

        function askTargetTableId(message) {
            const tables = Array.from(document.querySelectorAll('.staff-table-item'))
                .filter(function(table) {
                    return !selectedTable || String(table.dataset.id) !== String(selectedTable.id);
                })
                .map(function(table) {
                    const statusText = table.dataset.status === 'empty' ? 'Boş' : 'Dolu';
                    return table.dataset.id + ' - ' + table.dataset.name + ' (' + statusText + ')';
                })
                .join('\n');

            const value = prompt(message + '\n\nAşağıdakı siyahıdan hədəf masanın ID nömrəsini yazın:\n\n' + tables);

            if (!value) {
                return null;
            }

            return value.trim();
        }

        function renderCart() {
            const cartItems = document.getElementById('cartItems');
            const subtotalAmount = document.getElementById('subtotalAmount');
            const discountAmount = document.getElementById('discountAmount');
            const totalAmount = document.getElementById('totalAmount');

            const items = Object.values(cart);

            if (items.length === 0) {
                cartItems.innerHTML = `
                    <div style="padding:30px 10px; text-align:center; color:#7b8498; font-weight:800;">
                        Səbət boşdur
                    </div>
                `;

                subtotalAmount.textContent = formatMoney(0);
                discountAmount.textContent = formatMoney(0);
                totalAmount.textContent = formatMoney(0);

                return;
            }

            let subtotal = 0;

            cartItems.innerHTML = items.map(item => {
                const qty = parseFloat(item.qty || 0);
                const lockedQty = parseFloat(item.lockedQty || 0);
                const lineTotal = item.price * qty;
                subtotal += lineTotal;

                const canDecrease = qty > lockedQty;
                const canDelete = lockedQty <= 0;

                const minusButton = canDecrease ?
                    `<a href="#" class="qty-link js-cart-minus" data-id="${item.id}">-</a>` :
                    `<span class="qty-link" style="opacity:.35; cursor:not-allowed;">-</span>`;

                const deleteButton = canDelete ?
                    `<a href="#" class="delete-link js-cart-remove" data-id="${item.id}">⊗</a>` :
                    `<span></span>`;

                return `
                    <div class="order-item">
                        <div class="qty-box">
                            ${minusButton}
                            <span>${qty}</span>
                            ${selectedTable && selectedTable.paymentLocked ? '<span class="qty-link" style="opacity:.35; cursor:not-allowed;">+</span>' : `<a href="#" class="qty-link js-cart-plus" data-id="${item.id}">+</a>`}
                        </div>

                        <div>
                            <div class="order-product-name">${item.name}</div>
                        </div>

                        <div class="order-price">${formatMoney(lineTotal)}</div>

                        ${deleteButton}
                    </div>
                `;
            }).join('');

            const discount = 0;
            const total = subtotal - discount;

            subtotalAmount.textContent = formatMoney(subtotal);
            discountAmount.textContent = formatMoney(discount);
            totalAmount.textContent = formatMoney(total);
        }

        document.querySelectorAll('.js-product-card').forEach(card => {
            card.addEventListener('click', function(event) {
                event.preventDefault();

                if (selectedTable && selectedTable.paymentLocked) {
                    alert('Bu masa üçün hesab yazılıb. Əlavə məhsul üçün əvvəl “Kilidi aç” edin.');
                    return;
                }

                const id = this.dataset.id;
                const name = this.dataset.name;
                const price = parseFloat(this.dataset.price);

                if (!cart[id]) {
                    cart[id] = {
                        id: id,
                        product_id: id,
                        name: name,
                        price: price,
                        qty: 1,
                        lockedQty: 0
                    };
                } else {
                    cart[id].qty++;
                }

                renderCart();
            });
        });

        let staffIdleTimer;

        function staffAutoLogout() {
            const form = document.createElement('form');

            form.method = 'POST';
            form.action = "{{ route('staff.logout') }}";

            const csrf = document.createElement('input');

            csrf.type = 'hidden';
            csrf.name = '_token';
            csrf.value = "{{ csrf_token() }}";

            form.appendChild(csrf);
            document.body.appendChild(form);
            form.submit();
        }

        function resetStaffIdleTimer() {
            clearTimeout(staffIdleTimer);

            staffIdleTimer = setTimeout(function() {
                staffAutoLogout();
            }, 10 * 60 * 1000);
        }

        ['click', 'mousemove', 'keydown', 'touchstart'].forEach(function(eventName) {
            document.addEventListener(eventName, resetStaffIdleTimer, true);
        });

        document.addEventListener('click', function(event) {
            const plus = event.target.closest('.js-cart-plus');
            const minus = event.target.closest('.js-cart-minus');
            const remove = event.target.closest('.js-cart-remove');

            if (plus) {
                event.preventDefault();

                if (selectedTable && selectedTable.paymentLocked) {
                    alert('Bu masa üçün hesab yazılıb. Say artırmaq üçün əvvəl “Kilidi aç” edin.');
                    return;
                }

                const id = plus.dataset.id;

                if (cart[id]) {
                    cart[id].qty++;
                    renderCart();
                }
            }

            if (minus) {
                event.preventDefault();

                if (selectedTable && selectedTable.paymentLocked) {
                    alert('Bu masa üçün hesab yazılıb. Dəyişiklik üçün əvvəl “Kilidi aç” edin.');
                    return;
                }

                const id = minus.dataset.id;

                if (cart[id]) {
                    const lockedQty = parseFloat(cart[id].lockedQty || 0);

                    if (parseFloat(cart[id].qty || 0) > lockedQty) {
                        cart[id].qty--;
                    }

                    if (lockedQty <= 0 && cart[id].qty <= 0) {
                        delete cart[id];
                    }

                    renderCart();
                }
            }

            if (remove) {
                event.preventDefault();

                if (selectedTable && selectedTable.paymentLocked) {
                    alert('Bu masa üçün hesab yazılıb. Dəyişiklik üçün əvvəl “Kilidi aç” edin.');
                    return;
                }

                const id = remove.dataset.id;

                if (cart[id]) {
                    const lockedQty = parseFloat(cart[id].lockedQty || 0);

                    if (lockedQty > 0) {
                        alert('Bu məhsul artıq masaya vurulub. Silmək üçün icazə tələb olunur.');
                        return;
                    }

                    delete cart[id];
                    renderCart();
                }
            }
        });



        function setTableUiStatus(tableId, statusValue, stateLabel, badgeClass) {
            const tableButton = document.querySelector('.staff-table-item[data-id="' + tableId + '"]');

            if (!tableButton) {
                return;
            }

            tableButton.dataset.status = statusValue;
            tableButton.dataset.state = statusValue;
            tableButton.dataset.stateLabel = stateLabel;
            tableButton.dataset.paymentLocked = statusValue === 'waiting_payment' ? '1' : '0';

            if (statusValue === 'empty') {
                tableButton.dataset.staff = '';
                tableButton.dataset.openedAt = '';
                tableButton.dataset.openedAtMs = '';

                const meta = tableButton.querySelector('.staff-table-meta');
                if (meta) {
                    meta.textContent = (tableButton.dataset.seats || '0') + ' nəfər';
                }
            } else if (selectedTable && String(selectedTable.id) === String(tableId)) {
                syncTableButtonOrderInfo(tableId, selectedTable.staff || 'Əməkdaş', selectedTable.openedAt || '', selectedTable.openedAtMs || '', statusValue);
            }

            const badge = tableButton.querySelector('.staff-table-badge');

            if (badge) {
                badge.className = 'staff-table-badge ' + badgeClass;
            }
        }

        function updateOrderActionButtons() {
            const closeBtn = document.getElementById('closeOrderBtn');
            const actionBtn = document.getElementById('mainPaymentActionBtn');

            if (!closeBtn || !actionBtn) {
                return;
            }

            if (selectedTable && selectedTable.paymentLocked) {
                if (staffCanUnlockPaymentLock) {
                    closeBtn.innerHTML = 'Kilidi aç<small>Əlavə sifariş</small>';
                    closeBtn.classList.add('unlock-mode');
                } else {
                    closeBtn.innerHTML = 'Bağla<small>Masa üzərinə vur</small>';
                    closeBtn.classList.remove('unlock-mode');
                }

                if (staffCanTakePayment) {
                    actionBtn.innerHTML = 'Ödəniş et<small>Hesabı tamamla</small>';
                    actionBtn.dataset.mode = 'payment';
                } else if (staffCanUnlockPaymentLock) {
                    actionBtn.innerHTML = 'Kilidi aç<small>Əlavə sifariş</small>';
                    actionBtn.dataset.mode = 'unlock';
                } else {
                    actionBtn.innerHTML = 'Bağla<small>Masa ekranına dön</small>';
                    actionBtn.dataset.mode = 'close';
                }

                return;
            }

            closeBtn.innerHTML = 'Bağla<small>Masa üzərinə vur</small>';
            closeBtn.classList.remove('unlock-mode');
            actionBtn.innerHTML = 'Hesab yaz<small>Hesabı çıxar</small>';
            actionBtn.dataset.mode = 'print_bill';
        }

        async function unlockCurrentTablePaymentLock() {
            if (!selectedTable) {
                return;
            }

            if (!staffCanUnlockPaymentLock) {
                alert('Bu əməliyyat üçün səlahiyyət tələb olunur.');
                return;
            }

            const data = await postJson("{{ route('staff.orders.unlock-bill') }}", {
                table_id: selectedTable.id
            });

            if (!data.success) {
                alert(data.message || 'Kilid açılmadı.');
                return;
            }

            selectedTable.status = data.table_status || 'busy';
            selectedTable.state = selectedTable.status;
            selectedTable.stateLabel = 'Dolu';
            selectedTable.paymentLocked = false;

            setTableUiStatus(selectedTable.id, 'busy', 'Dolu', 'status-busy');
            renderTableInfo();
            updateOrderActionButtons();
            showPosToast(data.message || 'Masa kilidi açıldı.', 'success');
        }

        const closeOrderBtn = document.getElementById('closeOrderBtn');

        if (closeOrderBtn) {

            closeOrderBtn.addEventListener('click', async function(event) {

                event.preventDefault();

                if (!selectedTable) {
                    returnToTablesScreen();
                    return;
                }

                if (selectedTable.paymentLocked) {
                    if (staffCanUnlockPaymentLock) {
                        await unlockCurrentTablePaymentLock();
                    } else {
                        returnToTablesScreen();
                    }
                    return;
                }

                const items = Object.values(cart);

                closeOrderBtn.style.pointerEvents = 'none';
                closeOrderBtn.style.opacity = '.7';

                try {

                    const response = await fetch("{{ route('staff.orders.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify({
                            table_id: selectedTable.id,
                            order_id: selectedOrderId,
                            items: items
                        })
                    });

                    const data = await response.json();

                    if (!data.success) {
                        alert(data.message || 'Xəta baş verdi');
                        return;
                    }

                    selectedOrderId = data.order_id || selectedOrderId;

                    Object.values(cart).forEach(function(item) {
                        item.lockedQty = parseFloat(item.qty || 0);
                    });

                    const tableButton = document.querySelector(
                        '.staff-table-item[data-id="' + selectedTable.id + '"]'
                    );

                    if (tableButton && items.length > 0) {

                        tableButton.dataset.status = 'busy';
                        tableButton.dataset.state = 'busy';
                        tableButton.dataset.stateLabel = 'Dolu';

                        const badge = tableButton.querySelector('.staff-table-badge');

                        if (badge) {
                            badge.className = 'staff-table-badge status-busy';
                        }

                        const meta = tableButton.querySelector('.staff-table-meta');

                        if (meta) {
                            const existingOpenedAt = data.opened_at || selectedTable.openedAt || tableButton.dataset.openedAt || new Date().toISOString();
                            const activeStaffName = data.staff_name || selectedTable.staff || tableButton.dataset.staff || "{{ $staffName }}";

                            selectedTable.openedAt = existingOpenedAt;
                            selectedTable.staff = activeStaffName;

                            tableButton.dataset.staff = activeStaffName;
                            tableButton.dataset.openedAt = existingOpenedAt;

                            meta.innerHTML = `
                                <span class="staff-table-waiter">${tableButton.dataset.staff}</span>
                                <span class="staff-table-time" data-opened-at="${existingOpenedAt}">00:00</span>
                            `;
                        }
                    }

                    if (tableButton && items.length === 0) {

                        tableButton.dataset.status = 'empty';
                        tableButton.dataset.state = tableButton.dataset.reservationId ? 'reservation_upcoming' : 'empty';
                        tableButton.dataset.stateLabel = tableButton.dataset.reservationId ? 'Rezerv var' : 'Boş';

                        const badge = tableButton.querySelector('.staff-table-badge');

                        if (badge) {
                            badge.className = 'staff-table-badge status-empty';
                        }

                        const meta = tableButton.querySelector('.staff-table-meta');

                        if (meta) {
                            tableButton.dataset.staff = '';
                            tableButton.dataset.openedAt = '';

                            meta.innerHTML = selectedTable.seats + ' nəfər';
                        }
                    }

                    returnToTablesScreen();

                } catch (error) {

                    console.error(error);
                    alert('Server xətası baş verdi');

                } finally {

                    closeOrderBtn.style.pointerEvents = '';
                    closeOrderBtn.style.opacity = '';
                }
            });
        }


        const mainPaymentActionBtn = document.getElementById('mainPaymentActionBtn');

        if (mainPaymentActionBtn) {
            mainPaymentActionBtn.addEventListener('click', async function(event) {
                event.preventDefault();

                if (!selectedTable) {
                    alert('Əvvəl masa seçin.');
                    return;
                }

                const mode = mainPaymentActionBtn.dataset.mode || 'print_bill';

                if (mode === 'unlock') {
                    await unlockCurrentTablePaymentLock();
                    return;
                }

                if (mode === 'close') {
                    returnToTablesScreen();
                    return;
                }

                if (mode === 'payment') {
                    openPaymentScreen();
                    return;
                }

                const items = Object.values(cart);

                if (items.length === 0) {
                    alert('Hesab yazmaq üçün əvvəl məhsul əlavə edin.');
                    return;
                }

                mainPaymentActionBtn.style.pointerEvents = 'none';
                mainPaymentActionBtn.style.opacity = '.7';

                try {
                    const saved = await saveCurrentOrder(true);

                    if (!saved) {
                        return;
                    }

                    const data = await postJson("{{ route('staff.orders.print-bill') }}", {
                        table_id: selectedTable.id,
                        order_id: selectedOrderId
                    });

                    if (!data.success) {
                        alert(data.message || 'Hesab yazılmadı.');
                        return;
                    }

                    Object.values(cart).forEach(function(item) {
                        item.lockedQty = parseFloat(item.qty || 0);
                    });

                    selectedTable.status = 'waiting_payment';
                    selectedTable.state = 'waiting_payment';
                    selectedTable.stateLabel = 'Hesab gözləyir';
                    selectedTable.paymentLocked = true;

                    syncTableButtonOrderInfo(selectedTable.id, selectedTable.staff || 'Əməkdaş', selectedTable.openedAt || '', selectedTable.openedAtMs || '', 'waiting_payment');
                    setTableUiStatus(selectedTable.id, 'waiting_payment', 'Hesab gözləyir', 'status-waiting');
                    renderCart();
                    renderTableInfo();
                    updateOrderActionButtons();

                    showPosToast(data.message || 'Hesab yazıldı.', 'success');

                    if (!staffCanTakePayment) {
                        returnToTablesScreen();
                    }
                } catch (error) {
                    console.error(error);
                    alert('Server xətası baş verdi.');
                } finally {
                    mainPaymentActionBtn.style.pointerEvents = '';
                    mainPaymentActionBtn.style.opacity = '';
                }
            });
        }

        const newOrderBtn = document.getElementById('newOrderBtn');

        if (newOrderBtn) {
            newOrderBtn.addEventListener('click', function(event) {
                event.preventDefault();
                Object.keys(cart).forEach(id => delete cart[id]);
                renderCart();
                returnToTablesScreen();
            });
        }


        async function runTableOperation(button, callback) {
            if (!selectedTable) {
                alert('Əvvəl masa seçin.');
                return;
            }

            button.style.pointerEvents = 'none';
            button.style.opacity = '.7';

            try {
                await callback();
            } finally {
                button.style.pointerEvents = '';
                button.style.opacity = '';
            }
        }

        const moveTableBtn = document.getElementById('moveTableBtn');

        if (moveTableBtn) {
            moveTableBtn.addEventListener('click', function() {
                runTableOperation(moveTableBtn, async function() {
                    const saved = await saveCurrentOrder(true);
                    if (!saved) return;

                    const toTableId = askTargetTableId('Masanı dəyişmək üçün boş hədəf masanı seçin.');
                    if (!toTableId) return;

                    if (!confirm(selectedTable.name + ' masasındakı bütün açıq çeklər həmin masaya köçürülsün?')) {
                        return;
                    }

                    const data = await postJson("{{ route('staff.orders.move-table') }}", {
                        from_table_id: selectedTable.id,
                        to_table_id: toTableId
                    });

                    if (!data.success) {
                        alert(data.message || 'Masa dəyişdirilmədi.');
                        return;
                    }

                    showPosToast(data.message || 'Masa dəyişdirildi.', 'success');
                    window.location.reload();
                });
            });
        }

        const mergeTablesBtn = document.getElementById('mergeTablesBtn');

        if (mergeTablesBtn) {
            mergeTablesBtn.addEventListener('click', function() {
                runTableOperation(mergeTablesBtn, async function() {
                    const saved = await saveCurrentOrder(true);
                    if (!saved) return;

                    const toTableId = askTargetTableId('Bu masanı hansı masa ilə birləşdirirsiniz?');
                    if (!toTableId) return;

                    if (!confirm(selectedTable.name + ' masasındakı çeklər hədəf masaya keçəcək və bu masa boşalacaq. Davam edək?')) {
                        return;
                    }

                    const data = await postJson("{{ route('staff.orders.merge-tables') }}", {
                        from_table_id: selectedTable.id,
                        to_table_id: toTableId
                    });

                    if (!data.success) {
                        alert(data.message || 'Masalar birləşdirilmədi.');
                        return;
                    }

                    showPosToast(data.message || 'Masalar birləşdirildi.', 'success');
                    window.location.reload();
                });
            });
        }

        const mergeChecksBtn = document.getElementById('mergeChecksBtn');

        if (mergeChecksBtn) {
            mergeChecksBtn.addEventListener('click', function() {
                runTableOperation(mergeChecksBtn, async function() {
                    const saved = await saveCurrentOrder(true);
                    if (!saved) return;

                    if (!confirm('Bu masadakı bütün açıq çeklər bir hesaba birləşdirilsin?')) {
                        return;
                    }

                    const data = await postJson("{{ route('staff.orders.merge-checks') }}", {
                        table_id: selectedTable.id,
                        target_order_id: selectedOrderId
                    });

                    if (!data.success) {
                        alert(data.message || 'Çeklər birləşdirilmədi.');
                        return;
                    }

                    selectedOrderId = data.order_id || selectedOrderId;

                    Object.values(cart).forEach(function(item) {
                        item.lockedQty = parseFloat(item.qty || 0);
                    });
                    showPosToast(data.message || 'Çeklər birləşdirildi.', 'success');
                    await loadOrderCheck(selectedOrderId, false);
                });
            });
        }

        const shareTableBtn = document.getElementById('shareTableBtn');

        if (shareTableBtn) {
            shareTableBtn.addEventListener('click', function() {
                runTableOperation(shareTableBtn, async function() {
                    if (!selectedTable) {
                        alert('Əvvəl masa seçin.');
                        return;
                    }

                    const saved = await saveCurrentOrder(true);
                    if (!saved) return;

                    if (!confirm(selectedTable.name + ' üçün ayrıca yeni çek açılsın?')) {
                        return;
                    }

                    const data = await postJson("{{ route('staff.orders.new-check') }}", {
                        table_id: selectedTable.id
                    });

                    if (!data.success) {
                        alert(data.message || 'Masa paylaşılmadı.');
                        return;
                    }

                    selectedOrderId = data.order_id;
                    Object.keys(cart).forEach(id => delete cart[id]);
                    await refreshSelectedTableChecks();
                    renderCart();
                    renderCheckTabs();
                    setOrderTab('order');
                    showPosToast(data.message || 'Masa paylaşıldı və yeni çek açıldı.', 'success');
                });
            });
        }

        const liveSearch = document.getElementById('liveProductSearch');

        if (liveSearch) {
            liveSearch.addEventListener('input', function() {
                const keyword = this.value.toLowerCase().trim();

                document.querySelectorAll('.js-product-card').forEach(card => {
                    const name = card.dataset.name.toLowerCase();

                    card.style.display = name.includes(keyword) ? 'block' : 'none';
                });
            });
        }

        function parsePosDate(value) {
            if (!value) return null;

            const raw = String(value).trim();
            let date = new Date(raw);

            if (!Number.isNaN(date.getTime())) {
                return date;
            }

            date = new Date(raw.replace(' ', 'T'));

            return Number.isNaN(date.getTime()) ? null : date;
        }

        function getTimerStartMs(timer) {
            const ms = parseInt(timer.dataset.openedAtMs || '', 10);

            if (Number.isFinite(ms) && ms > 0) {
                return ms;
            }

            const startDate = parsePosDate(timer.dataset.openedAt || '');

            return startDate ? startDate.getTime() : null;
        }

        function formatElapsedTime(diffSeconds) {
            const hours = Math.floor(diffSeconds / 3600);
            const minutes = Math.floor((diffSeconds % 3600) / 60);
            const seconds = diffSeconds % 60;

            if (hours > 0) {
                return String(hours).padStart(2, '0') + ':' +
                    String(minutes).padStart(2, '0') + ':' +
                    String(seconds).padStart(2, '0');
            }

            return String(minutes).padStart(2, '0') + ':' +
                String(seconds).padStart(2, '0');
        }

        function updateTableTimers() {
            const now = Date.now();

            document.querySelectorAll('.staff-table-time').forEach(function(timer) {
                const start = getTimerStartMs(timer);

                if (!start) {
                    timer.textContent = '--:--';
                    return;
                }

                const diffSeconds = Math.max(0, Math.floor((now - start) / 1000));
                timer.textContent = formatElapsedTime(diffSeconds);
            });
        }

        function syncTableButtonOrderInfo(tableId, staffName, openedAt, openedAtMs, statusValue) {
            const tableButton = document.querySelector('.staff-table-item[data-id="' + tableId + '"]');

            if (!tableButton) {
                return;
            }

            if (statusValue) {
                tableButton.dataset.status = statusValue;
            }

            tableButton.dataset.staff = staffName || tableButton.dataset.staff || 'Əməkdaş';
            tableButton.dataset.openedAt = openedAt || tableButton.dataset.openedAt || '';
            tableButton.dataset.openedAtMs = openedAtMs || tableButton.dataset.openedAtMs || '';

            const meta = tableButton.querySelector('.staff-table-meta');

            if (!meta) {
                return;
            }

            const currentStatus = tableButton.dataset.status || statusValue || 'busy';

            if (currentStatus === 'empty') {
                meta.textContent = (tableButton.dataset.seats || '0') + ' nəfər';
                return;
            }

            meta.innerHTML =
                '<span class="staff-table-waiter"></span>' +
                '<span class="staff-table-time"></span>';

            const waiter = meta.querySelector('.staff-table-waiter');
            const timer = meta.querySelector('.staff-table-time');

            if (waiter) {
                waiter.textContent = tableButton.dataset.staff || 'Əməkdaş';
            }

            if (timer) {
                timer.dataset.openedAt = tableButton.dataset.openedAt || '';
                timer.dataset.openedAtMs = tableButton.dataset.openedAtMs || '';
            }

            updateTableTimers();
        }


        function setOrderTab(tabName) {
            document.querySelectorAll('.order-tab-link').forEach(function(tab) {
                tab.classList.toggle('active', tab.dataset.orderTab === tabName);
            });

            const map = {
                order: document.getElementById('orderTabContent'),
                table: document.getElementById('tableTabContent'),
                customer: document.getElementById('customerTabContent')
            };

            Object.keys(map).forEach(function(key) {
                if (map[key]) {
                    map[key].classList.toggle('active', key === tabName);
                }
            });

            if (tabName === 'table') {
                renderTableInfo();
            }
        }

        document.querySelectorAll('.order-tab-link').forEach(function(tab) {
            tab.addEventListener('click', function(event) {
                event.preventDefault();
                setOrderTab(tab.dataset.orderTab || 'order');
            });
        });

        function formatDateTimeLabel(value) {
            const date = parsePosDate(value);

            if (!date) {
                return '-';
            }

            return date.toLocaleString('az-AZ', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric',
                hour: '2-digit',
                minute: '2-digit',
                hour12: false
            });
        }

        function normalizeReservationDateLabel(value) {
            if (!value) return '-';

            const raw = String(value).trim();

            if (/^\d{2}\.\d{2}\.\d{4}$/.test(raw)) {
                return raw;
            }

            const onlyDate = raw.split(' ')[0].split('T')[0];
            const parts = onlyDate.split('-');

            if (parts.length === 3) {
                return parts[2].padStart(2, '0') + '.' + parts[1].padStart(2, '0') + '.' + parts[0];
            }

            const date = new Date(raw);
            if (Number.isNaN(date.getTime())) return raw;

            return date.toLocaleDateString('az-AZ', {
                day: '2-digit',
                month: '2-digit',
                year: 'numeric'
            });
        }

        function normalizeReservationTimeLabel(value) {
            if (!value) return '--:--';

            const raw = String(value).trim();
            const match = raw.match(/(\d{1,2}):(\d{2})/);

            if (match) {
                return match[1].padStart(2, '0') + ':' + match[2];
            }

            return raw;
        }

        function renderTableInfo() {
            const name = document.getElementById('tableInfoName');
            const area = document.getElementById('tableInfoArea');
            const status = document.getElementById('tableInfoStatus');
            const seats = document.getElementById('tableInfoSeats');
            const staff = document.getElementById('tableInfoStaff');
            const openedAt = document.getElementById('tableInfoOpenedAt');
            const duration = document.getElementById('tableInfoDuration');
            const reservationTableId = document.getElementById('reservationTableId');

            const currentReservationCard = document.getElementById('currentReservationCard');
            const currentReservationTime = document.getElementById('currentReservationTime');
            const currentReservationCustomer = document.getElementById('currentReservationCustomer');
            const currentReservationPhone = document.getElementById('currentReservationPhone');
            const currentReservationDate = document.getElementById('currentReservationDate');
            const currentReservationGuests = document.getElementById('currentReservationGuests');

            if (!selectedTable) {
                if (name) name.textContent = 'Masa seçilməyib';
                if (area) area.textContent = 'Əvvəl masa seçin';
                if (status) status.textContent = 'Boş';
                if (seats) seats.textContent = '-';
                if (staff) staff.textContent = '-';
                if (openedAt) openedAt.textContent = '-';
                if (duration) {
                    duration.textContent = '00:00';
                    duration.dataset.openedAt = '';
                }
                if (reservationTableId) reservationTableId.value = '';
                if (currentReservationCard) currentReservationCard.classList.remove('show');
                updateOrderActionButtons();
                return;
            }

            if (name) name.textContent = selectedTable.name || 'Masa';
            if (area) area.textContent = selectedTable.area || '-';
            if (status) status.textContent = selectedTable.paymentLocked ? 'Hesab gözləyir' : (selectedTable.stateLabel || (selectedTable.status === 'busy' ? 'Dolu' : 'Boş'));
            if (seats) seats.textContent = (selectedTable.seats || '-') + ' nəfər';
            if (staff) staff.textContent = selectedTable.staff || '{{ $staffName }}';
            if (openedAt) openedAt.textContent = formatDateTimeLabel(selectedTable.openedAt);
            if (reservationTableId) reservationTableId.value = selectedTable.id;

            if (duration) {
                duration.dataset.openedAt = selectedTable.openedAt || '';
                duration.classList.add('staff-table-time');
            }

            if (currentReservationCard) {
                if (selectedTable.reservationId) {
                    currentReservationCard.classList.add('show');

                    if (currentReservationTime) currentReservationTime.textContent = selectedTable.reservationTime || '--:--';
                    if (currentReservationCustomer) currentReservationCustomer.textContent = selectedTable.reservationCustomer || '-';
                    if (currentReservationPhone) currentReservationPhone.textContent = selectedTable.reservationPhone || '-';
                    if (currentReservationDate) currentReservationDate.textContent = normalizeReservationDateLabel(selectedTable.reservationDate);
                    if (currentReservationGuests) currentReservationGuests.textContent = (selectedTable.reservationGuests || '-') + ' nəfər';
                } else {
                    currentReservationCard.classList.remove('show');
                }
            }

            updateOrderActionButtons();
        }

        function clearSelectedReservationFromUi() {
            if (!selectedTable) {
                return;
            }

            const tableButton = document.querySelector(
                '.staff-table-item[data-id="' + selectedTable.id + '"]'
            );

            selectedTable.reservationId = '';
            selectedTable.reservationTime = '';
            selectedTable.reservationDate = '';
            selectedTable.reservationCustomer = '';
            selectedTable.reservationPhone = '';
            selectedTable.reservationGuests = '';
            selectedTable.reservationNote = '';

            if (tableButton) {
                tableButton.dataset.reservationId = '';
                tableButton.dataset.reservationTime = '';
                tableButton.dataset.reservationDate = '';
                tableButton.dataset.reservationCustomer = '';
                tableButton.dataset.reservationPhone = '';
                tableButton.dataset.reservationGuests = '';
                tableButton.dataset.reservationNote = '';

                if (tableButton.dataset.status === 'empty') {
                    tableButton.dataset.state = 'empty';
                    tableButton.dataset.stateLabel = 'Boş';

                    selectedTable.state = 'empty';
                    selectedTable.stateLabel = 'Boş';
                }

                const badge = tableButton.querySelector('.staff-reservation-badge');

                if (badge) {
                    badge.remove();
                }
            }

            renderTableInfo();
        }

        async function updateReservationStatus(action) {
            if (!selectedTable || !selectedTable.reservationId) {
                alert('Bu masada aktiv rezerv yoxdur.');
                return;
            }

            const confirmText = action === 'complete' ?
                'Bu rezervi tamamlandı kimi qeyd edirsiniz?' :
                'Bu rezervi ləğv etmək istəyirsiniz?';

            if (!confirm(confirmText)) {
                return;
            }

            const url = action === 'complete' ?
                "{{ url('/staff/reservations') }}/" + selectedTable.reservationId + "/complete" :
                "{{ url('/staff/reservations') }}/" + selectedTable.reservationId + "/cancel";

            try {
                const response = await fetch(url, {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    }
                });

                const data = await response.json();

                if (!data.success) {
                    alert(data.message || 'Əməliyyat icra olunmadı.');
                    return;
                }

                clearSelectedReservationFromUi();

                showPosToast(data.message || 'Əməliyyat tamamlandı.', 'success');

                setTimeout(function() {
                    window.location.reload();
                }, 900);

            } catch (error) {
                console.error(error);
                alert('Server xətası baş verdi.');
            }
        }

        const completeReservationBtn = document.getElementById('completeReservationBtn');

        if (completeReservationBtn) {
            completeReservationBtn.addEventListener('click', function() {
                updateReservationStatus('complete');
            });
        }

        const cancelReservationBtn = document.getElementById('cancelReservationBtn');

        if (cancelReservationBtn) {
            cancelReservationBtn.addEventListener('click', function() {
                updateReservationStatus('cancel');
            });
        }

        const reservationForm = document.getElementById('reservationForm');

        if (reservationForm) {
            reservationForm.addEventListener('submit', async function(event) {
                event.preventDefault();

                if (!selectedTable) {
                    alert('Əvvəl masa seçin.');
                    return;
                }

                const payload = {
                    table_id: selectedTable.id,
                    customer_name: document.getElementById('reservationCustomerName').value,
                    customer_phone: document.getElementById('reservationCustomerPhone').value,
                    guest_count: document.getElementById('reservationGuestCount').value || 1,
                    reservation_date: document.getElementById('reservationDate').value,
                    start_time: document.getElementById('reservationStartTime').value,
                    note: document.getElementById('reservationNote').value
                };

                try {
                    const response = await fetch("{{ route('staff.reservations.store') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        body: JSON.stringify(payload)
                    });

                    const data = await response.json();

                    if (!data.success) {
                        alert(data.message || 'Rezerv yaradılmadı.');
                        return;
                    }

                    const tableButton = document.querySelector(
                        '.staff-table-item[data-id="' + selectedTable.id + '"]'
                    );

                    if (tableButton) {
                        const reservationId = data.reservation && data.reservation.id ?
                            data.reservation.id :
                            '';

                        tableButton.dataset.reservationId = reservationId;
                        tableButton.dataset.reservationTime = payload.start_time;
                        tableButton.dataset.reservationDate = payload.reservation_date;
                        tableButton.dataset.reservationCustomer = payload.customer_name;
                        tableButton.dataset.reservationPhone = payload.customer_phone;
                        tableButton.dataset.reservationGuests = payload.guest_count;
                        tableButton.dataset.reservationNote = payload.note;
                        tableButton.dataset.state = 'reservation_upcoming';
                        tableButton.dataset.stateLabel = 'Rezerv var';

                        selectedTable.reservationId = reservationId;
                        selectedTable.reservationTime = payload.start_time;
                        selectedTable.reservationDate = payload.reservation_date;
                        selectedTable.reservationCustomer = payload.customer_name;
                        selectedTable.reservationPhone = payload.customer_phone;
                        selectedTable.reservationGuests = payload.guest_count;
                        selectedTable.reservationNote = payload.note;
                        selectedTable.state = 'reservation_upcoming';
                        selectedTable.stateLabel = 'Rezerv var';

                        let badge = tableButton.querySelector('.staff-reservation-badge');

                        if (!badge) {
                            badge = document.createElement('span');
                            badge.className = 'staff-reservation-badge';
                            tableButton.appendChild(badge);
                        }

                        badge.textContent = 'Rezerv var ' + payload.start_time;
                    }

                    reservationForm.reset();
                    renderTableInfo();

                    showPosToast('Rezerv yaradıldı.', 'success');

                    setTimeout(function() {
                        window.location.reload();
                    }, 900);

                } catch (error) {
                    console.error(error);
                    alert('Server xətası baş verdi.');
                }
            });
        }




        /* ================= OPEN CHECKS LOGIC ================= */

        const openChecksBtn = document.getElementById('openChecksBtn');
        const openChecksPanel = document.getElementById('openChecksPanel');
        const openChecksOverlay = document.getElementById('openChecksOverlay');
        const closeChecksPanelBtn = document.getElementById('closeChecksPanelBtn');
        const openChecksList = document.getElementById('openChecksList');
        const checksTotalCount = document.getElementById('checksTotalCount');
        const checksTotalAmount = document.getElementById('checksTotalAmount');
        const checksPanelSubtitle = document.getElementById('checksPanelSubtitle');
        const checksPanelTitle = document.getElementById('checksPanelTitle');
        const checksFilterButtons = document.querySelectorAll('[data-check-filter]');
        let currentChecksFilter = 'open';
        let checksFetchController = null;

        function closeOpenChecksPanel() {
            if (openChecksPanel) {
                openChecksPanel.classList.remove('show');
                openChecksPanel.setAttribute('aria-hidden', 'true');
            }

            if (openChecksOverlay) {
                openChecksOverlay.classList.remove('show');
            }
        }

        function openOpenChecksPanel() {
            if (openChecksPanel) {
                openChecksPanel.classList.add('show');
                openChecksPanel.setAttribute('aria-hidden', 'false');
            }

            if (openChecksOverlay) {
                openChecksOverlay.classList.add('show');
            }
        }

        function checkFilterTitle(filter) {
            if (filter === 'paid') return 'Bağlı çeklər';
            if (filter === 'all') return 'Bütün çeklər';
            return 'Açıq çeklər';
        }

        function updateChecksFilterUi(filter) {
            checksFilterButtons.forEach(function(button) {
                button.classList.toggle('active', button.dataset.checkFilter === filter);
            });

            if (checksPanelTitle) {
                checksPanelTitle.textContent = checkFilterTitle(filter);
            }
        }

        function renderOpenChecks(data) {
            const checks = Array.isArray(data.checks) ? data.checks : [];
            const filter = data.filter || currentChecksFilter || 'open';

            updateChecksFilterUi(filter);

            if (checksTotalCount) checksTotalCount.textContent = data.count || checks.length || 0;
            if (checksTotalAmount) checksTotalAmount.textContent = formatMoney(data.total_amount || 0);

            if (checksPanelSubtitle) {
                const scopeText = data.role === 'cashier' ?
                    'Bütün əməkdaşların çekləri' :
                    'Yalnız sizə aid çeklər';

                checksPanelSubtitle.textContent = scopeText + ' · ' + checkFilterTitle(filter);
            }

            if (!openChecksList) return;

            if (!checks.length) {
                openChecksList.innerHTML = '<div class="checks-empty">' + checkFilterTitle(filter) + ' tapılmadı</div>';
                return;
            }

            openChecksList.innerHTML = checks.map(function(check) {
                const area = check.area_name ? ' · ' + check.area_name : '';
                const amount = formatMoney(check.total_amount || 0);
                const openedAt = check.opened_at || '-';
                const closedAt = check.closed_at || '-';
                const itemsCount = check.items_count || 0;
                const status = check.status || 'open';
                const statusLabel = check.status_label || (status === 'paid' ? 'Bağlı' : 'Açıq');
                const timeLabel = status === 'paid' ? ('Bağlandı: ' + closedAt) : ('Açılış: ' + openedAt);

                return `
                    <button type="button" class="check-row-card" data-open-check-table-id="${check.table_id || ''}" data-open-check-order-id="${check.id}" data-check-status="${status}">
                        <div class="check-row-top">
                            <div>
                                <div class="check-row-title">${check.label || ('Çek #' + check.id)} · ${check.table_name || 'Masa'}</div>
                                <div class="check-row-sub">${check.staff_name || 'Əməkdaş'}${area}</div>
                                <span class="check-status-badge ${status === 'paid' ? 'paid' : 'open'}">${statusLabel}</span>
                            </div>
                            <div class="check-row-amount">${amount}</div>
                        </div>
                        <div class="check-row-meta">
                            <span>${timeLabel}</span>
                            <span>Məhsul: ${itemsCount}</span>
                            <span>${statusLabel}</span>
                        </div>
                    </button>
                `;
            }).join('');
        }

        async function loadOpenChecks(filter = currentChecksFilter) {
            currentChecksFilter = filter || 'open';
            updateChecksFilterUi(currentChecksFilter);

            if (openChecksList) {
                openChecksList.innerHTML = '<div class="checks-empty">Çeklər yüklənir...</div>';
            }

            openOpenChecksPanel();

            if (checksFetchController) {
                checksFetchController.abort();
            }

            checksFetchController = new AbortController();

            try {
                const url = "{{ route('staff.orders.open-checks') }}" + '?status=' + encodeURIComponent(currentChecksFilter);
                const response = await fetch(url, {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json'
                    },
                    signal: checksFetchController.signal
                });

                const data = await response.json();

                if (!data.success) {
                    showPosToast(data.message || 'Çeklər yüklənmədi.', 'error');
                    return;
                }

                renderOpenChecks(data);
            } catch (error) {
                if (error.name === 'AbortError') {
                    return;
                }

                console.error(error);
                showPosToast('Çeklər yüklənmədi.', 'error');
            }
        }

        async function openCheckFromPanel(tableId, orderId, status = 'open') {
            if (status !== 'open') {
                showPosToast('Bağlı çek yalnız baxış üçündür. Açıq sifariş kimi açılmır.', 'info');
                return;
            }

            closeOpenChecksPanel();

            const tableButton = document.querySelector('.staff-table-item[data-id="' + tableId + '"]');

            if (!tableButton) {
                showPosToast('Bu çekin masası ekranda tapılmadı.', 'error');
                return;
            }

            await openPosForTable(tableButton);

            if (orderId && String(selectedOrderId) !== String(orderId)) {
                await loadOrderCheck(orderId, false);
            }
        }

        if (openChecksBtn) {
            openChecksBtn.addEventListener('click', function(event) {
                event.preventDefault();
                loadOpenChecks('open');
            });
        }

        checksFilterButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                loadOpenChecks(button.dataset.checkFilter || 'open');
            });
        });

        if (closeChecksPanelBtn) {
            closeChecksPanelBtn.addEventListener('click', function(event) {
                event.preventDefault();
                closeOpenChecksPanel();
            });
        }

        if (openChecksOverlay) {
            openChecksOverlay.addEventListener('click', closeOpenChecksPanel);
        }

        document.addEventListener('click', function(event) {
            const checkCard = event.target.closest('[data-open-check-order-id]');

            if (!checkCard) {
                return;
            }

            event.preventDefault();
            openCheckFromPanel(checkCard.dataset.openCheckTableId, checkCard.dataset.openCheckOrderId, checkCard.dataset.checkStatus || 'open');
        });


        renderStaffSeats();
        renderCheckTabs();
        renderCart();
        updateTableTimers();
        setInterval(updateTableTimers, 1000);
        resetStaffIdleTimer();

        /* ================= PAYMENT SCREEN LOGIC ================= */

        const paymentState = {
            method: 'cash',
            discountType: 'none',
            discountValue: '',
            cashAmount: '',
            cardAmount: '',
            inputTarget: 'cash',
            subtotal: 0,
            discountAmount: 0,
            payable: 0,
            changeAmount: 0,
        };

        function parsePaymentNumber(value) {
            const number = parseFloat(String(value ?? '').replace(',', '.'));
            return Number.isFinite(number) ? number : 0;
        }

        function getCartSubtotalForPayment() {
            return Object.values(cart).reduce(function(sum, item) {
                return sum + (parseFloat(item.price || 0) * parseFloat(item.qty || 0));
            }, 0);
        }

        function cleanPaymentInput(value) {
            let clean = String(value ?? '')
                .replace(',', '.')
                .replace(/[^0-9.]/g, '');

            const parts = clean.split('.');

            if (parts.length > 2) {
                clean = parts.shift() + '.' + parts.join('');
            }

            if (clean.startsWith('.')) {
                clean = '0' + clean;
            }

            return clean;
        }

        function normalizePaymentInput(value) {
            const clean = cleanPaymentInput(value);
            return clean === '' ? '' : clean;
        }

        function isPaymentTargetAllowed(target) {
            if (target === 'discount') {
                return paymentState.discountType !== 'none';
            }

            if (target === 'cash') {
                return paymentState.method === 'cash' || paymentState.method === 'mixed';
            }

            if (target === 'card') {
                return paymentState.method === 'card' || paymentState.method === 'mixed';
            }

            return false;
        }

        function setPaymentFieldValue(id, value) {
            const element = document.getElementById(id);

            if (!element) {
                return;
            }

            if (element.tagName === 'INPUT') {
                if (document.activeElement !== element) {
                    element.value = value;
                }
            } else {
                element.textContent = value;
            }
        }

        function setPaymentInputDisabled(id, disabled) {
            const input = document.getElementById(id);

            if (!input || input.tagName !== 'INPUT') {
                return;
            }

            input.disabled = disabled;
            input.readOnly = disabled;

            const box = input.closest('.payment-input-box');
            if (box) {
                box.classList.toggle('disabled', disabled);
            }
        }

        function syncPaymentStateFromInputs() {
            const discountInput = document.getElementById('paymentDiscountValue');
            const cashInput = document.getElementById('paymentCashAmount');
            const cardInput = document.getElementById('paymentCardAmount');

            if (discountInput && discountInput.tagName === 'INPUT' && !discountInput.disabled) {
                paymentState.discountValue = normalizePaymentInput(discountInput.value);
            }

            if (cashInput && cashInput.tagName === 'INPUT' && !cashInput.disabled) {
                paymentState.cashAmount = normalizePaymentInput(cashInput.value);
            }

            if (cardInput && cardInput.tagName === 'INPUT' && !cardInput.disabled) {
                paymentState.cardAmount = normalizePaymentInput(cardInput.value);
            }
        }

        function calculatePaymentAmounts() {
            paymentState.subtotal = getCartSubtotalForPayment();

            const discountValue = parsePaymentNumber(paymentState.discountValue);

            if (paymentState.discountType === 'percent') {
                paymentState.discountAmount = Math.min(paymentState.subtotal, paymentState.subtotal * discountValue / 100);
            } else if (paymentState.discountType === 'amount') {
                paymentState.discountAmount = Math.min(paymentState.subtotal, discountValue);
            } else {
                paymentState.discountAmount = 0;
            }

            paymentState.payable = roundMoney(Math.max(0, paymentState.subtotal - paymentState.discountAmount));

            if (paymentState.method === 'cash') {
                paymentState.cardAmount = '';
                paymentState.inputTarget = 'cash';
            }

            if (paymentState.method === 'card') {
                paymentState.cashAmount = '';
                paymentState.inputTarget = 'card';
            }

            if (paymentState.method === 'debt') {
                paymentState.cashAmount = '';
                paymentState.cardAmount = '';
                paymentState.inputTarget = 'cash';
            }

            if (paymentState.method === 'mixed') {
                let cash = Math.min(parsePaymentNumber(paymentState.cashAmount), paymentState.payable);
                let card = Math.min(parsePaymentNumber(paymentState.cardAmount), paymentState.payable);

                if (paymentState.inputTarget === 'cash') {
                    card = Math.max(0, paymentState.payable - cash);
                } else if (paymentState.inputTarget === 'card') {
                    cash = Math.max(0, paymentState.payable - card);
                } else if (roundMoney(cash + card) !== paymentState.payable) {
                    card = Math.max(0, paymentState.payable - cash);
                }

                paymentState.cashAmount = cash > 0 ? cash.toFixed(2) : '';
                paymentState.cardAmount = card > 0 ? card.toFixed(2) : '';
            }
        }

        function roundMoney(value) {
            return Math.round((parseFloat(value) || 0) * 100) / 100;
        }

        function getPaymentPaidAndBalance() {
            const cash = parsePaymentNumber(paymentState.cashAmount);
            const card = parsePaymentNumber(paymentState.cardAmount);
            const paid = roundMoney(cash + card);
            const payable = roundMoney(paymentState.payable);

            if (paymentState.method === 'cash') {
                return {
                    cash,
                    card: 0,
                    paid: cash,
                    remaining: Math.max(0, payable - cash),
                    change: Math.max(0, cash - payable),
                    canComplete: payable > 0 && cash >= payable,
                };
            }

            if (paymentState.method === 'card') {
                return {
                    cash: 0,
                    card,
                    paid: card,
                    remaining: Math.max(0, payable - card),
                    change: 0,
                    canComplete: payable > 0 && Math.abs(card - payable) <= 0.01,
                };
            }

            if (paymentState.method === 'debt') {
                return {
                    cash: 0,
                    card: 0,
                    paid: 0,
                    remaining: payable,
                    change: 0,
                    canComplete: payable > 0 && !!selectedCustomer,
                };
            }

            return {
                cash,
                card,
                paid,
                remaining: Math.max(0, payable - paid),
                change: 0,
                canComplete: payable > 0 && Math.abs(paid - payable) <= 0.01,
            };
        }

        function renderPaymentScreen() {
            calculatePaymentAmounts();

            const balance = getPaymentPaidAndBalance();
            paymentState.changeAmount = balance.change;

            document.getElementById('paymentCheckLabel').textContent = selectedOrderId ? ('Çek #' + selectedOrderId) : 'Çek seçilməyib';
            document.getElementById('paymentPayableBadge').textContent = formatMoney(paymentState.payable);
            setPaymentFieldValue('paymentDiscountValue', paymentState.discountType === 'none' ? '0' : (paymentState.discountValue || ''));
            setPaymentFieldValue('paymentCashAmount', (paymentState.method === 'card' || paymentState.method === 'debt') ? '' : (paymentState.cashAmount || ''));
            setPaymentFieldValue('paymentCardAmount', (paymentState.method === 'cash' || paymentState.method === 'debt') ? '' : (paymentState.cardAmount || ''));
            document.getElementById('paymentSubtotalText').textContent = formatMoney(paymentState.subtotal);
            document.getElementById('paymentDiscountText').textContent = formatMoney(paymentState.discountAmount);
            document.getElementById('paymentPayableText').textContent = formatMoney(paymentState.payable);

            const remainingText = document.getElementById('paymentRemainingText');
            if (remainingText) {
                remainingText.textContent = balance.change > 0 ? formatMoney(balance.change) : formatMoney(balance.remaining);

                const remainingLabel = remainingText.closest('.payment-summary-line')?.querySelector('span');
                if (remainingLabel) {
                    remainingLabel.textContent = balance.change > 0 ? 'Qaytarılacaq' : 'Qalıq';
                }
            }

            document.querySelectorAll('[data-payment-method]').forEach(function(btn) {
                btn.classList.toggle('active', btn.dataset.paymentMethod === paymentState.method);
            });

            document.querySelectorAll('[data-discount-type]').forEach(function(btn) {
                btn.classList.toggle('active', btn.dataset.discountType === paymentState.discountType);
            });

            document.querySelectorAll('[data-payment-target]').forEach(function(box) {
                const target = box.dataset.paymentTarget;
                const allowed = isPaymentTargetAllowed(target);
                box.classList.toggle('active', allowed && target === paymentState.inputTarget);
                box.classList.toggle('disabled', !allowed);
            });

            setPaymentInputDisabled('paymentDiscountValue', paymentState.discountType === 'none');
            setPaymentInputDisabled('paymentCashAmount', !(paymentState.method === 'cash' || paymentState.method === 'mixed'));
            setPaymentInputDisabled('paymentCardAmount', !(paymentState.method === 'card' || paymentState.method === 'mixed'));

            const completeBtn = document.getElementById('paymentCompleteBtn');
            if (completeBtn) {
                completeBtn.disabled = !balance.canComplete;
            }
        }

        function resetPaymentState() {
            paymentState.method = 'cash';
            paymentState.discountType = 'none';
            paymentState.discountValue = '';
            paymentState.subtotal = getCartSubtotalForPayment();
            paymentState.discountAmount = 0;
            paymentState.payable = roundMoney(paymentState.subtotal);
            paymentState.cashAmount = paymentState.payable > 0 ? paymentState.payable.toFixed(2) : '';
            paymentState.cardAmount = '';
            paymentState.inputTarget = 'cash';
            paymentState.changeAmount = 0;
        }

        function openPaymentScreen() {
            if (!staffCanTakePayment) {
                showPosToast('Ödəniş almaq üçün səlahiyyət tələb olunur.', 'error');
                return;
            }

            if (!selectedTable || !selectedOrderId) {
                showPosToast('Ödəniş üçün aktiv çek seçilməyib.', 'error');
                return;
            }

            if (Object.values(cart).length === 0) {
                showPosToast('Ödəniş üçün çekdə məhsul yoxdur.', 'error');
                return;
            }

            resetPaymentState();

            document.querySelectorAll('.order-tab-content').forEach(function(content) {
                content.classList.remove('active');
            });

            const paymentTab = document.getElementById('paymentTabContent');
            if (paymentTab) paymentTab.classList.add('active');

            renderPaymentScreen();
        }

        function closePaymentScreen() {
            const paymentTab = document.getElementById('paymentTabContent');
            const orderTab = document.getElementById('orderTabContent');

            if (paymentTab) paymentTab.classList.remove('active');
            if (orderTab) orderTab.classList.add('active');
        }

        function focusPaymentTarget(target, clearOnFocus = false) {
            if (!isPaymentTargetAllowed(target)) {
                return;
            }

            paymentState.inputTarget = target;
            renderPaymentScreen();

            const inputId = target === 'discount' ? 'paymentDiscountValue' : (target === 'cash' ? 'paymentCashAmount' : 'paymentCardAmount');
            const input = document.getElementById(inputId);

            if (input && input.tagName === 'INPUT' && !input.disabled) {
                input.focus();
                if (clearOnFocus) {
                    input.value = '';
                    if (target === 'discount') paymentState.discountValue = '';
                    if (target === 'cash') paymentState.cashAmount = '';
                    if (target === 'card') paymentState.cardAmount = '';
                }
                input.select();
            }
        }

        document.addEventListener('focusin', function(event) {
            const input = event.target.closest('.payment-input-field');

            if (!input) {
                return;
            }

            const box = input.closest('[data-payment-target]');
            if (!box) {
                return;
            }

            const target = box.dataset.paymentTarget;

            if (!isPaymentTargetAllowed(target)) {
                input.blur();
                return;
            }

            paymentState.inputTarget = target;

            if (input.value === '0' || input.value === '0.00') {
                input.value = '';
                if (target === 'discount') paymentState.discountValue = '';
                if (target === 'cash') paymentState.cashAmount = '';
                if (target === 'card') paymentState.cardAmount = '';
            }

            renderPaymentScreen();
        });

        document.addEventListener('input', function(event) {
            const input = event.target.closest('.payment-input-field');

            if (!input || input.disabled) {
                return;
            }

            const previousCursor = input.selectionStart || input.value.length;
            input.value = cleanPaymentInput(input.value);

            const box = input.closest('[data-payment-target]');
            if (box) {
                paymentState.inputTarget = box.dataset.paymentTarget;
            }

            syncPaymentStateFromInputs();
            renderPaymentScreen();

            if (document.activeElement === input) {
                const pos = Math.min(previousCursor, input.value.length);
                input.setSelectionRange(pos, pos);
            }
        });

        document.addEventListener('click', async function(event) {
            const methodBtn = event.target.closest('[data-payment-method]');
            const discountBtn = event.target.closest('[data-discount-type]');
            const targetBox = event.target.closest('[data-payment-target]');
            const keyBtn = event.target.closest('.payment-key');
            const backBtn = event.target.closest('#paymentBackBtn');
            const completeBtn = event.target.closest('#paymentCompleteBtn');

            if (methodBtn) {
                event.preventDefault();
                event.stopPropagation();

                paymentState.method = methodBtn.dataset.paymentMethod;
                paymentState.subtotal = getCartSubtotalForPayment();
                paymentState.payable = roundMoney(paymentState.subtotal - paymentState.discountAmount);

                if (paymentState.method === 'cash') {
                    paymentState.cashAmount = paymentState.payable > 0 ? paymentState.payable.toFixed(2) : '';
                    paymentState.cardAmount = '';
                    paymentState.inputTarget = 'cash';
                } else if (paymentState.method === 'card') {
                    paymentState.cashAmount = '';
                    paymentState.cardAmount = paymentState.payable > 0 ? paymentState.payable.toFixed(2) : '';
                    paymentState.inputTarget = 'card';
                } else if (paymentState.method === 'debt') {
                    paymentState.cashAmount = '';
                    paymentState.cardAmount = '';
                    paymentState.inputTarget = 'cash';

                    if (!selectedCustomer) {
                        showPosToast('Borc üçün əvvəl Müştəri tabından müştəri seçin.', 'warning');
                    }
                } else {
                    paymentState.cashAmount = '';
                    paymentState.cardAmount = paymentState.payable > 0 ? paymentState.payable.toFixed(2) : '';
                    paymentState.inputTarget = 'cash';
                }

                renderPaymentScreen();
                return;
            }

            if (discountBtn) {
                event.preventDefault();
                event.stopPropagation();

                paymentState.discountType = discountBtn.dataset.discountType;
                paymentState.discountValue = '';

                if (paymentState.discountType === 'none') {
                    paymentState.inputTarget = paymentState.method === 'card' ? 'card' : 'cash';
                } else {
                    paymentState.inputTarget = 'discount';
                }

                renderPaymentScreen();

                if (paymentState.discountType !== 'none') {
                    setTimeout(function() {
                        focusPaymentTarget('discount', true);
                    }, 30);
                }

                return;
            }

            if (targetBox) {
                event.preventDefault();
                const target = targetBox.dataset.paymentTarget;
                focusPaymentTarget(target, true);
                return;
            }

            if (keyBtn) {
                event.preventDefault();
                const key = keyBtn.dataset.key;
                let target = paymentState.inputTarget;

                if (!isPaymentTargetAllowed(target)) {
                    target = paymentState.method === 'card' ? 'card' : 'cash';
                    paymentState.inputTarget = target;
                }

                let current = '';
                if (target === 'discount') current = paymentState.discountValue;
                if (target === 'cash') current = paymentState.cashAmount;
                if (target === 'card') current = paymentState.cardAmount;

                current = String(current || '');

                if (key === 'back') {
                    current = current.length > 1 ? current.slice(0, -1) : '';
                } else if (key === '.') {
                    if (!current.includes('.')) current = current === '' ? '0.' : current + '.';
                } else {
                    current = current === '0' ? key : current + key;
                }

                current = cleanPaymentInput(current);

                if (target === 'discount') paymentState.discountValue = current;
                if (target === 'cash') paymentState.cashAmount = current;
                if (target === 'card') paymentState.cardAmount = current;

                renderPaymentScreen();
                return;
            }

            if (backBtn) {
                event.preventDefault();
                closePaymentScreen();
                return;
            }

            if (completeBtn) {
                event.preventDefault();

                if (completeBtn.disabled) return;

                completeBtn.disabled = true;

                try {
                    syncPaymentStateFromInputs();
                    calculatePaymentAmounts();
                    const balance = getPaymentPaidAndBalance();

                    let serverCashAmount = parsePaymentNumber(paymentState.cashAmount);
                    let serverCardAmount = parsePaymentNumber(paymentState.cardAmount);

                    if (paymentState.method === 'cash') {
                        serverCashAmount = paymentState.payable;
                        serverCardAmount = 0;
                    }

                    if (paymentState.method === 'card') {
                        serverCashAmount = 0;
                        serverCardAmount = paymentState.payable;
                    }

                    if (paymentState.method === 'debt') {
                        if (!selectedCustomer) {
                            showPosToast('Borc üçün əvvəl Müştəri tabından müştəri seçin.', 'error');
                            renderPaymentScreen();
                            return;
                        }

                        serverCashAmount = 0;
                        serverCardAmount = 0;
                    }

                    const data = await postJson("{{ route('staff.orders.complete-payment') }}", {
                        table_id: selectedTable.id,
                        order_id: selectedOrderId,
                        payment_method: paymentState.method,
                        discount_type: paymentState.discountType,
                        discount_value: parsePaymentNumber(paymentState.discountValue),
                        cash_amount: serverCashAmount,
                        card_amount: serverCardAmount,
                        customer_id: selectedCustomer ? selectedCustomer.id : null,
                        debt_amount: paymentState.method === 'debt' ? paymentState.payable : 0,
                    });

                    if (!data.success) {
                        showPosToast(data.message || 'Ödəniş tamamlanmadı.', 'error');
                        renderPaymentScreen();
                        return;
                    }

                    const changeMessage = balance.change > 0 ? (' Qaytarılacaq: ' + formatMoney(balance.change)) : '';
                    showPosToast((data.message || 'Ödəniş tamamlandı.') + changeMessage, 'success');
                    Object.keys(cart).forEach(id => delete cart[id]);
                    renderCart();

                    setTimeout(function() {
                        window.location.reload();
                    }, 700);
                } catch (error) {
                    console.error(error);
                    showPosToast('Server xətası baş verdi.', 'error');
                    renderPaymentScreen();
                }
            }
        });
    </script>

</body>

</html>