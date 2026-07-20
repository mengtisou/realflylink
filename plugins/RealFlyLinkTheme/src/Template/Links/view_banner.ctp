<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Link $link
 * @var \App\Model\Entity\Post $post
 * @var mixed $ad_form_data
 * @var string $banner_336x280
 * @var string $banner_468x60
 * @var string $banner_728x90
 * @var mixed $pop_ad
 * @var mixed $show_pop_ad
 * @var \App\Model\Entity\Plan $link_user_plan
 */

$this->assign('title', get_option('site_name'));
$this->assign('description', get_option('description'));
$this->assign('content_title', get_option('site_name'));
$this->assign('og_title', $link->title);
$this->assign('og_description', $link->description);
$this->assign('og_image', $link->image);
$timerSeconds = (int)($link_user_plan->timer ?? 5);
?>

<?php $this->start('scriptTop'); ?>
<script type="text/javascript">
    if (window.self !== window.top) {
        window.top.location.href = window.location.href;
    }
</script>
<?php $this->end(); ?>

<div class="box-main rf-verify-box">
    <?php if (!empty($banner_728x90)) : ?>
        <div class="banner banner-728x90">
            <div class="banner-inner"><?= $banner_728x90; ?></div>
        </div>
    <?php endif; ?>

    <?php if ($post): ?>
        <div class="blog-item">
            <div class="page-header">
                <h3>
                    <small><a href="<?= build_main_domain_url('/blog') ?>"><?= __('From Our Blog') ?>:</a>
                    </small>
                    <a href="<?= build_main_domain_url('/blog/' . $post->id . '-' . $post->slug) ?>" class="rf-blog-post-link">
                        <?= h($post->title) ?>
                    </a>
                </h3>
            </div>
            <div class="blog-content"><?= $post->description ?></div>
        </div>
    <?php endif; ?>

    <h4 class="rf-almost-ready"><?= __('Your link is almost ready.') ?></h4>

    <!-- Aurora SVG arc countdown -->
    <div class="rf-arc-wrap" id="rfArcWrap">
        <svg class="rf-arc-svg" viewBox="0 0 120 120" width="100" height="100">
            <defs>
                <linearGradient id="rfArcGrad" x1="0%" y1="0%" x2="100%" y2="0%">
                    <stop offset="0%"   stop-color="#9054D8"/>
                    <stop offset="50%"  stop-color="#CC30C0"/>
                    <stop offset="100%" stop-color="#E0623C"/>
                </linearGradient>
            </defs>
            <circle class="rf-arc-track" cx="60" cy="60" r="52" />
            <circle class="rf-arc-fill" id="rfArcFill" cx="60" cy="60" r="52"
                stroke-dasharray="326.7"
                stroke-dashoffset="0" />
        </svg>
        <div class="rf-arc-inner">
            <span class="rf-arc-num" id="rfArcNum"><?= $timerSeconds ?></span>
            <span class="rf-arc-label"><?= __('Seconds') ?></span>
        </div>
    </div>

    <!-- Hidden original countdown (required by ads.js) -->
    <span id="countdown" class="countdown" style="display:none!important;visibility:hidden!important;position:absolute!important;">
        <span id="timer" class="timer"><?= $timerSeconds ?></span><br><?= __('Seconds') ?>
    </span>

    <?php if (!empty($banner_468x60)) : ?>
        <div class="banner banner-468x60">
            <div class="banner-inner"><?= $banner_468x60; ?></div>
        </div>
    <?php endif; ?>

    <?php
    $hidden_class = '';
    if (empty($link->image) && empty($link->title) && empty($link->description)) {
        $hidden_class = 'hidden';
    }
    ?>
    <?php if (get_option('short_link_content', 'no') === 'yes') : ?>
        <div class="link-details <?= $hidden_class ?>">
            <div class="panel panel-default">
                <div class="panel-body">
                    <img class="link-image" src="<?= h($link->image) ?>"/>
                    <h4 class="link-title"><?= h($link->title) ?></h4>
                    <p class="link-description"><?= h($link->description) ?></p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div style="margin-bottom:10px;">
        <a href="javascript: void(0)" class="btn btn-success btn-lg get-link disabled" id="rfGetLink">
            <?= __('Please wait...') ?>
        </a>
    </div>

    <?php if (!empty($banner_336x280)) : ?>
        <div class="banner banner-336x280">
            <div class="banner-inner"><?= $banner_336x280; ?></div>
        </div>
    <?php endif; ?>
</div>

<?=
$this->Form->create(null, [
    'url' => ['controller' => 'Links', 'action' => 'go', 'prefix' => false],
    'id' => 'go-link',
    'class' => 'hidden',
]);
?>
<?= $this->Form->hidden('ad_form_data', ['value' => $ad_form_data]); ?>
<?=
$this->Form->button(__('Submit'), [
    'id' => 'go-submit',
    'class' => 'hidden',
]);
?>
<?= $this->Form->end(); ?>

<?php if (get_option('enable_popup', 'yes') == 'yes' && $show_pop_ad) : ?>
    <?=
    $this->Form->create(null, [
        'url' => ['controller' => 'Links', 'action' => 'popad', 'prefix' => false],
        'target' => "_blank",
        'id' => 'go-popup',
        'class' => 'hidden',
    ]);
    ?>
    <?= $this->Form->hidden('pop_ad', ['value' => $pop_ad]); ?>
    <?= $this->Form->end(); ?>
<?php endif; ?>

<?php $this->start('scriptBottom'); ?>
<script>
(function() {
    var total = <?= $timerSeconds ?>;
    var left  = total;
    var fill  = document.getElementById('rfArcFill');
    var num   = document.getElementById('rfArcNum');
    var btn   = document.getElementById('rfGetLink');

    var circumference = 2 * Math.PI * 52;

    function setArc(seconds, instant) {
        var pct    = seconds / total;
        var offset = circumference * (1 - pct);
        if (fill) {
            if (instant) fill.style.transition = 'none';
            fill.style.strokeDasharray  = circumference.toFixed(1);
            fill.style.strokeDashoffset = offset.toFixed(1);
            if (instant) { fill.getBoundingClientRect(); fill.style.transition = ''; }
        }
        if (num) num.textContent = seconds;
    }

    // Mirror the ads.js timer — watch #timer for changes
    var timerEl = document.getElementById('timer');
    if (timerEl && window.MutationObserver) {
        var obs = new MutationObserver(function() {
            var v = parseInt(timerEl.textContent.trim(), 10);
            if (!isNaN(v)) { left = v; setArc(v, false); }
            if (v <= 0 && btn) {
                btn.classList.remove('disabled');
                btn.textContent = '<?= __('Get Link ?') ?>';
            }
        });
        obs.observe(timerEl, { childList: true, characterData: true, subtree: true });
    } else {
        // Fallback: run our own timer
        var iv = setInterval(function() {
            left--;
            setArc(Math.max(0, left), false);
            if (left <= 0) {
                clearInterval(iv);
                if (btn) {
                    btn.classList.remove('disabled');
                    btn.textContent = '<?= __('Get Link ?') ?>';
                }
            }
        }, 1000);
    }

    // Init — set instantly (no transition) so it starts full
    setArc(total, true);
})();
</script>
<?php
$rand = mt_rand(1, 10);
if ($rand <= 5):
?>
<!-- Monetag 50% — highest CPM -->
<script>(function(s){s.dataset.zone='11226349',s.src='https://al5sm.com/tag.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script>
<?php elseif ($rand <= 7): ?>
<!-- Adsterra 20% -->
<script src="https://pl30163555.effectivecpmnetwork.com/4b/91/a5/4b91a5c967c61f1858ecf06edab8adfb.js"></script>
<?php else: ?>
<!-- HilltopAds 30% -->
<script async="async" src="https://villainoussession.com/b/3_Vx0.PK3Wp/v/b/mDV/JZZ_D/0/3GMej/MZ2fMITaAexCLLTWcMyoM_z/YjxJM/DIUl"></script>
<?php endif; ?>
<?php $this->end(); ?>
