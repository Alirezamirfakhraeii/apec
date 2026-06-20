<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParsToday Navbar - Precision Build</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        /* --- استایل‌های سفارشی برای پیاده‌سازی دقیق --- */

        /* ۱. پس‌زمینه گرادینت با کدهای رنگی داده شده */
        .parstoday-header {
            background: linear-gradient(
                to bottom,
                #00BEF2 0%,  /* رنگ بالایی روشن */
                #0092D1 50%, /* رنگ میانی متوسط */
                #0067B0 100% /* رنگ پایینی تیره */
            );
            border-bottom: 2px solid #ffffff; /* خط سفید پایین */
            color: #ffffff;
            font-family: Arial, sans-serif; /* فونت استاندارد */
            padding: 8px 0; /* فاصله عمودی */
        }

        /* ۲. تنظیمات لوگوی اختصاصی */
        .navbar-brand-custom {
            display: flex;
            align-items: center;
            font-weight: bold;
            font-size: 1.25rem;
            color: #ffffff !important;
            text-decoration: none;
        }

        /* استایل آیکون لوگو */
        .navbar-brand-custom i {
            margin-right: 6px;
            font-size: 1.5rem;
        }

        /* ۳. تنظیمات منوی سمت راست (Home, Radio, Social) */
        .right-nav {
            display: flex;
            align-items: center;
            gap: 20px; /* فاصله بین آیتم‌ها */
        }

        .right-nav a {
            color: #ffffff;
            text-decoration: none;
            font-size: 0.95rem;
            display: flex;
            align-items: center;
            gap: 6px; /* فاصله آیکون تا متن */
        }

        /* ۴. تنظیمات منوی زبان (English) */
        .language-dropdown a {
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        /* ۵. تنظیمات دکمه منوی کشویی */
        .mobile-menu-toggle {
            background: none;
            border: none;
            color: #ffffff;
            font-size: 1.5rem;
            cursor: pointer;
        }

    </style>
</head>
<body>

<header class="parstoday-header">
    <div class="container-fluid">
        <div class="row align-items-center">

            <div class="col-6 col-md-3">
                <a href="#" class="navbar-brand-custom">
                    <i class="bi bi-briefcase-fill"></i>
                    <span>ParsToday</span>
                </a>
            </div>

            <div class="col-6 col-md-9 d-flex justify-content-end align-items-center gap-4">

                <div class="language-dropdown">
                    <a href="#">
                        <i class="bi bi-caret-down-fill small"></i> <span>English</span>
                    </a>
                </div>

                <nav class="right-nav d-none d-md-flex">
                    <a href="#">
                        <i class="bi bi-house-door-fill"></i>
                        <span>Home</span>
                    </a>
                    <a href="#">
                        <i class="bi bi-broadcast"></i>
                        <span>Radio</span>
                    </a>
                    <a href="#">
                        <i class="bi bi-chat-left-dots-fill"></i>
                        <span>Social</span>
                    </a>
                </nav>

                <button class="mobile-menu-toggle d-block d-md-none">
                    <i class="bi bi-list"></i>
                </button>
            </div>

        </div>
    </div>
</header>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
