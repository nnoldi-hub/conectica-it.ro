        </div>
    </main>
    
    <footer class='bg-dark text-light py-5 mt-5'>
        <div class='container'>
            <div class='row g-4'>
                <div class='col-lg-6'>
                    <h5 class='mb-3'>
                        <i class="fas fa-code me-2"></i>Conectica‑IT
                    </h5>
                    <p class='mb-3'>Freelancer IT specializat în dezvoltarea de aplicații web moderne și soluții personalizate pentru afaceri.</p>
                    <div class='social-links'>
                        <a href='mailto:<?php echo defined('CONTACT_EMAIL') ? CONTACT_EMAIL : 'conectica.it.ro@gmail.com'; ?>' class='text-light me-3' title='Email'>
                            <i class='fas fa-envelope fa-lg'></i>
                        </a>
                        <a href='tel:<?php echo defined('CONTACT_PHONE') ? CONTACT_PHONE : '0740173581'; ?>' class='text-light me-3' title='Telefon'>
                            <i class='fas fa-phone fa-lg'></i>
                        </a>
                        <a href='https://<?php echo defined('WEBSITE_URL') ? WEBSITE_URL : 'conectica-it.ro'; ?>' class='text-light me-3' title='Website'>
                            <i class='fas fa-globe fa-lg'></i>
                        </a>
                    </div>
                </div>
                
                <div class='col-lg-3'>
                    <h6 class='mb-3'>Servicii</h6>
                    <ul class='list-unstyled'>
                        <li class='mb-2'><a href='#' class='text-light-emphasis text-decoration-none'>Dezvoltare Web</a></li>
                        <li class='mb-2'><a href='#' class='text-light-emphasis text-decoration-none'>Aplicații PHP</a></li>
                        <li class='mb-2'><a href='#' class='text-light-emphasis text-decoration-none'>Baze de Date</a></li>
                        <li class='mb-2'><a href='#' class='text-light-emphasis text-decoration-none'>Mentenanță IT</a></li>
                    </ul>
                </div>
                
                <div class='col-lg-3'>
                    <h6 class='mb-3'>Contact</h6>
                    <div class='contact-info'>
                        <p class='mb-2'>
                            <i class='fas fa-envelope me-2'></i>
                            <a href='mailto:<?php echo defined('CONTACT_EMAIL') ? CONTACT_EMAIL : 'conectica.it.ro@gmail.com'; ?>' class='text-light-emphasis text-decoration-none'><?php echo defined('CONTACT_EMAIL') ? CONTACT_EMAIL : 'conectica.it.ro@gmail.com'; ?></a>
                        </p>
                        <p class='mb-2'>
                            <i class='fas fa-phone me-2'></i>
                            <a href='tel:<?php echo defined('CONTACT_PHONE') ? CONTACT_PHONE : '0740173581'; ?>' class='text-light-emphasis text-decoration-none'><?php echo defined('CONTACT_PHONE') ? CONTACT_PHONE : '0740173581'; ?></a>
                        </p>
                        <p class='mb-0'>
                            <i class='fas fa-globe me-2'></i>
                            <a href='https://<?php echo defined('WEBSITE_URL') ? WEBSITE_URL : 'conectica-it.ro'; ?>' class='text-light-emphasis text-decoration-none'><?php echo defined('WEBSITE_URL') ? WEBSITE_URL : 'conectica-it.ro'; ?></a>
                        </p>
                    </div>
                </div>
            </div>
            
            <hr class='my-4 border-secondary'>
            <div class='text-center'>
                <p class='mb-0 text-light-emphasis'>
                    &copy; <?php echo date('Y'); ?> Conectica‑IT - Nyikora Noldi. Toate drepturile rezervate.
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
    
    <!-- Custom JS -->
    <script>
        // Smooth scrolling pentru link-urile interne
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
        
        // Active nav link highlighting
        const currentLocation = location.pathname;
        const menuItems = document.querySelectorAll('.navbar-nav .nav-link');
        menuItems.forEach(item => {
            if(item.getAttribute('href') === currentLocation.split('/').pop()){
                item.classList.add('active');
            }
        });
    </script>
</body>
</html>