<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/jobs.php';
require_once __DIR__ . '/../includes/header.php';

$jobs = jobs_open();

$perks = [
    'Competitive salary',
    'Remote-friendly culture',
    'Work on real growth challenges',
    'Cutting-edge AI tools',
    'Fast-growing agency',
    'Direct impact on results',
];

// ?role=ai-engineer preselects that role in the application form, so the
// "Apply" button on each card can jump straight to a prefilled form.
$requestedRole = (string)($_GET['role'] ?? '');
$validIds = array_column($jobs, 'id');
if (!in_array($requestedRole, $validIds, true)) {
    $requestedRole = '';
}
?>

<section class="relative overflow-hidden">
  <div class="absolute inset-0 bg-gradient-to-br from-primary/5 via-background to-accent/10"></div>
  <div class="relative mx-auto max-w-4xl px-6 py-16 md:py-24 text-center">
    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-primary/10 text-primary text-sm font-medium border border-primary/20 mb-6">
      <?= icon('briefcase', 'h-4 w-4') ?> We're hiring
    </div>
    <h1 class="text-4xl md:text-5xl font-bold tracking-tight leading-[1.1] mb-6">
      Build the Future of <span class="text-primary">AI-Driven Growth</span>
    </h1>
    <p class="text-lg text-muted-foreground font-serif max-w-2xl mx-auto leading-relaxed mb-8">
      We're a product growth and performance marketing team in Jeddah, working with brands across Saudi Arabia and beyond. Join us and put AI to work on real growth problems.
    </p>
    <a href="#open-roles" class="inline-flex items-center gap-2 rounded-md px-6 py-3 text-sm font-medium bg-primary text-primary-foreground shadow-lg hover:opacity-90 transition-opacity">
      See Open Roles <?= icon('arrow-right', 'h-4 w-4') ?>
    </a>
  </div>
</section>

<section class="py-14 md:py-20 bg-muted/30">
  <div class="mx-auto max-w-6xl px-6">
    <div class="text-center mb-10">
      <span class="inline-block text-sm font-medium text-primary mb-4 uppercase tracking-wide">Why BROX</span>
      <h2 class="text-3xl md:text-4xl font-bold tracking-tight">What You Get</h2>
    </div>
    <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-4">
      <?php foreach ($perks as $perk): ?>
        <div class="flex items-center gap-3 rounded-lg border border-border bg-card px-5 py-4">
          <span class="inline-flex items-center justify-center w-8 h-8 rounded-full bg-primary/10 text-primary shrink-0"><?= icon('check', 'h-4 w-4') ?></span>
          <span class="text-sm font-medium"><?= h($perk) ?></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="open-roles" class="py-14 md:py-20">
  <div class="mx-auto max-w-4xl px-6">
    <div class="text-center mb-12">
      <span class="inline-block text-sm font-medium text-primary mb-4 uppercase tracking-wide">Open Roles</span>
      <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-4"><?= count($jobs) ?> Positions Open</h2>
      <p class="text-muted-foreground font-serif">Expand a role to see the full description.</p>
    </div>

    <div class="space-y-6">
      <?php foreach ($jobs as $job): ?>
        <div class="rounded-2xl border border-border bg-card overflow-hidden">
          <div class="p-6 md:p-8">
            <div class="flex items-start justify-between gap-4 mb-4">
              <div class="flex items-start gap-4">
                <span class="inline-flex items-center justify-center w-12 h-12 rounded-lg bg-primary/10 text-primary shrink-0"><?= icon($job['icon'], 'h-6 w-6') ?></span>
                <div>
                  <h3 class="text-xl font-bold tracking-tight mb-1"><?= h($job['title']) ?></h3>
                  <p class="text-sm text-muted-foreground"><?= h($job['department']) ?></p>
                </div>
              </div>
            </div>

            <p class="text-muted-foreground font-serif text-sm leading-relaxed mb-4"><?= h($job['summary']) ?></p>

            <div class="flex flex-wrap gap-2 mb-6">
              <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium rounded-full border border-border bg-muted/50 text-muted-foreground">
                <?= icon('clock', 'h-3 w-3') ?> <?= h($job['type']) ?>
              </span>
              <span class="inline-flex items-center gap-1.5 px-3 py-1 text-xs font-medium rounded-full border border-border bg-muted/50 text-muted-foreground">
                <?= icon('map-pin', 'h-3 w-3') ?> <?= h($job['location']) ?>
              </span>
            </div>

            <details class="group border-t border-border pt-5">
              <summary class="flex items-center justify-between cursor-pointer text-sm font-semibold list-none">
                <span>Full description</span>
                <span class="inline-flex items-center justify-center w-7 h-7 rounded-full bg-muted text-muted-foreground transition-transform group-open:rotate-180"><?= icon('chevron-down', 'h-4 w-4') ?></span>
              </summary>

              <div class="mt-5 space-y-6">
                <?php
                $sections = [
                    'What You\'ll Do' => $job['responsibilities'],
                    'What We\'re Looking For' => $job['requirements'],
                    'Nice to Have' => $job['nice'],
                ];
                foreach ($sections as $heading => $items): ?>
                  <div>
                    <h4 class="text-sm font-semibold uppercase tracking-wide text-primary mb-3"><?= h($heading) ?></h4>
                    <ul class="space-y-2">
                      <?php foreach ($items as $item): ?>
                        <li class="flex items-start gap-2.5 text-sm text-muted-foreground font-serif leading-relaxed">
                          <span class="text-primary shrink-0 mt-0.5"><?= icon('check', 'h-4 w-4') ?></span>
                          <span><?= h($item) ?></span>
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>
                <?php endforeach; ?>
              </div>
            </details>

            <div class="mt-6 pt-5 border-t border-border">
              <a href="#apply" data-role="<?= h($job['id']) ?>" class="apply-link inline-flex items-center gap-2 rounded-md px-5 py-2.5 text-sm font-medium bg-primary text-primary-foreground hover:opacity-90 transition-opacity">
                Apply for <?= h($job['title']) ?> <?= icon('arrow-right', 'h-4 w-4') ?>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section id="apply" class="py-14 md:py-20 bg-muted/30">
  <div class="mx-auto max-w-3xl px-6">
    <div class="text-center mb-10">
      <span class="inline-block text-sm font-medium text-primary mb-4 uppercase tracking-wide">Apply</span>
      <h2 class="text-3xl md:text-4xl font-bold tracking-tight mb-4">Send Us Your Application</h2>
      <p class="text-muted-foreground font-serif">Tell us a little about yourself and attach your CV. We read every application.</p>
    </div>

    <div id="apply-success" class="hidden rounded-lg border border-green-500/30 bg-green-500/10 p-6 mb-6 text-center">
      <p class="font-semibold text-green-700">Application received!</p>
      <p class="text-sm text-green-700/80 mt-1">Thanks for applying — we'll be in touch if there's a fit.</p>
    </div>
    <div id="apply-error" class="hidden rounded-lg border border-destructive/30 bg-destructive/10 p-4 mb-6 text-sm text-destructive"></div>

    <form id="apply-form" class="space-y-6 rounded-2xl border border-border bg-card p-6 md:p-8" novalidate>
      <?= csrf_field() ?>
      <div class="hidden" aria-hidden="true">
        <label>Leave this field empty</label>
        <input type="text" name="website" tabindex="-1" autocomplete="off">
      </div>

      <div>
        <label for="job" class="block text-sm font-medium mb-1.5">Which role? *</label>
        <select required id="job" name="job" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm">
          <?php foreach ($jobs as $job): ?>
            <option value="<?= h($job['id']) ?>" <?= $requestedRole === $job['id'] ? 'selected' : '' ?>><?= h($job['title']) ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="grid sm:grid-cols-2 gap-4">
        <div>
          <label for="name" class="block text-sm font-medium mb-1.5">Full Name *</label>
          <input required id="name" name="name" type="text" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" />
        </div>
        <div>
          <label for="email" class="block text-sm font-medium mb-1.5">Email *</label>
          <input required id="email" name="email" type="email" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" />
        </div>
      </div>

      <div>
        <label for="portfolio" class="block text-sm font-medium mb-1.5">Portfolio / GitHub / LinkedIn</label>
        <input id="portfolio" name="portfolio" type="url" placeholder="https://" class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm" />
      </div>

      <div>
        <label for="message" class="block text-sm font-medium mb-1.5">Why you? *</label>
        <textarea required id="message" name="message" rows="5" placeholder="Tell us what you've built and why this role fits." class="w-full rounded-md border border-input bg-background px-3 py-2 text-sm"></textarea>
      </div>

      <div>
        <label for="cv" class="block text-sm font-medium mb-1.5">CV / Resume</label>
        <label for="cv" class="flex items-center gap-3 rounded-md border border-dashed border-input bg-background px-4 py-4 cursor-pointer hover:border-primary transition-colors">
          <span class="inline-flex items-center justify-center w-9 h-9 rounded-md bg-muted text-muted-foreground shrink-0"><?= icon('upload', 'h-4 w-4') ?></span>
          <span>
            <span id="cv-label" class="block text-sm font-medium">Choose a file</span>
            <span class="block text-xs text-muted-foreground mt-0.5">PDF, DOC or DOCX &middot; up to 4 MB</span>
          </span>
        </label>
        <input id="cv" name="cv" type="file" accept=".pdf,.doc,.docx,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document" class="hidden" />
      </div>

      <button type="submit" id="apply-submit" class="w-full inline-flex items-center justify-center gap-2 rounded-md px-6 py-3 text-sm font-medium bg-primary text-primary-foreground hover:opacity-90 transition-opacity">
        Submit Application <?= icon('arrow-right', 'h-4 w-4') ?>
      </button>
    </form>

    <p class="text-center text-sm text-muted-foreground mt-6">
      Prefer email? Write to
      <a href="mailto:<?= h(SITE_CONTACT_EMAIL) ?>" class="text-primary hover:underline"><?= h(SITE_CONTACT_EMAIL) ?></a>
    </p>
  </div>
</section>

<script>
(function () {
  var MAX_BYTES = 4 * 1024 * 1024;
  var form = document.getElementById('apply-form');
  var cvInput = document.getElementById('cv');
  var cvLabel = document.getElementById('cv-label');
  var submitBtn = document.getElementById('apply-submit');
  var successBox = document.getElementById('apply-success');
  var errorBox = document.getElementById('apply-error');
  var cv = null;

  function showError(msg) {
    errorBox.textContent = msg;
    errorBox.classList.remove('hidden');
  }

  // "Apply for X" buttons preselect that role, then scroll to the form.
  document.querySelectorAll('.apply-link').forEach(function (link) {
    link.addEventListener('click', function () {
      document.getElementById('job').value = link.getAttribute('data-role');
    });
  });

  cvInput.addEventListener('change', function () {
    errorBox.classList.add('hidden');
    var file = cvInput.files && cvInput.files[0];
    if (!file) { cv = null; cvLabel.textContent = 'Choose a file'; return; }

    if (file.size > MAX_BYTES) {
      cvInput.value = '';
      cv = null;
      cvLabel.textContent = 'Choose a file';
      showError('That file is larger than 4 MB. Please attach a smaller CV.');
      return;
    }

    var reader = new FileReader();
    reader.onload = function () {
      // strip the "data:...;base64," prefix — the server wants raw base64
      cv = { name: file.name, type: file.type || 'application/octet-stream', data_base64: String(reader.result).split(',')[1] };
      cvLabel.textContent = file.name;
    };
    reader.onerror = function () { showError('Could not read that file. Please try another.'); };
    reader.readAsDataURL(file);
  });

  form.addEventListener('submit', async function (e) {
    e.preventDefault();
    successBox.classList.add('hidden');
    errorBox.classList.add('hidden');

    if (form.website.value) return; // honeypot

    var payload = {
      csrf_token: form.csrf_token.value,
      job: form.job.value,
      name: form.name.value,
      email: form.email.value,
      portfolio: form.portfolio.value,
      message: form.message.value,
      cv: cv,
    };

    submitBtn.disabled = true;
    submitBtn.textContent = 'Sending...';

    try {
      var res = await fetch('/api/jobs-apply.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload),
      });
      var data = await res.json();
      if (!res.ok) throw new Error(data.error || 'Something went wrong.');
      form.reset();
      cv = null;
      cvLabel.textContent = 'Choose a file';
      successBox.classList.remove('hidden');
      successBox.scrollIntoView({ behavior: 'smooth', block: 'center' });
    } catch (err) {
      showError(err.message);
    } finally {
      submitBtn.disabled = false;
      submitBtn.innerHTML = 'Submit Application';
    }
  });
})();
</script>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
