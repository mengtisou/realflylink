<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="<?= locale_get_primary_language('') ?>">
<head>
    <meta name="referrer" content="no-referrer-when-downgrade" />
    <meta name="robots" content="noindex, nofollow">
    <meta name="og:title" content="<?= h($this->fetch('og_title')); ?>">
    <meta name="og:description" content="<?= h($this->fetch('og_description')); ?>">
    <meta property="og:image" content="<?= h($this->fetch('og_image')); ?>"/>
    <?= $this->element('front_head'); ?>
</head>
<body class="interstitial-page rf-interstitial-page">
<?= get_option('after_body_tag_code'); ?>

<nav id="mainNav" class="navbar navbar-default">
    <div class="container">
        <div class="row is-table-row">

            <!-- Aurora logo — matches captcha/front layout -->
            <div class="col-xs-6 col-sm-3">
                <div class="navbar-header pull-left">
                    <a class="navbar-brand rf-brand" href="<?= build_main_domain_url('/'); ?>">
                        <span class="rf-logo-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" class="rf-logo-pin" width="24" height="24"><path d="M10 55 C 30 40, 45 40, 58 55 C 45 58, 30 62, 10 55 Z" fill="#4FA8E0"/><path d="M58 55 C 70 20, 95 8, 112 15 C 100 30, 90 45, 66 58 Z" fill="#8B5FD6"/><path d="M58 55 C 75 55, 90 65, 95 85 C 78 82, 64 74, 55 62 Z" fill="#B24FCB"/><path d="M55 62 C 60 78, 55 95, 42 108 C 40 92, 42 76, 50 62 Z" fill="#D14FA8"/><circle cx="60" cy="52" r="4.5" fill="#FFFFFF" class="rf-pin-dot"/></svg></span>
                        <span class="rf-logo-text">Real<span>Fly</span><span class="rf-logo-link">Link<span class="rf-logo-dot">.com</span></span></span>
                    </a>
                </div>
            </div>

            <!-- Centre banner ad slot -->
            <div class="hidden-xs col-sm-6">
                <?php if (!empty($interstitial_banner_ad)) : ?>
                    <div class="banner banner-468x60">
                        <div class="banner-inner">
                            <?= $interstitial_banner_ad; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Countdown in nav -->
            <div class="col-xs-6 col-sm-3">
                <div class="pull-right">
                    <div class="skip-ad">
                        <div class="text-center">
                            <span><?= __('Please Wait') ?></span><br>
                            <span class="counter"></span>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</nav>

<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>

<?= $this->element('js_vars'); ?>

<?php
echo $this->Assets->script('/js/ads.js');

if ((bool)get_option('combine_minify_css_js', false)) {
    echo $this->Assets->script('/build/js/script.min.js?ver=' . APP_VERSION);
} else {
    echo $this->Assets->script('/vendor/jquery.min.js?ver=' . APP_VERSION);
    echo $this->Assets->script('/vendor/bootstrap/js/bootstrap.min.js?ver=' . APP_VERSION);
    echo $this->Assets->script('/vendor/owl/owl.carousel.min.js?ver=' . APP_VERSION);
    echo $this->Assets->script('/vendor/wow.min.js?ver=' . APP_VERSION);
    echo $this->Assets->script('/vendor/clipboard.min.js?ver=' . APP_VERSION);
    echo $this->Assets->script('/js/front.js?ver=' . APP_VERSION);
    echo $this->Assets->script('/js/app.js?ver=' . APP_VERSION);
}
?>

<?= $this->fetch('scriptBottom') ?>
<?= get_option('footer_code'); ?>

</body>
</html>
