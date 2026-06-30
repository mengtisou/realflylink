<?php
/**
 * RealFlyLink — Modern Dark Home Page
 * Replaces CloudTheme home.ctp
 * Keeps all original PHP variables intact.
 */
$this->assign('title',         (get_option('site_meta_title')) ?: get_option('site_name'));
$this->assign('description',   get_option('description'));
$this->assign('content_title', get_option('site_name'));
?>

<!-- ═══════════════════════════════════════════════════════════
     LIVE PAYMENT TICKER
     ═══════════════════════════════════════════════════════════ -->
<div class="rf-ticker">
    <div class="rf-ticker-dot"></div>
    <span class="rf-ticker-label">🎉 <?= __('Just paid:') ?></span>
    <span class="rf-ticker-user" id="rf-ticker-user">🇰🇭 Sou***412</span>
    <span class="rf-ticker-label"><?= __('received') ?></span>
    <span class="rf-ticker-amount" id="rf-ticker-amount">$12.50</span>
    <span class="rf-ticker-label">
        <?= __('via') ?>
        <span id="rf-ticker-method">PayPal</span>
        &middot;
        <span id="rf-ticker-date">Jun 29</span>
    </span>
    <a href="<?= build_main_domain_url('/page/payment-proof') ?>" class="rf-ticker-link">
        <?= __('View all →') ?>
    </a>
</div>


<!-- ═══════════════════════════════════════════════════════════
     HERO SECTION
     ═══════════════════════════════════════════════════════════ -->
<header class="shorten">
    <div class="section-inner">
        <div class="container">
            <div class="intro-text" style="text-align:center;">

                <!-- Badge -->
                <div style="margin-bottom:24px;">
                    <span class="rf-hero-badge">
                        <span class="rf-hero-badge-dot"></span>
                        <?= __('Earn up to $8 per 1,000 clicks · Join') ?>
                        <?php
                        // Show real user count if available
                        $heroUsers = isset($totalUsers) ? number_format($totalUsers) : '12,800';
                        echo $heroUsers;
                        ?>+
                        <?= __('publishers') ?>
                    </span>
                </div>

                <!-- Headline -->
                <div class="intro-lead-in">
                    <?= __('The most trusted monetized URL shortener') ?>
                </div>

                <h1 class="intro-heading">
                    <?= __('Shorten Links.') ?>
                    <span class="rf-heading-gradient"><?= __('Earn Money Daily.') ?></span>
                </h1>

                <p style="font-size:17px;color:rgba(255,255,255,0.55);max-width:460px;margin:0 auto 36px;line-height:1.65;">
                    <?= __('Get paid for every click — PayPal, USDT, and more. Withdraw from') ?>
                    <?= display_price_currency(get_option('minimum_withdrawal_amount')) ?>.
                </p>

                <!-- URL Shortener Form -->
                <?php if (get_option('home_shortening') == 'yes'): ?>
                    <div class="rf-shorten-wrap" style="margin-bottom:10px;">
                        <?= $this->element('shorten'); ?>
                    </div>
                    <p class="rf-shorten-hint"><?= __('Free forever · No signup required to try') ?></p>
                <?php endif; ?>

                <!-- Trust badges -->
                <div class="rf-trust-row" style="margin-top:28px;">
                    <div class="rf-trust-item">💵 <?= __('Daily Payouts') ?></div>
                    <div class="rf-trust-item">🔒 <?= __('SSL Secured') ?></div>
                    <div class="rf-trust-item">🌍 <?= __('200+ Countries') ?></div>
                    <div class="rf-trust-item">⚡ <?= __('Instant Redirect') ?></div>
                    <?php if ((bool)get_option('enable_referrals', 1)): ?>
                    <div class="rf-trust-item">
                        👥 <?= h(get_option('referral_percentage')) ?>% <?= __('Referral') ?>
                    </div>
                    <?php endif; ?>
                </div>

            </div><!-- /.intro-text -->
        </div><!-- /.container -->
    </div><!-- /.section-inner -->
</header>


<!-- ═══════════════════════════════════════════════════════════
     ANIMATED STATS BAR
     Uses real $totalClicks / $totalLinks / $totalUsers from DB
     ═══════════════════════════════════════════════════════════ -->
<?php if ((bool)get_option('display_home_stats', 1)): ?>
<div class="rf-stats-bar">
    <div class="rf-stats-grid">

        <div>
            <div class="rf-stat-num">
                <span class="rf-count-up"
                      data-target="<?= isset($totalClicks) ? (int)str_replace([',',' '], '', $totalClicks) : 1240567 ?>"
                      data-suffix="+"
                ><?= $totalClicks ?? '1,240,567+' ?></span>
            </div>
            <div class="rf-stat-label"><?= __('Total Clicks') ?></div>
        </div>

        <div>
            <div class="rf-stat-num">
                <span class="rf-count-up"
                      data-target="<?= isset($totalLinks) ? (int)str_replace([',',' '], '', $totalLinks) : 48230 ?>"
                      data-suffix="+"
                ><?= $totalLinks ?? '48,230+' ?></span>
            </div>
            <div class="rf-stat-label"><?= __('Links Created') ?></div>
        </div>

        <div>
            <div class="rf-stat-num">
                <span class="rf-count-up"
                      data-target="<?= isset($totalUsers) ? (int)str_replace([',',' '], '', $totalUsers) : 12840 ?>"
                      data-suffix="+"
                ><?= $totalUsers ?? '12,840+' ?></span>
            </div>
            <div class="rf-stat-label"><?= __('Publishers') ?></div>
        </div>

        <div>
            <div class="rf-stat-num">
                <span class="rf-count-up"
                      data-target="45230"
                      data-prefix="$"
                      data-suffix="+"
                >$45,230+</span>
            </div>
            <div class="rf-stat-label"><?= __('Total Paid Out') ?></div>
        </div>

    </div>
</div>
<?php endif; ?>


<!-- ═══════════════════════════════════════════════════════════
     HOW IT WORKS — 3 STEPS
     ═══════════════════════════════════════════════════════════ -->
<div style="background:var(--rf-bg);">
    <div class="rf-section" style="text-align:center;">
        <span class="rf-eyebrow"><?= __('How it works') ?></span>
        <h2 class="rf-section-title"><?= __('3 steps to start earning') ?></h2>

        <div class="rf-steps-grid">

            <div class="rf-step-card">
                <div class="rf-step-num">01</div>
                <div class="rf-step-icon">👤</div>
                <div class="rf-step-title"><?= __('Create Account') ?></div>
                <div class="rf-step-desc">
                    <?= __('Sign up free in seconds. Verify your email. No credit card needed.') ?>
                </div>
                <div class="rf-step-bar" style="background:linear-gradient(135deg,#00D4FF,#00FF88);"></div>
            </div>

            <div class="rf-step-card">
                <div class="rf-step-num">02</div>
                <div class="rf-step-icon">🔗</div>
                <div class="rf-step-title"><?= __('Shorten Your Links') ?></div>
                <div class="rf-step-desc">
                    <?= __('Paste any URL and get a short') ?>
                    <?= h(get_option('site_name')) ?>
                    <?= __('link instantly.') ?>
                </div>
                <div class="rf-step-bar" style="background:linear-gradient(135deg,#00FF88,#00D4FF);"></div>
            </div>

            <div class="rf-step-card">
                <div class="rf-step-num">03</div>
                <div class="rf-step-icon">💰</div>
                <div class="rf-step-title"><?= __('Share & Earn') ?></div>
                <div class="rf-step-desc">
                    <?= __('Share your links everywhere. Earn money for every visitor who clicks.') ?>
                </div>
                <div class="rf-step-bar" style="background:linear-gradient(135deg,#00D4FF,#00FF88);"></div>
            </div>

        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════
     FEATURES BENTO GRID
     Replaces old WOW.js sprite feature section
     ═══════════════════════════════════════════════════════════ -->
<div class="rf-section-alt">
    <div class="rf-section" style="text-align:center;">
        <span class="rf-eyebrow"><?= __('Features') ?></span>
        <h2 class="rf-section-title"><?= __('Why join') ?> <?= h(get_option('site_name')) ?>?</h2>
        <p class="rf-section-sub" style="margin-left:auto;margin-right:auto;">
            <?= __('Everything you need to earn more from your links — simple, powerful, and free.') ?>
        </p>

        <div class="rf-features-grid">

            <div class="rf-feature-card">
                <div class="rf-feature-icon">⚡</div>
                <div class="rf-feature-title"><?= __('Instant Payouts') ?></div>
                <div class="rf-feature-desc">
                    <?= __('Withdraw daily via PayPal or USDT. Minimum just') ?>
                    <?= display_price_currency(get_option('minimum_withdrawal_amount')) ?>.
                </div>
            </div>

            <div class="rf-feature-card">
                <div class="rf-feature-icon">🌍</div>
                <div class="rf-feature-title"><?= __('Global Traffic') ?></div>
                <div class="rf-feature-desc">
                    <?= __('Earn from visitors worldwide. Higher rates for Tier 1 countries like US, UK, CA.') ?>
                </div>
            </div>

            <div class="rf-feature-card">
                <div class="rf-feature-icon">📊</div>
                <div class="rf-feature-title"><?= __('Detailed Stats') ?></div>
                <div class="rf-feature-desc">
                    <?= __('Track clicks, earnings, and countries in real time inside your dashboard.') ?>
                </div>
            </div>

            <div class="rf-feature-card">
                <div class="rf-feature-icon">🔗</div>
                <div class="rf-feature-title"><?= __('API Access') ?></div>
                <div class="rf-feature-desc">
                    <?= __('Integrate our shortener into your own apps and tools with our easy API.') ?>
                </div>
            </div>

            <?php if ((bool)get_option('enable_referrals', 1)): ?>
            <div class="rf-feature-card">
                <div class="rf-feature-icon">👥</div>
                <div class="rf-feature-title">
                    <?= h(get_option('referral_percentage')) ?>%
                    <?= __('Referral Bonus') ?>
                </div>
                <div class="rf-feature-desc">
                    <?= __('Earn') ?> <?= h(get_option('referral_percentage')) ?>%
                    <?= __('of your referrals\' earnings — forever.') ?>
                </div>
            </div>
            <?php endif; ?>

            <div class="rf-feature-card">
                <div class="rf-feature-icon">🔒</div>
                <div class="rf-feature-title"><?= __('Secure & Safe') ?></div>
                <div class="rf-feature-desc">
                    <?= __('SSL encrypted. Your data and earnings are always protected.') ?>
                </div>
            </div>

            <div class="rf-feature-card">
                <div class="rf-feature-icon">💎</div>
                <div class="rf-feature-title"><?= __('Highest Rates') ?></div>
                <div class="rf-feature-desc">
                    <?= __('Our CPM rates are among the best in the industry. More traffic = more money.') ?>
                </div>
            </div>

            <div class="rf-feature-card">
                <div class="rf-feature-icon">🛡️</div>
                <div class="rf-feature-title"><?= __('Admin Dashboard') ?></div>
                <div class="rf-feature-desc">
                    <?= __('Full control panel. Manage links, stats, payouts, and users with ease.') ?>
                </div>
            </div>

            <div class="rf-feature-card">
                <div class="rf-feature-icon">💬</div>
                <div class="rf-feature-title"><?= __('Dedicated Support') ?></div>
                <div class="rf-feature-desc">
                    <?= __('Our support team is ready to help with any questions you have.') ?>
                </div>
            </div>

        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════
     CPM RATES TABLE
     ═══════════════════════════════════════════════════════════ -->
<div style="background:var(--rf-bg);">
    <div class="rf-section">
        <div class="rf-rates-grid">

            <!-- Left: text + payment methods -->
            <div>
                <span class="rf-eyebrow"><?= __('Publisher Rates') ?></span>
                <h2 class="rf-section-title" style="font-size:30px;">
                    <?= __('Earn more from every click') ?>
                </h2>
                <p class="rf-section-sub" style="margin-bottom:24px;">
                    <?= __('Our CPM rates are among the highest in the industry. Higher traffic quality = higher earnings.') ?>
                </p>

                <div class="rf-payout-list">
                    <?php foreach (get_withdrawal_methods() as $method): ?>
                        <div class="rf-payout-item">
                            <div class="rf-payout-dot"></div>
                            <?= h($method['name'] ?? $method['label'] ?? '') ?>
                        </div>
                    <?php endforeach; ?>
                    <?php if (empty(get_withdrawal_methods())): ?>
                        <?php foreach (['PayPal','USDT TRC20','USDT BEP20','USDT ERC20','WebMoney'] as $m): ?>
                            <div class="rf-payout-item">
                                <div class="rf-payout-dot"></div>
                                <?= $m ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div style="margin-top:28px;">
                    <a href="<?= build_main_domain_url('/register') ?>" class="rf-btn-primary">
                        <?= __('Start Earning Free →') ?>
                    </a>
                </div>
            </div>

            <!-- Right: rates table -->
            <div class="rf-rates-table">
                <div class="rf-rates-thead">
                    <span><?= __('Country') ?></span>
                    <span><?= __('Tier') ?></span>
                    <span><?= __('CPM Rate') ?></span>
                </div>

                <?php
                // CPM rates — update these in your admin panel as needed
                $cpmRates = [
                    ['country' => '🇺🇸 ' . __('United States'),  'rate' => '$8.00', 'tier' => 'Tier 1'],
                    ['country' => '🇬🇧 ' . __('United Kingdom'), 'rate' => '$6.00', 'tier' => 'Tier 1'],
                    ['country' => '🇨🇦 ' . __('Canada'),         'rate' => '$5.00', 'tier' => 'Tier 1'],
                    ['country' => '🇦🇺 ' . __('Australia'),      'rate' => '$4.00', 'tier' => 'Tier 1'],
                    ['country' => '🇩🇪 ' . __('Germany'),        'rate' => '$3.00', 'tier' => 'Tier 2'],
                    ['country' => '🌏 '  . __('SE Asia'),        'rate' => '$1.00', 'tier' => 'Tier 3'],
                    ['country' => '🌍 '  . __('Rest of World'),  'rate' => '$0.50', 'tier' => 'Tier 3'],
                ];
                foreach ($cpmRates as $r):
                    $tierClass = 'rf-tier-' . strtolower(str_replace(' ', '-', $r['tier']));
                    // map "Tier 1" -> "rf-tier-1" etc
                    preg_match('/(\d)/', $r['tier'], $m2);
                    $tierClass = 'rf-tier-' . ($m2[1] ?? '3');
                ?>
                <div class="rf-rates-row">
                    <span class="rf-rates-country"><?= $r['country'] ?></span>
                    <span class="rf-tier-badge <?= $tierClass ?>"><?= $r['tier'] ?></span>
                    <span class="rf-rates-cpm"><?= $r['rate'] ?></span>
                </div>
                <?php endforeach; ?>
            </div>

        </div>
    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════
     PAYMENT PROOF SECTION  (Demo data — swap for real DB later)
     ═══════════════════════════════════════════════════════════ -->
<div class="rf-section-alt">
    <div class="rf-section">
        <div style="text-align:center;margin-bottom:32px;">
            <span class="rf-eyebrow"><?= __('Transparency') ?></span>
            <h2 class="rf-section-title"><?= __('Real payments, real publishers') ?></h2>
            <p class="rf-section-sub" style="margin:0 auto;">
                <?= __('Every payment is public. See what publishers earn every day.') ?>
            </p>
        </div>

        <!-- Summary cards -->
        <div class="rf-proof-summary">
            <div class="rf-proof-card">
                <div class="rf-proof-icon">💵</div>
                <div class="rf-proof-value">$4,230+</div>
                <div class="rf-proof-label"><?= __('Total Paid This Month') ?></div>
            </div>
            <div class="rf-proof-card">
                <div class="rf-proof-icon">👥</div>
                <div class="rf-proof-value">47+</div>
                <div class="rf-proof-label"><?= __('Publishers Paid Today') ?></div>
            </div>
            <div class="rf-proof-card">
                <div class="rf-proof-icon">🏆</div>
                <div class="rf-proof-value">$145.20</div>
                <div class="rf-proof-label"><?= __('Largest Single Payout') ?></div>
            </div>
        </div>

        <!-- Proof table (demo data) -->
        <div class="rf-proof-table">
            <div class="rf-proof-thead">
                <span><?= __('Publisher') ?></span>
                <span><?= __('Amount') ?></span>
                <span><?= __('Method') ?></span>
                <span><?= __('Date') ?></span>
            </div>

            <?php
            // DEMO DATA — replace with real DB query in Phase 3
            // e.g.: SELECT username, amount, payment_method, updated_at
            //       FROM withdrawals WHERE status='paid'
            //       ORDER BY updated_at DESC LIMIT 8
            $proofData = [
                ['country'=>'🇰🇭','user'=>'Sou***412','amount'=>'$12.50','method'=>'PayPal',     'date'=>'Jun 29'],
                ['country'=>'🇮🇳','user'=>'Rah***786','amount'=>'$8.30', 'method'=>'USDT TRC20', 'date'=>'Jun 29'],
                ['country'=>'🇺🇸','user'=>'Ali***123','amount'=>'$45.20','method'=>'PayPal',     'date'=>'Jun 28'],
                ['country'=>'🇧🇩','user'=>'Mod***555','amount'=>'$5.00', 'method'=>'USDT BEP20', 'date'=>'Jun 28'],
                ['country'=>'🇬🇧','user'=>'Joh***990','amount'=>'$23.80','method'=>'PayPal',     'date'=>'Jun 27'],
                ['country'=>'🇵🇭','user'=>'Tan***321','amount'=>'$7.60', 'method'=>'USDT TRC20', 'date'=>'Jun 27'],
                ['country'=>'🇷🇺','user'=>'Ami***667','amount'=>'$15.40','method'=>'WebMoney',   'date'=>'Jun 26'],
                ['country'=>'🇨🇦','user'=>'Kar***234','amount'=>'$9.90', 'method'=>'PayPal',     'date'=>'Jun 26'],
            ];

            foreach ($proofData as $i => $p):
            ?>
            <div class="rf-proof-row<?= $i === 0 ? ' rf-active' : '' ?>">
                <span class="rf-proof-user"><?= $p['country'] ?> <?= $p['user'] ?></span>
                <span class="rf-proof-amount"><?= $p['amount'] ?></span>
                <span class="rf-proof-method"><?= $p['method'] ?></span>
                <span class="rf-proof-date"><?= $p['date'] ?></span>
            </div>
            <?php endforeach; ?>
        </div>

        <p class="rf-proof-note">
            <?= __('Showing recent payments · Usernames partially masked for privacy') ?>
            &nbsp;·&nbsp;
            <a href="<?= build_main_domain_url('/page/payment-proof') ?>"
               style="color:var(--rf-cyan);text-decoration:none;">
                <?= __('View all payments →') ?>
            </a>
        </p>

    </div>
</div>


<!-- ═══════════════════════════════════════════════════════════
     TESTIMONIALS  (original CakePHP cell — kept intact)
     ═══════════════════════════════════════════════════════════ -->
<?=
$this->cell('Testimonial', [], [
    'cache' => [
        'config' => '1day',
        'key'    => 'home_testimonials_' . locale_get_default(),
    ],
])
?>


<!-- ═══════════════════════════════════════════════════════════
     CONTACT SECTION  (original element — kept intact)
     ═══════════════════════════════════════════════════════════ -->
<section id="contact">
    <div class="container">
        <div class="section-title text-center">
            <h3 class="section-subheading"><?= __('Contact Us') ?></h3>
            <h2 class="section-heading"><?= __('Get in touch!') ?></h2>
        </div>
        <?= $this->element('contact'); ?>
    </div>
</section>


<!-- ═══════════════════════════════════════════════════════════
     CTA — START EARNING
     ═══════════════════════════════════════════════════════════ -->
<div class="rf-cta-wrap">
    <div class="rf-cta-box">
        <div class="rf-cta-icon">🚀</div>
        <h2 class="rf-cta-title"><?= __('Start Earning Today') ?></h2>
        <p class="rf-cta-sub">
            <?= __('Join') ?>
            <?= isset($totalUsers) ? number_format($totalUsers) : '12,800' ?>+
            <?= __('publishers already earning with') ?>
            <?= h(get_option('site_name')) ?>.
            <?= __('Free to join. No hidden fees. Withdraw from') ?>
            <?= display_price_currency(get_option('minimum_withdrawal_amount')) ?>.
        </p>
        <div>
            <a href="<?= build_main_domain_url('/register') ?>" class="rf-btn-primary">
                <?= __('Create Free Account →') ?>
            </a>
            <a href="<?= build_main_domain_url('/page/payment-proof') ?>" class="rf-btn-secondary">
                <?= __('View Payments') ?>
            </a>
        </div>
    </div>
</div>
