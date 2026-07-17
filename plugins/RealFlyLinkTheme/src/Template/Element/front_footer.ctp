<?php /** @var \App\View\AppView $this */ ?>
<footer>
    <div class="container">
        <div class="rf-footer-wrap">
            <div class="row">
                <div class="col-sm-4 col-md-3" style="margin-bottom:28px">
                    <a class="rf-brand" href="<?= build_main_domain_url('/') ?>" style="height:auto;line-height:1;display:inline-flex;margin-bottom:0">
                        <span class="rf-logo-icon" style="width:28px;height:28px"><svg viewBox="0 0 120 120" xmlns="http://www.w3.org/2000/svg" class="rf-logo-pin"><g transform="translate(60,60)"><g transform="rotate(-38)"><ellipse cx="30" cy="0" rx="27" ry="12" fill="#9054D8"/></g><g transform="rotate(176)"><ellipse cx="24" cy="0" rx="21" ry="10" fill="#00B4E4"/></g><g transform="rotate(50)"><ellipse cx="24" cy="0" rx="21" ry="10" fill="#E448C0"/></g><g transform="rotate(118)"><ellipse cx="21" cy="0" rx="18" ry="9" fill="#CC30C0"/></g><circle r="6" fill="#fff" class="rf-pin-dot"/></g></svg></span>
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
