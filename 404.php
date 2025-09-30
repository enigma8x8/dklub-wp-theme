<?php get_header(); ?>

<main class="site-main">
    <div class="container">
        <div class="error-404">
            <div class="error-content">
                <div class="error-icon">
                    <svg width="120" height="120" viewBox="0 0 120 120" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M60 10C32.39 10 10 32.39 10 60C10 87.61 32.39 110 60 110C87.61 110 110 87.61 110 60C110 32.39 87.61 10 60 10ZM60 100C37.91 100 20 82.09 20 60C20 37.91 37.91 20 60 20C82.09 20 100 37.91 100 60C100 82.09 82.09 100 60 100Z" fill="#206D69" />
                        <path d="M60 30C42.33 30 30 42.33 30 60C30 77.67 42.33 90 60 90C77.67 90 90 77.67 90 60C90 42.33 77.67 30 60 30ZM60 80C47.85 80 40 72.15 40 60C40 47.85 47.85 40 60 40C72.15 40 80 47.85 80 60C80 72.15 72.15 80 60 80Z" fill="#206D69" />
                        <path d="M60 50C55.58 50 50 55.58 50 60C50 64.42 55.58 70 60 70C64.42 70 70 64.42 70 60C70 55.58 64.42 50 60 50Z" fill="#206D69" />
                    </svg>
                </div>

                <h1 class="error-title">404</h1>
                <h2 class="error-subtitle">Lapa nav atrasta</h2>
                <p class="error-description">
                    Diemžēl meklētā lapa neeksistē vai ir pārvietota.
                    Mēģiniet pārlūkot mūsu saturu.
                </p>

                <div class="error-actions">
                    <a href="<?php echo home_url('/'); ?>" class="btn btn-primary">
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 1L1 8L8 15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M1 8H15" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        Atpakaļ uz sākumu
                    </a>
                </div>
            </div>
        </div>
    </div>
</main>

<?php get_footer(); ?>