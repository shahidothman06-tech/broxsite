<?php
declare(strict_types=1);
require_once __DIR__ . '/icons.php';
require_once __DIR__ . '/site.php';

$__currentPath = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?: '/';
$__meta = PAGE_META[$__currentPath] ?? PAGE_META['/'];
$__title = $pageTitle ?? $__meta['title'];
$__description = $pageDescription ?? $__meta['description'];
$__baseUrl = (isset($_SERVER['HTTPS']) ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'];
$__canonical = $__baseUrl . $__currentPath;
?><!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title><?= h($__title) ?></title>
  <meta name="description" content="<?= h($__description) ?>" />
  <link rel="canonical" href="<?= h($__canonical) ?>" />

  <meta property="og:title" content="<?= h($__title) ?>" />
  <meta property="og:description" content="<?= h($__description) ?>" />
  <meta property="og:type" content="website" />
  <meta property="og:site_name" content="BROX Tech" />
  <meta property="og:image" content="<?= h($__baseUrl . '/assets/img/og-image.png') ?>" />

  <link rel="icon" href="/assets/img/favicon.png" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="/assets/css/app.css?v=<?= @filemtime(ROOT_PATH . '/public/assets/css/app.css') ?: 1 ?>" />
</head>
<body class="bg-background text-foreground antialiased">

<header class="sticky top-0 z-50 w-full border-b border-border bg-background/95 backdrop-blur">
  <div class="mx-auto max-w-6xl px-6">
    <div class="flex h-16 items-center justify-between gap-4">
      <a href="/" class="flex items-center gap-2">
        <img src="/assets/img/brox-logo.png" alt="BROX Tech Logo" class="h-10 w-10 object-contain rounded-md" />
        <span class="text-xl font-bold tracking-tight">BROX Tech</span>
      </a>

      <nav class="hidden md:flex items-center gap-1">
        <?php foreach (NAV_ITEMS as $item): $active = $__currentPath === $item['href']; ?>
          <a href="<?= h($item['href']) ?>" class="inline-flex items-center rounded-md px-4 py-2 text-sm font-medium transition-colors <?= $active ? 'bg-primary text-primary-foreground' : 'hover:bg-accent text-foreground' ?>">
            <?= h($item['label']) ?>
          </a>
        <?php endforeach; ?>
      </nav>

      <div class="flex items-center gap-2">
        <a href="/contact.php" class="hidden sm:inline-flex items-center rounded-md px-4 py-2 text-sm font-medium bg-primary text-primary-foreground hover:opacity-90 transition-opacity">
          Get Started
        </a>
        <button id="mobile-menu-toggle" type="button" aria-label="Open menu" class="md:hidden inline-flex items-center justify-center h-9 w-9 rounded-md hover:bg-accent transition-colors">
          <?= icon('menu', 'h-5 w-5') ?>
        </button>
      </div>
    </div>
  </div>

  <div id="mobile-menu" class="hidden md:hidden border-t border-border bg-background px-6 py-4">
    <div class="flex flex-col gap-2">
      <?php foreach (NAV_ITEMS as $item): $active = $__currentPath === $item['href']; ?>
        <a href="<?= h($item['href']) ?>" class="w-full rounded-md px-4 py-2 text-sm font-medium <?= $active ? 'bg-primary text-primary-foreground' : 'hover:bg-accent' ?>">
          <?= h($item['label']) ?>
        </a>
      <?php endforeach; ?>
      <a href="/contact.php" class="w-full mt-2 rounded-md px-4 py-2 text-sm font-medium bg-primary text-primary-foreground text-center">Get Started</a>
    </div>
  </div>
</header>

<main>
