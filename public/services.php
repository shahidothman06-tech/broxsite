<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/header.php';

$services = [
    ['icon' => 'code', 'title' => 'Product Development', 'desc' => "We build digital products the way founders think — from concept to launch to growth. Web apps, mobile apps, and SaaS platforms built to scale.", 'features' => ['Web & mobile app development (iOS & Android)', 'SaaS platform architecture & development', 'UI/UX design, prototyping & post-launch support']],
    ['icon' => 'shopping-bag', 'title' => 'Ecommerce Solutions', 'desc' => 'Full-stack ecommerce built to convert — store setup, catalogue management, paid growth, and CRO all handled under one roof.', 'features' => ['Shopify, WooCommerce & custom development', 'Product catalogue & payment integrations', 'Paid growth, CRO & ecommerce SEO']],
    ['icon' => 'trending-up', 'title' => 'Product Growth & Performance Marketing', 'desc' => "We combine product growth expertise with paid performance — not just campaigns, but the entire funnel.", 'features' => ['Full-funnel growth strategy & experimentation', 'Multi-channel paid performance management', 'CRO, retention & product analytics']],
    ['icon' => 'megaphone', 'title' => 'Google Ads Expert Team', 'desc' => "Our dedicated team runs Search, Shopping, Display, YouTube, and Performance Max campaigns — engineered for ROI.", 'features' => ['Search, Shopping & Performance Max', 'YouTube advertising & video campaigns', 'Smart Bidding, remarketing & attribution']],
    ['icon' => 'search', 'title' => 'SEO, ASO & AI Search Optimization', 'desc' => 'We optimise apps for ASO and rank clients across Google, the App Store, and the new wave of AI-powered discovery platforms.', 'features' => ['Technical SEO & Core Web Vitals', 'App Store Optimization (ASO) — iOS & Android', 'AI search visibility — ChatGPT, Perplexity, Gemini']],
    ['icon' => 'palette', 'title' => 'Meta Ads & Product Branding', 'desc' => 'We build brands that customers remember, then amplify them with high-converting Meta campaigns.', 'features' => ['Facebook & Instagram Ads with creative testing', 'Product branding, identity & visual system', 'Audience strategy, lookalikes & performance reporting']],
];
?>
<section class="py-14 md:py-20 bg-gradient-to-b from-primary/5 to-background">
  <div class="mx-auto max-w-4xl px-6 text-center">
    <span class="inline-block mb-4 px-3 py-1 rounded-full bg-secondary text-secondary-foreground text-xs font-medium">What We Do</span>
    <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-6">Six Ways We <span class="text-primary">Grow</span> Your Product</h1>
    <p class="text-lg text-muted-foreground font-serif">Product development, paid performance, and organic growth — under one roof.</p>
  </div>
</section>

<section class="py-14 md:py-20">
  <div class="mx-auto max-w-6xl px-6">
    <div class="grid md:grid-cols-2 gap-8">
      <?php foreach ($services as $service): ?>
        <div class="rounded-2xl border border-border bg-card p-6 md:p-8">
          <div class="inline-flex items-center justify-center w-14 h-14 rounded-xl bg-primary/10 mb-6"><?= icon($service['icon'], 'h-7 w-7 text-primary') ?></div>
          <h2 class="text-2xl font-bold tracking-tight mb-3"><?= h($service['title']) ?></h2>
          <p class="text-muted-foreground font-serif mb-6"><?= h($service['desc']) ?></p>
          <ul class="space-y-2 mb-6">
            <?php foreach ($service['features'] as $f): ?>
              <li class="flex items-start gap-2"><?= icon('check', 'h-5 w-5 text-green-600 flex-shrink-0 mt-0.5') ?><span class="text-muted-foreground text-sm"><?= h($f) ?></span></li>
            <?php endforeach; ?>
          </ul>
          <a href="/contact.php" class="inline-flex items-center gap-2 text-sm font-medium text-primary hover:underline">
            Get Started <?= icon('arrow-right', 'h-4 w-4') ?>
          </a>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="py-14 md:py-20 bg-muted/30">
  <div class="mx-auto max-w-4xl px-6 text-center">
    <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-4">Let's Build Something That Grows</h2>
    <p class="text-lg text-muted-foreground font-serif mb-8">Tell us where you are and where you want to be — no obligation, just a straight conversation.</p>
    <a href="/contact.php" class="inline-flex items-center gap-2 rounded-md px-6 py-3 text-sm font-medium bg-primary text-primary-foreground hover:opacity-90 transition-opacity">
      Get Your Free Strategy Session <?= icon('arrow-right', 'h-4 w-4') ?>
    </a>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
