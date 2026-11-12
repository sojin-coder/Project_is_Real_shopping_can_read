<!DOCTYPE html>
<html lang="km">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up — Electro Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Kantumruy Pro', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 30px 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Decorative Circles */
        body::before,
        body::after {
            content: "";
            position: absolute;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            pointer-events: none;
        }

        body::before {
            width: 500px;
            height: 500px;
            top: -200px;
            right: -150px;
        }

        body::after {
            width: 350px;
            height: 350px;
            bottom: -150px;
            left: -100px;
        }

        /* Register Box */
        .register-box {
            background: #fff;
            width: 100%;
            max-width: 480px;
            padding: 40px 40px 30px;
            border-radius: 20px;
            box-shadow: 0 25px 70px rgba(0, 0, 0, 0.35);
            position: relative;
            z-index: 10;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(30px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Logo */
        .register-logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .register-logo .icon-box {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
            margin: 0 auto 12px;
            box-shadow: 0 10px 25px rgba(37, 99, 235, 0.35);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50%      { transform: scale(1.05); }
        }

        .register-logo h1 {
            color: #1e3a8a;
            font-size: 22px;
            font-weight: 700;
        }

        .register-logo h1 span {
            color: #2563eb;
        }

        .register-logo p {
            color: #94a3b8;
            font-size: 13px;
            margin-top: 4px;
        }

        /* Title */
        .register-title {
            text-align: center;
            margin-bottom: 22px;
        }

        .register-title h2 {
            color: #1e3a8a;
            font-size: 18px;
            font-weight: 600;
        }

        /* Alert Boxes */
        .alert {
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            font-size: 13px;
            font-weight: 600;
            display: flex;
            align-items: flex-start;
            gap: 10px;
            animation: shake 0.4s;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25%      { transform: translateX(-5px); }
            75%      { transform: translateX(5px); }
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border-left: 4px solid #dc2626;
        }

        .alert-error ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .alert-error li {
            padding: 2px 0;
        }

        .alert-success {
            background: #dcfce7;
            color: #166534;
            border-left: 4px solid #16a34a;
        }

        /* Form Group */
        .form-group {
            margin-bottom: 18px;
            position: relative;
        }

        .form-group label {
            display: block;
            color: #1e3a8a;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 7px;
        }

        .form-group .input-wrap {
            position: relative;
        }

        .form-group .input-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 15px;
            pointer-events: none;
            transition: color 0.2s;
        }

        .form-group input {
            width: 100%;
            padding: 13px 45px 13px 44px;
            border: 2px solid #e2e8f0;
            border-radius: 12px;
            font-size: 14px;
            font-family: inherit;
            color: #334155;
            background: #f8fafc;
            transition: all 0.25s ease;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, 0.12);
        }

        .form-group input:focus + .input-icon {
            color: #2563eb;
        }

        .form-group input::placeholder {
            color: #cbd5e1;
        }

        /* Password Toggle */
        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            font-size: 15px;
            cursor: pointer;
            padding: 4px;
            transition: color 0.2s;
        }

        .toggle-password:hover {
            color: #2563eb;
        }

        /* Password Strength Meter */
        .password-strength {
            margin-top: 8px;
            display: none;
        }

        .password-strength.show {
            display: block;
        }

        .strength-bar {
            height: 5px;
            background: #e2e8f0;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 5px;
        }

        .strength-fill {
            height: 100%;
            width: 0%;
            border-radius: 10px;
            transition: all 0.3s ease;
        }

        .strength-text {
            font-size: 11px;
            font-weight: 600;
            color: #94a3b8;
        }

        /* Terms */
        .terms {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            font-size: 13px;
            color: #475569;
            margin-bottom: 22px;
            line-height: 1.5;
        }

        .terms input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: #2563eb;
            cursor: pointer;
            margin-top: 2px;
            flex-shrink: 0;
        }

        .terms a {
            color: #2563eb;
            font-weight: 600;
            text-decoration: none;
        }

        .terms a:hover {
            text-decoration: underline;
        }

        /* Submit Button */
        .btn-register {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #2563eb, #1e40af);
            color: #fff;
            border: none;
            border-radius: 12px;
            font-size: 15px;
            font-weight: 700;
            font-family: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 8px 22px rgba(37, 99, 235, 0.35);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-register:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 30px rgba(37, 99, 235, 0.5);
        }

        /* Divider */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0 18px;
            color: #94a3b8;
            font-size: 12px;
        }

        .divider::before,
        .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: #e2e8f0;
        }

        /* Login Link */
        .login-link {
            text-align: center;
            font-size: 14px;
            color: #64748b;
        }

        .login-link a {
            color: #2563eb;
            font-weight: 700;
            text-decoration: none;
            transition: color 0.2s;
        }

        .login-link a:hover {
            color: #1e40af;
            text-decoration: underline;
        }

        /* Footer */
        .register-footer {
            text-align: center;
            color: #94a3b8;
            font-size: 11px;
            margin-top: 15px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .register-box {
                padding: 30px 22px 25px;
                border-radius: 16px;
            }

            .register-logo h1 {
                font-size: 19px;
            }

            .register-logo .icon-box {
                width: 60px;
                height: 60px;
                font-size: 28px;
            }
        }
    </style>
</head>
<body>

    <div class="register-box">

        <!-- LOGO -->
        <div class="register-logo">
            <div class="icon-box">⚡</div>
            <h1>Electro<span>Admin</span></h1>
            <p>Electronics Shopping Management</p>
        </div>

        <!-- TITLE -->
        <div class="register-title">
            <h2>📝 បង្កើតគណនីថ្មី</h2>
        </div>

        <!-- ERRORS -->
        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert alert-error">
                <i class="fa-solid fa-circle-exclamation"></i>
                <ul>
                    <?php foreach ($_SESSION['errors'] as $err): ?>
                        <li>• <?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <!-- SUCCESS -->
        <?php if (!empty($_SESSION['success'])): ?>
            <div class="alert alert-success">
                <i class="fa-solid fa-circle-check"></i>
                <?= htmlspecialchars($_SESSION['success']) ?>
            </div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <!-- REGISTER FORM -->
        <form method="POST" action="<?= BASE_URL ?>/register" autocomplete="off">

            <!-- Username -->
            <div class="form-group">
                <label>ឈ្មោះអ្នកប្រើ <span style="color:#dc2626">*</span></label>
                <div class="input-wrap">
                    <input 
                        type="text" 
                        name="username" 
                        placeholder="ឧ. admin"
                        value="<?= htmlspecialchars($_SESSION['old']['username'] ?? '') ?>"
                        required 
                        minlength="3"
                        autofocus>
                    <i class="fa-solid fa-user input-icon"></i>
                </div>
            </div>

            <!-- Email -->
            <div class="form-group">
                <label>អ៊ីមែល <span style="color:#dc2626">*</span></label>
                <div class="input-wrap">
                    <input 
                        type="email" 
                        name="email" 
                        placeholder="admin@electro.com"
                        value="<?= htmlspecialchars($_SESSION['old']['email'] ?? '') ?>"
                        required>
                    <i class="fa-solid fa-envelope input-icon"></i>
                </div>
            </div>

            <!-- Password -->
            <div class="form-group">
                <label>លេខសម្ងាត់ <span style="color:#dc2626">*</span></label>
                <div class="input-wrap">
                    <input 
                        type="password" 
                        name="password" 
                        id="passwordInput"
                        placeholder="យ៉ាងហោច 6 តួអក្សរ"
                        required
                        minlength="6">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <button type="button" class="toggle-password" data-target="passwordInput">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>

                <!-- Strength Meter -->
                <div class="password-strength" id="strengthMeter">
                    <div class="strength-bar">
                        <div class="strength-fill" id="strengthFill"></div>
                    </div>
                    <span class="strength-text" id="strengthText"></span>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label>បញ្ជាក់លេខសម្ងាត់ <span style="color:#dc2626">*</span></label>
                <div class="input-wrap">
                    <input 
                        type="password" 
                        name="confirm_password" 
                        id="confirmInput"
                        placeholder="បញ្ចូលលេខសម្ងាត់ម្តងទៀត"
                        required
                        minlength="6">
                    <i class="fa-solid fa-lock input-icon"></i>
                    <button type="button" class="toggle-password" data-target="confirmInput">
                        <i class="fa-solid fa-eye"></i>
                    </button>
                </div>
            </div>

            <!-- Terms -->
            <label class="terms">
                <input type="checkbox" name="terms" required>
                <span>
                    ខ្ញុំយល់ព្រមតាម 
                    <a href="#">លក្ខខណ្ឌប្រើប្រាស់</a> 
                    និង 
                    <a href="#">គោលការណ៍ភាពឯកជន</a>
                </span>
            </label>

            <!-- Submit -->
            <button type="submit" class="btn-register">
                <i class="fa-solid fa-user-plus"></i>
                បង្កើតគណនី
            </button>

        </form>

        <!-- DIVIDER -->
        <div class="divider">ឬ</div>

        <!-- LOGIN LINK -->
        <div class="login-link">
            មានគណនីរួចហើយ? 
            <a href="<?= BASE_URL ?>/login">ចូលប្រើប្រាស់</a>
        </div>

        <!-- FOOTER -->
        <div class="register-footer">
            © 2026 ElectroAdmin — v1.0.0
        </div>

    </div>

    <script>
        // ═══════════════════════════════════════════════
        // TOGGLE PASSWORD VISIBILITY
        // ═══════════════════════════════════════════════
        document.querySelectorAll('.toggle-password').forEach(btn => {
            btn.addEventListener('click', function () {
                const targetId = this.dataset.target;
                const input = document.getElementById(targetId);
                const icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.className = 'fa-solid fa-eye-slash';
                } else {
                    input.type = 'password';
                    icon.className = 'fa-solid fa-eye';
                }
            });
        });

        // ═══════════════════════════════════════════════
        // PASSWORD STRENGTH METER
        // ═══════════════════════════════════════════════
        const passwordInput = document.getElementById('passwordInput');
        const strengthMeter = document.getElementById('strengthMeter');
        const strengthFill  = document.getElementById('strengthFill');
        const strengthText  = document.getElementById('strengthText');

        if (passwordInput) {
            passwordInput.addEventListener('input', function () {
                const val = this.value;

                if (val.length === 0) {
                    strengthMeter.classList.remove('show');
                    return;
                }

                strengthMeter.classList.add('show');

                let strength = 0;

                // Length
                if (val.length >= 6)  strength++;
                if (val.length >= 10) strength++;
                // Lowercase
                if (/[a-z]/.test(val)) strength++;
                // Uppercase
                if (/[A-Z]/.test(val)) strength++;
                // Number
                if (/[0-9]/.test(val)) strength++;
                // Symbol
                if (/[^a-zA-Z0-9]/.test(val)) strength++;

                let percent = 0;
                let color = '';
                let label = '';

                if (strength <= 2) {
                    percent = 33;
                    color = '#dc2626';
                    label = '🔴 ខ្សោយ';
                } else if (strength <= 4) {
                    percent = 66;
                    color = '#f59e0b';
                    label = '🟡 មធ្យម';
                } else {
                    percent = 100;
                    color = '#16a34a';
                    label = '🟢 ខ្លាំង';
                }

                strengthFill.style.width = percent + '%';
                strengthFill.style.background = color;
                strengthText.textContent = label;
                strengthText.style.color = color;
            });
        }

        // ═══════════════════════════════════════════════
        // CONFIRM PASSWORD MATCH
        // ═══════════════════════════════════════════════
        const confirmInput = document.getElementById('confirmInput');

        if (confirmInput && passwordInput) {
            confirmInput.addEventListener('input', function () {
                if (this.value === '') {
                    this.style.borderColor = '#e2e8f0';
                    return;
                }
                if (this.value === passwordInput.value) {
                    this.style.borderColor = '#16a34a';
                } else {
                    this.style.borderColor = '#dc2626';
                }
            });
        }
    </script>

</body>
</html>