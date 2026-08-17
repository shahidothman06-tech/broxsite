<?php
declare(strict_types=1);

define('SITE_CONTACT_EMAIL', env('SITE_CONTACT_EMAIL', 'hello@broxpvt.com'));
define('SITE_CONTACT_PHONE', env('SITE_CONTACT_PHONE', '+966 5X XXX XXXX'));
define('SITE_LOCATION', env('SITE_LOCATION', 'Jeddah, Saudi Arabia'));

const NAV_ITEMS = [
    ['label' => 'Home', 'href' => '/'],
    ['label' => 'Services', 'href' => '/services.php'],
    ['label' => 'Careers', 'href' => '/jobs.php'],
    ['label' => 'Contact', 'href' => '/contact.php'],
];

const FOOTER_SERVICES = [
    ['icon' => 'code', 'label' => 'Product Development'],
    ['icon' => 'trending-up', 'label' => 'Product Marketing & Growth'],
    ['icon' => 'search', 'label' => 'SEO & ASO / AI Search'],
    ['icon' => 'shopping-bag', 'label' => 'Ecommerce Solutions'],
    ['icon' => 'megaphone', 'label' => 'Google Ads & Meta Ads'],
    ['icon' => 'palette', 'label' => 'Product Branding'],
];

const PAGE_META = [
    '/' => [
        'title' => 'BROX Tech — Build, Grow & Scale Your Product',
        'description' => 'Full-stack growth partner: product development, ecommerce solutions, performance marketing, Google Ads, SEO, ASO, AI Search, Meta Ads & Product Branding.',
    ],
    '/services.php' => [
        'title' => 'Services — BROX Tech',
        'description' => 'Product Growth, Google Ads, SEO, ASO, AI Search, Meta Ads & Product Branding services from BROX Tech.',
    ],
    '/jobs.php' => [
        'title' => "We're Hiring — BROX Tech (Jeddah / Remote)",
        'description' => 'Join the BROX Tech team. Open roles: AI Engineer & AI Expert. Full-time, based in Jeddah, Saudi Arabia or remote. Apply now.',
    ],
    '/contact.php' => [
        'title' => 'Contact — BROX Tech',
        'description' => "Get a free product growth audit from BROX Tech. Tell us about your product and we'll build a custom strategy.",
    ],
];
