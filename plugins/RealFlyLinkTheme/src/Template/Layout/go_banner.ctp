<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="<?= locale_get_primary_language('') ?>">
<head>
    <meta name="robots" content="noindex, nofollow">
    <meta name="og:title" content="<?= h($this->fetch('og_title')); ?>">
    <meta name="og:description" content="<?= h($this->fetch('og_description')); ?>">
    <meta property="og:image" content="<?= h($this->fetch('og_image')); ?>"/>
    <?= $this->element('front_head'); ?>
</head>
<body class="banner-page rf-banner-page">
<?= get_option('after_body_tag_code'); ?>

<!-- Navigation -->
<nav id="mainNav" class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header page-scroll">
            <button type="button" class="navbar-toggle" data-toggle="collapse"
                    data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only"><?= __('Toggle navigation') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Aurora logo -->
            <a class="navbar-brand rf-brand" href="<?= build_main_domain_url('/'); ?>">
                <span class="rf-logo-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" class="rf-logo-pin" width="24" height="24"><path d="M10 55 C 30 40, 45 40, 58 55 C 45 58, 30 62, 10 55 Z" fill="#4FA8E0"/><path d="M58 55 C 70 20, 95 8, 112 15 C 100 30, 90 45, 66 58 Z" fill="#8B5FD6"/><path d="M58 55 C 75 55, 90 65, 95 85 C 78 82, 64 74, 55 62 Z" fill="#B24FCB"/><path d="M55 62 C 60 78, 55 95, 42 108 C 40 92, 42 76, 50 62 Z" fill="#D14FA8"/><circle cx="60" cy="52" r="4.5" fill="#FFFFFF" class="rf-pin-dot"/></svg></span>
                <span class="rf-logo-text">Real<span>Fly</span><span class="rf-logo-link">Link<span class="rf-logo-dot">.com</span></span></span>
            </a>
        </div>

        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?=
            menu_display('menu_short', [
                'ul_class' => 'nav navbar-nav navbar-right rf-nav-links',
                'li_class' => '',
                'a_class'  => '',
            ], true);
            ?>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </div>
</div>

<?= $this->element('front_footer'); ?>

</body>
</html>
