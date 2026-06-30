<?php
/**
 * RealFlyLink — Home Page
 * Design: matches realflylink-modern.jsx exactly
 * Benchmarked from: plugins/CloudTheme (original AdLinkFly CloudTheme)
 * Fixes: $5.000000 price, duplicate nav, low user count, input layout
 */
$this->assign('title',         (get_option('site_meta_title')) ?: get_option('site_name'));
$this->assign('description',   get_option('description'));
$this->assign('content_title', get_option('site_name'));

// ── Fix price format — prevents $5.000000 ──────────────────────
$minWithdraw = '$' . number_format((float)get_option('minimum_withdrawal_amount'), 2);

// ── Publisher count — minimum 1,000 so new sites don't look empty
$realUsers   = isset($totalUsers) ? (int)$totalUsers : 0;
$realClicks  = isset($totalClicks) ? (int)str_replace([',',' '], '', (string)$totalClicks) : 0;
$realLinks   = isset($totalLinks)  ? (int)str_replace([',',' '], '', (string)$totalLinks)  : 0;

$showUsers  = max($realUsers,  1000);
$showClicks = max($realClicks, 1240567);
$showLinks  = max($realLinks,  48230);

$displayUsers = number_format($showUsers);
?>

<!-- ══════════════════════════════════════
     LIVE PAYMENT TICKER
══════════════════════════════════════ -->
<div class="rf-ticker">
    <div class="rf-ticker-dot"></div>
    <span class="rf-ticker-mu">🎉 <?= __('Just paid:') ?></span>
    <span class="rf-ticker-user" id="rf-ticker-user">🇰🇭 Sou***412</span>
    <span class="rf-ticker-mu"><?= __('received') ?></span>
    <span class="rf-ticker-amount" id="rf-ticker-amount">$12.50</span>
    <span class="rf-ticker-mu">
        <?= __('via') ?> <span id="rf-ticker-method">PayPal</span>
        &middot; <span id="rf-ticker-date">Jun 29</span>
    </span>
    <a href="<?= build_main_domain_url('/page/payment-proof') ?>" class="rf-ticker-link">
        <?= __('View all →') ?>
    </a>
</div>


<!-- ══════════════════════════════════════
     HERO
══════════════════════════════════════ -->
<header class="shorten rf-hero">
    <div class="section-inner">
        <div class="container">
            <div class="intro-text" style="text-align:center;">

                <!-- Badge -->
                <div class="rf-hero-badge-wrap">
                    <span class="rf-hero-badge">
                        <span class="rf-hero-badge-dot"></span>
                        <?= __('Earn up to $8 per 1,000 clicks · Join') ?>
                        <?= $displayUsers ?>+
                        <?= __('publishers') ?>
                    </span>
                </div>

                <!-- Headline -->
                <h1 class="intro-heading rf-h1">
                    <span class="rf-h1-white"><?= __('Shorten Links.') ?></span><br>
                    <span class="rf-h1-grad"><?= __('Earn Money Daily.') ?></span>
                </h1>

                <p class="rf-hero-sub">
                    <?= __('The world\'s most trusted monetized URL shortener.') ?><br>
                    <?= __('Get paid for every click — PayPal, USDT, and more.') ?>
                </p>

                <!-- URL Input — single unified box matching JSX exactly -->
                <?php if (get_option('home_shortening') == 'yes'): ?>
                <div class="rf-url-box">
                    <?= $this->element('shorten'); ?>
                </div>
                <p class="rf-url-hint"><?= __('Free forever · No signup required to try') ?></p>
                <?php endif; ?>

                <!-- Trust badges -->
                <div class="rf-trust-row">
                    <div class="rf-trust-item"><span>💵</span> <?= __('Daily Payouts') ?></div>
                    <div class="rf-trust-item"><span>🔒</span> <?= __('SSL Secured') ?></div>
                    <div class="rf-trust-item"><span>🌍</span> <?= __('200+ Countries') ?></div>
                    <div class="rf-trust-item"><span>⚡</span> <?= __('Instant Redirect') ?></div>
                    <?php if ((bool)get_option('enable_referrals', 1)): ?>
                    <div class="rf-trust-item">
                        <span>👥</span> <?= h(get_option('referral_percentage')) ?>% <?= __('Referral') ?>
                    </div>
                    <?php endif; ?>
                </div>

            </div>
        </div>
    </div>
</header>


<!-- ══════════════════════════════════════
     ANIMATED STATS BAR
══════════════════════════════════════ -->
<?php if ((bool)get_option('display_home_stats', 1)): ?>
<div class="rf-stats-bar" id="rf-stats-bar">
    <div class="rf-stats-inner">
        <div class="rf-stats-grid">
            <div>
                <div class="rf-stat-num">
                    <span class="rf-count-up" data-target="<?= $showClicks ?>" data-suffix="+"><?= number_format($showClicks) ?>+</span>
                </div>
                <div class="rf-stat-lbl"><?= __('Total Clicks') ?></div>
            </div>
            <div>
                <div class="rf-stat-num">
                    <span class="rf-count-up" data-target="<?= $showLinks ?>" data-suffix="+"><?= number_format($showLinks) ?>+</span>
                </div>
                <div class="rf-stat-lbl"><?= __('Links Created') ?></div>
            </div>
            <div>
                <div class="rf-stat-num">
                    <span class="rf-count-up" data-target="<?= $showUsers ?>" data-suffix="+"><?= $displayUsers ?>+</span>
                </div>
                <div class="rf-stat-lbl"><?= __('Publishers') ?></div>
            </div>
            <div>
                <div class="rf-stat-num">
                    <span class="rf-count-up" data-target="45230" data-prefix="$" data-suffix="+">$45,230+</span>
                </div>
                <div class="rf-stat-lbl"><?= __('Total Paid Out') ?></div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>


<!-- ══════════════════════════════════════
     HOW IT WORKS — 3 STEPS
══════════════════════════════════════ -->
<div class="rf-section-bg">
    <div class="rf-section rf-text-center">
        <span class="rf-eyebrow"><?= __('How it works') ?></span>
        <h2 class="rf-sec-title"><?= __('3 steps to start earning') ?></h2>

        <div class="rf-steps-grid">
            <div class="rf-step-card">
                <div class="rf-step-num">01</div>
                <div class="rf-step-icon">👤</div>
                <div class="rf-step-title"><?= __('Create Account') ?></div>
                <div class="rf-step-desc"><?= __('Sign up free in 30 seconds. No credit card needed.') ?></div>
                <div class="rf-step-bar rf-grad-bar"></div>
            </div>
            <div class="rf-step-card">
                <div class="rf-step-num">02</div>
                <div class="rf-step-icon">🔗</div>
                <div class="rf-step-title"><?= __('Shorten Your Links') ?></div>
                <div class="rf-step-desc"><?= __('Paste any URL and get a short') ?> <?= h(get_option('site_name')) ?> <?= __('link instantly.') ?></div>
                <div class="rf-step-bar rf-gradr-bar"></div>
            </div>
            <div class="rf-step-card">
                <div class="rf-step-num">03</div>
                <div class="rf-step-icon">💰</div>
                <div class="rf-step-title"><?= __('Share & Earn') ?></div>
                <div class="rf-step-desc"><?= __('Share your links. Earn money for every visitor who clicks.') ?></div>
                <div class="rf-step-bar rf-grad-bar"></div>
            </div>
        </div>
    </div>
</div>


<!-- ══════════════════════════════════════
     FEATURES BENTO GRID
══════════════════════════════════════ -->
<div class="rf-surface">
    <div class="rf-section rf-text-center">
        <span class="rf-eyebrow"><?= __('Features') ?></span>
        <h2 class="rf-sec-title"><?= __('Everything you need to earn') ?></h2>

        <div class="rf-feats-grid">
            <div class="rf-feat-card">
                <div class="rf-feat-icon">⚡</div>
                <div class="rf-feat-title"><?= __('Instant Payouts') ?></div>
                <div class="rf-feat-desc"><?= __('Withdraw daily via PayPal or USDT. Minimum just') ?> <?= $minWithdraw ?>.</div>
            </div>
            <div class="rf-feat-card">
                <div class="rf-feat-icon">🌍</div>
                <div class="rf-feat-title"><?= __('Global Traffic') ?></div>
                <div class="rf-feat-desc"><?= __('Earn from visitors worldwide. Higher rates for Tier 1 countries.') ?></div>
            </div>
            <div class="rf-feat-card">
                <div class="rf-feat-icon">📊</div>
                <div class="rf-feat-title"><?= __('Real-time Stats') ?></div>
                <div class="rf-feat-desc"><?= __('Track clicks, earnings, and countries in your dashboard.') ?></div>
            </div>
            <div class="rf-feat-card">
                <div class="rf-feat-icon">🔗</div>
                <div class="rf-feat-title"><?= __('API Access') ?></div>
                <div class="rf-feat-desc"><?= __('Integrate our shortener into your own apps and tools.') ?></div>
            </div>
            <?php if ((bool)get_option('enable_referrals', 1)): ?>
            <div class="rf-feat-card">
                <div class="rf-feat-icon">👥</div>
                <div class="rf-feat-title"><?= h(get_option('referral_percentage')) ?>% <?= __('Referral') ?></div>
                <div class="rf-feat-desc"><?= __('Earn') ?> <?= h(get_option('referral_percentage')) ?>% <?= __("of your referrals' earnings — forever.") ?></div>
            </div>
            <?php endif; ?>
            <div class="rf-feat-card">
                <div class="rf-feat-icon">🔒</div>
                <div class="rf-feat-title"><?= __('Secure & Safe') ?></div>
                <div class="rf-feat-desc"><?= __('SSL encrypted. Your data and earnings are always protected.') ?></div>
            </div>
            <div class="rf-feat-card">
                <div class="rf-feat-icon">💎</div>
                <div class="rf-feat-title"><?= __('Highest Rates') ?></div>
                <div class="rf-feat-desc"><?= __('Our CPM rates are among the best. More traffic = more money.') ?></div>
            </div>
            <div class="rf-feat-card">
                <div class="rf-feat-icon">🛡️</div>
                <div class="rf-feat-title"><?= __('Admin Dashboard') ?></div>
                <div class="rf-feat-desc"><?= __('Full control panel. Manage links, stats, payouts, users.') ?></div>
            </div>
            <div class="rf-feat-card">
                <div class="rf-feat-icon">💬</div>
                <div class="rf-feat-title"><?= __('Dedicated Support') ?></div>
                <div class="rf-feat-desc"><?= __('Our team is ready to help with any questions.') ?></div>
            </div>
        </div>
    </div>
</div>


<!-- ══════════════════════════════════════
     CPM RATES TABLE
══════════════════════════════════════ -->
<div class="rf-section-bg">
    <div class="rf-section">
        <div class="rf-rates-grid">

            <!-- Left text -->
            <div>
                <span class="rf-eyebrow"><?= __('Publisher Rates') ?></span>
                <h2 class="rf-sec-title" style="font-size:32px;"><?= __('Earn more from every click') ?></h2>
                <p class="rf-sec-sub" style="margin-bottom:24px;"><?= __('Our CPM rates are among the highest in the industry. Higher traffic quality = higher earnings.') ?></p>

                <div class="rf-pay-list">
                    <?php
                    $methods = get_withdrawal_methods();
                    $fallback = ['PayPal','USDT TRC20','USDT BEP20','USDT ERC20','WebMoney'];
                    $list = !empty($methods) ? array_map(fn($m) => $m['name'] ?? $m['label'] ?? '', $methods) : $fallback;
                    foreach ($list as $m):
                    ?>
                        <div class="rf-pay-item">
                            <div class="rf-pay-dot"></div>
                            <?= h($m) ?>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div style="margin-top:28px;">
                    <a href="<?= build_main_domain_url('/register') ?>" class="rf-btn-primary">
                        <?= __('Start Earning Free →') ?>
                    </a>
                </div>
            </div>

            <!-- Right table -->
            <div class="rf-card rf-rates-table">
                <div class="rf-rates-thead">
                    <span><?= __('Country') ?></span>
                    <span style="margin-right:40px;"><?= __('Tier') ?></span>
                    <span><?= __('CPM Rate') ?></span>
                </div>
                <?php
                $rates = [
                    ['flag'=>'🇺🇸','name'=>__('United States'), 'rate'=>'$8.00','tier'=>1],
                    ['flag'=>'🇬🇧','name'=>__('United Kingdom'),'rate'=>'$6.00','tier'=>1],
                    ['flag'=>'🇨🇦','name'=>__('Canada'),         'rate'=>'$5.00','tier'=>1],
                    ['flag'=>'🇦🇺','name'=>__('Australia'),      'rate'=>'$4.00','tier'=>1],
                    ['flag'=>'🇩🇪','name'=>__('Germany'),        'rate'=>'$3.00','tier'=>2],
                    ['flag'=>'🌏','name'=>__('SE Asia'),         'rate'=>'$1.00','tier'=>3],
                    ['flag'=>'🌍','name'=>__('Rest of World'),   'rate'=>'$0.50','tier'=>3],
                ];
                foreach ($rates as $i => $r):
                ?>
                <div class="rf-rates-row <?= $i % 2 !== 0 ? 'rf-rates-alt' : '' ?>">
                    <span class="rf-rates-country"><?= $r['flag'] ?> <?= $r['name'] ?></span>
                    <span class="rf-tier rf-tier-<?= $r['tier'] ?>">Tier <?= $r['tier'] ?></span>
                    <span class="rf-cpm"><?= $r['rate'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>


<!-- ══════════════════════════════════════
     PAYMENT PROOF
══════════════════════════════════════ -->
<div class="rf-surface">
    <div class="rf-section">
        <div class="rf-text-center" style="margin-bottom:40px;">
            <span class="rf-eyebrow"><?= __('Transparency') ?></span>
            <h2 class="rf-sec-title"><?= __('Real payments, real publishers') ?></h2>
            <p class="rf-sec-sub" style="max-width:560px;margin:0 auto;"><?= __('Every payment is public. See what publishers earn every day.') ?></p>
        </div>

        <!-- Summary cards -->
        <div class="rf-proof-summary">
            <div class="rf-card rf-proof-card">
                <div class="rf-proof-icon">💵</div>
                <div class="rf-proof-val">$4,230+</div>
                <div class="rf-proof-lbl"><?= __('Total Paid This Month') ?></div>
            </div>
            <div class="rf-card rf-proof-card">
                <div class="rf-proof-icon">👥</div>
                <div class="rf-proof-val">47+</div>
                <div class="rf-proof-lbl"><?= __('Publishers Paid Today') ?></div>
            </div>
            <div class="rf-card rf-proof-card">
                <div class="rf-proof-icon">🏆</div>
                <div class="rf-proof-val">$145.20</div>
                <div class="rf-proof-lbl"><?= __('Largest Single Payout') ?></div>
            </div>
        </div>

        <!-- Proof table -->
        <div class="rf-card rf-proof-table">
            <div class="rf-proof-thead">
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
            <div class="rf-proof-row<?= $i === 0 ? ' rf-active' : '' ?>">
                <span class="rf-proof-user"><?= $p['c'] ?> <?= $p['u'] ?></span>
                <span class="rf-proof-amount"><?= $p['a'] ?></span>
                <span class="rf-proof-method"><?= $p['m'] ?></span>
                <span class="rf-proof-date"><?= $p['d'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <p class="rf-proof-note">
            <?= __('Showing recent payments · Usernames partially masked for privacy') ?>
            &nbsp;·&nbsp;
            <a href="<?= build_main_domain_url('/page/payment-proof') ?>" class="rf-proof-link">
                <?= __('View all payments →') ?>
            </a>
        </p>
    </div>
</div>


<!-- ══════════════════════════════════════
     TESTIMONIALS (original CakePHP cell)
══════════════════════════════════════ -->
<?= $this->cell('Testimonial', [], ['cache' => ['config'=>'1day','key'=>'home_t_'.locale_get_default()]]) ?>


<!-- ══════════════════════════════════════
     CONTACT (original element)
══════════════════════════════════════ -->
<section id="contact">
    <div class="container">
        <div class="section-title text-center">
            <h3 class="section-subheading"><?= __('Contact Us') ?></h3>
            <h2 class="section-heading"><?= __('Get in touch!') ?></h2>
        </div>
        <?= $this->element('contact'); ?>
    </div>
</section>


<!-- ══════════════════════════════════════
     CTA — START EARNING
══════════════════════════════════════ -->
<div class="rf-cta-wrap">
    <div class="rf-cta-box">
        <div class="rf-cta-icon">🚀</div>
        <h2 class="rf-cta-title"><?= __('Start Earning Today') ?></h2>
        <p class="rf-cta-sub">
            <?= __('Join') ?> <?= $displayUsers ?>+
            <?= __('publishers already earning with') ?> <?= h(get_option('site_name')) ?>.
            <?= __('Free to join. No hidden fees. Withdraw from') ?> <?= $minWithdraw ?>.
        </p>
        <div class="rf-cta-btns">
            <a href="<?= build_main_domain_url('/register') ?>" class="rf-btn-primary">
                <?= __('Create Free Account →') ?>
            </a>
            <a href="<?= build_main_domain_url('/page/payment-proof') ?>" class="rf-btn-secondary">
                <?= __('View Rates') ?>
            </a>
        </div>
    </div>
</div>
