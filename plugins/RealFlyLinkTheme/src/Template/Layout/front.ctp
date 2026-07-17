<?php
/**
 * RealFlyLink Theme — front.ctp
 * Bootstrap 3 navbar with PHP-filtered menu (no duplicate login/signup)
 * Dark/light mode toggle persists via localStorage
 */

function rf_nav_links($name) {
    $req   = \Cake\Routing\Router::getRequest();
    $uid   = $req->getSession()->read('Auth.User.id');
    $tbl   = \Cake\ORM\TableRegistry::getTableLocator()->get('Options')
                ->addBehavior('Translate', ['fields' => ['value']]);
    $items = json_decode($tbl->findByName($name)->first()->value);
    $skip  = ['signin','signup','sign-up','register','login','dashboard'];
    $html  = '';
    foreach ($items as $item) {
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
    return $html;
}
?>
<!DOCTYPE html>
<html lang="<?= locale_get_primary_language('') ?>">
<head>
<meta name="monetag" content="a269f41b5d2fd7c574d0c60467123811"/>
    <?= $this->element('front_head'); ?>
</head>
<body class="<?= ($this->request->getParam('_name') === 'home') ? 'home' : 'inner-page' ?>">
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
                <a class="navbar-brand rf-brand" href="<?= build_main_domain_url('/') ?>">
                    <span class="rf-logo-icon"><svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" class="rf-logo-pin" width="30" height="30"><g transform="translate(60,60)"><g transform="rotate(-38)"><ellipse cx="30" cy="0" rx="27" ry="12" fill="#9054D8"/></g><g transform="rotate(176)"><ellipse cx="24" cy="0" rx="21" ry="10" fill="#00B4E4"/></g><g transform="rotate(50)"><ellipse cx="24" cy="0" rx="21" ry="10" fill="#E448C0"/></g><g transform="rotate(118)"><ellipse cx="21" cy="0" rx="18" ry="9" fill="#CC30C0"/></g><circle r="6" fill="#fff" class="rf-pin-dot"/></g></svg></span>
                    <?= $logo['content'] ?>
                </a>
            <?php else: ?>
                <a class="navbar-brand rf-brand" href="<?= build_main_domain_url('/') ?>">
                    <span class="rf-logo-icon"><svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" class="rf-logo-pin" width="30" height="30"><g transform="translate(60,60)"><g transform="rotate(-38)"><ellipse cx="30" cy="0" rx="27" ry="12" fill="#9054D8"/></g><g transform="rotate(176)"><ellipse cx="24" cy="0" rx="21" ry="10" fill="#00B4E4"/></g><g transform="rotate(50)"><ellipse cx="24" cy="0" rx="21" ry="10" fill="#E448C0"/></g><g transform="rotate(118)"><ellipse cx="21" cy="0" rx="18" ry="9" fill="#CC30C0"/></g><circle r="6" fill="#fff" class="rf-pin-dot"/></g></svg></span>
                    <span class="rf-logo-text">Real<span>Fly</span><span class="rf-logo-link">Link<span class="rf-logo-dot">.com</span></span></span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Bootstrap collapse panel — opens on mobile hamburger click -->
        <div class="collapse navbar-collapse" id="rf-nav-collapse">

            <!-- Page links only (login/signup filtered out in PHP) -->
            <ul class="nav navbar-nav navbar-right rf-nav-links">
                <?= rf_nav_links('menu_main') ?>
            </ul>

            <!-- Auth buttons + dark toggle — always right side -->
            <ul class="nav navbar-nav navbar-right rf-nav-auth">
                <li class="rf-dark-li">
                    <button class="rf-dark-btn" onclick="rfToggleDark()" title="Toggle theme">
                        <span id="rf-dark-icon">☀️</span>
                    </button>
                </li>
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
