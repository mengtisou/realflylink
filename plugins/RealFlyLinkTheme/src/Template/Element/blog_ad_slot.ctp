<?php
/**
 * Reusable blog ad slot.
 *
 * Usage:  <?= $this->element('blog_ad_slot', ['slot' => 'blog_ad_top']) ?>
 *
 * The slot's HTML comes from an Option of the same name, so ad network code
 * (Monetag, Adsterra, AdSense, a direct <a><img>) is pasted in the database
 * or admin settings — never in this file. An empty option renders nothing at
 * all, so unsold slots leave no gap on the page.
 *
 * @var \App\View\AppView $this
 * @var string $slot   option name holding the ad markup
 * @var string $label  optional caption; defaults to "Advertisement"
 *
 * NOTE: the option value is echoed raw and NOT escaped. That is deliberate —
 * it has to contain <script> and <ins> tags to work. Only administrators can
 * set it, so treat it like any other admin-supplied template snippet.
 */

$slot = isset($slot) ? $slot : '';
$code = $slot && function_exists('get_option') ? trim((string)get_option($slot, '')) : '';

if ($code === '') {
    return;
}

$label = isset($label) ? $label : __('Advertisement');
?>
<div class="rf-promo rf-promo-<?= h(str_replace('_', '-', $slot)) ?>">
    <span class="rf-promo-label"><?= h($label) ?></span>
    <div class="rf-promo-inner"><?= $code ?></div>
</div>
