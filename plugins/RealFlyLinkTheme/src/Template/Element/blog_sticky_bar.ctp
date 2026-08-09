<?php
/**
 * Sticky bottom bar for blog pages — the Linkvertise-style strip that sits
 * above the fold on mobile.
 *
 * Two modes, decided automatically:
 *   1. If the Option `blog_ad_sticky` contains markup, that is rendered.
 *   2. Otherwise it falls back to a RealFlyLink sign-up promo, so the slot
 *      is never empty and earns something even with no ad sold.
 *
 * Dismissal is remembered in sessionStorage, so closing it lasts for the
 * browsing session but it returns on the next visit. Logged-in users never
 * see the promo fallback — they have already signed up.
 *
 * @var \App\View\AppView $this
 */

$stickyCode = function_exists('get_option') ? trim((string)get_option('blog_ad_sticky', '')) : '';
$isLoggedIn = (bool)$this->request->getSession()->read('Auth.User.id');

// nothing to show: no ad code, and the promo would be pointless for a member
if ($stickyCode === '' && $isLoggedIn) {
    return;
}
?>
<div class="rf-sticky" id="rfSticky" role="complementary" aria-label="<?= __('Promotion') ?>">
    <button type="button" class="rf-sticky-x" id="rfStickyX" aria-label="<?= __('Close') ?>">&times;</button>

    <?php if ($stickyCode !== ''): ?>
        <div class="rf-sticky-ad"><?= $stickyCode ?></div>
    <?php else: ?>
        <a class="rf-sticky-promo" href="<?= build_main_domain_url('/auth/signup') ?>">
            <span class="rf-sticky-txt">
                <b><?= __('Post &amp; earn!') ?></b>
                <?= __('Get paid for every 1,000 visitors.') ?>
            </span>
            <span class="rf-sticky-cta"><?= __('Start free') ?></span>
        </a>
    <?php endif; ?>
</div>

<script>
(function () {
    var bar = document.getElementById('rfSticky');
    if (!bar) { return; }
    var KEY = 'rf_sticky_closed';
    try {
        if (sessionStorage.getItem(KEY)) { bar.parentNode.removeChild(bar); return; }
    } catch (e) { /* private mode — just show it */ }

    document.body.classList.add('rf-has-sticky');
    // slide in once, after the page has settled
    setTimeout(function () { bar.classList.add('rf-sticky-in'); }, 600);

    document.getElementById('rfStickyX').addEventListener('click', function () {
        bar.classList.remove('rf-sticky-in');
        document.body.classList.remove('rf-has-sticky');
        try { sessionStorage.setItem(KEY, '1'); } catch (e) {}
        setTimeout(function () {
            if (bar.parentNode) { bar.parentNode.removeChild(bar); }
        }, 300);
    });
})();
</script>
