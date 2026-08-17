</main>

<footer class="border-t border-border bg-card overflow-hidden">
  <div class="border-b border-border py-3 bg-muted/30">
    <div class="flex gap-0 marquee-track">
      <?php foreach (array_merge(FOOTER_SERVICES, FOOTER_SERVICES) as $s): ?>
        <span class="inline-flex items-center gap-2 px-5 text-sm font-medium text-muted-foreground whitespace-nowrap shrink-0">
          <?= icon($s['icon'], 'h-3.5 w-3.5 text-primary shrink-0') ?>
          <?= h($s['label']) ?>
          <span class="mx-3 text-border select-none">&middot;</span>
        </span>
      <?php endforeach; ?>
    </div>
  </div>

  <div class="mx-auto max-w-6xl px-6 pt-12 pb-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-10 mb-10 items-start">
      <div>
        <a href="/" class="inline-flex items-center gap-2.5 mb-5">
          <img src="/assets/img/brox-logo.png" alt="BROX Tech" class="h-10 w-10 object-contain rounded-md" />
          <span class="text-xl font-bold tracking-tight">BROX Tech</span>
        </a>
        <p class="text-muted-foreground font-serif text-sm leading-relaxed mb-6 max-w-xs">
          Your full-stack growth partner — from product development to performance marketing and product branding.
        </p>
        <div class="space-y-2.5 text-sm">
          <a href="mailto:<?= h(SITE_CONTACT_EMAIL) ?>" class="flex items-center gap-2.5 text-muted-foreground hover:text-foreground transition-colors group">
            <span class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-muted group-hover:bg-primary/10 transition-colors"><?= icon('mail', 'h-3.5 w-3.5') ?></span>
            <?= h(SITE_CONTACT_EMAIL) ?>
          </a>
          <span class="flex items-center gap-2.5 text-muted-foreground">
            <span class="inline-flex items-center justify-center w-7 h-7 rounded-md bg-muted"><?= icon('map-pin', 'h-3.5 w-3.5') ?></span>
            <?= h(SITE_LOCATION) ?>
          </span>
        </div>
      </div>

      <a href="/contact.php" class="group block rounded-2xl border border-border bg-background hover:border-primary/40 hover:bg-primary/5 transition-all p-6">
        <div class="flex items-center justify-between">
          <div>
            <p class="text-xs font-semibold uppercase tracking-widest text-muted-foreground mb-1">Work with us</p>
            <h3 class="text-lg font-bold">Start a Project</h3>
            <p class="text-sm text-muted-foreground font-serif mt-1">Tell us what you're building — we'll make it grow.</p>
          </div>
          <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-primary/10 text-primary group-hover:bg-primary group-hover:text-white transition-all shrink-0 ml-4"><?= icon('arrow-right', 'h-4 w-4') ?></span>
        </div>
      </a>
    </div>

    <div class="border-t border-border pt-6 text-center">
      <p class="text-xs text-muted-foreground">&copy; <?= date('Y') ?> BROX Tech. All rights reserved.</p>
    </div>
  </div>
</footer>

<script src="/assets/js/app.js"></script>
</body>
</html>
