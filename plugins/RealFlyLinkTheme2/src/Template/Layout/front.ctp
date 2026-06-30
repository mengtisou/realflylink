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

            <!-- Hamburger toggle (Bootstrap 3 default + our custom JS drawer) -->
            <button type="button"
                    class="navbar-toggle collapsed"
                    aria-expanded="false"
                    onclick="rfToggleDrawer()">
                <span class="sr-only"><?= __('Toggle navigation') ?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <?php
            $logo    = get_logo();
            $isImage = ($logo['type'] === 'image');
            ?>

            <?php if ($isImage): ?>
                <a class="navbar-brand logo-image rf-logo-wrap"
                   href="<?= build_main_domain_url('/') ?>">
                    <?= $logo['content'] ?>
                </a>
            <?php else: ?>
                <a class="navbar-brand rf-logo-wrap"
                   href="<?= build_main_domain_url('/') ?>">
                    <span class="rf-logo-icon">RF</span>
                    <span class="rf-logo-text">
                        Real<span>Fly</span>Link
                    </span>
                </a>
            <?php endif; ?>
        </div>

        <!-- Desktop nav -->
        <div class="collapse navbar-collapse" id="rf-navbar-collapse">
            <?=
            menu_display('menu_main', [
                'ul_class' => 'nav navbar-nav navbar-right',
                'li_class' => '',
                'a_class'  => '',
            ], true);
            ?>

            <ul class="nav navbar-nav navbar-right rf-nav-auth">
                <?php if ($this->request->getSession()->read('Auth.User.id')): ?>
                    <li>
                        <a class="rf-nav-btn-login"
                           href="<?= build_main_domain_url('/member/dashboard') ?>">
                            <?= __('Dashboard') ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li>
                        <a class="rf-nav-btn-login"
                           href="<?= build_main_domain_url('/login') ?>">
                            <?= __('Login') ?>
                        </a>
                    </li>
                    <li>
                        <a class="rf-nav-btn-signup"
                           href="<?= build_main_domain_url('/register') ?>">
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

    <!-- Nav links (same as desktop) -->
    <a href="<?= build_main_domain_url('/') ?>"><?= __('🏠 Home') ?></a>
    <a href="<?= build_main_domain_url('/page/rates') ?>"><?= __('📊 Rates') ?></a>
    <a href="<?= build_main_domain_url('/page/payment-proof') ?>"><?= __('💵 Payment Proof') ?></a>
    <a href="<?= build_main_domain_url('/blog') ?>"><?= __('📝 Blog') ?></a>
    <a href="<?= build_main_domain_url('/contact') ?>"><?= __('✉️ Contact') ?></a>

    <div class="rf-drawer-divider"></div>

    <?php if ($this->request->getSession()->read('Auth.User.id')): ?>
        <a href="<?= build_main_domain_url('/member/dashboard') ?>"
           style="background:rgba(0,212,255,0.08);border-color:rgba(0,212,255,0.2);color:var(--rf-cyan);">
            <?= __('📈 My Dashboard') ?>
        </a>
    <?php else: ?>
        <div class="rf-drawer-btn-wrap">
            <a href="<?= build_main_domain_url('/login') ?>"
               class="rf-drawer-login-btn"
               style="display:block;text-align:center;text-decoration:none;">
                <?= __('Login') ?>
            </a>
            <a href="<?= build_main_domain_url('/register') ?>"
               class="rf-drawer-signup-btn"
               style="display:block;text-align:center;text-decoration:none;">
                <?= __('Sign Up Free →') ?>
            </a>
        </div>
    <?php endif; ?>
</div>

<!-- Drawer backdrop -->
<div id="rf-drawer-backdrop"
     style="display:none;position:fixed;inset:0;z-index:198;background:transparent;"
     onclick="rfCloseDrawer()">
</div>

<?= $this->Flash->render() ?>
<?= $this->fetch('content') ?>

<?= $this->element('front_footer'); ?>

<!-- Mobile drawer script -->
<script>
(function(){
    var drawer   = document.getElementById('rf-mobile-drawer');
    var backdrop = document.getElementById('rf-drawer-backdrop');
    var isOpen   = false;

    window.rfToggleDrawer = function(){
        isOpen ? rfCloseDrawer() : rfOpenDrawer();
    };

    function rfOpenDrawer(){
        isOpen = true;
        drawer.classList.add('open');
        backdrop.style.display = 'block';
        document.body.style.overflow = 'hidden';
        drawer.setAttribute('aria-hidden','false');
    }

    window.rfCloseDrawer = function(){
        isOpen = false;
        drawer.classList.remove('open');
        backdrop.style.display = 'none';
        document.body.style.overflow = '';
        drawer.setAttribute('aria-hidden','true');
    };

    // Close on ESC key
    document.addEventListener('keydown', function(e){
        if(e.key === 'Escape' && isOpen) rfCloseDrawer();
    });

    // Close drawer on window resize to desktop
    window.addEventListener('resize', function(){
        if(window.innerWidth > 768 && isOpen) rfCloseDrawer();
    });
})();
</script>

</body>
</html>
