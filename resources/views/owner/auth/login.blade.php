<!DOCTYPE html>
<html lang="az">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NovaPOS | Owner Login</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

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
            background: #fff;
            overflow: hidden;
            text-rendering: geometricPrecision;
            -webkit-font-smoothing: antialiased;
        }

        .login-wrapper {
            width: 100%;
            height: 100vh;
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
            background: #fff;
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
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
            font-weight: 800;
            line-height: 1.1;
            margin-bottom: 22px;
            min-height: 47px;
        }

        .welcome-text {
            color: rgba(255, 255, 255, .92);
            font-size: 16px;
            line-height: 1.85;
            font-weight: 500;
            max-width: 560px;
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
            font-weight: 700;
            z-index: 5;
            height: 34px;
            min-height: 34px;
        }

        .language select {
            border: none;
            background: transparent;
            outline: none;
            color: #071143;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: Arial, Helvetica, sans-serif;
        }

        .login-box {
            width: 100%;
            max-width: 340px;
            min-height: 430px;
            margin-top: -26px;
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
            font-weight: 800;
            line-height: 1;
            width: 142px;
            min-width: 142px;
        }

        .login-title {
            color: #071143;
            font-size: 22px;
            font-weight: 800;
            text-align: center;
            margin-bottom: 28px;
            min-height: 27px;
            line-height: 27px;
        }

        #brandStep {
            min-height: 190px;
        }

        #authStep {
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
            font-weight: 800;
            margin-bottom: 8px;
            min-height: 18px;
            line-height: 18px;
        }

        .input-wrap {
            position: relative;
            height: 50px;
            min-height: 50px;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #9ca3af;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .input-icon svg {
            width: 100%;
            height: 100%;
        }

        .input-action {
            position: absolute;
            right: 14px;
            top: 50%;
            transform: translateY(-50%);
            width: 20px;
            height: 20px;
            border: none;
            background: transparent;
            color: #9ca3af;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        .input-action svg {
            width: 100%;
            height: 100%;
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
            font-family: Arial, Helvetica, sans-serif;
            font-weight: 600;
            line-height: 50px;
        }

        .form-control::placeholder {
            color: #9aa3b4;
        }

        .form-control:focus {
            border-color: #20d6ad;
            box-shadow: 0 0 0 4px rgba(32, 214, 173, .12);
        }

        .form-control.with-icon {
            padding-left: 46px;
        }

        .form-control.with-action {
            padding-right: 46px;
        }

        .brand-locked {
            background: #eef5ff;
            border-color: #dbe7f6;
            font-weight: 700;
        }

        .form-control[readonly] {
            background: #f8fafc;
            color: #475569;
            cursor: not-allowed;
        }

        .divider {
            width: 100%;
            height: 1px;
            min-height: 1px;
            background: #e5e7eb;
            margin: 20px 0;
        }

        .status-message {
            height: 20px;
            min-height: 20px;
            margin-top: 8px;
            font-size: 13px;
            font-weight: 700;
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
            font-weight: 800;
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

        .login-btn:not(:disabled):hover {
            transform: translateY(-2px);
            box-shadow: 0 14px 30px rgba(32, 214, 173, .24);
        }

        .forgot-link {
            display: inline-block;
            margin: -2px 0 18px;
            color: #2563eb;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            min-height: 18px;
            line-height: 18px;
        }

        .forgot-link:hover {
            text-decoration: underline;
        }

        .back-btn {
            width: 100%;
            height: 36px;
            min-height: 36px;
            margin-top: 14px;
            border: none;
            background: transparent;
            color: #64748b;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            font-family: Arial, Helvetica, sans-serif;
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
                padding: 70px 22px 90px;
            }

            .welcome-title {
                font-size: 34px;
            }

            .welcome-text {
                font-size: 14px;
                line-height: 1.7;
            }

            .login-box {
                max-width: 390px;
                margin-top: 0;
            }
        }

        @media(max-width: 480px) {
            .left-side {
                min-height: 260px;
                padding: 30px 20px;
            }

            .welcome-title {
                font-size: 30px;
            }

            .welcome-text {
                font-size: 13px;
            }

            .brand-name {
                font-size: 28px;
                width: 130px;
                min-width: 130px;
            }

            .login-title {
                font-size: 21px;
            }

            .form-control,
            .login-btn {
                height: 48px;
                min-height: 48px;
                line-height: 48px;
            }

            .input-wrap {
                height: 48px;
                min-height: 48px;
            }

            .footer {
                font-size: 12px;
                gap: 10px;
            }
        }
    </style>
</head>

<body>

    <div class="login-wrapper">

        <div class="left-side">

            <div class="pattern">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>

            <div class="welcome-content">

                <div class="leaf-logo left-logo"></div>

                <h1 class="welcome-title">
                    Xoş gəldiniz
                </h1>

                <p class="welcome-text">
                    NovaPOS sistemi ilə restoranınızı, filiallarınızı,
                    satışlarınızı, əməkdaşlarınızı, anbarınızı və maliyyə
                    axınınızı istənilən yerdən rahat idarə edin.
                </p>

            </div>

        </div>

        <div class="right-side">

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

                <h2 class="login-title">
                    Daxil ol
                </h2>

                <div id="brandStep">

                    <div class="form-group">

                        <label>
                            Brend adı
                        </label>

                        <div class="input-wrap">

                            <input
                                id="brandInput"
                                type="search"
                                name="np_brand_{{ time() }}"
                                class="form-control"
                                placeholder="Brendin adını yaz"
                                autocomplete="off"
                                readonly
                                onfocus="this.removeAttribute('readonly');">

                        </div>

                        <div id="brandStatus" class="status-message"></div>

                    </div>

                    <button id="continueBtn" class="login-btn" disabled>
                        Davam et
                    </button>

                </div>

                <div id="authStep" style="display:none;">

                    <div class="form-group">

                        <label>
                            Brend adı
                        </label>

                        <div class="input-wrap">

                            <input
                                id="lockedBrandInput"
                                type="text"
                                class="form-control brand-locked with-action"
                                readonly>

                            <span class="input-action" style="color:#16a34a;">✓</span>

                        </div>

                    </div>

                    <div class="divider"></div>

                    <div class="form-group">

                        <label>
                            E-mail
                        </label>

                        <div class="input-wrap">

                            <span class="input-icon">

                                <svg viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M4 6.5A2.5 2.5 0 0 1 6.5 4h11A2.5 2.5 0 0 1 20 6.5v11a2.5 2.5 0 0 1-2.5 2.5h-11A2.5 2.5 0 0 1 4 17.5v-11Z"
                                        stroke="currentColor"
                                        stroke-width="1.8" />

                                    <path
                                        d="m6.5 7.5 5.5 4 5.5-4"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round"
                                        stroke-linejoin="round" />
                                </svg>

                            </span>

                            <input
                                id="emailInput"
                                type="text"
                                name="np_mail_{{ time() }}"
                                class="form-control with-icon"
                                readonly
                                autocomplete="off">

                        </div>

                    </div>

                    <div class="form-group">

                        <label>
                            Parol
                        </label>

                        <div class="input-wrap">

                            <span class="input-icon">

                                <svg viewBox="0 0 24 24" fill="none">
                                    <rect
                                        x="5"
                                        y="10"
                                        width="14"
                                        height="10"
                                        rx="2.5"
                                        stroke="currentColor"
                                        stroke-width="1.8" />

                                    <path
                                        d="M8 10V7.8A4 4 0 0 1 12 4a4 4 0 0 1 4 3.8V10"
                                        stroke="currentColor"
                                        stroke-width="1.8"
                                        stroke-linecap="round" />
                                </svg>

                            </span>

                            <input
                                id="codeInput"
                                type="password"
                                name="np_secret_{{ time() }}"
                                class="form-control with-icon with-action"
                                placeholder="Parol"
                                autocomplete="new-password"
                                readonly
                                onfocus="this.removeAttribute('readonly');">

                            <button
                                type="button"
                                class="input-action"
                                id="togglePassword">

                                <svg viewBox="0 0 24 24" fill="none">
                                    <path
                                        d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6Z"
                                        stroke="currentColor"
                                        stroke-width="1.8" />

                                    <circle
                                        cx="12"
                                        cy="12"
                                        r="3"
                                        stroke="currentColor"
                                        stroke-width="1.8" />
                                </svg>

                            </button>

                        </div>

                        <div id="loginStatus" class="status-message"></div>

                    </div>

                    <a href="#" class="forgot-link">
                        Şifrəni unutmusunuz?
                    </a>

                    <button id="submitLoginBtn" class="login-btn">
                        Giriş et
                    </button>

                    <button id="backBtn" class="back-btn">
                        Geri qayıt
                    </button>

                </div>

            </div>

            <div class="footer">
                <span>© NovaPOS - 2026</span>
                <span>v1.0.0</span>
            </div>

        </div>

    </div>

    <script>
        const brandInput = document.getElementById('brandInput');
        const continueBtn = document.getElementById('continueBtn');
        const brandStatus = document.getElementById('brandStatus');

        const brandStep = document.getElementById('brandStep');
        const authStep = document.getElementById('authStep');

        const emailInput = document.getElementById('emailInput');
        const codeInput = document.getElementById('codeInput');
        const lockedBrandInput = document.getElementById('lockedBrandInput');

        const submitLoginBtn = document.getElementById('submitLoginBtn');
        const loginStatus = document.getElementById('loginStatus');

        const togglePassword = document.getElementById('togglePassword');
        const backBtn = document.getElementById('backBtn');

        let brandExists = false;
        let restaurantEmail = '';
        let restaurantName = '';
        let brandTimer = null;

        window.addEventListener('load', function() {
            brandInput.value = '';
            codeInput.value = '';
        });

        brandInput.addEventListener('input', function() {
            const brandName = this.value.trim();

            brandExists = false;
            restaurantEmail = '';
            restaurantName = '';

            continueBtn.disabled = true;
            brandStatus.innerHTML = '';
            brandStatus.className = 'status-message';
            brandInput.style.borderColor = '#e3e7ef';

            clearTimeout(brandTimer);

            if (brandName.length < 2) {
                return;
            }

            brandStatus.className = 'status-message checking';
            brandStatus.innerHTML = 'Brend yoxlanılır...';

            brandTimer = setTimeout(function() {
                fetch("{{ route('owner.check-brand') }}", {
                        method: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            brand_name: brandName
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.exists === true) {
                            brandExists = true;
                            restaurantEmail = data.restaurant_email || '';
                            restaurantName = data.restaurant_name || brandName;

                            continueBtn.disabled = false;
                            brandInput.style.borderColor = '#20d6ad';

                            brandStatus.className = 'status-message success';
                            brandStatus.innerHTML = 'Brend tapıldı';
                        } else {
                            brandExists = false;
                            continueBtn.disabled = true;
                            brandInput.style.borderColor = '#ef4444';

                            brandStatus.className = 'status-message error';
                            brandStatus.innerHTML = 'Brend tapılmadı';
                        }
                    })
                    .catch(() => {
                        brandExists = false;
                        continueBtn.disabled = true;
                        brandInput.style.borderColor = '#ef4444';

                        brandStatus.className = 'status-message error';
                        brandStatus.innerHTML = 'Brend tapılmadı';
                    });
            }, 350);
        });

        continueBtn.addEventListener('click', function() {
            if (brandExists !== true) {
                return;
            }

            brandStep.style.display = 'none';
            authStep.style.display = 'block';

            lockedBrandInput.value = restaurantName;
            emailInput.value = restaurantEmail;
            codeInput.value = '';
            loginStatus.innerHTML = '';
            loginStatus.className = 'status-message';

            setTimeout(function() {
                codeInput.value = '';
            }, 100);
        });

        backBtn.addEventListener('click', function() {
            authStep.style.display = 'none';
            brandStep.style.display = 'block';

            brandInput.value = '';
            brandInput.removeAttribute('readonly');
            brandInput.style.borderColor = '#e3e7ef';

            brandStatus.innerHTML = '';
            brandStatus.className = 'status-message';

            continueBtn.disabled = true;

            codeInput.value = '';
            loginStatus.innerHTML = '';
            loginStatus.className = 'status-message';

            brandExists = false;
            restaurantEmail = '';
            restaurantName = '';
        });

        togglePassword.addEventListener('click', function() {
            codeInput.type = codeInput.type === 'password' ? 'text' : 'password';
        });

        submitLoginBtn.addEventListener('click', function() {
            fetch("{{ route('owner.login-submit') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        email: emailInput.value,
                        code: codeInput.value
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success === true) {
                        window.location.href = data.redirect;
                        return;
                    }

                    loginStatus.className = 'status-message error';
                    loginStatus.innerHTML = data.message || 'Giriş mümkün olmadı.';
                })
                .catch(() => {
                    loginStatus.className = 'status-message error';
                    loginStatus.innerHTML = 'Giriş zamanı xəta baş verdi.';
                });
        });
    </script>

</body>

</html>