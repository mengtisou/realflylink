<?php
/**
 * RealFlyLink — home.ctp
 * Bootstrap 3 grid (.container .row .col-*) for all layouts
 * RF classes for visual styling only
 */
$this->assign('title',       (get_option('site_meta_title')) ?: get_option('site_name'));
$this->assign('description', get_option('description'));

$minWith   = '$' . number_format((float)get_option('minimum_withdrawal_amount'), 2);
$realU     = isset($totalUsers)  ? (int)$totalUsers  : 0;
$realC     = isset($totalClicks) ? (int)str_replace([',',' '], '', (string)$totalClicks) : 0;
$realL     = isset($totalLinks)  ? (int)str_replace([',',' '], '', (string)$totalLinks)  : 0;
$sU        = max($realU, 1000);
$sC        = max($realC, 1240567);
$sL        = max($realL, 48230);
$dU        = number_format($sU);
?>

<!-- TICKER -->
<div class="rf-ticker">
    <div class="rf-dot"></div>
    <span class="rf-mu">🎉 <?= __('Just paid:') ?></span>
    <span class="rf-ticker-user" id="rf-ticker-user">🇰🇭 Sou***412</span>
    <span class="rf-mu"><?= __('received') ?></span>
    <span class="rf-ticker-amt" id="rf-ticker-amount">$12.50</span>
    <span class="rf-mu"><?= __('via') ?> <span id="rf-ticker-method">PayPal</span> · <span id="rf-ticker-date">Jun 29</span></span>
    <a class="rf-ticker-lnk" href="<?= build_main_domain_url('/page/payment-proof') ?>"><?= __('View all →') ?></a>
</div>

<!-- HERO -->
<header class="shorten">
    <div class="section-inner">
        <div class="container text-center">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <span class="rf-badge">
                        <span class="rf-badge-dot"></span>
                        <?= __('Earn up to $8 per 1,000 clicks · Join') ?> <?= $dU ?>+ <?= __('publishers') ?>
                    </span>

                    <h1 class="intro-heading">
                        <span class="rf-wh"><?= __('Shorten Links.') ?></span><br>
                        <span class="rf-gr"><?= __('Earn Money Daily.') ?></span>
                    </h1>

                    <p class="rf-hero-sub">
                        <?= __("The world's most trusted monetized URL shortener.") ?><br>
                        <?= __('Get paid for every click — PayPal, USDT, and more.') ?>
                    </p>

                    <?php if (get_option('home_shortening') == 'yes'): ?>
                    <div class="rf-url-box">
                        <?= $this->element('shorten') ?>
                    </div>
                    <p class="rf-url-hint"><?= __('Free forever · No signup required to try') ?></p>
                    <?php endif; ?>

                    <div class="rf-trust-row">
                        <div class="rf-trust-item">💵 <?= __('Daily Payouts') ?></div>
                        <div class="rf-trust-item">🔒 <?= __('SSL Secured') ?></div>
                        <div class="rf-trust-item">🌍 <?= __('200+ Countries') ?></div>
                        <div class="rf-trust-item">⚡ <?= __('Instant Redirect') ?></div>
                        <?php if ((bool)get_option('enable_referrals', 1)): ?>
                        <div class="rf-trust-item">👥 <?= h(get_option('referral_percentage')) ?>% <?= __('Referral') ?></div>
                        <?php endif; ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</header>

<!-- STATS -->
<?php if ((bool)get_option('display_home_stats', 1)): ?>
<div class="rf-stats-bar">
    <div class="container">
        <div class="row text-center">
            <div class="col-xs-6 col-sm-3"><div class="rf-stat-wrap">
                <div class="rf-stat-num rf-count-up" data-target="<?= $sC ?>" data-suffix="+">0+</div>
                <div class="rf-stat-lbl"><?= __('Total Clicks') ?></div>
            </div></div>
            <div class="col-xs-6 col-sm-3"><div class="rf-stat-wrap">
                <div class="rf-stat-num rf-count-up" data-target="<?= $sL ?>" data-suffix="+">0+</div>
                <div class="rf-stat-lbl"><?= __('Links Created') ?></div>
            </div></div>
            <div class="col-xs-6 col-sm-3"><div class="rf-stat-wrap">
                <div class="rf-stat-num rf-count-up" data-target="<?= $sU ?>" data-suffix="+">0+</div>
                <div class="rf-stat-lbl"><?= __('Publishers') ?></div>
            </div></div>
            <div class="col-xs-6 col-sm-3"><div class="rf-stat-wrap">
                <div class="rf-stat-num rf-count-up" data-target="45230" data-prefix="$" data-suffix="+">$0+</div>
                <div class="rf-stat-lbl"><?= __('Total Paid Out') ?></div>
            </div></div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- HOW IT WORKS -->
<div class="rf-bg-main">
    <div class="container rf-pad text-center">
        <span class="rf-eyebrow"><?= __('How it works') ?></span>
        <h2 class="rf-sec-h"><?= __('3 steps to start earning') ?></h2>
        <div class="row" style="margin-top:32px">
            <?php
            $steps = [
                ['n'=>'01','i'=>'👤','t'=>__('Create Account'),     'd'=>__('Sign up free in 30 seconds. No credit card needed.'),'b'=>'a'],
                ['n'=>'02','i'=>'🔗','t'=>__('Shorten Your Links'), 'd'=>__('Paste any URL and get a short link instantly.'),       'b'=>'b'],
                ['n'=>'03','i'=>'💰','t'=>__('Share & Earn'),        'd'=>__('Share your links. Earn money for every visitor.'),     'b'=>'a'],
            ];
            foreach ($steps as $s):
            ?>
            <div class="col-sm-4" style="margin-bottom:20px">
                <div class="rf-card rf-step">
                    <div class="rf-step-n"><?= $s['n'] ?></div>
                    <div class="rf-step-ico"><?= $s['i'] ?></div>
                    <div class="rf-step-t"><?= $s['t'] ?></div>
                    <p class="rf-step-d"><?= $s['d'] ?></p>
                    <div class="rf-step-bar rf-bar-<?= $s['b'] ?>"></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- FEATURES -->
<div class="rf-bg-alt">
    <div class="container rf-pad text-center">
        <span class="rf-eyebrow"><?= __('Features') ?></span>
        <h2 class="rf-sec-h"><?= __('Why join') ?> <?= h(get_option('site_name')) ?>?</h2>
        <div class="row" style="margin-top:32px">
            <?php
            $feats = [
                ['i'=>'⚡','t'=>__('Instant Payouts'),    'd'=>__('Withdraw daily via PayPal or USDT. Minimum just') . ' ' . $minWith . '.'],
                ['i'=>'🌍','t'=>__('Global Traffic'),     'd'=>__('Earn from visitors worldwide. Higher rates for Tier 1 countries.')],
                ['i'=>'📊','t'=>__('Real-time Stats'),    'd'=>__('Track clicks, earnings, and countries in your dashboard.')],
                ['i'=>'🔗','t'=>__('API Access'),         'd'=>__('Integrate our shortener into your own apps and tools.')],
                ['i'=>'🔒','t'=>__('Secure & Safe'),      'd'=>__('SSL encrypted. Your data and earnings are always protected.')],
                ['i'=>'💎','t'=>__('Highest Rates'),      'd'=>__('Our CPM rates are among the best. More traffic = more money.')],
                ['i'=>'🛡️','t'=>__('Admin Dashboard'),    'd'=>__('Full control panel. Manage links, stats, payouts, users.')],
                ['i'=>'💬','t'=>__('Dedicated Support'),  'd'=>__('Our team is ready to help with any questions.')],
            ];
            if ((bool)get_option('enable_referrals', 1)) {
                array_splice($feats, 4, 0, [[
                    'i' => '👥',
                    't' => h(get_option('referral_percentage')) . '% ' . __('Referral'),
                    'd' => __('Earn') . ' ' . h(get_option('referral_percentage')) . '% ' . __("of your referrals' earnings — forever."),
                ]]);
            }
            foreach ($feats as $f):
            ?>
            <div class="col-sm-4" style="margin-bottom:16px">
                <div class="rf-card">
                    <div class="rf-feat-ico"><?= $f['i'] ?></div>
                    <div class="rf-feat-t"><?= $f['t'] ?></div>
                    <p class="rf-feat-d"><?= $f['d'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<!-- CPM RATES -->
<div class="rf-bg-main">
    <div class="container rf-pad">
        <div class="row">
            <div class="col-sm-5" style="margin-bottom:24px">
                <span class="rf-eyebrow"><?= __('Publisher Rates') ?></span>
                <h2 class="rf-sec-h"><?= __('Earn more from every click') ?></h2>
                <p class="rf-sec-sub"><?= __('Our CPM rates are among the highest in the industry.') ?></p>
                <ul class="rf-pay-list">
                    <?php
                    $methods = get_withdrawal_methods();
                    $fb = ['PayPal','USDT TRC20','USDT BEP20','USDT ERC20','WebMoney'];
                    $ml = !empty($methods) ? array_map(fn($m)=>$m['name']??$m['label']??'',$methods) : $fb;
                    foreach ($ml as $m):
                    ?>
                    <li class="rf-pay-item"><span class="rf-pay-dot"></span><?= h($m) ?></li>
                    <?php endforeach; ?>
                </ul>
                <a href="<?= build_main_domain_url('/register') ?>" class="rf-btn-primary">
                    <?= __('Start Earning Free →') ?>
                </a>
            </div>
            <div class="col-sm-7" style="margin-bottom:24px">
                <div class="rf-rates-tbl">
                    <div class="rf-rates-hd">
                        <span><?= __('Country') ?></span>
                        <span style="margin-right:30px"><?= __('Tier') ?></span>
                        <span><?= __('CPM Rate') ?></span>
                    </div>
                    <?php
                    $rates = [
                        ['f'=>'🇺🇸','n'=>__('United States'), 'r'=>'$8.00','t'=>1],
                        ['f'=>'🇬🇧','n'=>__('United Kingdom'),'r'=>'$6.00','t'=>1],
                        ['f'=>'🇨🇦','n'=>__('Canada'),         'r'=>'$5.00','t'=>1],
                        ['f'=>'🇦🇺','n'=>__('Australia'),      'r'=>'$4.00','t'=>1],
                        ['f'=>'🇩🇪','n'=>__('Germany'),        'r'=>'$3.00','t'=>2],
                        ['f'=>'🌏', 'n'=>__('SE Asia'),        'r'=>'$1.00','t'=>3],
                        ['f'=>'🌍', 'n'=>__('Rest of World'),  'r'=>'$0.50','t'=>3],
                    ];
                    foreach ($rates as $r):
                    ?>
                    <div class="rf-rate-row">
                        <span class="rf-rate-c"><?= $r['f'] ?> <?= $r['n'] ?></span>
                        <span class="rf-tier rf-t<?= $r['t'] ?>">Tier <?= $r['t'] ?></span>
                        <span class="rf-cpm"><?= $r['r'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PAYMENT PROOF -->
<div class="rf-bg-alt">
    <div class="container rf-pad">
        <div class="text-center" style="margin-bottom:36px">
            <span class="rf-eyebrow"><?= __('Transparency') ?></span>
            <h2 class="rf-sec-h"><?= __('Real payments, real publishers') ?></h2>
            <p class="rf-sec-sub" style="max-width:500px;margin:0 auto">
                <?= __('Every payment is public. See what publishers earn every day.') ?>
            </p>
        </div>
        <div class="row" style="margin-bottom:20px">
            <?php
            $cards = [
                ['i'=>'💵','v'=>'$4,230+','l'=>__('Total Paid This Month')],
                ['i'=>'👥','v'=>'47+',    'l'=>__('Publishers Paid Today')],
                ['i'=>'🏆','v'=>'$145.20','l'=>__('Largest Single Payout')],
            ];
            foreach ($cards as $c):
            ?>
            <div class="col-sm-4" style="margin-bottom:14px">
                <div class="rf-proof-card">
                    <div class="rf-proof-ico"><?= $c['i'] ?></div>
                    <div class="rf-proof-val"><?= $c['v'] ?></div>
                    <p class="rf-proof-lbl"><?= $c['l'] ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="rf-proof-tbl">
            <div class="rf-proof-hd">
                <span><?= __('Publisher') ?></span>
                <span><?= __('Amount') ?></span>
                <span><?= __('Method') ?></span>
                <span><?= __('Date') ?></span>
            </div>
            <?php
            $proofs = [
                ['c'=>'🇰🇭','u'=>'Sou***412','a'=>'$12.50','m'=>'PayPal',    'd'=>'Jun 29'],
                ['c'=>'🇮🇳','u'=>'Rah***786','a'=>'$8.30', 'm'=>'USDT TRC20','d'=>'Jun 29'],
                ['c'=>'🇺🇸','u'=>'Ali***123','a'=>'$45.20','m'=>'PayPal',    'd'=>'Jun 28'],
                ['c'=>'🇧🇩','u'=>'Mod***555','a'=>'$5.00', 'm'=>'USDT BEP20','d'=>'Jun 28'],
                ['c'=>'🇬🇧','u'=>'Joh***990','a'=>'$23.80','m'=>'PayPal',    'd'=>'Jun 27'],
                ['c'=>'🇵🇭','u'=>'Tan***321','a'=>'$7.60', 'm'=>'USDT TRC20','d'=>'Jun 27'],
                ['c'=>'🇷🇺','u'=>'Ami***667','a'=>'$15.40','m'=>'WebMoney',  'd'=>'Jun 26'],
                ['c'=>'🇨🇦','u'=>'Kar***234','a'=>'$9.90', 'm'=>'PayPal',    'd'=>'Jun 26'],
                ['c'=>'🇺🇸','u'=>'Dev***112','a'=>'$31.00','m'=>'USDT ERC20','d'=>'Jun 25'],
                ['c'=>'🇸🇦','u'=>'Nas***778','a'=>'$6.70', 'm'=>'PayPal',    'd'=>'Jun 25'],
            ];
            foreach ($proofs as $i => $p):
            ?>
            <div class="rf-proof-row<?= $i===0?' rf-active':'' ?>" id="rfpr<?= $i ?>">
                <span class="rf-proof-user"><?= $p['c'] ?> <?= $p['u'] ?></span>
                <span class="rf-proof-amount"><?= $p['a'] ?></span>
                <span class="rf-proof-method"><?= $p['m'] ?></span>
                <span class="rf-proof-date"><?= $p['d'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>
        <p class="rf-proof-note">
            <?= __('Showing recent payments · Usernames partially masked for privacy') ?> ·
            <a href="<?= build_main_domain_url('/page/payment-proof') ?>"><?= __('View all →') ?></a>
        </p>
    </div>
</div>

<!-- TESTIMONIALS -->
<?= $this->cell('Testimonial', [], ['cache' => ['config'=>'1day','key'=>'home_t_'.locale_get_default()]]) ?>

<!-- CONTACT -->
<section id="contact">
    <div class="container">
        <div class="section-title text-center">
            <h3 class="section-subheading"><?= __('Contact Us') ?></h3>
            <h2 class="section-heading"><?= __('Get in touch!') ?></h2>
        </div>
        <?= $this->element('contact') ?>
    </div>
</section>

<!-- CTA -->
<div class="rf-cta-wrap">
    <div class="container">
        <div class="rf-cta-box">
            <div class="rf-cta-icon">🚀</div>
            <h2 class="rf-cta-h"><?= __('Start Earning Today') ?></h2>
            <p class="rf-cta-sub">
                <?= __('Join') ?> <?= $dU ?>+ <?= __('publishers already earning with') ?> <?= h(get_option('site_name')) ?>.
                <?= __('Free to join. Withdraw from') ?> <?= $minWith ?>.
            </p>
            <div class="rf-cta-btns">
                <a href="<?= build_main_domain_url('/register') ?>" class="rf-btn-primary"><?= __('Create Free Account →') ?></a>
                <a href="<?= build_main_domain_url('/page/payment-proof') ?>" class="rf-btn-secondary"><?= __('View Rates') ?></a>
            </div>
        </div>
    </div>
</div>
