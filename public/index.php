<?php
require_once __DIR__ . '/../config/config.php';
$pageTitle = 'BROX Tech — Build, Grow & Scale Your Product';
require_once __DIR__ . '/../includes/header.php';

$pillars = ['Product Development', 'Product Marketing & Growth', 'SEO & ASO', 'Ecommerce Solutions', 'Google Ads & Meta Ads', 'Product Branding'];

$services = [
    ['icon' => 'code', 'title' => 'Product Development', 'desc' => 'Web apps, mobile apps, and SaaS platforms built from concept to launch to growth.'],
    ['icon' => 'shopping-bag', 'title' => 'Ecommerce Solutions', 'desc' => 'Full-stack ecommerce built to convert — store setup, catalogue, paid growth, and CRO.'],
    ['icon' => 'trending-up', 'title' => 'Product Growth & Performance Marketing', 'desc' => 'Full-funnel growth strategy combining product expertise with paid performance.'],
    ['icon' => 'megaphone', 'title' => 'Google Ads Expert Team', 'desc' => 'Search, Shopping, Display, YouTube, and Performance Max — engineered for ROI.'],
    ['icon' => 'search', 'title' => 'SEO, ASO & AI Search', 'desc' => 'Technical SEO, App Store Optimization, and visibility across AI search platforms.'],
    ['icon' => 'palette', 'title' => 'Meta Ads & Product Branding', 'desc' => 'Product identities and brand systems, amplified with high-converting Meta campaigns.'],
];

// NOTE: placeholder figures — replace with your real numbers before launch.
$stats = [
    ['value' => '250+', 'label' => 'Clients Served'],
    ['value' => '150%', 'label' => 'Average ROI'],
    ['value' => '$10M+', 'label' => 'Ad Spend Managed'],
    ['value' => '92%', 'label' => 'Client Retention'],
];
?>

<section class="relative overflow-hidden">
  <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-background to-accent/10"></div>
  <div class="relative mx-auto max-w-6xl px-6 py-16 md:py-24 text-center">
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium border border-primary/20 mb-6">
      Trusted by growing brands worldwide
    </div>
    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold tracking-tight leading-[1.1] mb-6">
      Build, Grow &amp; <span class="text-primary">Scale Your Product</span> with Expert Marketing
    </h1>
    <p class="text-lg md:text-xl text-muted-foreground font-serif max-w-2xl mx-auto leading-relaxed mb-8">
      Your full-stack growth partner — product development, performance marketing, ecommerce, and brand building. One team. Real results.
    </p>

    <div class="flex flex-wrap justify-center gap-2 mb-10">
      <?php foreach ($pillars as $p): ?>
        <span class="px-3 py-1 text-xs font-medium rounded-full border border-border bg-muted/50 text-muted-foreground"><?= h($p) ?></span>
      <?php endforeach; ?>
    </div>

    <div class="flex flex-wrap items-center justify-center gap-4">
      <a href="/contact.php" class="inline-flex items-center gap-2 rounded-md px-6 py-3 text-sm font-medium bg-primary text-primary-foreground shadow-lg hover:opacity-90 transition-opacity">
        Get Free Growth Audit <?= icon('arrow-right', 'h-4 w-4') ?>
      </a>
      <a href="/services.php" class="inline-flex items-center gap-2 rounded-md px-6 py-3 text-sm font-medium border border-border hover:bg-accent transition-colors">
        See Our Services
      </a>
    </div>
  </div>
</section>

<section class="py-14 md:py-20 bg-muted/30">
  <div class="mx-auto max-w-6xl px-6">
    <div class="text-center mb-12">
      <span class="inline-block text-sm font-medium text-primary mb-4 uppercase tracking-wide">What We Do</span>
      <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-4">Everything Your Product Needs to Win</h2>
    </div>

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php foreach ($services as $s): ?>
        <div class="rounded-lg border border-border bg-card p-6 hover:shadow-md transition-shadow">
          <div class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-primary/10 mb-4"><?= icon($s['icon'], 'h-6 w-6 text-primary') ?></div>
          <h3 class="text-lg font-semibold mb-2"><?= h($s['title']) ?></h3>
          <p class="text-muted-foreground font-serif text-sm leading-relaxed"><?= h($s['desc']) ?></p>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="text-center mt-10">
      <a href="/services.php" class="inline-flex items-center gap-2 rounded-md px-6 py-3 text-sm font-medium border border-border hover:bg-accent transition-colors">
        Explore All Services <?= icon('arrow-right', 'h-4 w-4') ?>
      </a>
    </div>
  </div>
</section>

<section class="py-16 md:py-20 bg-primary text-primary-foreground">
  <div class="mx-auto max-w-6xl px-6">
    <div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center">
      <?php foreach ($stats as $stat): ?>
        <div>
          <div class="text-3xl md:text-4xl font-bold mb-1"><?= h($stat['value']) ?></div>
          <div class="text-sm opacity-80"><?= h($stat['label']) ?></div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="py-14 md:py-20">
  <div class="mx-auto max-w-4xl px-6 text-center">
    <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-4">Ready to Accelerate Your Growth?</h2>
    <p class="text-lg text-muted-foreground font-serif mb-8">Get a free audit and custom strategy tailored to your business — no obligation.</p>
    <a href="/contact.php" class="inline-flex items-center gap-2 rounded-md px-6 py-3 text-sm font-medium bg-primary text-primary-foreground hover:opacity-90 transition-opacity">
      Book Free Consultation <?= icon('arrow-right', 'h-4 w-4') ?>
    </a>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
