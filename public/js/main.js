document.addEventListener("DOMContentLoaded", function () {
    const destinationSwiper = document.querySelector(".destination-swiper");

    if (destinationSwiper) {
        new Swiper(".destination-swiper", {
            slidesPerView: 3,
            spaceBetween: 30,
            loop: true,

            autoplay: {
                delay: 2500,
                disableOnInteraction: false,
            },

            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },

            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },

            breakpoints: {
                320: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                576: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 30,
                },
            },
        });
    }
});