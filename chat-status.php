<?php
require_once __DIR__ . '/includes/init.php';

header('Content-Type: text/html; charset=utf-8');

function b(bool $v){ return $v ? '<span style="color:#16a34a">OK</span>' : '<span style="color:#dc2626">NU</span>'; }

$enabled   = defined('CHAT_ENABLED') && CHAT_ENABLED;
$provider  = defined('CHAT_PROVIDER') ? CHAT_PROVIDER : '(nesetat)';
$tawkProp  = defined('CHAT_TAWK_PROPERTY_ID') && CHAT_TAWK_PROPERTY_ID !== '';
$tawkWid   = defined('CHAT_TAWK_WIDGET_ID') && CHAT_TAWK_WIDGET_ID !== '';
$crispId   = defined('CHAT_CRISP_WEBSITE_ID') && CHAT_CRISP_WEBSITE_ID !== '';
$floatBtn  = !defined('CHAT_FLOAT_BUTTON') || CHAT_FLOAT_BUTTON;
$hideBadge = defined('CHAT_HIDE_PROVIDER_BADGE') && CHAT_HIDE_PROVIDER_BADGE;
?>
<!doctype html>
<html lang="ro">
<head>
  <meta charset="utf-8">
  <meta name="robots" content="noindex,nofollow">
  <title>Chat Status</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-dark text-light">
  <div class="container py-5">
    <h1 class="h3 mb-4">Chat Status</h1>
    <div class="card bg-secondary-subtle text-dark">
      <div class="card-body">
        <ul class="list-unstyled m-0">
          <li class="mb-2"><strong>CHAT_ENABLED:</strong> <?= b($enabled) ?></li>
          <li class="mb-2"><strong>CHAT_PROVIDER:</strong> <code><?= htmlspecialchars($provider) ?></code></li>
          <li class="mb-2"><strong>Tawk property ID set:</strong> <?= b($tawkProp) ?></li>
          <li class="mb-2"><strong>Tawk widget ID set:</strong> <?= b($tawkWid) ?></li>
          <li class="mb-2"><strong>Crisp website ID set:</strong> <?= b($crispId) ?></li>
          <li class="mb-2"><strong>CHAT_FLOAT_BUTTON:</strong> <?= b($floatBtn) ?></li>
          <li class="mb-2"><strong>CHAT_HIDE_PROVIDER_BADGE:</strong> <?= b($hideBadge) ?></li>
        </ul>
        <small class="text-muted">Notă: valorile ID-urilor nu sunt afișate; arătăm doar dacă sunt setate.</small>
      </div>
    </div>

    <div class="mt-4">
      <p class="mb-1">Detectare în browser (după load):</p>
      <div id="client-check" class="small text-light-emphasis">Verific...</div>
    </div>

    <div class="mt-4">
      <a class="btn btn-outline-light" href="index.php">Înapoi la site</a>
    </div>
  </div>

  <script>
    window.addEventListener('load', function(){
      setTimeout(function(){
        var hasTawk = !!(window.Tawk_API);
        var hasCrisp = !!(window.$crisp);
        var el = document.getElementById('client-check');
        if (hasTawk) {
          el.innerHTML = 'Tawk_API prezent ✔';
        } else if (hasCrisp) {
          el.innerHTML = '$crisp prezent ✔';
        } else {
          el.innerHTML = 'Niciun widget detectat încă (verifică ad-blocker / setările de chat)';
        }
      }, 2000);
    });
  </script>
</body>
<style> body{min-height:100vh;} </style>
</html>
