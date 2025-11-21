<?php
/*
Template Name: FAQ
*/
?>

<?php get_template_part('header', 'custom'); ?>


<main id="main-content">
    <div class="container GalleryContentSubPage">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		    <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		   
            <section class="HeroMaterialsPage HeroSubPage">
                <?php  while( have_rows('hero') ) : the_row(); ?>
                    <picture>
                        <source media="(min-width: 651px)" srcset="<?php echo get_sub_field('image_desktop_hero') ?>">
                        <source media="(max-width: 650px)" srcset="<?php echo get_sub_field('image_mobile_hero') ?>">
                        <img loading="eager" class="heroimg" src="<?php echo get_sub_field('image_desktop_hero') ?>" alt="Hero Materials HPI.">
                    </picture>
                    <div class="contentHero">
                        <h1><?php echo get_sub_field('title_hero'); ?></h1>
                    </div>
                <?php  endwhile; ?>
            </section>



		    <section class="Gallery">
		    	<div id="gallery"></div>
			    <button id="loadMore">Load More</button>
		    </section>


            <!-- Modal -->
            <div id="darkbackground"></div>
            <div id="imageModal" class="modal">
                <div id="buttonslinksGallery"></div>
                <span class="close">&times;</span>
                <img id="modalImage" class="modal-content" draggable="false">
                <button id="prevImage">&#10094;</button>
                <button id="nextImage">&#10095;</button>
            </div>

		    </article>
		<?php endwhile; endif; ?>
    </div>
</main>

<script>
    let galleryData = [
        <?php
        $data = [];
        while( have_rows('gallery') ) : the_row();
            $image = get_sub_field('image');
            $links = [];

            if ( have_rows('links') ) :
                while( have_rows('links') ) : the_row();
                    $link = get_sub_field('link');
                    $links[] = [
                        'url' => $link['url'],
                        'text' => $link['title']
                    ];
                endwhile;
            endif;

            $data[] = json_encode([
                'image' => $image,
                'links' => $links
            ]);
        endwhile;

        echo implode(",", $data);
        ?>
    ];

    let gallery = document.getElementById("gallery");
    let loadMoreButton = document.getElementById("loadMore");
    let modal = document.getElementById("imageModal");
    let darkbackground = document.getElementById("darkbackground");
    let modalImage = document.getElementById("modalImage");
    let prevButton = document.getElementById("prevImage");
    let nextButton = document.getElementById("nextImage");
    let closeModal = document.querySelector(".close");

    let loadInitial = 40;
    let loadPerClick = 40;
    let index = 0;
    let currentIndex = 0;
    let startX = 0;
    let endX = 0;

    function loadImages(count) {
        for (let i = 0; i < count; i++) {
            if (index >= galleryData.length) {
                loadMoreButton.style.display = "none";
                return;
            }
            let img = document.createElement("img");
            img.src = galleryData[index].image;
            img.dataset.index = index;
            img.addEventListener("click", openModal);
            gallery.appendChild(img);
            index++;
        }
    }

    function openModal(event) {
        currentIndex = parseInt(event.target.dataset.index);
        modal.style.display = "grid";
        darkbackground.style.display = "block";

        updateModalContent(currentIndex);
    }

    function closeModalFunction() {
        darkbackground.style.display = "none";
        modal.style.display = "none";
    }

    function changeImage(direction) {
        currentIndex += direction;

        if (currentIndex >= index) {
            loadImages(loadPerClick);
        }

        if (currentIndex < 0) {
            currentIndex = 0;
        } else if (currentIndex >= galleryData.length) {
            currentIndex = galleryData.length - 1;
        }

        updateModalContent(currentIndex);
    }


    function updateModalContent(index) {
        modalImage.classList.remove("fade-in");
        void modalImage.offsetWidth; // reinicia animación CSS
        modalImage.classList.add("fade-in");

        modalImage.src = galleryData[index].image;

        const linksContainer = document.getElementById("buttonslinksGallery");
        linksContainer.innerHTML = "";

        const links = galleryData[index].links;
        links.forEach(link => {
            const a = document.createElement("a");
            a.href = link.url;
            a.textContent = link.text;
            a.target = "_blank";
            a.className = "gallery-link-button";
            linksContainer.appendChild(a);
        });
    }



    function handleGesture() {
        const swipeDistance = endX - startX;

        if (Math.abs(swipeDistance) > 50) { // mínimo 50px para considerar swipe
            if (swipeDistance < 0) {
                changeImage(1); // swipe left → next
            } else {
                changeImage(-1); // swipe right → prev
            }
        }
    }

    // Para dispositivos táctiles
    modal.addEventListener("touchstart", (e) => {
        startX = e.touches[0].clientX;
    });
    modal.addEventListener("touchend", (e) => {
        endX = e.changedTouches[0].clientX;
        handleGesture();
    });

    // Para mouse (drag izquierdo o derecho)
    modal.addEventListener("mousedown", (e) => {
        startX = e.clientX;
    });
    modal.addEventListener("mouseup", (e) => {
        endX = e.clientX;
        handleGesture();
    });




    loadImages(loadInitial);
    loadMoreButton.addEventListener("click", () => loadImages(loadPerClick));
    prevButton.addEventListener("click", () => changeImage(-1));
    nextButton.addEventListener("click", () => changeImage(1));
    closeModal.addEventListener("click", closeModalFunction);

    window.addEventListener("click", (e) => {
        if (e.target === modal) {
            closeModalFunction();
        }
    });
</script>


<?php get_template_part('footer', 'custom'); ?>
