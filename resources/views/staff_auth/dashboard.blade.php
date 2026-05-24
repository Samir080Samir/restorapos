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

        .table-action-btn.danger {
            grid-column: 1 / -1;
            color: #ef4444;
            border-color: rgba(239, 68, 68, .28);
            background: #fff7f7;
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

        @media(max-width: 900px) {
            body {
                overflow: auto;
            }

            .pos-wrapper {
                height: auto;
                min-height: 100vh;
            }

            .pos-navbar {
                height: auto;
                min-height: 60px;
                flex-wrap: wrap;
                padding: 10px;
            }

            .pos-content {
                height: auto;
                grid-template-columns: 1fr;
                overflow: visible;
            }

            .products-grid {
                grid-template-columns: repeat(2, 1fr);
                overflow: visible;
            }
        }
    </style>
</head>

<body>

    @php
    $restaurantName = session('staff_restaurant_name') ?: 'Restoran';
    $branchName = session('staff_branch_name');

    $displayPlace = $branchName && $branchName !== 'Ümumi restoran'
    ? $branchName
    : $restaurantName;

    $staffName = session('staff_user_name') ?: 'Əməkdaş';
    $staffRole = session('staff_user_role') ?: 'cashier';
    @endphp

    <div class="pos-wrapper">

        <header class="pos-navbar">

            <a href="#" id="newOrderBtn" class="nav-btn green">
                <svg fill="none" stroke="currentColor" stroke-width="2.1" viewBox="0 0 24 24">
                    <path d="M12 5v14M5 12h14" />
                </svg>
                Yeni sifariş
            </a>

            <a href="#" class="nav-btn">
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
        @endphp

        <section id="tablesScreen" class="tables-screen">

            <div class="tables-shell">

                <div class="tables-header">

                    <div class="tables-header-left">
                        <div class="tables-title">Masa seçimi</div>
                        <div class="tables-subtitle">Sifarişə başlamaq üçün əvvəl masanı seçin.</div>
                    </div>

                    <div class="tables-header-right">

                        @if($tableAreas->count())
                        <div class="tables-area-tabs">
                            @foreach($tableAreas as $area)
                            <button type="button"
                                class="table-area-tab {{ $loop->first ? 'active' : '' }}"
                                data-area-tab="staff-area-{{ $area->id }}">
                                {{ $area->name }}
                            </button>
                            @endforeach
                        </div>
                        @endif

                        <div class="tables-status-row">
                            <div class="table-status-pill">
                                <span class="status-dot status-empty"></span>
                                Boş
                            </div>

                            <div class="table-status-pill">
                                <span class="status-dot status-busy"></span>
                                Dolu
                            </div>

                            <div class="table-status-pill">
                                <span class="status-dot status-waiting"></span>
                                Hesab gözləyir
                            </div>

                            <div class="table-status-pill">
                                <span class="status-dot status-reserved"></span>
                                Rezerv
                            </div>
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
                            $tableStatus = $table->status ?? 'empty';

                            $statusClass = match($tableStatus) {
                            'busy' => 'status-busy',
                            'reserved' => 'status-reserved',
                            'waiting_payment' => 'status-waiting',
                            default => 'status-empty',
                            };
                            @endphp

                            <button type="button"
                                class="staff-table-item staff-table-{{ $table->shape }}"
                                data-id="{{ $table->id }}"
                                data-name="{{ $table->name }}"
                                data-seats="{{ (int) $table->seats }}"
                                data-status="{{ $tableStatus }}"
                                data-area="{{ $area->name }}"
                                data-staff="{{ $table->openOrder?->staff?->name ?? '' }}"
                                data-opened-at="{{ optional($table->openOrder?->opened_at)->toIso8601String() }}"
                                data-reservation-id="{{ $table->activeReservation?->id ?? '' }}"
                                data-reservation-time="{{ $table->activeReservation ? \Carbon\Carbon::parse($table->activeReservation->start_time)->format('H:i') : '' }}"
                                data-reservation-date="{{ $table->activeReservation?->reservation_date ?? '' }}"
                                data-reservation-customer="{{ $table->activeReservation?->customer_name ?? '' }}"
                                data-reservation-phone="{{ $table->activeReservation?->customer_phone ?? '' }}"
                                data-reservation-guests="{{ $table->activeReservation?->guest_count ?? '' }}"
                                data-reservation-note="{{ $table->activeReservation?->note ?? '' }}"
                                onclick="openPosForTable(this)"
                                style="
                                                left: {{ $table->position_x }}px;
                                                top: {{ $table->position_y }}px;
                                                width: {{ $table->width }}px;
                                                height: {{ $table->height }}px;
                                            ">

                                <span class="staff-table-badge {{ $statusClass }}"></span>

                                @if($table->activeReservation)
                                <span class="staff-reservation-badge">
                                    Rezerv {{ \Carbon\Carbon::parse($table->activeReservation->start_time)->format('H:i') }}
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
                                        {{ $table->openOrder?->staff?->name ?? 'Əməkdaş' }}
                                    </span>

                                    <span class="staff-table-time"
                                        data-opened-at="{{ optional($table->openOrder?->opened_at)->toIso8601String() }}">
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

                        <a href="#" class="clear-cart-link">
                            Səbəti təmizlə 🗑
                        </a>
                    </div>

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

                            <a href="#" class="pay-link">
                                Ödəniş et
                                <small>Sifarişi tamamla</small>
                            </a>
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
                            <button type="button" class="table-action-btn">Masanı dəyiş</button>
                            <button type="button" class="table-action-btn">Yekunlaşdır</button>
                            <button type="button" class="table-action-btn danger">Masanı boşalt</button>
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
                            Masa açıq olsa belə, bu masanı seçilən başlanğıc saatına rezerv edə bilərsiniz.
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
                    <div class="customer-empty-card">
                        Müştəri bölməsi növbəti mərhələdə aktivləşdiriləcək.
                        Burada müştəri adı, telefon, qeyd, bonus və tarixçə görünəcək.
                    </div>
                </div>

            </aside>

        </main>

    </div>

    <script>
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

        function formatMoney(amount) {
            return Number(amount).toFixed(2) + ' ₼';
        }


        let selectedTable = null;

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
                area: button.dataset.area || '',
                staff: button.dataset.staff || '',
                openedAt: button.dataset.openedAt || '',
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
                            qty: parseFloat(item.qty || 1)
                        };
                    });
                }

                renderCart();
                renderTableInfo();

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
                const lineTotal = item.price * item.qty;
                subtotal += lineTotal;

                return `
                    <div class="order-item">
                        <div class="qty-box">
                            <a href="#" class="qty-link js-cart-minus" data-id="${item.id}">-</a>
                            <span>${item.qty}</span>
                            <a href="#" class="qty-link js-cart-plus" data-id="${item.id}">+</a>
                        </div>

                        <div>
                            <div class="order-product-name">${item.name}</div>
                        </div>

                        <div class="order-price">${formatMoney(lineTotal)}</div>

                        <a href="#" class="delete-link js-cart-remove" data-id="${item.id}">⊗</a>
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

                const id = this.dataset.id;
                const name = this.dataset.name;
                const price = parseFloat(this.dataset.price);

                if (!cart[id]) {
                    cart[id] = {
                        id: id,
                        name: name,
                        price: price,
                        qty: 1
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

                const id = plus.dataset.id;

                if (cart[id]) {
                    cart[id].qty++;
                    renderCart();
                }
            }

            if (minus) {
                event.preventDefault();

                const id = minus.dataset.id;

                if (cart[id]) {
                    cart[id].qty--;

                    if (cart[id].qty <= 0) {
                        delete cart[id];
                    }

                    renderCart();
                }
            }

            if (remove) {
                event.preventDefault();

                const id = remove.dataset.id;

                if (cart[id]) {
                    delete cart[id];
                    renderCart();
                }
            }
        });

        const clearCartLink = document.querySelector('.clear-cart-link');

        if (clearCartLink) {
            clearCartLink.addEventListener('click', function(event) {
                event.preventDefault();

                Object.keys(cart).forEach(id => delete cart[id]);

                renderCart();
            });
        }


        const closeOrderBtn = document.getElementById('closeOrderBtn');

        if (closeOrderBtn) {

            closeOrderBtn.addEventListener('click', async function(event) {

                event.preventDefault();

                if (!selectedTable) {
                    returnToTablesScreen();
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
                            items: items
                        })
                    });

                    const data = await response.json();

                    if (!data.success) {
                        alert(data.message || 'Xəta baş verdi');
                        return;
                    }

                    const tableButton = document.querySelector(
                        '.staff-table-item[data-id="' + selectedTable.id + '"]'
                    );

                    if (tableButton && items.length > 0) {

                        tableButton.dataset.status = 'busy';

                        const badge = tableButton.querySelector('.staff-table-badge');

                        if (badge) {
                            badge.className = 'staff-table-badge status-busy';
                        }

                        const meta = tableButton.querySelector('.staff-table-meta');

                        if (meta) {
                            const nowIso = new Date().toISOString();

                            tableButton.dataset.staff = "{{ $staffName }}";
                            tableButton.dataset.openedAt = nowIso;

                            meta.innerHTML = `
                                <span class="staff-table-waiter">{{ $staffName }}</span>
                                <span class="staff-table-time" data-opened-at="${nowIso}">00:00</span>
                            `;
                        }
                    }

                    if (tableButton && items.length === 0) {

                        tableButton.dataset.status = 'empty';

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

        const newOrderBtn = document.getElementById('newOrderBtn');

        if (newOrderBtn) {
            newOrderBtn.addEventListener('click', function(event) {
                event.preventDefault();
                Object.keys(cart).forEach(id => delete cart[id]);
                renderCart();
                returnToTablesScreen();
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

        function updateTableTimers() {
            document.querySelectorAll('.staff-table-time').forEach(function(timer) {
                const openedAt = timer.dataset.openedAt;

                if (!openedAt) {
                    timer.textContent = '00:00';
                    return;
                }

                const start = new Date(openedAt).getTime();

                if (!start || Number.isNaN(start)) {
                    timer.textContent = '00:00';
                    return;
                }

                const now = new Date().getTime();
                const diffSeconds = Math.max(0, Math.floor((now - start) / 1000));

                const hours = Math.floor(diffSeconds / 3600);
                const minutes = Math.floor((diffSeconds % 3600) / 60);
                const seconds = diffSeconds % 60;

                if (hours > 0) {
                    timer.textContent =
                        String(hours).padStart(2, '0') + ':' +
                        String(minutes).padStart(2, '0') + ':' +
                        String(seconds).padStart(2, '0');
                    return;
                }

                timer.textContent =
                    String(minutes).padStart(2, '0') + ':' +
                    String(seconds).padStart(2, '0');
            });
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
            if (!value) {
                return '-';
            }

            const date = new Date(value);

            if (Number.isNaN(date.getTime())) {
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
                return;
            }

            if (name) name.textContent = selectedTable.name || 'Masa';
            if (area) area.textContent = selectedTable.area || '-';
            if (status) status.textContent = selectedTable.status === 'busy' ? 'Dolu' : 'Boş';
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
                    if (currentReservationDate) currentReservationDate.textContent = selectedTable.reservationDate || '-';
                    if (currentReservationGuests) currentReservationGuests.textContent = (selectedTable.reservationGuests || '-') + ' nəfər';
                } else {
                    currentReservationCard.classList.remove('show');
                }
            }
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

                alert(data.message || 'Əməliyyat tamamlandı.');

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

                        selectedTable.reservationId = reservationId;
                        selectedTable.reservationTime = payload.start_time;
                        selectedTable.reservationDate = payload.reservation_date;
                        selectedTable.reservationCustomer = payload.customer_name;
                        selectedTable.reservationPhone = payload.customer_phone;
                        selectedTable.reservationGuests = payload.guest_count;
                        selectedTable.reservationNote = payload.note;

                        let badge = tableButton.querySelector('.staff-reservation-badge');

                        if (!badge) {
                            badge = document.createElement('span');
                            badge.className = 'staff-reservation-badge';
                            tableButton.appendChild(badge);
                        }

                        badge.textContent = 'Rezerv ' + payload.start_time;
                    }

                    reservationForm.reset();
                    renderTableInfo();

                    alert('Rezerv yaradıldı.');

                } catch (error) {
                    console.error(error);
                    alert('Server xətası baş verdi.');
                }
            });
        }


        renderStaffSeats();
        renderCart();
        updateTableTimers();
        setInterval(updateTableTimers, 1000);
        resetStaffIdleTimer();
    </script>

</body>

</html>