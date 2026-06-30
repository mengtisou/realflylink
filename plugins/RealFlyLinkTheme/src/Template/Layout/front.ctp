<?php
/**
 * @var \App\View\AppView $this
 */
?>
<!DOCTYPE html>
<html lang="<?= locale_get_primary_language('') ?>">
<head>
<meta name="monetag" content="a269f41b5d2fd7c574d0c60467123811"/>
    <?= $this->element('front_head'); ?>
</head>
<body class="<?= ($this->request->getParam('_name') === 'home') ? 'home' : 'inner-page' ?>">
<?= get_option('after_body_tag_code'); ?>

<!-- ═══ NAVBAR ═══ -->
<nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header page-scroll">

            <!-- Mobile hamburger -->
            <button type="button" class="navbar-toggle collapsed"
                    aria-expanded="false" onclick="rfToggleDrawer()">
                <span class="sr-only"><?= __('Toggle navigation') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Logo -->
            <?php $logo = get_logo(); ?>
            <?php if ($logo['type'] === 'image'): ?>
                <a class="navbar-brand logo-image rf-logo-wrap" href="<?= build_main_domain_url('/') ?>">
                    <?= $logo['content'] ?>
                </a>
            <?php else: ?>
                <a class="navbar-brand rf-logo-wrap" href="<?= build_main_domain_url('/') ?>">
                    <span class="rf-logo-icon">RF</span>
                    <span class="rf-logo-text">Real<span>Fly</span>Link</span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Desktop nav -->
        <div class="collapse navbar-collapse" id="rf-navbar-collapse">

            <?php
            // Output menu_main but CSS hides any login/register items already in it
            // so our styled buttons below don't duplicate
            menu_display('menu_main', [
                'ul_class' => 'nav navbar-nav navbar-right rf-menu-main',
                'li_class' => '',
                'a_class'  => '',
            ], true);
            ?>

            <!-- Dark toggle + styled auth buttons -->
            <ul class="nav navbar-nav navbar-right rf-nav-auth">
                <li>
                    <button class="rf-dark-toggle" onclick="rfToggleDark()" title="Toggle dark/light">
                        <span id="rf-dark-icon">☀️</span>
                    </button>
                </li>
                <?php if ($this->request->getSession()->read('Auth.User.id')): ?>
                    <li>
                        <a class="rf-nav-btn-login" href="<?= build_main_domain_url('/member/dashboard') ?>">
                            <?= __('Dashboard') ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a class="rf-nav-btn-login" href="<?= build_main_domain_url('/login') ?>">
                            <?= __('Login') ?>
                        </a>
                    </li>
                    <li>
                        <a class="rf-nav-btn-signup" href="<?= build_main_domain_url('/register') ?>">
                            <?= __('Sign Up Free') ?>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- ═══ MOBILE DRAWER ═══ -->
<div id="rf-mobile-drawer" class="rf-mobile-drawer" aria-hidden="true">
    <a href="<?= build_main_domain_url('/') ?>">🏠 <?= __('Home') ?></a>
    <a href="<?= build_main_domain_url('/page/rates') ?>">📊 <?= __('Rates') ?></a>
    <a href="<?= build_main_domain_url('/page/payment-proof') ?>">💵 <?= __('Payment Proof') ?></a>
    <a href="<?= build_main_domain_url('/blog') ?>">📝 <?= __('Blog') ?></a>
    <a href="<?= build_main_domain_url('/contact') ?>">✉️ <?= __('Contact') ?></a>
    <div class="rf-drawer-divider"></div>
    <?php if ($this->request->getSession()->read('Auth.User.id')): ?>
        <a href="<?= build_main_domain_url('/member/dashboard') ?>" class="rf-drawer-highlight">
            📈 <?= __('My Dashboard') ?>
        </a>
    <?php else: ?>
        <a href="<?= build_main_domain_url('/login') ?>" class="rf-drawer-login-btn">
            <?= __('Login') ?>
        </a>
        <a href="<?= build_main_domain_url('/register') ?>" class="rf-drawer-signup-btn">
            <?= __('Sign Up Free →') ?>
        </a>
    <?php endif; ?>
</div>
<div id="rf-drawer-backdrop" onclick="rfCloseDrawer()"></div>

<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>
<?= $this->element('front_footer'); ?>

<script>
// ── DARK MODE ─────────────────────────────────────────────────────
(function(){
    var isDark = localStorage.getItem('rf-dark') !== 'light';
    function applyDark(dark) {
        document.body.classList.toggle('rf-light', !dark);
        var icon = document.getElementById('rf-dark-icon');
        if (icon) icon.textContent = dark ? '☀️' : '🌙';
        localStorage.setItem('rf-dark', dark ? 'dark' : 'light');
    }
    applyDark(isDark);
    window.rfToggleDark = function(){ isDark = !isDark; applyDark(isDark); };
})();

// ── MOBILE DRAWER ─────────────────────────────────────────────────
(function(){
    var drawer   = document.getElementById('rf-mobile-drawer');
    var backdrop = document.getElementById('rf-drawer-backdrop');
    var open     = false;
    window.rfToggleDrawer = function(){ open ? rfCloseDrawer() : rfOpenDrawer(); };
    function rfOpenDrawer(){
        open = true;
        drawer.classList.add('open');
        backdrop.style.display = 'block';
        document.body.style.overflow = 'hidden';
    }
    window.rfCloseDrawer = function(){
        open = false;
        drawer.classList.remove('open');
        backdrop.style.display = 'none';
        document.body.style.overflow = '';
    };
    document.addEventListener('keydown', function(e){ if(e.key==='Escape' && open) rfCloseDrawer(); });
    window.addEventListener('resize', function(){ if(window.innerWidth>768 && open) rfCloseDrawer(); });
})();
</script>

</body>
</html>
