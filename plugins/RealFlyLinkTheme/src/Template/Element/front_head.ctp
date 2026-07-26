<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?= $this->Html->charset(); ?>
<!-- Google Tag Manager -->
<script>(function (w, d, s, l, i) {
        w[l] = w[l] || []; w[l].push({
            'gtm.start':
                new Date().getTime(), event: 'gtm.js'
        }); var f = d.getElementsByTagName(s)[0],
            j = d.createElement(s), dl = l != 'dataLayer' ? '&l=' + l : ''; j.async = true; j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl; f.parentNode.insertBefore(j, f);
    })(window, document, 'script', 'dataLayer', 'GTM-TLBRZM5D');</script>
<!-- End Google Tag Manager -->
 
<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MTG7BYG7HG"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'G-MTG7BYG7HG');
</script>
<meta name="monetag" content="a269f41b5d2fd7c574d0c60467123811"/>
<title><?= h($this->fetch('title')); ?></title>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="color-scheme" content="dark">
<meta name="description" content="<?= h($this->fetch('description')); ?>">
<meta name="keywords" content="<?= h(get_option('seo_keywords')); ?>">

<?= $this->Assets->favicon() ?>

<!-- Inter font -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

<?php
if ((bool)get_option('combine_minify_css_js', false)) {
    // styles.min.css already has realfly-dark.css appended at the end
    echo $this->Assets->css('/build/css/styles.min.css?ver=' . APP_VERSION);
} else {
    echo $this->Assets->css('/vendor/bootstrap/css/bootstrap.min.css?ver=' . APP_VERSION);
    echo $this->Assets->css('/vendor/font-awesome/css/font-awesome.min.css?ver=' . APP_VERSION);
    echo $this->Assets->css('/vendor/animate.min.css?ver=' . APP_VERSION);
    echo $this->Assets->css('/vendor/owl/owl.carousel.min.css?ver=' . APP_VERSION);
    echo $this->Assets->css('/vendor/owl/owl.theme.default.css?ver=' . APP_VERSION);
    echo $this->Assets->css('/css/front.css?ver=' . APP_VERSION);
    echo $this->Assets->css('/css/app.css?ver=' . APP_VERSION);
    echo $this->Assets->css('/css/spritesheet.css?ver=' . APP_VERSION);
    // RealFlyLink dark theme — loaded last so it overrides Bootstrap + front.css
    echo $this->Assets->css('/build/css/realfly-dark.css?ver=' . APP_VERSION);
}
echo $this->fetch('meta');
echo $this->fetch('css');
echo $this->fetch('script');
?>

<?= get_option('head_code'); ?>
<?= $this->fetch('scriptTop') ?>

<!--[if lt IE 9]>
<script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
