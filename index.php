<?php
include_once('./config/header.php');

?>

<body>
    <!-- ==================================Navigation====================================== -->
    <nav>
        <div class="container nav__container">
            <a href="index.php" class="logo">
                <!-- logo -->
                <h4>CARGO CARRIERS </h4>
            </a>
            <ul class="nav__menu">
                <li>
                    <a href="login.php" target="_blank" rel="noopener noreferrer">Login</a>
                </li>
            </ul>
        </div>
    </nav>
    <!-- ===============================Close-Navigation=============================== -->
    <header>
        <div class="container header__container">
            <div class="header__left">
                <h1>
                    WELCOME TO THE BEST CARGO CARRIERS AND LOGISTICS
                </h1>
                <p>
                    Logistics solutions you can rely on! We manage your complex logistics issues so you can focus on
                    building a stronger business, faster
                </p>
                <a href="login.php" class="btn btn-primary" target="_blank" rel="noopener noreferrer">Get Started</a>
            </div>
            <div class="header__right">
                <div class="header__right-image">
                    <img src="assets/home.png" alt="cargo-image" />
                </div>
            </div>
        </div>
    </header>
    <!-- ==================================close Header================================ -->
    <?php
    include_once('./config/footer.php');
    ?>
    <!-- script -->
    <script>
    // 1. change navBar background on scroll
    window.addEventListener("scroll", () => {
        document
            .querySelector("nav")
            .classList.toggle("window-scroll", window.scrollY > 0);
    });
    </script>

</body>

</html>