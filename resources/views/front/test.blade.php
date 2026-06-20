<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ParsToday Mega Menu</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>

<header class="main-header">
    <div class="header-left">
        <div class="site-logo">
            <span class="logo-mark"></span>
            <span>ParsToday</span>
        </div>

        <span class="language-normal">English ▾</span>
    </div>

    <div class="header-right">
        <span>Home</span>
        <span>Radio</span>
        <i class="bi bi-search"></i>

        <button class="menu-open-btn" onclick="openMenu()">
            ☰
        </button>
    </div>
</header>

<div class="full-menu" id="fullMenu">

    <header class="menu-top">
        <div class="menu-logo">
            <span class="menu-logo-mark"></span>
            <span>ParsToday</span>
        </div>

        <div class="menu-actions">
            <div class="menu-lang">
                <i class="bi bi-caret-down-fill"></i>
                <span>English</span>
            </div>

            <button class="menu-search">
                <i class="bi bi-search"></i>
            </button>

            <button class="menu-close" onclick="closeMenu()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
    </header>

    <main class="menu-content">

        <section class="menu-column news-column">
            <h3>News</h3>

            <div class="news-links-grid">

                <div>
                    <div class="home-row">
                        <i class="bi bi-house-door-fill"></i>
                        <a href="#">home</a>
                    </div>

                    <a href="#" class="side-indent">west Asia</a>
                    <a href="#" class="side-indent">Iran</a>

                    <div class="sub-links">
                        <a href="#">Culture and Art</a>
                        <a href="#">Science and University</a>
                        <a href="#">Sports</a>
                        <a href="#">Politics and Diplomacy</a>
                        <a href="#">Economy and Trade</a>
                        <a href="#">Defense and Security</a>
                        <a href="#">society and Ecology</a>
                    </div>
                </div>

                <div>
                    <a href="#">Religion</a>
                    <a href="#">world</a>
                </div>

            </div>
        </section>

        <section class="menu-column">
            <h3>Call of islam</h3>

            <a href="#">programs</a>
            <a href="#">Issues & Events</a>
            <a href="#">Latest Episode</a>
        </section>

        <section class="menu-column">
            <h3>Pars Today</h3>

            <a href="#">About Us</a>
            <a href="#">Contact Us</a>
            <a href="#">RSS</a>
        </section>

        <section class="empty-col"></section>

    </main>

    <div class="menu-bottom">
        <div class="bottom-item">
            <i class="bi bi-radio"></i>
            <span>Radio</span>
        </div>

        <div class="bottom-item">
            <i class="bi bi-chat-square-dots-fill"></i>
            <span>Social</span>
        </div>
    </div>

    <div class="menu-scroll-line"></div>

</div>

<script>
    function openMenu(){
        document.getElementById("fullMenu").classList.add("active");
    }

    function closeMenu(){
        document.getElementById("fullMenu").classList.remove("active");
    }
</script>

</body>
</html>
