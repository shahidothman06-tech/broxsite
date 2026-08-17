<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/header.php';

$serviceOptions = [
    'product-development' => 'Product Development',
    'ecommerce' => 'Ecommerce Solutions',
    'product-growth' => 'Product Growth & Performance Marketing',
    'google-ads' => 'Google Ads',
    'seo-aso' => 'SEO, ASO & AI Search',
    'meta-branding' => 'Meta Ads & Branding',
];
?>
<section class="py-16 md:py-24 bg-gradient-to-b from-primary/5 to-background">
  <div class="mx-auto max-w-3xl px-6">
    <div class="text-center mb-12">
      <span class="inline-block mb-4 px-3 py-1 rounded-full bg-secondary text-secondary-foreground text-xs font-medium">Contact Us</span>
      <h1 class="text-4xl md:text-5xl font-bold tracking-tight mb-6">Get Your <span class="text-primary">Product Growth Strategy</span></h1>
      <p class="text-lg text-muted-foreground font-serif">Tell us about your product and we'll get back to you within 24 hours.</p>
    </div>

    <div id="form-success" class="hidden rounded-lg border border-green-500/30 bg-green-500/10 p-6 mb-6 text-center">
      <p class="font-semibold text-green-700">Thank you for your inquiry!</p>
      <p class="text-sm text-green-700/80 mt-1">We'll get back to you within 24 hours.</p>
    </div>
    <div id="form-error" class="hidden rounded-lg border border-destructive/30 bg-destructive/10 p-4 mb-6 text-sm text-destructive"></div>

    <form id="contact-form" class="space-y-6 rounded-2xl border border-border bg-card p-6 md:p-8" novalidate>
      <?= csrf_field() ?>
      <div class="hidden" aria-hidden="true">
        <label>Leave this field empty</label>
        <input type="text" name="website" tabindex="-1" autocomplete="off">
      </div>

      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label class="block text-sm font-medium mb-1.5">Full Name *</label>
          <input required name="name" type="text" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" />
        </div>
        <div>
          <label class="block text-sm font-medium mb-1.5">Email *</label>
          <input required name="email" type="email" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" />
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1.5">Company</label>
        <input name="company" type="text" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" />
      </div>

      <div>
        <label class="block text-sm font-medium mb-2">Which service(s) are you interested in? *</label>
        <div class="grid sm:grid-cols-2 gap-2">
          <?php foreach ($serviceOptions as $v => $l): ?>
            <label class="flex items-center gap-2 text-sm rounded-md border border-input px-3 py-2 cursor-pointer hover:bg-accent">
              <input type="checkbox" name="service[]" value="<?= h($v) ?>" class="rounded border-input">
              <?= h($l) ?>
            </label>
          <?php endforeach; ?>
        </div>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1.5">Tell us about your project</label>
        <textarea name="message" rows="4" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm"></textarea>
      </div>

      <button type="submit" id="contact-submit" class="w-full inline-flex items-center justify-center gap-2 rounded-md px-6 py-3 text-sm font-medium bg-primary text-primary-foreground hover:opacity-90 transition-opacity">
        Send Inquiry <?= icon('arrow-right', 'h-4 w-4') ?>
      </button>
    </form>

    <div class="mt-8 flex flex-wrap justify-center gap-6 text-sm text-muted-foreground">
      <a href="mailto:<?= h(SITE_CONTACT_EMAIL) ?>" class="flex items-center gap-2 hover:text-foreground transition-colors"><?= icon('mail', 'h-4 w-4') ?><?= h(SITE_CONTACT_EMAIL) ?></a>
      <a href="tel:<?= h(SITE_CONTACT_PHONE) ?>" class="flex items-center gap-2 hover:text-foreground transition-colors"><?= icon('phone', 'h-4 w-4') ?><?= h(SITE_CONTACT_PHONE) ?></a>
      <span class="flex items-center gap-2"><?= icon('map-pin', 'h-4 w-4') ?><?= h(SITE_LOCATION) ?></span>
    </div>
  </div>
</section>

<script>
document.getElementById('contact-form').addEventListener('submit', async function (e) {
  e.preventDefault();
  var form = e.target;
  var submitBtn = document.getElementById('contact-submit');
  var successBox = document.getElementById('form-success');
  var errorBox = document.getElementById('form-error');
  successBox.classList.add('hidden');
  errorBox.classList.add('hidden');

  if (form.website.value) return; // honeypot

  var services = Array.from(form.querySelectorAll('input[name="service[]"]:checked')).map(el => el.value);
  if (services.length === 0) {
    errorBox.textContent = 'Please select at least one service.';
    errorBox.classList.remove('hidden');
    return;
  }

  var payload = {
    csrf_token: form.csrf_token.value,
    name: form.name.value,
    email: form.email.value,
    company: form.company.value,
    service: services,
    message: form.message.value,
  };

  submitBtn.disabled = true;
  submitBtn.textContent = 'Sending...';

  try {
    var res = await fetch('/api/contact.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify(payload),
    });
    var data = await res.json();
    if (!res.ok) throw new Error(data.error || 'Something went wrong.');
    form.reset();
    successBox.classList.remove('hidden');
    successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
  } catch (err) {
    errorBox.textContent = err.message;
    errorBox.classList.remove('hidden');
  } finally {
    submitBtn.disabled = false;
    submitBtn.innerHTML = 'Send Inquiry';
  }
});
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
