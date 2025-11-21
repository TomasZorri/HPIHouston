<?php
/*
Template Name: Services
*/
?>

<?php get_template_part('header', 'custom'); ?>

<main id="main-content">
    <div class="SingleServicesPage">
    <?php if (have_posts()) : while (have_posts()) : the_post(); 
        $galeria_ids = get_post_meta(get_the_ID(), '_servicio_galeria_ids', true); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
            

            <section class="HeroSingleServicesPage">
                <h1><?php the_title(); ?></h1>
                <div>
                    <a href="/services">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 18.14 16.81">
                            <g> 
                              <line style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 2.25px;" x1="2.94" y1="8.4" x2="18.14" y2="8.4"/>
                              <polyline style="fill: none;stroke: #fff;stroke-miterlimit: 10;stroke-width: 2.25px;" points="9.2 16.01 1.59 8.4 9.2 .8"/>
                            </g>
                        </svg>
                        <span>SERVICES</span>
                    </a>
                </div>
            </section>


                <div class="gallery">
                    <div class="contenido">
                        <?php the_content(); ?>
                    </div>
                    <?php if (!empty($galeria_ids) && is_array($galeria_ids)) : ?>

                        <?php
                        foreach ($galeria_ids as $id) :
                            $imagen_url = wp_get_attachment_image_src($id, 'full');
                            if ($imagen_url) :
                                ?>
                                <img src="<?php echo esc_url($imagen_url[0]); ?>" alt="<?php echo esc_attr(get_post_meta($id, '_wp_attachment_image_alt', true)); ?>" loading="lazy">
                                <?php
                            endif;
                        endforeach;
                        ?>
                    <?php endif; ?>
                </div>


            <!-- Modal -->
            <div id="darkbackground"></div>
            <div id="imageModal" class="modal">
                <span class="close">&times;</span>
                <img id="modalImage" class="modal-content" draggable="false">
                <button id="prevImage">&#10094;</button>
                <button id="nextImage">&#10095;</button>
            </div>

            
        </article>
    </div>
    <?php endwhile; endif; ?>
</main>


<script type="text/javascript">
document.addEventListener('DOMContentLoaded', () => {
    const galleryImages = document.querySelectorAll(".SingleServicesPage .gallery img");
    const modal = document.getElementById("imageModal");
    const darkbackground = document.getElementById("darkbackground");
    const modalImage = document.getElementById("modalImage");
    const prevButton = document.getElementById("prevImage");
    const nextButton = document.getElementById("nextImage");
    const closeModal = document.querySelector(".close");

    let currentIndex = 0;
    let startX = 0;
    let endX = 0;
    let imageList = [];

    // Cargar las imágenes directamente del DOM
    galleryImages.forEach((img, index) => {
        imageList.push(img.src);
        img.dataset.index = index;
        img.addEventListener("click", openModal);
    });

    function openModal(e) {
        currentIndex = parseInt(e.target.dataset.index);
        showModal();
    }

    function showModal() {
        modal.style.display = "flex";
        darkbackground.style.display = "block";
        updateModalContent(currentIndex);
    }

    function closeModalFunction() {
        darkbackground.style.display = "none";
        modal.style.display = "none";
    }

    function updateModalContent(index) {
        modalImage.classList.remove("fade-in");
        void modalImage.offsetWidth;
        modalImage.classList.add("fade-in");
        modalImage.src = imageList[index];
    }

    function changeImage(direction) {
        currentIndex += direction;

        if (currentIndex < 0) {
            currentIndex = 0;
            return;
        }
        if (currentIndex >= imageList.length) {
            currentIndex = imageList.length - 1;
            return;
        }

        updateModalContent(currentIndex);
    }

    // Gestos táctiles
    modal.addEventListener("touchstart", (e) => {
        startX = e.touches[0].clientX;
    });

    modal.addEventListener("touchend", (e) => {
        endX = e.changedTouches[0].clientX;
        handleSwipe();
    });

    // Gestos con mouse
    modal.addEventListener("mousedown", (e) => {
        startX = e.clientX;
    });

    modal.addEventListener("mouseup", (e) => {
        endX = e.clientX;
        handleSwipe();
    });

    function handleSwipe() {
        const diff = endX - startX;
        if (Math.abs(diff) > 50) {
            if (diff > 0) {
                changeImage(-1);
            } else {
                changeImage(1);
            }
        }
    }

    prevButton.addEventListener("click", () => changeImage(-1));
    nextButton.addEventListener("click", () => changeImage(1));
    closeModal.addEventListener("click", closeModalFunction);

    // Cierre al hacer clic fuera
    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            closeModalFunction();
        }
    });
});
</script>


<?php get_template_part('footer', 'custom'); ?>