<?php /** @var \App\View\AppView $this */ ?>
<footer>
    <div class="container">
        <div class="rf-footer-wrap">
            <div class="row">
                <div class="col-sm-4 col-md-3" style="margin-bottom:28px">
                    <a class="rf-brand" href="<?= build_main_domain_url('/') ?>" style="height:auto;line-height:1;display:inline-flex;margin-bottom:0">
                        <span class="rf-logo-icon" style="width:22px;height:22px"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 120 120" class="rf-logo-pin" width="22" height="22"><path d="M10 55 C 30 40, 45 40, 58 55 C 45 58, 30 62, 10 55 Z" fill="#4FA8E0"/><path d="M58 55 C 70 20, 95 8, 112 15 C 100 30, 90 45, 66 58 Z" fill="#8B5FD6"/><path d="M58 55 C 75 55, 90 65, 95 85 C 78 82, 64 74, 55 62 Z" fill="#B24FCB"/><path d="M55 62 C 60 78, 55 95, 42 108 C 40 92, 42 76, 50 62 Z" fill="#D14FA8"/><circle cx="60" cy="52" r="4.5" fill="#FFFFFF" class="rf-pin-dot"/></svg></span>
                        <span class="rf-logo-text" style="font-size:15px">Real<span>Fly</span>Link</span>
                    </a>
                    <p style="font-size:13px;color:var(--muted);margin-top:10px;line-height:1.7;max-width:200px">
                        <?= __('The most trusted monetized URL shortener.') ?>
                    </p>
                    <?php if (get_option('facebook_url') || get_option('twitter_url')): ?>
                    <div class="rf-socials">
                        <?php if (get_option('facebook_url')): ?>
                        <a class="rf-social-btn" href="<?= h(get_option('facebook_url')) ?>"><i class="fa fa-facebook"></i></a>
                        <?php endif; ?>
                        <?php if (get_option('twitter_url')): ?>
                        <a class="rf-social-btn" href="<?= h(get_option('twitter_url')) ?>"><i class="fa fa-twitter"></i></a>
                        <?php endif; ?>
                    </div>
                    <?php endif; ?>
                </div>
                <div class="col-xs-6 col-sm-2 col-md-3" style="margin-bottom:20px">
                    <div class="rf-fcol">
                        <span class="rf-fcol-ttl"><?= __('Platform') ?></span>
                        <a href="<?= build_main_domain_url('/') ?>"><?= __('Home') ?></a>
                        <a href="<?= build_main_domain_url('/payout-rates') ?>"><?= __('Publisher Rates') ?></a>
                        <a href="<?= build_main_domain_url('/pages/payment-proof') ?>"><?= __('Payment Proof') ?></a>
                        <a href="<?= build_main_domain_url('/blog') ?>"><?= __('Blog') ?></a>
                        <a href="<?= build_main_domain_url('/pages/how-to-download') ?>"><?= __('How To Download') ?></a>
                        <a href="<?= build_main_domain_url('/pages/earn-money') ?>"><?= __('Earn Money') ?></a>
                        <a href="<?= build_main_domain_url('/page/api') ?>"><?= __('API Docs') ?></a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-2 col-md-3" style="margin-bottom:20px">
                    <div class="rf-fcol">
                        <span class="rf-fcol-ttl"><?= __('Account') ?></span>
                        <a href="<?= build_main_domain_url('/auth/signup') ?>"><?= __('Sign Up') ?></a>
                        <a href="<?= build_main_domain_url('/auth/signin') ?>"><?= __('Login') ?></a>
                        <a href="<?= build_main_domain_url('/member/dashboard') ?>"><?= __('Dashboard') ?></a>
                        <a href="<?= build_main_domain_url('/member/withdraw') ?>"><?= __('Withdraw') ?></a>
                        <a href="<?= build_main_domain_url('/member/referrals') ?>"><?= __('Referrals') ?></a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-2 col-md-3" style="margin-bottom:20px">
                    <div class="rf-fcol">
                        <span class="rf-fcol-ttl"><?= __('Legal') ?></span>
                        <a href="<?= build_main_domain_url('/page/privacy-policy') ?>"><?= __('Privacy Policy') ?></a>
                        <a href="<?= build_main_domain_url('/page/terms') ?>"><?= __('Terms of Use') ?></a>
                        <a href="<?= build_main_domain_url('/page/dmca') ?>"><?= __('DMCA') ?></a>
                        <a href="<?= build_main_domain_url('/contact') ?>"><?= __('Contact Us') ?></a>
                    </div>
                </div>
            </div>
            <div class="rf-footer-bot">
                <span>&copy; <?= h(get_option('site_name')) ?> <?= date('Y') ?>. <?= __('All rights reserved.') ?></span>
                <div class="rf-footer-pills">
                    <?php
                    $ml = get_withdrawal_methods();
                    $fb = ['PayPal','USDT TRC20','USDT BEP20','WebMoney'];
                    $ls = !empty($ml) ? array_map(fn($m)=>$m['name']??$m['label']??'',$ml) : $fb;
                    foreach ($ls as $m): ?>
                    <span class="rf-footer-pill"><?= h($m) ?></span>
                    <?php endforeach; ?>
                </div>
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
<script>
(function(){
    'use strict';
    // Ticker now lives in home.ctp (self-contained)
function countUp(el,target,dur){
        var s=null,pre=el.dataset.prefix||'',suf=el.dataset.suffix||'';
        function step(ts){
            if(!s)s=ts;
            var e=1-Math.pow(1-Math.min((ts-s)/dur,1),3);
            el.textContent=pre+Math.floor(e*target).toLocaleString()+suf;
            if(e<1)requestAnimationFrame(step);
        }
        requestAnimationFrame(step);
    }
    if('IntersectionObserver' in window){
        var io=new IntersectionObserver(function(entries){
            entries.forEach(function(e){
                if(e.isIntersecting){countUp(e.target,parseInt(e.target.dataset.target,10),2000);io.unobserve(e.target);}
            });
        },{threshold:0.3});
        document.querySelectorAll('.rf-count-up').forEach(function(el){io.observe(el);});
    }
}());
</script>
<?= $this->fetch('scriptBottom') ?>
<?= get_option('footer_code') ?>
