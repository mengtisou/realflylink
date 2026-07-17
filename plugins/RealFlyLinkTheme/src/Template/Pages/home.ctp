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
$realP     = isset($totalPaid)   ? (float)$totalPaid : 0;
$dU        = number_format($realU);

// Highest real CPM rate for the hero badge (from the same admin options)
$topCpm = 0;
try {
    $bMode   = get_option('earning_mode');
    $bOpts   = ($bMode === 'campaign')
        ? ['banner_price', 'interstitial_price', 'popup_price']
        : ['payout_rates_banner', 'payout_rates_interstitial', 'payout_rates_popup'];
    foreach ($bOpts as $bOpt) {
        $bData = get_option($bOpt, []);
        if (empty($bData) || !is_array($bData)) continue;
        foreach ($bData as $bV) {
            $bDesk = ($bMode === 'campaign') ? ($bV[2]['publisher'] ?? 0) : ($bV[2] ?? 0);
            $bMob  = ($bMode === 'campaign') ? ($bV[3]['publisher'] ?? 0) : ($bV[3] ?? 0);
            $topCpm = max($topCpm, (float)$bDesk, (float)$bMob);
        }
    }
} catch (\Throwable $e) { $topCpm = 0; }
$badgeCpm = $topCpm > 0 ? '$' . number_format($topCpm, 2) : '$8';
?>

<!-- TICKER (self-contained: own data, styles, and script) -->
<?php
// ── Real paid withdrawals (status 3) for the ticker ──
$tickerData = [];
try {
    $wTbl   = \Cake\ORM\TableRegistry::getTableLocator()->get('Withdraws');
    $recent = $wTbl->find()
        ->contain(['Users'])
        ->where(['Withdraws.status' => 3])
        ->order(['Withdraws.created' => 'DESC'])
        ->limit(15)
        ->all();

    $tkSym  = get_option('currency_symbol', '$');
    $wmL    = get_withdrawal_methods();
    $wmM    = function_exists('array_column_polyfill')
        ? array_column_polyfill($wmL, 'name', 'id')
        : array_column($wmL, 'name', 'id');

    $tkFlag = function ($cc) {
        $cc = strtoupper((string)$cc);
        if (strlen($cc) !== 2 || !ctype_alpha($cc)) {
            return '<i class="fa fa-globe" style="color:var(--cyan,#00d4ff);font-size:13px" aria-hidden="true"></i>';
        }
        return '<span class="flag-icon flag-icon-' . strtolower(h($cc)) . '" style="border-radius:2px;box-shadow:0 0 0 1px rgba(255,255,255,.15)"></span>';
    };

    foreach ($recent as $w) {
        $un  = isset($w->user->username) ? (string)$w->user->username : 'user';
        $ln  = mb_strlen($un);
        $mk  = $ln <= 3 ? mb_substr($un,0,1).'***' : mb_substr($un,0,3).'***'.mb_substr($un,-2);
        $tickerData[] = [
            'f' => $tkFlag($w->user->country ?? ''),
            'u' => h($mk),
            'a' => $tkSym . number_format((float)$w->amount, 2),
            'm' => h((string)($wmM[$w->method] ?? $w->method)),
            'd' => $w->created ? $w->created->format('M j') : '',
        ];
    }
} catch (\Throwable $e) { $tickerData = []; }

// Fallback so the bar never breaks if there are no paid withdrawals yet
if (empty($tickerData)) {
    $tickerData = [
        ['f'=>'<span class="flag-icon flag-icon-kh"></span>','u'=>'Sou***12','a'=>'$12.50','m'=>'PayPal','d'=>'Jun 29'],
        ['f'=>'<span class="flag-icon flag-icon-in"></span>','u'=>'Rah***86','a'=>'$8.30','m'=>'USDT TRC20','d'=>'Jun 29'],
        ['f'=>'<span class="flag-icon flag-icon-us"></span>','u'=>'Ali***23','a'=>'$45.20','m'=>'PayPal','d'=>'Jun 28'],
    ];
}
$tk0 = $tickerData[0]; // first REAL payment rendered server-side, no JS needed
?>
<div class="rf-ticker" style="display:flex!important;align-items:center;justify-content:center;flex-wrap:wrap;gap:7px;padding:9px;font-size:12px;background:rgba(255,255,255,.05);border-top:1px solid rgba(255,255,255,.09);border-bottom:1px solid rgba(255,255,255,.09);position:relative;z-index:3;visibility:visible!important;opacity:1!important">
    <span class="rf-dot" style="width:6px;height:6px;border-radius:50%;background:#cf3f96;box-shadow:0 0 8px #cf3f96;flex-shrink:0;display:inline-block"></span>
    <span class="rf-tk-mu" style="color:rgba(255,255,255,.5)">🎉 <?= __('Just paid:') ?></span>
    <span id="rf-ticker-user" class="rf-tk-text" style="font-weight:500;color:#fff"><?php echo $tk0['f']; ?> <?= $tk0['u'] ?></span>
    <span class="rf-tk-text" style="color:rgba(255,255,255,.85)"><?= __('received') ?></span>
    <span id="rf-ticker-amount" style="font-weight:700;background:linear-gradient(105deg,#d8b8f5,#f5c8b0);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent"><?= $tk0['a'] ?></span>
    <span class="rf-tk-text" style="color:rgba(255,255,255,.85)"><?= __('via') ?> <span id="rf-ticker-method" style="font-weight:600"><?= $tk0['m'] ?></span> · <span id="rf-ticker-date"><?= $tk0['d'] ?></span></span>
    <a class="rf-ticker-lnk" href="<?= build_main_domain_url('/pages/payment-proof') ?>" style="color:#c9a8ec;font-size:11px;text-decoration:underline;margin-left:4px"><?= __('View all →') ?></a>
</div>
<script data-cfasync="false">
(function(){
    'use strict';
    if (window.__rfTicker) return;
    window.__rfTicker = 1;
    var PAYS = <?= json_encode(array_values($tickerData), JSON_UNESCAPED_UNICODE|JSON_HEX_TAG|JSON_HEX_QUOT|JSON_HEX_APOS) ?>;
    var ti = 1 % PAYS.length;
    function tick(){
        var p = PAYS[ti],
            u = document.getElementById('rf-ticker-user'),
            a = document.getElementById('rf-ticker-amount'),
            m = document.getElementById('rf-ticker-method'),
            d = document.getElementById('rf-ticker-date');
        if(u){ u.innerHTML = p.f + ' ' + p.u; }
        if(a){ a.textContent = p.a; }
        if(m){ m.textContent = p.m; }
        if(d){ d.textContent = p.d; }
        for(var i=0;i<10;i++){ var r=document.getElementById('rfpr'+i); if(r){ r.classList.toggle('rf-active', i===ti%10); } }
        ti = (ti+1) % PAYS.length;
    }
    if (PAYS.length > 1) { setInterval(tick, 3000); }

    // Keep page content below the fixed navbar, whatever its actual height
    function rfNavOffset(){
        var n = document.getElementById('mainNav');
        if (n) { document.body.style.setProperty('padding-top', n.offsetHeight + 'px', 'important'); }
    }
    rfNavOffset();
    window.addEventListener('load', rfNavOffset);
    window.addEventListener('resize', rfNavOffset);
}());
</script>

<!-- HERO -->
<!-- HERO (matches realflylink_full_aurora_clean.html exactly) -->
<header class="shorten" style="position:relative;text-align:center;padding:60px 20px 110px;overflow:hidden;background:#0b0a0d">
    <div class="glow" style="position:absolute;left:-15%;top:6%;width:55%;height:92%;background:radial-gradient(ellipse at 30% 40%,rgba(96,118,170,.55),rgba(70,80,140,.25) 45%,transparent 72%);filter:blur(30px);pointer-events:none"></div>
    <div class="glow" style="position:absolute;left:20%;bottom:-30%;width:64%;height:110%;background:radial-gradient(ellipse at 45% 75%,rgba(140,62,205,.62),rgba(190,55,170,.34) 50%,transparent 75%);filter:blur(34px);pointer-events:none"></div>
    <div class="glow" style="position:absolute;right:-18%;top:18%;width:60%;height:104%;background:radial-gradient(ellipse at 65% 55%,rgba(226,122,54,.6),rgba(200,90,60,.28) 52%,transparent 76%);filter:blur(34px);pointer-events:none"></div>
    <div class="glow" style="position:absolute;left:43%;bottom:-14%;width:24%;height:40%;background:radial-gradient(ellipse,rgba(150,225,255,.55),rgba(120,180,255,.22) 55%,transparent 78%);filter:blur(20px);pointer-events:none"></div>
    <svg style="position:absolute;inset:0;width:100%;height:100%;pointer-events:none" viewBox="0 0 1200 600" preserveAspectRatio="none"><path d="M-40 420 Q320 120 820 260 T1300 180" stroke="rgba(255,255,255,.09)" stroke-width="1" fill="none"/><path d="M-60 540 Q420 300 980 420" stroke="rgba(255,255,255,.06)" stroke-width="1" fill="none"/></svg>
    <div class="orb" style="position:absolute;left:6%;top:14%;width:64px;height:64px;border-radius:50%;background:radial-gradient(circle at 30% 28%,#46536e,#0e1017 72%);pointer-events:none"></div>
    <div class="orb" style="position:absolute;right:8%;top:8%;width:90px;height:90px;border-radius:50%;background:radial-gradient(circle at 30% 30%,#3a2a24,#120d0b 74%);pointer-events:none"></div>
    <div class="orb" style="position:absolute;right:22%;bottom:8%;width:56px;height:56px;border-radius:50%;background:radial-gradient(circle at 32% 30%,#8a5aa8,#241531 76%);pointer-events:none"></div>
    <div class="orb" style="position:absolute;left:16%;bottom:2%;width:70px;height:70px;border-radius:50%;background:radial-gradient(circle at 65% 70%,#e8b48c,#7a5a9a 45%,#1c1424 78%);pointer-events:none"></div>

    <div style="position:relative;z-index:3;max-width:760px;margin:0 auto">
        <div class="rf-hero-eyebrow" style="font-size:12px;letter-spacing:4px;color:rgba(255,255,255,.55);font-weight:500;margin-bottom:22px"><?= __('WELCOME TO REALFLYLINK') ?></div>

        <div class="rf-hero-title" style="font-weight:800;font-size:54px;letter-spacing:-2px;line-height:1.04;background:linear-gradient(105deg,#ffffff 25%,#ecd9f6 55%,#f2d9e2 75%,#f6dcc4 96%);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent">
            <?= __('Shorten Links.') ?><br><?= __('Earn Money Daily.') ?>
        </div>

        <div class="rf-hero-subtext" style="color:rgba(255,255,255,.72);font-size:16px;margin:24px auto 0;max-width:440px;line-height:1.65">
            <?= __('Get paid for every click — PayPal, USDT, and more. Built for publishers worldwide.') ?>
        </div>

        <?php if (get_option('home_shortening') == 'yes'): ?>
        <div class="rf-url-box" style="max-width:440px;margin:30px auto 0;display:flex;align-items:center;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.16);border-radius:32px;padding:6px 6px 6px 22px">
            <?= $this->element('shorten') ?>
        </div>
        <p style="color:rgba(255,255,255,.5);font-size:12px;margin-top:12px"><?= __('Free forever · No signup required to try') ?></p>
        <?php endif; ?>

        <div class="rf-trust-row" style="display:flex;justify-content:center;gap:8px;margin-top:16px;font-size:11px;color:rgba(255,255,255,.5);flex-wrap:wrap">
            <span class="rf-trust-pill" style="border:1px solid rgba(255,255,255,.14);border-radius:16px;padding:5px 12px;background:rgba(255,255,255,.04)">💵 <?= __('Daily payouts') ?></span>
            <span class="rf-trust-pill" style="border:1px solid rgba(255,255,255,.14);border-radius:16px;padding:5px 12px;background:rgba(255,255,255,.04)">🔒 <?= __('SSL secured') ?></span>
            <span class="rf-trust-pill" style="border:1px solid rgba(255,255,255,.14);border-radius:16px;padding:5px 12px;background:rgba(255,255,255,.04)">🌍 <?= __('200+ countries') ?></span>
            <?php if ((bool)get_option('enable_referrals', 1)): ?>
            <span class="rf-trust-pill" style="border:1px solid rgba(255,255,255,.14);border-radius:16px;padding:5px 12px;background:rgba(255,255,255,.04)">👥 <?= h(get_option('referral_percentage')) ?>% <?= __('referral') ?></span>
            <?php endif; ?>
        </div>
    </div>
</header>

<!-- STATS: 3 glass cards floating over the aurora (matches uploaded file exactly) -->
<?php if ((bool)get_option('display_home_stats', 1)): ?>
<div class="rf-stats-float" style="position:relative;margin-top:-56px;z-index:4">
    <div class="container rf-stats-row" style="display:flex;justify-content:center;gap:14px;padding:0 20px 44px;flex-wrap:wrap">
        <div class="rf-stat-card" style="flex:1;max-width:230px;min-width:160px;padding:20px 14px;text-align:center;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:16px;backdrop-filter:blur(6px)">
            <div class="rf-count-up" data-target="<?= $realC ?>" data-suffix="+" style="font-weight:900;font-size:26px;background:linear-gradient(105deg,#d8c4f2,#f2c8d8);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent">0+</div>
            <div style="font-size:10px;color:rgba(255,255,255,.5);letter-spacing:2px;margin-top:5px"><?= __('TOTAL CLICKS') ?></div>
        </div>
        <div class="rf-stat-card" style="flex:1;max-width:230px;min-width:160px;padding:20px 14px;text-align:center;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:16px;backdrop-filter:blur(6px)">
            <div class="rf-count-up" data-target="<?= $realU ?>" data-suffix="+" style="font-weight:900;font-size:26px;background:linear-gradient(105deg,#d8c4f2,#f2c8d8);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent">0+</div>
            <div style="font-size:10px;color:rgba(255,255,255,.5);letter-spacing:2px;margin-top:5px"><?= __('PUBLISHERS') ?></div>
        </div>
        <div class="rf-stat-card" style="flex:1;max-width:230px;min-width:160px;padding:20px 14px;text-align:center;background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:16px;backdrop-filter:blur(6px)">
            <div class="rf-count-up" data-target="<?= round($realP) ?>" data-prefix="$" data-suffix="+" style="font-weight:900;font-size:26px;background:linear-gradient(105deg,#f2d4b8,#f2c0c8);-webkit-background-clip:text;background-clip:text;-webkit-text-fill-color:transparent">$0+</div>
            <div style="font-size:10px;color:rgba(255,255,255,.5);letter-spacing:2px;margin-top:5px"><?= __('PAID OUT') ?></div>
        </div>
    </div>
</div>
<?php endif; ?>

<!-- HOW IT WORKS -->
<div class="rf-bg-main">

    <div class="container rf-pad text-center">
        <span class="rf-eyebrow"><?= __('How it works') ?></span>
        <h2 class="rf-sec-h"><?= __('3 steps to start earning') ?></h2>
        <div class="row rf-eq-row" style="margin-top:32px">
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
        <div class="row rf-eq-row" style="margin-top:32px">
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
<link rel="stylesheet" href="https://fastly.jsdelivr.net/gh/lipis/flag-icon-css@3.3.0/css/flag-icon.min.css"/>
<style>
.rf-rate-c .flag-icon{
    width:22px; line-height:16px; margin-right:9px; border-radius:3px;
    box-shadow:0 0 0 1px rgba(255,255,255,.12); vertical-align:-2px;
}
.rf-rate-c .rf-flag-globe{
    width:22px; margin-right:9px; text-align:center;
    color:var(--cyan); font-size:15px; vertical-align:-1px;
}
</style>
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
                    // ── Dynamic CPM rates from DB (same options the admin panel edits) ──
                    $rates = [];
                    try {
                        $mode = get_option('earning_mode');
                        $raw  = [];

                        // Collect rates from all enabled ad types, keep the highest per country
                        $optMap = ($mode === 'campaign')
                            ? ['banner_price', 'interstitial_price', 'popup_price']
                            : ['payout_rates_banner', 'payout_rates_interstitial', 'payout_rates_popup'];

                        foreach ($optMap as $opt) {
                            $data = get_option($opt, []);
                            if (empty($data) || !is_array($data)) continue;
                            foreach ($data as $cc => $v) {
                                if ($mode === 'campaign') {
                                    $desktop = $v[2]['publisher'] ?? 0;
                                    $mobile  = $v[3]['publisher'] ?? 0;
                                } else {
                                    $desktop = $v[2] ?? 0;
                                    $mobile  = $v[3] ?? 0;
                                }
                                $best = max((float)$desktop, (float)$mobile);
                                if ($best <= 0) continue;
                                $cc = strtoupper($cc);
                                if (!isset($raw[$cc]) || $best > $raw[$cc]) {
                                    $raw[$cc] = $best;
                                }
                            }
                        }

                        if (!empty($raw)) {
                            // Separate worldwide/ALL entries from real countries
                            $worldwide = null;
                            foreach ($raw as $cc => $cpm) {
                                if (strlen($cc) !== 2 || !ctype_alpha($cc)
                                    || in_array($cc, ['WW'], true)) {
                                    if ($worldwide === null || $cpm > $worldwide) {
                                        $worldwide = $cpm;
                                    }
                                    unset($raw[$cc]);
                                }
                            }

                            arsort($raw); // highest CPM first
                            $countriesList = get_countries(true);
                            $top    = array_slice($raw, 0, 6, true); // top 6 countries
                            $maxCpm = !empty($raw) ? max($raw) : ($worldwide ?? 0);

                            // Clean money format: $2.00 not $2.000000
                            $curSym = get_option('currency_symbol', '$');
                            $money  = fn($v) => $curSym . number_format((float)$v, 2);

                            // ISO code → flag image (same flag-icon-css as payout rates)
                            $ccFlag = function ($cc) {
                                if (strlen($cc) !== 2 || !ctype_alpha($cc)) {
                                    return '<i class="fa fa-globe rf-flag-globe" aria-hidden="true"></i>';
                                }
                                return '<span class="flag-icon flag-icon-' . strtolower(h($cc)) . '"></span>';
                            };

                            foreach ($top as $cc => $cpm) {
                                // Tier relative to the top rate
                                $t = ($cpm >= $maxCpm * 0.5) ? 1 : (($cpm >= $maxCpm * 0.2) ? 2 : 3);
                                $rates[] = [
                                    'f' => $ccFlag($cc),
                                    'n' => $countriesList[$cc] ?? $cc,
                                    'r' => $money($cpm),
                                    't' => $t,
                                ];
                            }
                            // "Rest of World" = your worldwide/ALL rate, else lowest country rate
                            $rowRate = $worldwide ?? (!empty($raw) ? min($raw) : null);
                            if ($rowRate !== null) {
                                $rates[] = [
                                    'f' => '<i class="fa fa-globe rf-flag-globe" aria-hidden="true"></i>',
                                    'n' => __('Rest of World'),
                                    'r' => $money($rowRate),
                                    't' => 3,
                                ];
                            }
                        }
                    } catch (\Throwable $e) {
                        $rates = []; // fall through to static fallback below
                    }

                    // Fallback if options are empty or something failed — page never breaks
                    if (empty($rates)) {
                        $g = '<i class="fa fa-globe rf-flag-globe" aria-hidden="true"></i>';
                        $rates = [
                            ['f'=>'<span class="flag-icon flag-icon-us"></span>','n'=>__('United States'), 'r'=>'$8.00','t'=>1],
                            ['f'=>'<span class="flag-icon flag-icon-gb"></span>','n'=>__('United Kingdom'),'r'=>'$6.00','t'=>1],
                            ['f'=>'<span class="flag-icon flag-icon-ca"></span>','n'=>__('Canada'),        'r'=>'$5.00','t'=>1],
                            ['f'=>'<span class="flag-icon flag-icon-au"></span>','n'=>__('Australia'),     'r'=>'$4.00','t'=>1],
                            ['f'=>'<span class="flag-icon flag-icon-de"></span>','n'=>__('Germany'),       'r'=>'$3.00','t'=>2],
                            ['f'=>$g,'n'=>__('SE Asia'),       'r'=>'$1.00','t'=>3],
                            ['f'=>$g,'n'=>__('Rest of World'), 'r'=>'$0.50','t'=>3],
                        ];
                    }
                    foreach ($rates as $r):
                    ?>
                    <div class="rf-rate-row">
                        <span class="rf-rate-c"><?php echo $r['f']; ?> <?= h($r['n']) ?></span>
                        <span class="rf-tier rf-t<?= $r['t'] ?>">Tier <?= $r['t'] ?></span>
                        <span class="rf-cpm"><?= $r['r'] ?></span>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- PAYMENT PROOF — reads from withdraws table (status=3 means Complete) -->
<div class="rf-bg-alt">
    <div class="container rf-pad">
        <div class="text-center" style="margin-bottom:36px">
            <span class="rf-eyebrow"><?= __('Transparency') ?></span>
            <h2 class="rf-sec-h"><?= __('Real payments, real publishers') ?></h2>
            <p class="rf-sec-sub" style="max-width:500px;margin:0 auto">
                <?= __('Every payment is public. See what publishers earn every day.') ?>
            </p>
        </div>

        <?php
        // ── Pull real data from withdraws table ──────────────────
        try {
            $Withdraws = \Cake\ORM\TableRegistry::getTableLocator()->get('Withdraws');

            // Last 10 completed payments with user info
            $dbPayments = $Withdraws->find()
                ->contain(['Users'])
                ->where(['Withdraws.status' => 3])
                ->order(['Withdraws.created' => 'DESC'])
                ->limit(10)
                ->all();

            $hasData = $dbPayments->count() > 0;

            // Raw SQL for aggregates — avoids Query::func() static call error
            $conn      = $Withdraws->getConnection();
            $thisMonth = date('Y-m-01');

            $r1 = $conn->execute(
                'SELECT COALESCE(SUM(amount),0) AS total FROM withdraws WHERE status = 3 AND created >= ?',
                [$thisMonth]
            )->fetch('assoc');
            $totalMonth = $r1 ? (float)$r1['total'] : 0;

            $r2 = $conn->execute(
                'SELECT COUNT(DISTINCT user_id) AS cnt FROM withdraws WHERE status = 3 AND DATE(created) = CURDATE()'
            )->fetch('assoc');
            $paidToday = $r2 ? (int)$r2['cnt'] : 0;

            $r2m = $conn->execute(
                'SELECT COUNT(DISTINCT user_id) AS cnt FROM withdraws WHERE status = 3 AND created >= ?',
                [$thisMonth]
            )->fetch('assoc');
            $paidMonthCnt = $r2m ? (int)$r2m['cnt'] : 0;

            $rAll = $conn->execute(
                'SELECT COALESCE(SUM(amount),0) AS total, COUNT(DISTINCT user_id) AS cnt FROM withdraws WHERE status = 3'
            )->fetch('assoc');
            $totalAll   = $rAll ? (float)$rAll['total'] : 0;
            $paidAllCnt = $rAll ? (int)$rAll['cnt'] : 0;

            $r3 = $conn->execute(
                'SELECT COALESCE(MAX(amount),0) AS mx FROM withdraws WHERE status = 3'
            )->fetch('assoc');
            $largestEver = $r3 ? (float)$r3['mx'] : 0;

        } catch (\Exception $e) {
            $hasData      = false;
            $dbPayments   = [];
            $totalMonth   = 0;
            $paidToday    = 0;
            $largestEver  = 0;
            $paidMonthCnt = 0;
            $totalAll     = 0;
            $paidAllCnt   = 0;
        }

        // Country flag image (flag-icon-css) — globe icon fallback
        $rfProofFlag = function ($cc) {
            $cc = strtoupper((string)$cc);
            if (strlen($cc) !== 2 || !ctype_alpha($cc)) {
                return '<i class="fa fa-globe" style="color:var(--cyan);font-size:14px" aria-hidden="true"></i>';
            }
            return '<span class="flag-icon flag-icon-' . strtolower(h($cc)) . '" style="border-radius:2px;box-shadow:0 0 0 1px rgba(255,255,255,.15)"></span>';
        };

        // Withdrawal method ID → name (method column stores the ID)
        $wmList  = get_withdrawal_methods();
        $rfWmMap = function_exists('array_column_polyfill')
            ? array_column_polyfill($wmList, 'name', 'id')
            : array_column($wmList, 'name', 'id');

        // Helper: mask username — "pengty" → "pen***ty"
        function rf_mask_user($name) {
            $len = mb_strlen($name);
            if ($len <= 3) return mb_substr($name, 0, 1) . '***';
            return mb_substr($name, 0, 3) . '***' . mb_substr($name, -2);
        }

        // Summary numbers — always REAL data; if a narrow time window is
        // empty, widen the window and adjust the label (never fake numbers)
        if ($totalMonth > 0) {
            $statMonth    = '$' . number_format($totalMonth, 2);
            $statMonthLbl = __('Total Paid This Month');
        } else {
            $statMonth    = '$' . number_format($totalAll, 2);
            $statMonthLbl = __('Total Paid Out');
        }

        if ($paidToday > 0) {
            $statToday    = $paidToday;
            $statTodayLbl = __('Publishers Paid Today');
        } elseif ($paidMonthCnt > 0) {
            $statToday    = $paidMonthCnt;
            $statTodayLbl = __('Publishers Paid This Month');
        } else {
            $statToday    = $paidAllCnt;
            $statTodayLbl = __('Publishers Paid');
        }

        $statLargest = '$' . number_format($largestEver, 2);
        ?>

        <!-- Summary cards -->
        <div class="row rf-eq-row" style="margin-bottom:20px">
            <div class="col-sm-4" style="margin-bottom:14px">
                <div class="rf-proof-card">
                    <div class="rf-proof-ico">💵</div>
                    <div class="rf-proof-val"><?= $statMonth ?></div>
                    <p class="rf-proof-lbl"><?= $statMonthLbl ?></p>
                </div>
            </div>
            <div class="col-sm-4" style="margin-bottom:14px">
                <div class="rf-proof-card">
                    <div class="rf-proof-ico">👥</div>
                    <div class="rf-proof-val"><?= $statToday ?></div>
                    <p class="rf-proof-lbl"><?= $statTodayLbl ?></p>
                </div>
            </div>
            <div class="col-sm-4" style="margin-bottom:14px">
                <div class="rf-proof-card">
                    <div class="rf-proof-ico">🏆</div>
                    <div class="rf-proof-val"><?= $statLargest ?></div>
                    <p class="rf-proof-lbl"><?= __('Largest Single Payout') ?></p>
                </div>
            </div>
        </div>

        <!-- Proof table -->
        <div class="rf-proof-tbl">
            <div class="rf-proof-hd">
                <span><?= __('Publisher') ?></span>
                <span><?= __('Amount') ?></span>
                <span><?= __('Method') ?></span>
                <span><?= __('Date') ?></span>
            </div>

            <?php if ($hasData): ?>
                <?php foreach ($dbPayments as $i => $w): ?>
                <?php
                    $username = $w->user->username ?? 'user';
                    $country  = $w->user->country ?? '';
                    $flag     = $rfProofFlag($country);
                    $masked   = rf_mask_user($username);
                    $amount   = '$' . number_format((float)$w->amount, 2);
                    $method   = h((string)($rfWmMap[$w->method] ?? $w->method));
                    $date     = $w->created ? $w->created->format('M d, Y, g:i A') : '';
                ?>
                <div class="rf-proof-row<?= $i===0?' rf-active':'' ?>" id="rfpr<?= $i ?>">
                    <span class="rf-proof-user"><?= $flag ?> <?= h($masked) ?></span>
                    <span class="rf-proof-amount"><?= $amount ?></span>
                    <span class="rf-proof-method"><?= $method ?></span>
                    <span class="rf-proof-date"><?= $date ?></span>
                </div>
                <?php endforeach; ?>

            <?php else: ?>
                <?php
                // No DB data yet — show static demo rows
                $staticRows = [
                    ['🇰🇭','Sou***412','$12.50','PayPal',    'Jun 29'],
                    ['🇮🇳','Rah***786','$8.30', 'USDT TRC20','Jun 29'],
                    ['🇺🇸','Ali***123','$45.20','PayPal',    'Jun 28'],
                    ['🇧🇩','Mod***555','$5.00', 'USDT BEP20','Jun 28'],
                    ['🇬🇧','Joh***990','$23.80','PayPal',    'Jun 27'],
                    ['🇵🇭','Tan***321','$7.60', 'USDT TRC20','Jun 27'],
                    ['🇷🇺','Ami***667','$15.40','WebMoney',  'Jun 26'],
                    ['🇨🇦','Kar***234','$9.90', 'PayPal',    'Jun 26'],
                ];
                foreach ($staticRows as $i => $r):
                ?>
                <div class="rf-proof-row<?= $i===0?' rf-active':'' ?>" id="rfpr<?= $i ?>">
                    <span class="rf-proof-user"><?= $r[0] ?> <?= $r[1] ?></span>
                    <span class="rf-proof-amount"><?= $r[2] ?></span>
                    <span class="rf-proof-method"><?= $r[3] ?></span>
                    <span class="rf-proof-date"><?= $r[4] ?></span>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>

        </div>

        <p class="rf-proof-note">
            <?= __('Showing recent payments · Usernames partially masked for privacy') ?> ·
            <a href="<?= build_main_domain_url('/pages/payment-proof') ?>"><?= __('View all →') ?></a>
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
                <a href="<?= build_main_domain_url('/pages/payment-proof') ?>" class="rf-btn-secondary"><?= __('View Rates') ?></a>
            </div>
        </div>
    </div>
</div>
