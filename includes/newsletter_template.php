<?php
// Newsletter HTML template generator

function newsletter_template_html(array $opt): string {
    $brand = $opt['brand'] ?? 'Conectica‑IT';
    $subject = $opt['subject'] ?? 'Noutăți Conectica‑IT';
    $preheader = $opt['preheader'] ?? 'Ultimele insight-uri și știri tehnice.';
    $title = $opt['title'] ?? $subject;
    $intro = $opt['intro'] ?? '';
    $items = $opt['items'] ?? [];
    $cta_text = $opt['cta_text'] ?? 'Află mai mult';
    $cta_url = $opt['cta_url'] ?? ((defined('BASE_URL')? rtrim(BASE_URL,'/') : '') . '/blog.php');
    $logo = $opt['logo'] ?? ((defined('BASE_URL')? rtrim(BASE_URL,'/') : '') . '/assets/images/logo.png');
    $site = defined('BASE_URL') ? rtrim(BASE_URL, '/') : '';

    // Sanitize minimal
    $h = fn($s) => htmlspecialchars($s ?? '', ENT_QUOTES, 'UTF-8');
    $abs = function($url) use ($site) {
        if (!$url) return $site.'/';
        if (preg_match('~^https?://~i', $url)) return $url;
        return $site . '/' . ltrim($url, '/');
    };

    // Build items HTML
    $blocks = '';
    foreach ($items as $it) {
        $tag = $h($it['tag'] ?? '');
        $it_title = $h($it['title'] ?? '');
        $desc = $h($it['desc'] ?? '');
        $url = $abs($it['url'] ?? $site.'/blog.php');
        $tagHtml = $tag ? "<span style=\"display:inline-block;background:#111;color:#fff;padding:4px 8px;border-radius:999px;font-size:12px;letter-spacing:.3px\">{$tag}</span>" : '';
        $blocks .= "<tr><td style=\"padding:16px 20px;border:1px solid #eee;border-radius:12px\">{$tagHtml}<h3 style=\"margin:8px 0 6px;font-size:18px;color:#111\">{$it_title}</h3><p style=\"margin:0 0 10px;color:#4b5563;line-height:1.5\">{$desc}</p><a href=\"{$url}\" style=\"display:inline-block;color:#2563eb;text-decoration:none;font-weight:600\">Citește ▶</a></td></tr><tr><td style=\"height:12px\"></td></tr>";
    }

    $cta_url_abs = $abs($cta_url);

    // Wrapper uses tables for email client compatibility
    $html = "<!doctype html><html lang=\"ro\"><head><meta charset=\"utf-8\"><meta name=\"viewport\" content=\"width=device-width\,initial-scale=1\"><title>".$h($subject)."</title>
    <style>@media (max-width:600px){.container{width:100%!important;padding:0 10px!important}.btn{display:block!important;width:100%!important}}</style>
    </head><body style=\"margin:0;background:#f5f7fb;color:#111\">
    <div style=\"display:none;max-height:0;overflow:hidden;opacity:0\">".$h($preheader)."</div>
    <table role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"100%\" style=\"background:#f5f7fb\"><tr><td>
      <table role=\"presentation\" class=\"container\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" align=\"center\" width=\"620\" style=\"width:620px;max-width:100%;margin:0 auto;padding:20px\">
        <tr><td style=\"text-align:center;padding:20px 0\"><a href=\"{$site}/\" style=\"text-decoration:none;color:inherit\"><img src=\"{$h($logo)}\" alt=\"{$h($brand)}\" height=\"42\" style=\"vertical-align:middle\"> </a></td></tr>
        <tr><td style=\"background:linear-gradient(135deg,#667eea,#764ba2);color:#fff;border-radius:16px;padding:26px 24px;text-align:center\">
          <h1 style=\"margin:0 0 8px;font-size:24px\">".$h($title)."</h1>
          <p style=\"margin:0;color:rgba(255,255,255,.9)\">".$h($intro)."</p>
          <div style=\"height:12px\"></div>
          <a class=\"btn\" href=\"{$cta_url_abs}\" style=\"display:inline-block;background:#111;color:#fff;text-decoration:none;padding:10px 18px;border-radius:10px;font-weight:600\">".$h($cta_text)."</a>
        </td></tr>
        <tr><td style=\"height:16px\"></td></tr>
        <tr><td>
          <table role=\"presentation\" cellpadding=\"0\" cellspacing=\"0\" border=\"0\" width=\"100%\">{$blocks}</table>
        </td></tr>
        <tr><td style=\"height:12px\"></td></tr>
        <tr><td style=\"text-align:center;color:#6b7280;font-size:12px\">© ".date('Y')." {$h($brand)} · <a href=\"{$site}/politica-cookies.php\" style=\"color:#6b7280\">Politica Cookie</a> · <a href=\"{$site}/contact.php\" style=\"color:#6b7280\">Contact</a></td></tr>
      </table>
    </td></tr></table>
    </body></html>";

    return $html;
}

?>