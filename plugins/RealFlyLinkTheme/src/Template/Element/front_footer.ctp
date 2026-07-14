<?php /** @var \App\View\AppView $this */ ?>
<footer>
    <div class="container">
        <div class="rf-footer-wrap">
            <div class="row">
                <div class="col-sm-4 col-md-3" style="margin-bottom:28px">
                    <a class="rf-brand" href="<?= build_main_domain_url('/') ?>" style="height:auto;line-height:1;display:inline-flex;margin-bottom:0">
                        <span class="rf-logo-icon" style="width:28px;height:28px"><svg viewBox="0 0 34 34" xmlns="http://www.w3.org/2000/svg" class="rf-logo-pill"><defs><linearGradient id="rfPillGradF" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" stop-color="#00D4FF"/><stop offset="100%" stop-color="#00FF88"/></linearGradient><clipPath id="rfPillLeftHalfF"><rect x="0" y="0" width="17" height="16"/></clipPath></defs><g transform="translate(0,9) rotate(-35 17 8)"><rect x="0" y="0" width="34" height="16" rx="8" fill="url(#rfPillGradF)"/><rect x="0" y="0" width="34" height="16" rx="8" fill="#0d1520" clip-path="url(#rfPillLeftHalfF)"/></g></svg></span>
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
                        <a href="<?= build_main_domain_url('/page/rates') ?>"><?= __('Publisher Rates') ?></a>
                        <a href="<?= build_main_domain_url('/page/payment-proof') ?>"><?= __('Payment Proof') ?></a>
                        <a href="<?= build_main_domain_url('/blog') ?>"><?= __('Blog') ?></a>
                        <a href="<?= build_main_domain_url('/page/api') ?>"><?= __('API Docs') ?></a>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-2 col-md-3" style="margin-bottom:20px">
                    <div class="rf-fcol">
                        <span class="rf-fcol-ttl"><?= __('Account') ?></span>
                        <a href="<?= build_main_domain_url('/register') ?>"><?= __('Sign Up') ?></a>
                        <a href="<?= build_main_domain_url('/login') ?>"><?= __('Login') ?></a>
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
    var PAYS=[
        {c:'🇰🇭',u:'Sou***412',a:'$12.50',m:'PayPal',    d:'Jun 29'},
        {c:'🇮🇳',u:'Rah***786',a:'$8.30', m:'USDT TRC20',d:'Jun 29'},
        {c:'🇺🇸',u:'Ali***123',a:'$45.20',m:'PayPal',    d:'Jun 28'},
        {c:'🇧🇩',u:'Mod***555',a:'$5.00', m:'USDT BEP20',d:'Jun 28'},
        {c:'🇬🇧',u:'Joh***990',a:'$23.80',m:'PayPal',    d:'Jun 27'},
        {c:'🇵🇭',u:'Tan***321',a:'$7.60', m:'USDT TRC20',d:'Jun 27'},
        {c:'🇷🇺',u:'Ami***667',a:'$15.40',m:'WebMoney',  d:'Jun 26'},
        {c:'🇨🇦',u:'Kar***234',a:'$9.90', m:'PayPal',    d:'Jun 26'},
        {c:'🇺🇸',u:'Dev***112',a:'$31.00',m:'USDT ERC20',d:'Jun 25'},
        {c:'🇸🇦',u:'Nas***778',a:'$6.70', m:'PayPal',    d:'Jun 25'},
    ];
    var ti=0;
    function tick(){
        var p=PAYS[ti];
        var u=document.getElementById('rf-ticker-user'),
            a=document.getElementById('rf-ticker-amount'),
            m=document.getElementById('rf-ticker-method'),
            d=document.getElementById('rf-ticker-date');
        if(u)u.textContent=p.c+' '+p.u;
        if(a)a.textContent=p.a;
        if(m)m.textContent=p.m;
        if(d)d.textContent=p.d;
        for(var i=0;i<10;i++){var r=document.getElementById('rfpr'+i);if(r)r.classList.toggle('rf-active',i===ti%10);}
        ti=(ti+1)%PAYS.length;
    }
    setInterval(tick,3000);

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
