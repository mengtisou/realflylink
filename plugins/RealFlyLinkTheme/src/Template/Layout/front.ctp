<?php
/**
 * RealFlyLink Theme — front.ctp
 * Bootstrap 3 navbar with PHP-filtered menu (no duplicate login/signup)
 * Dark/light mode toggle persists via localStorage
 */

/**
 * Build the <li> list for a DB-driven menu.
 *
 * @param string $name  Options row name, e.g. 'menu_main'
 * @param array  $extra Items added in code, each ['title'=>, 'link'=>, 'class'=>].
 *                      Skipped automatically if an equivalent link already
 *                      exists in the DB menu, so adding it later in Menu
 *                      Manager will not produce a duplicate.
 */
function rf_nav_links($name, array $extra = []) {
    $req   = \Cake\Routing\Router::getRequest();
    $uid   = $req->getSession()->read('Auth.User.id');
    $tbl   = \Cake\ORM\TableRegistry::getTableLocator()->get('Options')
                ->addBehavior('Translate', ['fields' => ['value']]);
    $row   = $tbl->findByName($name)->first();
    $items = $row ? json_decode($row->value) : [];
    if (!is_array($items)) { $items = []; }
    $skip  = ['signin','signup','sign-up','register','login','dashboard'];
    $html  = '';
    $seen  = [];
    foreach ($items as $item) {
        $seen[] = trim(strtolower($item->link), '/');
        $hide = false;
        foreach ($skip as $w) {
            if (stripos($item->link, $w) !== false) { $hide = true; break; }
        }
        if ($hide) continue;
        if (($item->visibility === 'all') ||
            ($uid  && $item->visibility === 'logged') ||
            (!$uid && $item->visibility === 'guest')) {
            $html .= '<li class="' . h($item->class) . '">'
                   . '<a href="' . build_main_domain_url($item->link) . '">' . h($item->title) . '</a>'
                   . '</li>';
        }
    }
    foreach ($extra as $ex) {
        $key = trim(strtolower($ex['link']), '/');
        $dup = false;
        foreach ($seen as $s) {
            if ($s === $key || substr($s, -strlen($key)) === $key) { $dup = true; break; }
        }
        if ($dup) continue;
        $cls = isset($ex['class']) ? $ex['class'] : '';
        $html .= '<li class="' . h($cls) . '">'
               . '<a href="' . build_main_domain_url($ex['link']) . '">' . h($ex['title']) . '</a>'
               . '</li>';
    }
    return $html;
}

$isBlogPage = ($this->request->getParam('controller') === 'Posts');
$logoHref   = $isBlogPage ? build_main_domain_url('/blog') : build_main_domain_url('/');
?>
<!DOCTYPE html>
<html lang="<?= locale_get_primary_language('') ?>">
<head>
<meta name="monetag" content="a269f41b5d2fd7c574d0c60467123811"/>
    <?= $this->element('front_head'); ?>
</head>
<body class="<?= ($this->request->getParam('_name') === 'home') ? 'home' : 'inner-page' ?>">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-TLBRZM5D"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->

<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-MTG7BYG7HG"></script>
<script>
    window.dataLayer = window.dataLayer || [];
    function gtag() { dataLayer.push(arguments); }
    gtag('js', new Date());

    gtag('config', 'G-MTG7BYG7HG');
</script>
<?= get_option('after_body_tag_code'); ?>

<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Bootstrap 3 collapse trigger — bootstrap.min.js handles this automatically -->
            <button type="button" class="navbar-toggle collapsed"
                    data-toggle="collapse"
                    data-target="#rf-nav-collapse"
                    aria-expanded="false">
                <span class="sr-only"><?= __('Toggle navigation') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <?php $logo = get_logo(); ?>
            <?php if ($logo['type'] === 'image'): ?>
                <a class="navbar-brand rf-brand" href="<?= $logoHref ?>">
                    <span class="rf-logo-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" class="rf-logo-pin" width="24" height="24"><path d="M10 55 C 30 40, 45 40, 58 55 C 45 58, 30 62, 10 55 Z" fill="#4FA8E0"/><path d="M58 55 C 70 20, 95 8, 112 15 C 100 30, 90 45, 66 58 Z" fill="#8B5FD6"/><path d="M58 55 C 75 55, 90 65, 95 85 C 78 82, 64 74, 55 62 Z" fill="#B24FCB"/><path d="M55 62 C 60 78, 55 95, 42 108 C 40 92, 42 76, 50 62 Z" fill="#D14FA8"/><circle cx="60" cy="52" r="4.5" fill="#FFFFFF" class="rf-pin-dot"/></svg></span>
                    <?= $logo['content'] ?>
                </a>
            <?php else: ?>
                <a class="navbar-brand rf-brand" href="<?= $logoHref ?>">
                    <span class="rf-logo-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" class="rf-logo-pin" width="24" height="24"><path d="M10 55 C 30 40, 45 40, 58 55 C 45 58, 30 62, 10 55 Z" fill="#4FA8E0"/><path d="M58 55 C 70 20, 95 8, 112 15 C 100 30, 90 45, 66 58 Z" fill="#8B5FD6"/><path d="M58 55 C 75 55, 90 65, 95 85 C 78 82, 64 74, 55 62 Z" fill="#B24FCB"/><path d="M55 62 C 60 78, 55 95, 42 108 C 40 92, 42 76, 50 62 Z" fill="#D14FA8"/><circle cx="60" cy="52" r="4.5" fill="#FFFFFF" class="rf-pin-dot"/></svg></span>
                    <span class="rf-logo-text">Real<span>Fly</span><span class="rf-logo-link">Link<span class="rf-logo-dot">.com</span></span></span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Bootstrap collapse panel — opens on mobile hamburger click -->
        <div class="collapse navbar-collapse" id="rf-nav-collapse">

            <!-- Page links only (login/signup filtered out in PHP) -->
            <ul class="nav navbar-nav navbar-right rf-nav-links">
                <?php if ($isBlogPage): ?>
                    <?= rf_nav_links('menu_blog', [
                        ['title' => __('How To Download'), 'link' => '/pages/how-to-download'],
                    ]) ?>
                <?php else: ?>
                    <?= rf_nav_links('menu_main', [
                        ['title' => __('Earn Money'), 'link' => '/pages/earn-money'],
                    ]) ?>
                <?php endif; ?>
            </ul>

            <!-- Auth buttons + dark toggle — always right side -->
            <ul class="nav navbar-nav navbar-right rf-nav-auth">
                <?php if ($isBlogPage): ?>
                    <li class="rf-auth-li">
                        <a class="rf-btn-signup" href="<?= build_main_domain_url('/') ?>">
                            &larr; <?= __('Exit Blog') ?>
                        </a>
                    </li>
                <?php endif; ?>
                <li class="rf-dark-li">
                    <button class="rf-dark-btn" onclick="rfToggleDark()" title="Toggle theme">
                        <span id="rf-dark-icon">☀️</span>
                    </button>
                </li>
                <?php if (!$isBlogPage): ?>
                    <?php if ($this->request->getSession()->read('Auth.User.id')): ?>
                        <li class="rf-auth-li">
                            <a class="rf-btn-login" href="<?= build_main_domain_url('/member/dashboard') ?>">
                                <?= __('Dashboard') ?>
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="rf-auth-li">
                            <a class="rf-btn-login" href="<?= build_main_domain_url('/auth/signin') ?>">
                                <?= __('Login') ?>
                            </a>
                        </li>
                        <li class="rf-auth-li">
                            <a class="rf-btn-signup" href="<?= build_main_domain_url('/auth/signup') ?>">
                                <?= __('Sign Up Free') ?>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container -->
</nav>

<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
<?= $this->element('front_footer'); ?>

<script>
(function () {
    var dark = localStorage.getItem('rf-dark') !== 'light';
    function set(d) {
        document.body.classList.toggle('rf-light', !d);
        var el = document.getElementById('rf-dark-icon');
        if (el) el.textContent = d ? '☀️' : '🌙';
        localStorage.setItem('rf-dark', d ? 'dark' : 'light');
    }
    set(dark);
    window.rfToggleDark = function () { dark = !dark; set(dark); };
}());
</script>

</body>
</html>