<?php
/**
 * RealFlyLink — Earn Money "Shortly about us" flow
 *
 * Rendered by Pages/view.ctp when the page slug is 'earn-money',
 * so the content lives in code and never has to survive CKEditor.
 *
 * Edit the seven points below to match your real rates.
 * Styles live in webroot/build/css/{realfly-dark,styles.min}.css (.rfa-* classes).
 */

$rfaSteps = [
    ['n' => '01', 'side' => 'l', 'lead' => __('Shorten any link in'),        'bold' => __('Under 3 Seconds.')],
    ['n' => '02', 'side' => 'r', 'lead' => __('Get paid for every'),         'bold' => __('1,000 Visitors.')],
    ['n' => '03', 'side' => 'l', 'lead' => __('Withdraw starting from a'),   'bold' => __('$5 Minimum.')],
    ['n' => '04', 'side' => 'r', 'lead' => __('Only official & safe'),       'bold' => __('Advertisements.')],
    ['n' => '05', 'side' => 'l', 'lead' => __('Live stats by country,'),     'bold' => __('Device And Source.')],
    ['n' => '06', 'side' => 'r', 'lead' => __('Ready to use'),               'bold' => __('API & Mass Shortener.')],
    ['n' => '07', 'side' => 'l', 'lead' => __('Referral system for website owners. Invite a friend and'),
                                 'bold' => __('Earn 20% For Life.')],
];
$rfaLast = count($rfaSteps) - 1;
?>
<div class="rfa-sec">
    <div class="rfa-waves"></div>
    <div class="rfa-wrap">

        <div class="rfa-medal"></div>

        <div class="rfa-flow">
            <?php foreach ($rfaSteps as $i => $s): ?>
                <?php
                $classes = 'rfa-step rfa-' . $s['side'] . ($i === $rfaLast ? ' rfa-last' : '');
                $txt = '<div class="rfa-txt">' . h($s['lead']) . '<br><b>' . h($s['bold']) . '</b></div>';
                $num = '<div class="rfa-num">' . h($s['n']) . '<div class="rfa-elbow"></div></div>';
                ?>
                <div class="<?= $classes ?>">
                    <?= $s['side'] === 'l' ? $txt . $num : $num . $txt ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if (!$this->request->getSession()->read('Auth.User.id')): ?>
            <a class="rfa-cta" href="<?= build_main_domain_url('/auth/signup') ?>">
                <?= __('Register Now') ?><span>&mdash;</span>
            </a>
        <?php else: ?>
            <a class="rfa-cta" href="<?= build_main_domain_url('/member/dashboard') ?>">
                <?= __('Go To Dashboard') ?><span>&mdash;</span>
            </a>
        <?php endif; ?>

    </div>
</div>
