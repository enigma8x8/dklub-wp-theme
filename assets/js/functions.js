
document.addEventListener("DOMContentLoaded", function () {

    /* Header on scroll */

    const masthead = document.getElementById("masthead");

    window.addEventListener("scroll", function () {
        if (window.scrollY > 200) {
            masthead.classList.add("on-scroll");
        } else {
            masthead.classList.remove("on-scroll");
        }
    });

    /* Mobile toggle btn */

    document.querySelector('#masthead .menu-toggle').addEventListener('click', function (e) {
        document.documentElement.classList.toggle('mobile-nav-open');
        this.classList.toggle('opened');

        e.preventDefault();
    });

    /* Posts items swiper */

    document.querySelectorAll('.posts-swiper:not(.single) .swiper-holder').forEach(holder => {
        const swiperContainer = holder.querySelector('.swiper');

        if (swiperContainer) {
            new Swiper(swiperContainer, {
                slidesPerView: 4,
                spaceBetween: 20,
                loop: false,
                navigation: {
                    nextEl: holder.querySelector(".swiper-button-next"),
                    prevEl: holder.querySelector(".swiper-button-prev"),
                },
                breakpoints: {
                    0: {
                        slidesPerView: 1.1,
                    },

                    576: {
                        slidesPerView: 1.5,
                    },

                    610: {
                        slidesPerView: 2.2,
                    },

                    992: {
                        slidesPerView: 3,
                        spaceBetween: 33,
                    },
                
                    1300: {
                        slidesPerView: 4,
                    }
                }
            });
        }
    });    


    /* Sidebar single posts swiper */

    document.querySelectorAll('.posts-swiper.single .swiper-holder').forEach(holder => {
        const swiperContainer = holder.querySelector('.swiper');

        if (swiperContainer) {
            new Swiper(swiperContainer, {
                slidesPerView: 1,
                spaceBetween: 15,
                loop: true,
                navigation: {
                    nextEl: holder.querySelector(".swiper-button-next"),
                    prevEl: holder.querySelector(".swiper-button-prev"),
                },
            });
        }
    });  
    
    /* Single post inline gallery swiper */


    document.querySelectorAll('.inline-gallery-swiper .swiper-holder').forEach(holder => {
        const swiperContainer = holder.querySelector('.swiper');

        if (swiperContainer) {
            new Swiper(swiperContainer, {
                slidesPerView: 4,
                spaceBetween: 15,
                loop: false,
                navigation: {
                    nextEl: holder.querySelector(".swiper-button-next"),
                    prevEl: holder.querySelector(".swiper-button-prev"),
                },

                breakpoints: {
                    0: {
                        slidesPerView: 1.5,
                    },

                    520: {
                        slidesPerView: 2.5,
                    },

                    769: {
                        slidesPerView: 3.5,
                    },

                    992: {
                        slidesPerView: 4,
                        spaceBetween: 24,
                    },
                
                }
            });
        }
    }); 

    /* Sidebar categories widget toggle */

    const widgetTitles = document.querySelectorAll(".content-sidebar .widget.categories .widget-title");

    widgetTitles.forEach(function (title) {
        title.addEventListener("click", function () {
            if (window.innerWidth < 1200) {
                const widget = title.closest(".widget.categories");
                
                if (widget) {
                    widget.classList.toggle("show");
                }
            }
        });
    });
});
