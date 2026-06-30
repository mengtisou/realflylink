<?php
/**
 * @var \App\View\AppView $this
 */
?>
<footer class="rf-footer">
    <div class="rf-footer-inner">

        <div class="rf-footer-grid">

            <!-- Brand -->
            <div class="rf-footer-brand">
                <a href="<?= build_main_domain_url('/') ?>" class="rf-logo-wrap" style="text-decoration:none;display:inline-flex;align-items:center;gap:10px;margin-bottom:14px;">
                    <span class="rf-logo-icon" style="width:30px;height:30px;font-size:12px;">RF</span>
                    <span class="rf-logo-text" style="font-size:16px;">Real<span>Fly</span>Link</span>
                </a>
                <p><?= __('The most trusted monetized URL shortener. Earn money with every click.') ?></p>
                <?php if (get_option('facebook_url') || get_option('twitter_url')): ?>
                <div class="rf-footer-socials">
                    <?php if (get_option('facebook_url')): ?>
                        <a href="<?= h(get_option('facebook_url')) ?>" class="rf-social-btn"><i class="fa fa-facebook"></i></a>
                    <?php endif; ?>
                    <?php if (get_option('twitter_url')): ?>
                        <a href="<?= h(get_option('twitter_url')) ?>" class="rf-social-btn"><i class="fa fa-twitter"></i></a>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Platform links -->
            <div class="rf-footer-col">
                <div class="rf-footer-col-title"><?= __('Platform') ?></div>
                <a href="<?= build_main_domain_url('/') ?>"><?= __('Home') ?></a>
                <a href="<?= build_main_domain_url('/page/rates') ?>"><?= __('Publisher Rates') ?></a>
                <a href="<?= build_main_domain_url('/page/payment-proof') ?>"><?= __('Payment Proof') ?></a>
                <a href="<?= build_main_domain_url('/blog') ?>"><?= __('Blog') ?></a>
                <a href="<?= build_main_domain_url('/page/api') ?>"><?= __('API Docs') ?></a>
            </div>

            <!-- Account links -->
            <div class="rf-footer-col">
                <div class="rf-footer-col-title"><?= __('Account') ?></div>
                <a href="<?= build_main_domain_url('/register') ?>"><?= __('Sign Up') ?></a>
                <a href="<?= build_main_domain_url('/login') ?>"><?= __('Login') ?></a>
                <a href="<?= build_main_domain_url('/member/dashboard') ?>"><?= __('Dashboard') ?></a>
                <a href="<?= build_main_domain_url('/member/withdraw') ?>"><?= __('Withdraw') ?></a>
                <a href="<?= build_main_domain_url('/member/referrals') ?>"><?= __('Referrals') ?></a>
            </div>

            <!-- Legal — use menu_footer if set, else hardcoded -->
            <div class="rf-footer-col">
                <div class="rf-footer-col-title"><?= __('Legal') ?></div>
                <a href="<?= build_main_domain_url('/page/privacy-policy') ?>"><?= __('Privacy Policy') ?></a>
                <a href="<?= build_main_domain_url('/page/terms') ?>"><?= __('Terms of Use') ?></a>
                <a href="<?= build_main_domain_url('/page/dmca') ?>"><?= __('DMCA') ?></a>
                <a href="<?= build_main_domain_url('/contact') ?>"><?= __('Contact Us') ?></a>
            </div>

        </div>

        <!-- Bottom bar -->
        <div class="rf-footer-bottom">
            <span>&copy; <?= h(get_option('site_name')) ?> <?= date('Y') ?>. <?= __('All rights reserved.') ?></span>
            <div class="rf-footer-pills">
                <?php
                $methods = get_withdrawal_methods();
                if (!empty($methods)):
                    foreach ($methods as $m):
                ?>
                    <span class="rf-footer-pill"><?= h($m['name'] ?? $m['label'] ?? '') ?></span>
                <?php
                    endforeach;
                else:
                    foreach (['PayPal','USDT TRC20','USDT BEP20','WebMoney'] as $m):
                ?>
                    <span class="rf-footer-pill"><?= $m ?></span>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>

    </div>
</footer>

<?= $this->element('js_vars'); ?>

<script data-cfasync="false" src="<?= $this->Assets->url('/js/ads.js?ver=' . APP_VERSION) ?>"></script>

<?php
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

<!-- RealFlyLink: ticker + count-up animation -->
<script>
(function(){
    'use strict';

    // ── PAYMENT TICKER ───────────────────────────────────────────
    var PAYS = [
        { country:'🇰🇭', user:'Sou***412', amount:'$12.50', method:'PayPal',     date:'Jun 29' },
        { country:'🇮🇳', user:'Rah***786', amount:'$8.30',  method:'USDT TRC20', date:'Jun 29' },
        { country:'🇺🇸', user:'Ali***123', amount:'$45.20', method:'PayPal',     date:'Jun 28' },
        { country:'🇧🇩', user:'Mod***555', amount:'$5.00',  method:'USDT BEP20', date:'Jun 28' },
        { country:'🇬🇧', user:'Joh***990', amount:'$23.80', method:'PayPal',     date:'Jun 27' },
        { country:'🇵🇭', user:'Tan***321', amount:'$7.60',  method:'USDT TRC20', date:'Jun 27' },
        { country:'🇷🇺', user:'Ami***667', amount:'$15.40', method:'WebMoney',   date:'Jun 26' },
        { country:'🇨🇦', user:'Kar***234', amount:'$9.90',  method:'PayPal',     date:'Jun 26' },
        { country:'🇺🇸', user:'Dev***112', amount:'$31.00', method:'USDT ERC20', date:'Jun 25' },
        { country:'🇸🇦', user:'Nas***778', amount:'$6.70',  method:'PayPal',     date:'Jun 25' },
    ];
    var tickerIdx = 0;

    function updateTicker(){
        var p = PAYS[tickerIdx];
        var elUser   = document.getElementById('rf-ticker-user');
        var elAmt    = document.getElementById('rf-ticker-amount');
        var elMethod = document.getElementById('rf-ticker-method');
        var elDate   = document.getElementById('rf-ticker-date');
        if (elUser)   elUser.textContent   = p.country + ' ' + p.user;
        if (elAmt)    elAmt.textContent    = p.amount;
        if (elMethod) elMethod.textContent = p.method;
        if (elDate)   elDate.textContent   = p.date;

        // highlight matching row in proof table
        var rows = document.querySelectorAll('.rf-proof-row');
        rows.forEach(function(r, i){ r.classList.toggle('rf-active', i === tickerIdx % rows.length); });

        tickerIdx = (tickerIdx + 1) % PAYS.length;
    }
    setInterval(updateTicker, 3000);

    // ── COUNT-UP ANIMATION ────────────────────────────────────────
    function animateCount(el, target, duration){
        var start = null;
        var pre  = el.dataset.prefix || '';
        var suf  = el.dataset.suffix || '';
        function step(ts){
            if (!start) start = ts;
            var ease = 1 - Math.pow(1 - Math.min((ts-start)/duration, 1), 3);
            el.textContent = pre + Math.floor(ease * target).toLocaleString() + suf;
            if (ease < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    if ('IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if (e.isIntersecting){
                    var el  = e.target;
                    var val = parseInt(el.dataset.target, 10);
                    animateCount(el, val, 2000);
                    io.unobserve(el);
                }
            });
        }, { threshold: 0.3 });
        document.querySelectorAll('.rf-count-up').forEach(function(el){ io.observe(el); });
    } else {
        document.querySelectorAll('.rf-count-up').forEach(function(el){
            el.textContent = (el.dataset.prefix||'') + parseInt(el.dataset.target,10).toLocaleString() + (el.dataset.suffix||'');
        });
    }
})();
</script>

<?= $this->fetch('scriptBottom') ?>
<?= get_option('footer_code'); ?>
