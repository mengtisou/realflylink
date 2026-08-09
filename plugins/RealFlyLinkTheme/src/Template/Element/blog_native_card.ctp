<?php
/**
 * Native promo card — the Linkvertise-style in-feed unit.
 *
 * Full-width image, an "Ad" tag, a headline, and one wide button. It sits in
 * the content flow rather than floating, so it never covers anything.
 *
 * Driven by four Options, all set in Settings -> Blog:
 *   blog_native_img    image URL for the creative
 *   blog_native_title  headline under the image
 *   blog_native_url    where the card links (e.g. a Monetag Direct Link)
 *   blog_native_btn    button text; defaults to "Download and install"
 *
 * Renders nothing unless BOTH the image and the URL are set, so a
 * half-configured card never appears half-broken on the page.
 *
 * Google Drive share links are accepted for the image and converted to a
 * direct URL automatically.
 *
 * @var \App\View\AppView $this
 */

if (!function_exists('rf_native_img')) {
    function rf_native_img($url) {
        $url = trim((string)$url);
        if ($url === '' || stripos($url, 'drive.google.com') === false) { return $url; }
        if (preg_match('~/(?:file/)?d/([a-zA-Z0-9_-]{10,})~', $url, $m)
            || preg_match('~[?&]id=([a-zA-Z0-9_-]{10,})~', $url, $m)) {
            return 'https://lh3.googleusercontent.com/d/' . $m[1] . '=w1200';
        }
        return $url;
    }
}

$nImg   = function_exists('get_option') ? rf_native_img(get_option('blog_native_img', '')) : '';
$nUrl   = function_exists('get_option') ? trim((string)get_option('blog_native_url', '')) : '';
$nTitle = function_exists('get_option') ? trim((string)get_option('blog_native_title', '')) : '';
$nBtn   = function_exists('get_option') ? trim((string)get_option('blog_native_btn', '')) : '';

if ($nImg === '' || $nUrl === '') {
    return;
}
if ($nBtn === '') {
    $nBtn = __('Download and install');
}
?>
<div class="rf-native">

    <a class="rf-native-media" href="<?= h($nUrl) ?>" target="_blank" rel="noopener sponsored">
        <span class="rf-native-tag"><?= __('Ad') ?></span>
        <img src="<?= h($nImg) ?>" alt="<?= h($nTitle ?: __('Sponsored')) ?>" loading="lazy">
    </a>

    <div class="rf-native-body">
        <?php if ($nTitle !== ''): ?>
            <a class="rf-native-title" href="<?= h($nUrl) ?>" target="_blank" rel="noopener sponsored">
                <?= h($nTitle) ?>
            </a>
        <?php endif; ?>

        <a class="rf-native-btn" href="<?= h($nUrl) ?>" target="_blank" rel="noopener sponsored">
            <?= h($nBtn) ?>
        </a>
    </div>

</div>
