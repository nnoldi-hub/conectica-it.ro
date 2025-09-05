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
    
    <?php if (defined('CHAT_ENABLED') && CHAT_ENABLED): ?>
    <!-- Live Chat Widget -->
    <?php if (defined('CHAT_PROVIDER') && CHAT_PROVIDER === 'tawk' && defined('CHAT_TAWK_PROPERTY_ID') && CHAT_TAWK_PROPERTY_ID && defined('CHAT_TAWK_WIDGET_ID') && CHAT_TAWK_WIDGET_ID): ?>
        <!-- Tawk.to -->
        <script type="text/javascript">
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            // Guard: do not inject twice
            if (document.querySelector('script[src^="https://embed.tawk.to/"]')) return;
            var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
            s1.async=true;
            s1.src='https://embed.tawk.to/<?php echo CHAT_TAWK_PROPERTY_ID; ?>/<?php echo CHAT_TAWK_WIDGET_ID; ?>';
            s1.charset='UTF-8';
            s1.setAttribute('crossorigin','*');
            s0.parentNode.insertBefore(s1,s0);
        })();
        </script>
    <?php elseif (defined('CHAT_CRISP_WEBSITE_ID') && CHAT_CRISP_WEBSITE_ID): ?>
        <!-- Crisp Chat -->
        <script type="text/javascript">
        // Declare via bracket notation to avoid editor warnings
        window['$crisp'] = window['$crisp'] || [];
        window['CRISP_WEBSITE_ID'] = window['CRISP_WEBSITE_ID'] || "<?php echo CHAT_CRISP_WEBSITE_ID; ?>";
        (function(){
            // Guard: do not inject twice
            if (document.querySelector('script[src^="https://client.crisp.chat/"]')) return;
            var d=document;var s=d.createElement("script");
            s.src="https://client.crisp.chat/l.js";s.async=1;
            d.getElementsByTagName("head")[0].appendChild(s);
        })();
        </script>
    <?php endif; ?>

    <?php if (!defined('CHAT_FLOAT_BUTTON') || CHAT_FLOAT_BUTTON): ?>
    <!-- Floating Chat Button (bottom-right) -->
    <button id="chat-fab" type="button" aria-label="Deschide chat" class="btn btn-primary chat-fab">
        <i class="fas fa-comments"></i>
        <span class="chat-fab-label d-none d-sm-inline ms-2">Chat</span>
    </button>
    <style>
        .chat-fab {
            position: fixed;
            right: 20px;
            bottom: 20px;
            z-index: 2147483000; /* above most widgets */
            border-radius: 999px;
            padding: 12px 16px;
            box-shadow: 0 12px 24px rgba(0,0,0,.25);
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .chat-fab:hover { transform: translateY(-1px); }
        @media (max-width: 576px) { .chat-fab { right: 14px; bottom: 14px; padding: 12px; } .chat-fab-label { display:none !important; } }
    </style>
    <script>
        (function(){
            function openChat(){
                try {
                    if (window.Tawk_API && typeof window.Tawk_API.maximize === 'function') {
                        if (typeof window.Tawk_API.showWidget === 'function') window.Tawk_API.showWidget();
                        window.Tawk_API.maximize();
                        return;
                    }
                    if (window.$crisp && Array.isArray(window.$crisp)) {
                        window.$crisp.push(["do","chat:show"]);
                        window.$crisp.push(["do","chat:open"]);
                        return;
                    }
                    // Fallback
                    window.location.href = 'contact.php#contact';
                } catch (e) { /* no-op */ }
            }
            var fab = document.getElementById('chat-fab');
            if (fab) fab.addEventListener('click', openChat);
        })();
    </script>
    
    <?php if (defined('CHAT_HIDE_PROVIDER_BADGE') && CHAT_HIDE_PROVIDER_BADGE): ?>
    <!-- Optionally hide provider's default bubble to avoid duplicates -->
    <script>
        (function(){
            function hideProviders(){
                try {
                    if (window.Tawk_API && typeof window.Tawk_API.hideWidget === 'function') {
                        window.Tawk_API.hideWidget();
                    }
                    if (window.$crisp && Array.isArray(window.$crisp)) {
                        window.$crisp.push(["do","chat:hide"]);
                    }
                } catch (e) {}
            }
            // Attempt after load and with a short retry, as these APIs attach async
            window.addEventListener('load', function(){
                hideProviders();
                var tries = 0; var iv = setInterval(function(){
                    tries++; hideProviders();
                    if (tries > 10) clearInterval(iv);
                }, 500);
            });
        })();
    </script>
    <?php endif; ?>
    <?php endif; ?>
    <?php endif; ?>


    <!-- Custom JS -->
    <script>
        // Smooth scrolling pentru link-urile interne (cu gardă pentru href="#" sau ținte lipsă)
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                try {
                    const target = this.getAttribute('href');
                    if (target && target.length > 1) {
                        const el = document.querySelector(target);
                        if (el) {
                            e.preventDefault();
                            el.scrollIntoView({ behavior: 'smooth' });
                        }
                    }
                } catch (_) { /* no-op */ }
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