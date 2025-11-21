<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo get_stylesheet_directory_uri(); ?>/style.css?id=1.53">
    <meta name="robots" content="noindex">


    <!-- Agrega jQuery y Slick.js -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/slick-carousel/slick/slick.css"/>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/jquery.slick/1.6.0/slick.min.js"></script>


    <!-- Tipografia -->
	<link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
	
    <?php wp_head(); ?>
</head>
<body>

<?php
if (post_password_required()) {
    // Si la página tiene contraseña y no se ha ingresado, muestra el formulario de contraseña
    echo get_the_password_form();
    exit;
}
?>



<header id="header">
    <?php if (is_active_sidebar('header-widget')) : ?>
        <?php dynamic_sidebar('header-widget'); ?>
    <?php endif; ?>
</header>



<script type="text/javascript">
    // Link de Orders
document.addEventListener("DOMContentLoaded", function () {
    const svgElement = document.querySelector("#header .contentHeaderNabButton .mainbuttonheadercontent svg");
    const linkElement = document.querySelector("#header .contentHeaderNabButton .mainbuttonheadercontent .buttonOrdersHeader a");

    if (svgElement && linkElement) {
        svgElement.addEventListener("click", function () {
            linkElement.click();
        });
    }
});
</script>
<script type="text/javascript">
    // Mostrar El menu
document.addEventListener("DOMContentLoaded", function () {
  const hamburger = document.getElementById("hamburgerheader");
  const menu = document.querySelector("#header #menu-main-menu");
  let menuOpened = false;

  if (hamburger && menu) {
    hamburger.addEventListener("click", function (event) {
      event.stopPropagation(); // Evita que el evento se propague al documento inmediatamente
      if (menu.style.display === "grid") {
        menu.style.display = "none";
      } else {
        menu.style.display = "grid";
        menuOpened = true;
      }
    });

    document.addEventListener("click", function (event) {
      if (menu.style.display === "grid" && menuOpened && !menu.contains(event.target) && event.target !== hamburger) {
        menu.style.display = "none";
      }
    });
  }
});
</script>

<script type="text/javascript">
    // Al escrolear muesta fixed
document.addEventListener("DOMContentLoaded", function () {
  const header = document.getElementById("header");
  let lastScrollTop = 0;

  window.addEventListener("scroll", function () {
    let scrollTop = window.pageYOffset || document.documentElement.scrollTop;

    if (scrollTop > 100) { // Cambia 100 al número de píxeles que deseas para activar el header fijo
      header.classList.add("header-fixed");
    } else {
      header.classList.remove("header-fixed");
    }

    lastScrollTop = scrollTop;
  });
});
</script>