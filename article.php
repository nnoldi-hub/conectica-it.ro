<?php
$page_title = 'Articol';
require_once __DIR__ . '/includes/init.php';
require_once __DIR__ . '/includes/head.php';

// Static demo articles mapped by slug until DB is added
$articles = [
    'php-mysql-modern-app' => [
        'title' => 'Cum să construiești o aplicație web modernă cu PHP și MySQL',
        'date' => '15 Dec 2024',
        'read' => 8,
        'cover' => 'https://placehold.co/1000x420/1a237e/ffffff?text=PHP+MySQL+Guide',
        'excerpt' => 'Un ghid complet pentru dezvoltarea unei aplicații web robuste, de la planificare până la deployment.',
        'content' => [
            'Acest ghid acoperă pașii cheie pentru a livra o aplicație web modernă folosind PHP și MySQL: arhitectură, organizarea codului, securitate și deploy.',
            'Începe cu o structură clară: un bootstrap comun (init.php), componente prezentare (head/foot), și straturi separate pentru accesul la date.',
            'Folosește PDO cu prepared statements, tratează erorile grațios și asigură-te că ai un proces de deployment repetabil (ex. GitHub Actions + FTP).',
        ],
        'tags' => ['PHP', 'MySQL', 'Arhitectură'],
        'author' => 'Nyikora Noldi',
    ],
    'php-security' => [
        'title' => 'Securitatea în PHP: Cele mai importante vulnerabilități',
        'date' => '10 Dec 2024',
        'read' => 6,
        'cover' => 'https://placehold.co/1000x420/0d47a1/ffffff?text=PHP+Security',
        'excerpt' => 'Cum să protejezi aplicațiile PHP împotriva atacurilor comune: SQL injection, XSS, CSRF și multe altele.',
        'content' => [
            'Validează și filtrează datele de intrare. Escapează output-ul corect. Folosește tokens anti-CSRF.',
            'Activează HTTP security headers și ține dependințele la zi.',
        ],
        'tags' => ['PHP', 'Security'],
        'author' => 'Nyikora Noldi',
    ],
    'mysql-optimization' => [
        'title' => 'Optimizarea performanțelor în MySQL',
        'date' => '5 Dec 2024',
        'read' => 8,
        'cover' => 'https://placehold.co/1000x420/28a745/ffffff?text=MySQL+Optimization',
        'excerpt' => 'Tehnici avansate pentru optimizarea query-urilor, indexare eficientă și configurarea serverului MySQL.',
        'content' => [
            'Folosește EXPLAIN pentru a înțelege planul de execuție. Adaugă indexuri acolo unde sunt potrivite.',
            'Evita N+1 queries și cache-uiește rezultatele intens folosite.',
        ],
        'tags' => ['MySQL', 'Performance'],
        'author' => 'Nyikora Noldi',
    ],
    'javascript-es6-plus' => [
        'title' => 'JavaScript ES6+: Funcționalități esențiale',
        'date' => '1 Dec 2024',
        'read' => 5,
        'cover' => 'https://placehold.co/1000x420/ffc107/000000?text=JavaScript+ES6',
        'excerpt' => 'Explorează funcționalitățile moderne ES6+: arrow functions, destructuring, async/await.',
        'content' => [
            'Modernează-ți codul cu sintaxa ES6 și folosește bundlers pentru producție.',
        ],
        'tags' => ['JavaScript'],
        'author' => 'Nyikora Noldi',
    ],
    'git-workflow' => [
        'title' => 'Workflow Git pentru dezvoltatori',
        'date' => '25 Nov 2024',
        'read' => 7,
        'cover' => 'https://placehold.co/1000x420/17a2b8/ffffff?text=Git+Workflow',
        'excerpt' => 'Strategii de branching, code review și best practices.',
        'content' => [
            'Adoptă un model clar (feature branches, PR-uri mici) și menține istoric curat.',
        ],
        'tags' => ['Git'],
        'author' => 'Nyikora Noldi',
    ],
    'php-8-features' => [
        'title' => 'Noutățile din PHP 8: Ce trebuie să știi',
        'date' => '20 Nov 2024',
        'read' => 9,
        'cover' => 'https://placehold.co/1000x420/6610f2/ffffff?text=PHP+8+Features',
        'excerpt' => 'Union types, Match expressions, JIT, constructor property promotion.',
        'content' => [
            'Profită de noile features pentru cod mai clar și mai rapid.',
        ],
        'tags' => ['PHP'],
        'author' => 'Nyikora Noldi',
    ],
    'api-development' => [
        'title' => 'Cum să construiești un API REST în PHP',
        'date' => '15 Nov 2024',
        'read' => 12,
        'cover' => 'https://placehold.co/1000x420/dc3545/ffffff?text=API+Development',
        'excerpt' => 'Autentificare, validare, documentare și testare.',
        'content' => [
            'Planifică endpoint-urile, scrie teste, documentează cu OpenAPI.',
        ],
        'tags' => ['API', 'PHP'],
        'author' => 'Nyikora Noldi',
    ],
];

$slug = isset($_GET['slug']) ? trim($_GET['slug']) : '';
$article = null;

// Try database first if available
try {
    $tableExists = false;
    if ($pdo instanceof PDO) {
        $stmt = $pdo->query("SHOW TABLES LIKE 'blog_posts'");
        $tableExists = $stmt && $stmt->fetchColumn();
    }
    if ($tableExists && $slug !== '') {
        $stmt = $pdo->prepare("SELECT id,title,slug,excerpt,content_html,cover_image,author,read_minutes,COALESCE(published_at, created_at) as dt,tags,views FROM blog_posts WHERE slug=? AND status='published' LIMIT 1");
        $stmt->execute([$slug]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            // increment view counter (non-blocking)
            try { $pdo->prepare("UPDATE blog_posts SET views = views + 1 WHERE id=?")->execute([(int)$row['id']]); } catch (Throwable $e2) {}
            $tags = [];
            if (!empty($row['tags'])) {
                $tj = json_decode($row['tags'], true);
                if (json_last_error() === JSON_ERROR_NONE && is_array($tj)) { $tags = $tj; }
            }
            $article = [
                'title' => $row['title'],
                'date' => date('d M Y', strtotime($row['dt'])),
                'read' => (int)($row['read_minutes'] ?: 6),
                'cover' => $row['cover_image'] ?: '/assets/images/placeholders/wide-purple.svg',
                'excerpt' => $row['excerpt'] ?: '',
                'content_html' => $row['content_html'] ?: '',
                'tags' => $tags,
                'author' => $row['author'] ?: 'Conectica IT',
            ];
        }
    }
} catch (Throwable $e) { /* ignore and fallback */ }

// Fallback to demo map
if (!$article) {
    $article = $slug && isset($articles[$slug]) ? $articles[$slug] : null;
}
?>

<div class="container py-5">
    <?php if (!$article): ?>
        <div class="alert alert-info mb-4">Articolul nu a fost găsit sau nu este disponibil încă.</div>
        <a href="blog.php" class="btn btn-primary"><i class="fas fa-arrow-left me-2"></i>Înapoi la blog</a>
    <?php else: ?>
        <article class="mx-auto" style="max-width: 900px;">
            <img class="img-fluid rounded shadow-sm mb-4" src="<?= htmlspecialchars($article['cover']) ?>" alt="<?= htmlspecialchars($article['title']) ?>">
            <h1 class="h2 mb-3"><?= htmlspecialchars($article['title']) ?></h1>
            <div class="text-muted mb-4">
                <span class="me-2"><i class="fas fa-user me-1"></i><?= htmlspecialchars($article['author']) ?></span>
                <span class="me-2">• <?= htmlspecialchars($article['date']) ?></span>
                <span>• <i class="fas fa-clock me-1"></i><?= (int)$article['read'] ?> min citire</span>
            </div>
            <p class="lead"><?= htmlspecialchars($article['excerpt']) ?></p>
            <hr>
            <div class="content">
                <?php if (!empty($article['content_html'])): ?>
                    <?= $article['content_html'] ?>
                <?php else: ?>
                    <?php foreach ($article['content'] as $p): ?>
                        <p><?= htmlspecialchars($p) ?></p>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
            <?php if (!empty($article['tags'])): ?>
                <div class="mt-4 d-flex gap-2 flex-wrap">
                    <?php foreach ($article['tags'] as $tag): ?>
                        <span class="badge bg-secondary"><?= htmlspecialchars($tag) ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
            <div class="mt-5">
                <a href="blog.php" class="btn btn-outline-primary"><i class="fas fa-arrow-left me-2"></i>Înapoi la blog</a>
            </div>
        </article>
    <?php endif; ?>
</div>

<?php require_once __DIR__ . '/includes/foot.php'; ?>
