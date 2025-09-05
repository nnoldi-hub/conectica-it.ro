<?php
// Test simplu pentru chat - fără includes complexe
?>
<!DOCTYPE html>
<html>
<head>
    <title>Test Chat</title>
    <meta charset="utf-8">
</head>
<body>
    <h1>Test Chat Direct</h1>
    <p>Această pagină testează direct Tawk.to fără logica complexă.</p>
    
    <button id="test-chat" style="position:fixed; bottom:20px; right:20px; z-index:9999; padding:15px; background:#007bff; color:white; border:none; border-radius:50px; cursor:pointer;">
        💬 Chat Test
    </button>

    <!-- Tawk.to Direct -->
    <script type="text/javascript">
    var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
    (function(){
        var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
        s1.async=true;
        s1.src='https://embed.tawk.to/68ba8c61b1986019272e8bdf/1j4cb8n2t';
        s1.charset='UTF-8';
        s1.setAttribute('crossorigin','*');
        s0.parentNode.insertBefore(s1,s0);
    })();
    
    document.getElementById('test-chat').addEventListener('click', function(){
        if (window.Tawk_API && typeof window.Tawk_API.maximize === 'function') {
            window.Tawk_API.maximize();
        } else {
            alert('Tawk_API nu este încă încărcat. Încearcă din nou în câteva secunde.');
        }
    });
    </script>
    
    <script>
    // Debug info after 3 seconds
    setTimeout(function(){
        console.log('Tawk_API exists:', !!(window.Tawk_API));
        console.log('Tawk script in DOM:', !!document.querySelector('script[src*="embed.tawk.to"]'));
        if (window.Tawk_API) {
            console.log('Tawk_API methods:', Object.keys(window.Tawk_API));
        }
    }, 3000);
    </script>
</body>
</html>
