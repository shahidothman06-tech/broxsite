<?php
http_response_code(404);
require_once __DIR__ . '/../config/config.php';
$pageTitle = 'Page Not Found — BROX Tech';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="py-24 md:py-32">
  <div class="mx-auto max-w-xl px-6 text-center">
    <div class="text-6xl font-bold text-primary mb-4">404</div>
    <h1 class="text-2xl font-bold mb-2">Page not found</h1>
    <p class="text-muted-foreground mb-8">The page you're looking for doesn't exist or has moved.</p>
    <a href="/" class="inline-flex items-center gap-2 rounded-md px-6 py-3 text-sm font-medium bg-primary text-primary-foreground hover:opacity-90 transition-opacity">Back to Home</a>
  </div>
</section>
<?php require_once __DIR__ . '/../includes/footer.php'; ?>
