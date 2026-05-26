<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaPOS | POS Login</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
        const savedTerminalForView = localStorage.getItem('novapos_terminal_code');
        const savedTerminalNameForView = localStorage.getItem('novapos_terminal_name');

        if (savedTerminalForView) {
            document.documentElement.classList.add('terminal-saved');
        }

        if (savedTerminalNameForView) {
            document.documentElement.classList.add('terminal-name-ready');
        }
    </script>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html {
            background: #fff;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            overflow: hidden;
            background: #fff;
            text-rendering: geometricPrecision;
            -webkit-font-smoothing: antialiased;
        }

        .login-wrapper {
            width: 100%;
            height: 100vh;
            display: flex;
        }

        html.terminal-saved #terminalStep {
            display: none;
        }

        html.terminal-saved #pinStep {
            display: block !important;
        }

        html.terminal-name-ready .top-restaurant-badge {
            display: flex;
        }

        .left-side {
            width: 66%;
            position: relative;
            background: radial-gradient(circle at top left, #102f9e 0%, #07185e 45%, #020b35 100%);
            padding: 72px 70px;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .right-side {
            width: 34%;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #fff;
            padding: 44px;
        }

        .pattern {
            position: absolute;
            right: 135px;
            top: -45px;
            width: 140px;
            height: 120%;
            opacity: .08;
        }

        .pattern div {
            width: 86px;
            height: 86px;
            border: 3px solid #8ba2ff;
            border-radius: 23px;
            margin-bottom: 24px;
        }

        .welcome-content {
            max-width: 560px;
            position: relative;
            z-index: 2;
        }

        .leaf-logo {
            width: 70px;
            height: 70px;
            position: relative;
            flex: 0 0 auto;
        }

        .leaf-logo.left-logo {
            margin-bottom: 34px;
        }

        .leaf-logo::before {
            content: '';
            position: absolute;
            width: 28px;
            height: 58px;
            left: 15px;
            top: 5px;
            background: #20d6ad;
            border-radius: 30px 30px 6px 30px;
            transform: rotate(32deg);
        }

        .leaf-logo::after {
            content: '';
            position: absolute;
            width: 28px;
            height: 58px;
            right: 13px;
            top: 6px;
            border: 4px solid #20d6ad;
            border-radius: 30px 30px 30px 6px;
            transform: rotate(32deg);
        }

        .welcome-title {
            color: #fff;
            font-size: 42px;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 22px;
            min-height: 47px;
        }

        .welcome-text {
            color: rgba(255, 255, 255, .92);
            font-size: 16px;
            line-height: 1.85;
            font-weight: 600;
            max-width: 560px;
        }

        .top-restaurant-badge {
            position: absolute;
            top: 22px;
            left: 28px;
            z-index: 5;
            min-height: 42px;
            padding: 0 18px;
            border-radius: 999px;
            background: #fff;
            display: none;
            align-items: center;
            gap: 10px;
            color: #071143;
            font-size: 14px;
            font-weight: 800;
            box-shadow: 0 14px 35px rgba(7, 17, 67, .12);
        }

        .top-restaurant-badge span:first-child {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            background: #16c784;
            flex: 0 0 9px;
        }

        .support-btn {
            position: absolute;
            top: 28px;
            left: 34px;
            height: 34px;
            padding: 0 16px;
            border: none;
            border-radius: 999px;
            background: #f1eef7;
            color: #071143;
            font-size: 14px;
            font-weight: 900;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            font-family: Arial, Helvetica, sans-serif;
        }

        .support-btn svg {
            width: 18px;
            height: 18px;
        }

        .language {
            position: absolute;
            top: 28px;
            right: 34px;
            display: flex;
            align-items: center;
            gap: 8px;
            color: #071143;
            font-size: 14px;
            font-weight: 800;
            min-height: 34px;
        }

        .language select {
            border: none;
            outline: none;
            background: transparent;
            color: #071143;
            font-size: 14px;
            font-weight: 800;
            font-family: Arial, Helvetica, sans-serif;
        }

        .login-box {
            width: 100%;
            max-width: 340px;
            min-height: 390px;
            margin-top: -20px;
        }

        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 16px;
            height: 54px;
            min-height: 54px;
        }

        .brand .leaf-logo {
            width: 54px;
            height: 54px;
            flex: 0 0 54px;
        }

        .brand .leaf-logo::before {
            width: 21px;
            height: 46px;
            left: 11px;
            top: 4px;
        }

        .brand .leaf-logo::after {
            width: 21px;
            height: 46px;
            right: 9px;
            top: 4px;
            border-width: 3px;
        }

        .brand-name {
            color: #071143;
            font-size: 31px;
            font-weight: 900;
            line-height: 1;
            width: 142px;
            min-width: 142px;
        }

        .login-title {
            color: #071143;
            font-size: 22px;
            font-weight: 900;
            text-align: center;
            margin-bottom: 26px;
            min-height: 27px;
            line-height: 27px;
        }

        #terminalStep {
            min-height: 210px;
        }

        #pinStep {
            min-height: 330px;
        }

        .form-group {
            margin-bottom: 16px;
            min-height: 98px;
        }

        .form-group label {
            display: block;
            color: #071143;
            font-size: 14px;
            font-weight: 900;
            margin-bottom: 8px;
            min-height: 18px;
            line-height: 18px;
        }

        .form-control {
            width: 100%;
            height: 50px;
            min-height: 50px;
            border: 2px solid #e3e7ef;
            border-radius: 9px;
            padding: 0 16px;
            font-size: 14px;
            color: #071143;
            outline: none;
            transition: .25s;
            font-weight: 700;
            font-family: Arial, Helvetica, sans-serif;
            line-height: 50px;
        }

        .form-control:focus {
            border-color: #20d6ad;
            box-shadow: 0 0 0 4px rgba(32, 214, 173, .12);
        }

        .form-control::placeholder {
            color: #9aa3b4;
            font-weight: 600;
        }

        .status-message {
            height: 20px;
            min-height: 20px;
            margin-top: 8px;
            font-size: 13px;
            font-weight: 800;
            line-height: 20px;
            overflow: hidden;
        }

        .status-message.success {
            color: #16a34a;
        }

        .status-message.error {
            color: #ef4444;
        }

        .status-message.checking {
            color: #64748b;
        }

        .login-btn {
            width: 100%;
            height: 52px;
            min-height: 52px;
            border: none;
            border-radius: 9px;
            background: linear-gradient(90deg, #16bd95, #20d6ad);
            color: #fff;
            font-size: 16px;
            font-weight: 900;
            cursor: pointer;
            transition: .25s;
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 1;
        }

        .login-btn:disabled {
            background: #cbd3dd;
            cursor: not-allowed;
        }

        .pin-title {
            display: none;
        }

        .pin-boxes {
            display: flex;
            justify-content: center;
            gap: 12px;
            margin-bottom: 24px;
            min-height: 46px;
        }

        .pin-box {
            width: 46px;
            height: 46px;
            border: 2px solid #e3e7ef;
            border-radius: 13px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            font-weight: 900;
            color: #071143;
        }

        .keypad {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            min-height: 252px;
        }

        .key-btn {
            height: 54px;
            border: 2px solid #e3e7ef;
            border-radius: 13px;
            background: #fff;
            color: #071143;
            font-size: 22px;
            font-weight: 900;
            cursor: pointer;
            transition: .2s;
            font-family: Arial, Helvetica, sans-serif;
        }

        .key-btn:hover {
            border-color: #20d6ad;
            background: #f8fffd;
        }

        .terminal-info {
            text-align: center;
            margin-bottom: 18px;
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.5;
            min-height: 20px;
        }

        .terminal-info strong {
            color: #071143;
            font-size: 15px;
            display: block;
            min-height: 20px;
            line-height: 20px;
        }

        .change-terminal-btn {
            width: 100%;
            height: 42px;
            min-height: 42px;
            margin-top: 14px;
            border: none;
            background: transparent;
            color: #071143;
            font-size: 14px;
            font-weight: 900;
            font-family: Arial, Helvetica, sans-serif;
            letter-spacing: -0.2px;
            cursor: pointer;
            transition: .25s;
        }

        .change-terminal-btn:hover {
            color: #16bd95;
            letter-spacing: 0;
        }

        .footer {
            position: absolute;
            bottom: 28px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 18px;
            color: #8890aa;
            font-size: 13px;
            font-weight: 500;
            white-space: nowrap;
            min-height: 18px;
        }

        @media(max-width: 900px) {
            body {
                overflow: auto;
            }

            .login-wrapper {
                flex-direction: column;
                height: auto;
                min-height: 100vh;
            }

            .left-side,
            .right-side {
                width: 100%;
            }

            .left-side {
                min-height: 300px;
                padding: 36px 24px;
            }

            .right-side {
                min-height: calc(100vh - 300px);
                padding: 82px 22px 90px;
            }

            .login-box {
                max-width: 390px;
                margin-top: 0;
            }

            .support-btn {
                top: 24px;
                left: 22px;
            }

            .language {
                top: 24px;
                right: 22px;
            }

            .top-restaurant-badge {
                top: 18px;
                left: 20px;
            }
        }


        /* ================= QR WAITER CALL ALERT - LOGIN SCREEN ================= */

        .login-waiter-alert-wrap {
            position: fixed;
            top: 22px;
            right: 22px;
            z-index: 99999;
            width: min(390px, calc(100vw - 32px));
            display: grid;
            gap: 10px;
            pointer-events: none;
        }

        .login-waiter-alert {
            border-radius: 20px;
            padding: 15px;
            background:
                radial-gradient(circle at top right, rgba(72, 187, 120, .28), transparent 34%),
                linear-gradient(135deg, #063b31, #083326 60%, #0b4d3d);
            color: #fff;
            box-shadow: 0 22px 55px rgba(6, 44, 35, .28);
            border: 1px solid rgba(255, 255, 255, .12);
            display: none;
            grid-template-columns: 46px 1fr;
            gap: 12px;
            align-items: center;
            pointer-events: auto;
            animation: waiterLoginIn .22s ease forwards;
        }

        .login-waiter-alert.show {
            display: grid;
        }

        .login-waiter-icon {
            width: 46px;
            height: 46px;
            border-radius: 17px;
            background: rgba(255, 255, 255, .12);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .10);
        }

        .login-waiter-title {
            font-size: 14px;
            font-weight: 900;
            line-height: 1.15;
        }

        .login-waiter-meta {
            margin-top: 5px;
            color: rgba(255, 255, 255, .82);
            font-size: 12px;
            line-height: 1.35;
            font-weight: 700;
        }

        .login-waiter-count {
            color: #f1c86a;
            font-weight: 900;
        }

        @keyframes waiterLoginIn {
            from {
                opacity: 0;
                transform: translateY(-8px) scale(.98);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @media(max-width: 900px) {
            .login-waiter-alert-wrap {
                top: auto;
                right: 16px;
                left: 16px;
                bottom: 16px;
                width: auto;
            }
        }
    </style>
</head>

<body>

    <div id="loginWaiterAlertWrap" class="login-waiter-alert-wrap">
        <div id="loginWaiterAlert" class="login-waiter-alert" aria-live="polite">
            <div class="login-waiter-icon">🛎</div>
            <div>
                <div id="loginWaiterTitle" class="login-waiter-title">Ofisiant çağırışı var</div>
                <div id="loginWaiterMeta" class="login-waiter-meta">Yeni çağırış gözləyir.</div>
            </div>
        </div>
    </div>


    <div class="login-wrapper">

        <div class="left-side">

            <div id="topRestaurantBadge" class="top-restaurant-badge">
                <span></span>
                <strong id="topRestaurantBadgeText"></strong>
            </div>

            <script>
                if (savedTerminalNameForView) {
                    document.getElementById('topRestaurantBadgeText').innerText = savedTerminalNameForView;
                }
            </script>

            <div class="pattern">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>

            <div class="welcome-content">

                <div class="leaf-logo left-logo"></div>

                <h1 class="welcome-title">Xoş gəldiniz</h1>

                <p class="welcome-text">
                    NovaPOS sistemi ilə restoranınızı, filiallarınızı,
                    satışlarınızı, əməkdaşlarınızı, anbarınızı və maliyyə
                    axınınızı istənilən yerdən rahat idarə edin.
                </p>

            </div>

        </div>

        <div class="right-side">

            <button type="button" class="support-btn">
                <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 12a8 8 0 0 1 16 0" />
                    <path d="M4 12v4a2 2 0 0 0 2 2h1v-8H6a2 2 0 0 0-2 2z" />
                    <path d="M20 12v4a2 2 0 0 1-2 2h-1v-8h1a2 2 0 0 1 2 2z" />
                    <path d="M13 19h2a3 3 0 0 0 3-3" />
                </svg>
                Dəstək
            </button>

            <div class="language">
                🌐
                <select>
                    <option>AZ</option>
                    <option>EN</option>
                    <option>RU</option>
                </select>
            </div>

            <div class="login-box">

                <div class="brand">
                    <div class="leaf-logo"></div>
                    <div class="brand-name">NovaPOS</div>
                </div>

                <div id="terminalStep">

                    <h2 class="login-title">POS Terminal</h2>

                    <div class="form-group">

                        <label>Terminal kodu</label>

                        <input
                            id="terminal_code"
                            type="text"
                            class="form-control"
                            placeholder="Məs: NP-901314"
                            autocomplete="off"
                            autocorrect="off"
                            autocapitalize="characters"
                            spellcheck="false">

                        <div id="terminalStatus" class="status-message"></div>

                    </div>

                    <button id="continueBtn" class="login-btn" disabled>
                        Davam et
                    </button>

                </div>

                <div id="pinStep" style="display:none;">

                    <h2 id="pinTitle" class="pin-title">Daxil ol</h2>

                    <div class="terminal-info">
                        <strong id="terminalRestaurantName"></strong>
                    </div>

                    <script>
                        if (savedTerminalNameForView) {
                            document.getElementById('terminalRestaurantName').innerText = savedTerminalNameForView;
                        }
                    </script>

                    <div class="pin-boxes">
                        <div class="pin-box" id="box1"></div>
                        <div class="pin-box" id="box2"></div>
                        <div class="pin-box" id="box3"></div>
                        <div class="pin-box" id="box4"></div>
                    </div>

                    <div class="keypad">
                        <button type="button" class="key-btn" onclick="addPin('1')">1</button>
                        <button type="button" class="key-btn" onclick="addPin('2')">2</button>
                        <button type="button" class="key-btn" onclick="addPin('3')">3</button>

                        <button type="button" class="key-btn" onclick="addPin('4')">4</button>
                        <button type="button" class="key-btn" onclick="addPin('5')">5</button>
                        <button type="button" class="key-btn" onclick="addPin('6')">6</button>

                        <button type="button" class="key-btn" onclick="addPin('7')">7</button>
                        <button type="button" class="key-btn" onclick="addPin('8')">8</button>
                        <button type="button" class="key-btn" onclick="addPin('9')">9</button>

                        <button type="button" class="key-btn" onclick="removePin()">⌫</button>
                        <button type="button" class="key-btn" onclick="addPin('0')">0</button>

                        <button type="button" id="powerBtn" class="key-btn" onclick="staffLogout()">⏻</button>
                    </div>

                    <button type="button" class="change-terminal-btn" onclick="resetTerminal()">
                        Başqa brendə keç
                    </button>

                    <div id="loginStatus" class="status-message"></div>

                </div>

            </div>

            <div class="footer">
                <span>© NovaPOS - 2026</span>
                <span>v1.0.0</span>
            </div>

        </div>

    </div>

    <script>
        const terminalInput = document.getElementById('terminal_code');
        const continueBtn = document.getElementById('continueBtn');
        const terminalStatus = document.getElementById('terminalStatus');

        const terminalStep = document.getElementById('terminalStep');
        const pinStep = document.getElementById('pinStep');

        const pinTitle = document.getElementById('pinTitle');
        const terminalRestaurantName = document.getElementById('terminalRestaurantName');

        const loginStatus = document.getElementById('loginStatus');

        const topRestaurantBadge = document.getElementById('topRestaurantBadge');
        const topRestaurantBadgeText = document.getElementById('topRestaurantBadgeText');

        let terminalValid = false;
        let terminalPayload = null;
        let pinCode = '';
        let terminalTimer = null;
        let logoutRunning = false;

        const savedTerminal = localStorage.getItem('novapos_terminal_code');

        window.addEventListener('load', function() {
            if (savedTerminal) {
                checkTerminal(savedTerminal, false, true);
            }
        });

        terminalInput.addEventListener('input', function() {
            const code = this.value.trim().toUpperCase();

            this.value = code;

            terminalValid = false;
            terminalPayload = null;

            continueBtn.disabled = true;
            terminalInput.style.borderColor = '#e3e7ef';
            terminalStatus.innerHTML = '';

            clearTimeout(terminalTimer);

            if (code.length < 3) {
                return;
            }

            terminalTimer = setTimeout(function() {
                checkTerminal(code, true, false);
            }, 350);
        });

        terminalInput.addEventListener('keydown', function(event) {
            if (event.key === 'Enter' && terminalValid) {
                openPinStep(terminalPayload, terminalInput.value.trim());
            }
        });

        continueBtn.addEventListener('click', function() {
            if (!terminalValid) {
                return;
            }

            openPinStep(terminalPayload, terminalInput.value.trim());
        });

        async function checkTerminal(code, showChecking = true, autoOpen = false) {
            if (!code) {
                setStatus(terminalStatus, 'error', 'Terminal kodunu daxil edin.');
                return;
            }

            if (showChecking) {
                setStatus(terminalStatus, 'checking', 'Terminal yoxlanılır...');
            }

            try {
                const response = await fetch("{{ route('staff.terminal.check') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        terminal_code: code
                    })
                });

                const data = await response.json();

                if (data.success === true) {
                    terminalValid = true;
                    terminalPayload = data;

                    continueBtn.disabled = false;
                    terminalInput.style.borderColor = '#20d6ad';

                    setStatus(terminalStatus, 'success', 'Terminal tapıldı');

                    if (autoOpen) {
                        openPinStep(data, code);
                    }

                    return;
                }

                terminalValid = false;
                terminalPayload = null;

                localStorage.removeItem('novapos_terminal_code');
                localStorage.removeItem('novapos_terminal_name');

                continueBtn.disabled = true;
                terminalInput.style.borderColor = '#ef4444';

                setStatus(terminalStatus, 'error', data.message || 'Terminal tapılmadı.');

            } catch (e) {
                terminalValid = false;
                terminalPayload = null;

                continueBtn.disabled = true;
                terminalInput.style.borderColor = '#ef4444';

                setStatus(terminalStatus, 'error', 'Yoxlama zamanı xəta baş verdi.');
            }
        }

        function openPinStep(data, code) {
            if (!data || data.success !== true) {
                return;
            }

            const restaurantName = data.restaurant_name || 'Restoran';
            const branchName = data.branch_name || '';

            const displayName =
                branchName && branchName !== 'Ümumi restoran' ?
                branchName :
                restaurantName;

            localStorage.setItem('novapos_terminal_code', code);
            localStorage.setItem('novapos_terminal_name', displayName);

            pinTitle.innerText = displayName;
            terminalRestaurantName.innerText = displayName;

            topRestaurantBadge.style.display = 'flex';
            topRestaurantBadgeText.innerText = displayName;

            terminalStep.style.display = 'none';
            pinStep.style.display = 'block';

            pinCode = '';
            renderPin();

            setTimeout(function() {
                window.focus();
            }, 100);
        }

        function addPin(number) {
            if (pinCode.length >= 4) {
                return;
            }

            pinCode += number;
            renderPin();

            if (pinCode.length === 4) {
                loginPin();
            }
        }

        function removePin() {
            pinCode = '';
            renderPin();
        }

        function renderPin() {
            for (let i = 1; i <= 4; i++) {
                const box = document.getElementById('box' + i);
                box.innerText = pinCode.length >= i ? '•' : '';
            }
        }

        async function loginPin() {
            if (pinCode.length !== 4) {
                setStatus(loginStatus, 'error', '4 rəqəmli PIN daxil edin.');
                return;
            }

            setStatus(loginStatus, 'checking', 'Giriş yoxlanılır...');

            const response = await fetch("{{ route('staff.pin-login') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    pin: pinCode
                })
            });

            const data = await response.json();

            if (data.success === true) {
                window.location.href = data.redirect;
                return;
            }

            pinCode = '';
            renderPin();

            setStatus(loginStatus, 'error', data.message || 'PIN kod düzgün deyil.');
        }

        async function resetTerminal() {
            localStorage.removeItem('novapos_terminal_code');
            localStorage.removeItem('novapos_terminal_name');

            await fetch("{{ route('staff.terminal.reset') }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                }
            });

            window.location.reload();
        }

        async function staffLogout() {
            if (logoutRunning) {
                return;
            }

            logoutRunning = true;

            const powerBtn = document.getElementById('powerBtn');

            if (powerBtn) {
                powerBtn.disabled = true;
                powerBtn.style.opacity = '.5';
                powerBtn.style.cursor = 'not-allowed';
            }

            pinCode = '';
            renderPin();

            setStatus(loginStatus, '', '');

            setTimeout(function() {
                if (powerBtn) {
                    powerBtn.disabled = false;
                    powerBtn.style.opacity = '1';
                    powerBtn.style.cursor = 'pointer';
                }

                logoutRunning = false;
            }, 250);
        }

        document.addEventListener('keydown', function(event) {
            if (pinStep.style.display === 'block') {
                if (/^[0-9]$/.test(event.key)) {
                    addPin(event.key);
                }

                if (event.key === 'Backspace') {
                    removePin();
                }
            }
        });

        function setStatus(element, type, message) {
            element.className = 'status-message ' + type;
            element.innerHTML = message || '';
        }


        /* ================= QR WAITER CALL ALERT - LOGIN SCREEN ================= */
        (function() {
            const alertBox = document.getElementById('loginWaiterAlert');
            const alertTitle = document.getElementById('loginWaiterTitle');
            const alertMeta = document.getElementById('loginWaiterMeta');

            let knownWaiterCallIds = new Set();
            let firstWaiterLoad = true;
            let loginWaiterLastReminderAt = 0;
            let loginWaiterLastActiveSignature = '';
            let loginWaiterReminderCount = 0;

            function escapeWaiterText(value) {
                return String(value ?? '')
                    .replaceAll('&', '&amp;')
                    .replaceAll('<', '&lt;')
                    .replaceAll('>', '&gt;')
                    .replaceAll('"', '&quot;')
                    .replaceAll("'", '&#039;');
            }

            function playLoginWaiterSignal() {
                try {
                    const AudioCtx = window.AudioContext || window.webkitAudioContext;
                    if (!AudioCtx) return;

                    const ctx = new AudioCtx();
                    const now = ctx.currentTime;

                    const compressor = ctx.createDynamicsCompressor();
                    compressor.threshold.setValueAtTime(-28, now);
                    compressor.knee.setValueAtTime(24, now);
                    compressor.ratio.setValueAtTime(5, now);
                    compressor.attack.setValueAtTime(0.012, now);
                    compressor.release.setValueAtTime(0.38, now);
                    compressor.connect(ctx.destination);

                    const master = ctx.createGain();
                    master.gain.setValueAtTime(0.0001, now);
                    master.gain.exponentialRampToValueAtTime(1.18, now + 0.09);
                    master.gain.setValueAtTime(1.18, now + 2.15);
                    master.gain.exponentialRampToValueAtTime(0.0001, now + 2.85);
                    master.connect(compressor);

                    const delay = ctx.createDelay(0.45);
                    delay.delayTime.setValueAtTime(0.18, now);

                    const feedback = ctx.createGain();
                    feedback.gain.setValueAtTime(0.18, now);

                    delay.connect(feedback);
                    feedback.connect(delay);
                    delay.connect(master);

                    function bell(start, duration, freq, type, volume) {
                        const osc = ctx.createOscillator();
                        const gain = ctx.createGain();
                        const startAt = now + start;
                        const endAt = startAt + duration;

                        osc.type = type || 'sine';
                        osc.frequency.setValueAtTime(freq, startAt);
                        osc.frequency.exponentialRampToValueAtTime(freq * 1.015, endAt);

                        gain.gain.setValueAtTime(0.0001, startAt);
                        gain.gain.exponentialRampToValueAtTime(volume, startAt + 0.055);
                        gain.gain.exponentialRampToValueAtTime(0.0001, endAt);

                        osc.connect(gain);
                        gain.connect(master);
                        gain.connect(delay);

                        osc.start(startAt);
                        osc.stop(endAt + 0.05);
                    }

                    // Premium hotel / reception notification tone
                    bell(0.00, 1.05, 523.25, 'sine', 0.55); // C5
                    bell(0.08, 1.22, 659.25, 'triangle', 0.35); // E5
                    bell(0.18, 1.34, 783.99, 'sine', 0.27); // G5

                    bell(1.10, 1.12, 587.33, 'sine', 0.55); // D5
                    bell(1.20, 1.35, 739.99, 'triangle', 0.34); // F#5
                    bell(1.34, 1.42, 880.00, 'sine', 0.26); // A5
                } catch (error) {
                    // Səs dəstəklənməsə panelin işləməsinə mane olmur.
                }
            }

            function playLoginWaiterReminderSeries() {
                playLoginWaiterSignal();
            }

            function renderLoginWaiterAlert(calls) {
                calls = Array.isArray(calls) ? calls : [];

                if (!alertBox || !alertTitle || !alertMeta) return;

                if (!calls.length) {
                    alertBox.classList.remove('show');
                    return;
                }

                const latest = calls[0] || {};
                const tableName = escapeWaiterText(latest.table_name || ('Masa #' + latest.table_id));
                const time = escapeWaiterText(latest.time || '');

                alertTitle.innerHTML = `🛎 ${tableName} ofisiant çağırır`;
                alertMeta.innerHTML = `<span class="login-waiter-count">${calls.length}</span> aktiv çağırış var${time ? ' · Saat: ' + time : ''}`;
                alertBox.classList.add('show');
            }

            async function loadLoginWaiterCalls() {
                try {
                    const waiterCallsUrl = new URL("{{ url('/staff/waiter-calls') }}", window.location.origin);
                    const savedTerminalCode = localStorage.getItem('novapos_terminal_code') || savedTerminalForView || '';

                    if (savedTerminalCode) {
                        waiterCallsUrl.searchParams.set('terminal_code', savedTerminalCode);
                    }

                    const response = await fetch(waiterCallsUrl.toString(), {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    if (!response.ok) return;

                    const data = await response.json();

                    if (!data.success) return;

                    const calls = Array.isArray(data.calls) ? data.calls : [];
                    const nowMs = Date.now();
                    const activeSignature = calls.map(function(call) {
                        return String(call.id);
                    }).join('|');

                    if (!calls.length) {
                        loginWaiterLastReminderAt = 0;
                        loginWaiterLastActiveSignature = '';
                        loginWaiterReminderCount = 0;
                    } else if (activeSignature !== loginWaiterLastActiveSignature) {
                        loginWaiterLastActiveSignature = activeSignature;
                        loginWaiterLastReminderAt = nowMs;
                        loginWaiterReminderCount = 0;
                    }

                    const currentIds = new Set(calls.map(function(call) {
                        return String(call.id);
                    }));

                    const hasNewCall = calls.some(function(call) {
                        return !knownWaiterCallIds.has(String(call.id));
                    });

                    renderLoginWaiterAlert(calls);

                    if (!firstWaiterLoad && hasNewCall && calls.length > 0) {
                        playLoginWaiterSignal();
                        loginWaiterLastReminderAt = nowMs;
                    }

                    if (firstWaiterLoad && calls.length > 0) {
                        playLoginWaiterSignal();
                        loginWaiterLastReminderAt = nowMs;
                    }

                    if (!firstWaiterLoad && calls.length > 0 && loginWaiterLastReminderAt > 0 && loginWaiterReminderCount < 3 && (nowMs - loginWaiterLastReminderAt) >= 60000) {
                        playLoginWaiterReminderSeries();
                        loginWaiterReminderCount++;
                        loginWaiterLastReminderAt = nowMs;
                    }

                    knownWaiterCallIds = currentIds;
                    firstWaiterLoad = false;
                } catch (error) {
                    // Login ekranında səssiz qalırıq ki giriş prosesini pozmasın.
                }
            }

            loadLoginWaiterCalls();
            setInterval(loadLoginWaiterCalls, 3000);
        })();
    </script>

</body>

</html>