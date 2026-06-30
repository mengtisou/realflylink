<?php
/**
 * @var \App\View\AppView $this
 */
?>
<footer>
    <div class="rf-footer-inner">
        <div class="rf-footer-grid">

            <!-- Brand column -->
            <div class="rf-footer-brand">
                <a href="<?= build_main_domain_url('/') ?>" style="text-decoration:none;">
                    <div class="rf-logo-wrap" style="margin-bottom:0">
                        <span class="rf-logo-icon" style="width:28px;height:28px;font-size:11px;">RF</span>
                        <span class="rf-logo-text" style="font-size:15px;font-weight:900;">
                            Real<span>Fly</span>Link
                        </span>
                    </div>
                </a>
                <p><?= __('The most trusted monetized URL shortener. Earn money with every click.') ?></p>

                <!-- Social icons -->
                <?php if (get_option('facebook_url') || get_option('twitter_url')): ?>
                <div style="display:flex;gap:10px;margin-top:14px;">
                    <?php if (get_option('facebook_url')): ?>
                        <a href="<?= h(get_option('facebook_url')) ?>"
                           style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,0.06);border:1px solid rgba(0,212,255,0.12);display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
                            <i class="fa fa-facebook" style="font-size:14px;"></i>
                        </a>
                    <?php endif; ?>
                    <?php if (get_option('twitter_url')): ?>
                        <a href="<?= h(get_option('twitter_url')) ?>"
                           style="width:32px;height:32px;border-radius:8px;background:rgba(255,255,255,0.06);border:1px solid rgba(0,212,255,0.12);display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;">
                            <i class="fa fa-twitter" style="font-size:14px;"></i>
                        </a>
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

            <!-- Legal links — uses CakePHP menu or fallback -->
            <div class="rf-footer-col">
                <div class="rf-footer-col-title"><?= __('Legal') ?></div>
                <a href="<?= build_main_domain_url('/page/privacy-policy') ?>"><?= __('Privacy Policy') ?></a>
                <a href="<?= build_main_domain_url('/page/terms') ?>"><?= __('Terms of Use') ?></a>
                <a href="<?= build_main_domain_url('/page/dmca') ?>"><?= __('DMCA') ?></a>
                <a href="<?= build_main_domain_url('/contact') ?>"><?= __('Contact Us') ?></a>
            </div>

        </div><!-- /.rf-footer-grid -->

        <!-- Bottom bar -->
        <div class="rf-footer-bottom">
            <span>
                &copy; <?= h(get_option('site_name')) ?> <?= date('Y') ?>.
                <?= __('All rights reserved.') ?>
            </span>

            <!-- Payment method pills from withdrawal methods -->
            <div class="rf-payment-pills">
                <?php
                $methods = get_withdrawal_methods();
                if (!empty($methods)):
                    foreach ($methods as $method):
                ?>
                    <span class="rf-payment-pill">
                        <?= h($method['name'] ?? $method['label'] ?? '') ?>
                    </span>
                <?php
                    endforeach;
                else:
                    // Fallback static pills
                    foreach (['PayPal', 'USDT TRC20', 'USDT BEP20', 'WebMoney'] as $m):
                ?>
                    <span class="rf-payment-pill"><?= $m ?></span>
                <?php
                    endforeach;
                endif;
                ?>
            </div>
        </div>

    </div><!-- /.rf-footer-inner -->
</footer>

<?= $this->element('js_vars'); ?>

<script data-cfasync="false"
        src="<?= $this->Assets->url('/js/ads.js?ver=' . APP_VERSION) ?>">
</script>

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

<!-- RealFlyLink ticker + counter JS -->
<script>
(function() {
    'use strict';

    // ── LIVE PAYMENT TICKER ───────────────────────────────────────
    var PAYMENTS = [
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
        { country:'🇲🇾', user:'Lea***099', amount:'$19.20', method:'USDT TRC20', date:'Jun 24' },
        { country:'🇦🇺', user:'Har***345', amount:'$52.00', method:'PayPal',     date:'Jun 24' }
    ];

    var tickerIdx   = 0;
    var tickerUser  = document.getElementById('rf-ticker-user');
    var tickerAmt   = document.getElementById('rf-ticker-amount');
    var tickerMethod= document.getElementById('rf-ticker-method');
    var tickerDate  = document.getElementById('rf-ticker-date');

    function updateTicker() {
        var p = PAYMENTS[tickerIdx];
        if (tickerUser)   tickerUser.textContent   = p.country + ' ' + p.user;
        if (tickerAmt)    tickerAmt.textContent    = p.amount;
        if (tickerMethod) tickerMethod.textContent = p.method;
        if (tickerDate)   tickerDate.textContent   = p.date;

        // highlight matching row in proof table
        var rows = document.querySelectorAll('.rf-proof-row');
        rows.forEach(function(r, i) {
            r.classList.toggle('rf-active', i === tickerIdx % rows.length);
        });

        tickerIdx = (tickerIdx + 1) % PAYMENTS.length;
    }

    setInterval(updateTicker, 3000);

    // ── COUNT-UP ANIMATION ────────────────────────────────────────
    function animateCount(el, target, duration) {
        var start     = null;
        var isPrice   = (target >= 1000 && el.dataset.prefix === '$');
        var startVal  = 0;
        function step(ts) {
            if (!start) start = ts;
            var progress = Math.min((ts - start) / duration, 1);
            var ease     = 1 - Math.pow(1 - progress, 3); // ease-out cubic
            var current  = Math.floor(ease * target);
            el.textContent = (el.dataset.prefix || '') + current.toLocaleString() + (el.dataset.suffix || '');
            if (progress < 1) requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }

    // Intersection Observer — start counters when stats bar scrolls into view
    var counters = document.querySelectorAll('.rf-count-up');
    if (counters.length && 'IntersectionObserver' in window) {
        var io = new IntersectionObserver(function(entries) {
            entries.forEach(function(entry) {
                if (entry.isIntersecting) {
                    var el  = entry.target;
                    var val = parseInt(el.dataset.target, 10);
                    animateCount(el, val, 2000);
                    io.unobserve(el);
                }
            });
        }, { threshold: 0.3 });

        counters.forEach(function(el) { io.observe(el); });
    } else {
        // Fallback: just set the value
        counters.forEach(function(el) {
            var val = parseInt(el.dataset.target, 10);
            el.textContent = (el.dataset.prefix || '') + val.toLocaleString() + (el.dataset.suffix || '');
        });
    }
})();
</script>

<?= $this->fetch('scriptBottom') ?>
<?= get_option('footer_code'); ?>

<style>
/* Payment method icons */
.payment-methods img {
    height: 50px; width: auto;
    object-fit: contain; vertical-align: middle;
}
.payment-methods .container {
    display: flex; align-items: center;
    justify-content: center; flex-wrap: wrap;
    gap: 20px; padding: 16px 0;
}
</style>
