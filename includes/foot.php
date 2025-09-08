        </div>
    </main>
    
    <!-- Newsletter Subscribe -->
    <section class="container my-5">
        <div class="p-4 p-md-5 rounded-4 text-white" style="background: linear-gradient(135deg,#667eea,#764ba2);">
            <div class="row align-items-center g-4">
                <div class="col-lg-7">
                    <h2 class="h3 fw-bold mb-2">Abonează-te la noutăți</h2>
                    <p class="mb-0">Primește periodic insight-uri și știri tehnice despre AI, DevOps și securitate, plus noutăți din proiectele mele.</p>
                </div>
                <div class="col-lg-5">
                    <form id="newsletterForm" class="d-flex gap-2 flex-column flex-sm-row" novalidate>
                        <label for="newsletterEmail" class="visually-hidden">Email</label>
                        <input type="email" id="newsletterEmail" name="email" class="form-control form-control-lg" placeholder="adresa@exemplu.ro" required>
                        <button class="btn btn-dark btn-lg flex-shrink-0" type="submit">
                            <i class="fas fa-envelope-open me-1"></i> Mă abonez
                        </button>
                    </form>
                    <div id="newsletterMsg" class="mt-2 small" role="status" aria-live="polite"></div>
                </div>
            </div>
        </div>
    </section>
    
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
                <p class='mb-2 text-light-emphasis'>
                    &copy; <?php echo date('Y'); ?> Conectica‑IT - Nyikora Noldi. Toate drepturile rezervate.
                </p>
                <p class='mb-0'>
                    <a href='politica-cookies.php' class='text-light-emphasis text-decoration-none me-3'>
                        <i class='fas fa-cookie-bite me-1'></i>Politica Cookies
                    </a>
                    <a href='contact.php' class='text-light-emphasis text-decoration-none'>
                        <i class='fas fa-shield-alt me-1'></i>Confidențialitate
                    </a>
                </p>
            </div>
        </div>
    </footer>
    
    <!-- Bootstrap JS -->
    <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js'></script>
    
    <script>
    // Newsletter subscribe handler
    (function(){
        const form = document.getElementById('newsletterForm');
        if(!form) return;
        const emailInput = document.getElementById('newsletterEmail');
        const msg = document.getElementById('newsletterMsg');
        function show(m, type){ if(!msg) return; msg.className = 'mt-2 small text-' + (type||'light'); msg.textContent = m; }
        form.addEventListener('submit', async function(e){
            e.preventDefault();
            const email = (emailInput?.value||'').trim();
            if(!email){ show('Te rog introdu o adresă de email.', 'warning'); emailInput?.focus(); return; }
            show('Se procesează...', 'light');
            try {
                const res = await fetch('api/newsletter-subscribe.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ email, source: window.location.pathname }) });
                const data = await res.json().catch(()=>({ ok:false, message:'Eroare răspuns server' }));
                if (data.ok) { show('Mulțumesc! Verifică-ți inbox-ul pentru confirmare (dacă e cazul).', 'success'); form.reset(); }
                else { show(data.message || 'Nu am putut înregistra abonarea.', 'warning'); }
            } catch(err){ show('Eroare rețea. Încearcă din nou.', 'danger'); }
        });
    })();
    </script>
    
    
    
    <?php if (defined('CHAT_ENABLED') && CHAT_ENABLED): ?>
    <!-- Live Chat Widget -->
    <?php if (defined('CHAT_PROVIDER') && CHAT_PROVIDER === 'tawk' && defined('CHAT_TAWK_PROPERTY_ID') && CHAT_TAWK_PROPERTY_ID && defined('CHAT_TAWK_WIDGET_ID') && CHAT_TAWK_WIDGET_ID): ?>
        <!-- Tawk.to -->
        <script type="text/javascript">
        // Load chat only if cookie consent given
        function __hasCookieConsent(){
            try{ return document.cookie.split(';').some(c=>c.trim().startsWith('cookie_consent=1')); }catch(e){ return false; }
        }
        var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
        (function(){
            // Guard: do not inject twice
            if (__hasCookieConsent() && !document.querySelector('script[src^="https://embed.tawk.to/"]')) {
                var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
                s1.async=true;
                s1.src='https://embed.tawk.to/<?php echo CHAT_TAWK_PROPERTY_ID; ?>/<?php echo CHAT_TAWK_WIDGET_ID; ?>';
                s1.charset='UTF-8';
                s1.setAttribute('crossorigin','*');
                s0.parentNode.insertBefore(s1,s0);
            }
        })();
        </script>
    <?php elseif (defined('CHAT_CRISP_WEBSITE_ID') && CHAT_CRISP_WEBSITE_ID): ?>
        <!-- Crisp Chat -->
        <script type="text/javascript">
        // Define globals before loading Crisp
        window['$crisp'] = window['$crisp'] || [];
        window['CRISP_WEBSITE_ID'] = window['CRISP_WEBSITE_ID'] || "<?php echo CHAT_CRISP_WEBSITE_ID; ?>";
        window.addEventListener('load', function(){
            var hasConsent=false;
            try {
                hasConsent = document.cookie.split(';').some(function(c){return c.trim().indexOf('cookie_consent=1')===0;});
            } catch(_) { hasConsent=false; }
            var alreadyLoaded = !!document.querySelector('script[src^="https://client.crisp.chat/"]');
            if (hasConsent && !alreadyLoaded) {
                var d=document; var s=d.createElement('script');
                s.src='https://client.crisp.chat/l.js'; s.async=1;
                (d.head||d.getElementsByTagName('head')[0]).appendChild(s);
            }
        });
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
                    // Check Tawk.to first
                    if (window.Tawk_API && typeof window.Tawk_API.maximize === 'function') {
                        if (typeof window.Tawk_API.showWidget === 'function') {
                            window.Tawk_API.showWidget();
                        }
                        window.Tawk_API.maximize();
                    }
                    // Check Crisp second
                    else if (window.$crisp && Array.isArray(window.$crisp)) {
                        window.$crisp.push(["do","chat:show"]);
                        window.$crisp.push(["do","chat:open"]);
                    }
                    // Fallback to contact page
                    else {
                        window.location.href = 'contact.php#contact';
                    }
                } catch (e) { 
                    // Fallback on any error
                    window.location.href = 'contact.php#contact';
                }
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
                    // Hide Tawk widget if available
                    if (window.Tawk_API && typeof window.Tawk_API.hideWidget === 'function') {
                        window.Tawk_API.hideWidget();
                    }
                    // Hide Crisp widget if available
                    if (window.$crisp && Array.isArray(window.$crisp)) {
                        window.$crisp.push(["do","chat:hide"]);
                    }
                } catch (e) {
                    // Silent fail - widgets may not be loaded yet
                }
            }
            // Attempt after load and with a short retry, as these APIs attach async
            window.addEventListener('load', function(){
                hideProviders();
                var tries = 0; 
                var iv = setInterval(function(){
                    tries++; 
                    hideProviders();
                    if (tries > 10) {
                        clearInterval(iv);
                    }
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

    <!-- Cookie Consent Banner -->
    <div id="cookie-banner" class="cookie-banner" role="region" aria-label="Informare cookie-uri" style="display:none;">
        <div class="cookie-text">
            Folosim cookie-uri pentru funcționarea site-ului și îmbunătățirea experienței. Prin „Accept”, ești de acord cu utilizarea cookie-urilor. 
            <a href="politica-cookies.php" class="link-light text-decoration-underline">Află mai multe</a>.
        </div>
        <div class="cookie-actions">
            <button id="cookie-essentials" class="btn btn-outline-light btn-sm">Doar esențiale</button>
            <button id="cookie-accept" class="btn btn-primary btn-sm ms-2">Accept</button>
        </div>
    </div>
    <style>
        .cookie-banner{position:fixed;left:0;right:0;bottom:0;z-index:2147483001;background:rgba(22,22,22,.96);color:#fff;padding:14px 16px;display:flex;align-items:center;gap:12px;flex-wrap:wrap}
        .cookie-text{flex:1;opacity:.95}
    </style>
    <script>
        (function(){
            function getCookie(name){
                const v=('; '+document.cookie).split('; '+name+'=');
                return v.length===2 ? v.pop().split(';').shift() : null;
            }
            function setCookie(name,value,days){
                const d=new Date(); d.setTime(d.getTime()+days*24*60*60*1000);
                document.cookie = name+'='+value+'; expires='+d.toUTCString()+'; path=/; SameSite=Lax';
            }
            var accepted = getCookie('cookie_consent')==='1';
            var banner = document.getElementById('cookie-banner');
            function hide(){ if(banner) banner.style.display='none'; }
            function show(){ if(banner) banner.style.display='flex'; }
            if(!accepted){ show(); }
            var btnAccept = document.getElementById('cookie-accept');
            var btnEss = document.getElementById('cookie-essentials');
            if(btnAccept){ btnAccept.addEventListener('click', function(){ setCookie('cookie_consent','1',180); hide(); location.reload(); }); }
            if(btnEss){ btnEss.addEventListener('click', function(){ setCookie('cookie_consent','0',180); hide(); }); }
        })();
    </script>
</body>
</html>