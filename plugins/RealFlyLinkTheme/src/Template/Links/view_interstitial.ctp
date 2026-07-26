<?php
$this->assign('title', get_option('site_name'));
$this->assign('description', get_option('description'));
$this->assign('content_title', get_option('site_name'));
$this->assign('og_title', $link->title);
$this->assign('og_description', $link->description);
$this->assign('og_image', $link->image);

// Read timer from DB via user plan — same source as ads.js uses
$timerSeconds = (int)($link_user_plan->timer ?? get_option('timer', 10));
if ($timerSeconds < 1) $timerSeconds = 5;
?>

<?php $this->start('scriptTop'); ?>
<script type="text/javascript">
    if (window.self !== window.top) {
        window.top.location.href = window.location.href;
    }
</script>
<?php $this->end(); ?>

<div class="myTestAd" style="height: 5px; width: 5px; position: absolute;"></div>
<iframe id="frame" src="<?= $interstitial_ad_url ?>" style="width: 100%; border: none;"></iframe>

<?=
$this->Form->create(null, [
    'url' => ['controller' => 'Links', 'action' => 'go', 'prefix' => false],
    'id' => 'go-link',
    'class' => 'hidden',
]);
?>
<?= $this->Form->hidden('ad_form_data', ['value' => $ad_form_data]); ?>
<?=
$this->Form->button(__('Please Wait {0}s', $timerSeconds), [
    'id' => 'go-submit',
    'class' => 'btn btn-default',
    'onclick' => 'javascript: return false;',
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
(function waitForCountdown() {
    var el = document.querySelector('.countdown');
    if (!el) { setTimeout(waitForCountdown, 100); return; }

    // Timer comes from PHP (DB value) — not from DOM parsing
    var total         = <?= $timerSeconds ?>;
    var circumference = 2 * Math.PI * 52;

    // Build aurora arc SVG
    var arc = document.createElement('div');
    arc.className = 'rf-arc-wrap';
    arc.innerHTML =
        '<svg class="rf-arc-svg" viewBox="0 0 120 120" width="100" height="100">' +
            '<defs>' +
                '<linearGradient id="rfArcGrad" x1="0%" y1="0%" x2="100%" y2="0%">' +
                    '<stop offset="0%"   stop-color="#9054D8"/>' +
                    '<stop offset="50%"  stop-color="#CC30C0"/>' +
                    '<stop offset="100%" stop-color="#E0623C"/>' +
                '</linearGradient>' +
            '</defs>' +
            '<circle class="rf-arc-track" cx="60" cy="60" r="52"/>' +
            '<circle class="rf-arc-fill" id="rfArcFill" cx="60" cy="60" r="52"' +
                ' stroke-dasharray="' + circumference.toFixed(1) + '"' +
                ' stroke-dashoffset="0"/>' +
        '</svg>' +
        '<div class="rf-arc-inner">' +
            '<span class="rf-arc-num" id="rfArcNum">' + total + '</span>' +
            '<span class="rf-arc-label"><?= __('Seconds') ?></span>' +
        '</div>';

    // Hide original .countdown, insert arc before it
    el.style.cssText = 'display:none!important;visibility:hidden!important;position:absolute!important;';
    el.parentNode.insertBefore(arc, el);

    var fill   = document.getElementById('rfArcFill');
    var numEl  = document.getElementById('rfArcNum');
    var submit = document.getElementById('go-submit');

    function setArc(seconds, instant) {
        var pct    = Math.max(0, seconds) / total;
        var offset = circumference * (1 - pct);
        if (fill) {
            if (instant) fill.style.transition = 'none';
            fill.style.strokeDasharray  = circumference.toFixed(1);
            fill.style.strokeDashoffset = offset.toFixed(1);
            if (instant) { fill.getBoundingClientRect(); fill.style.transition = ''; }
        }
        if (numEl) numEl.textContent = Math.max(0, seconds);
    }

    // Watch .timer that ads.js updates each second
    var timerEl = el.querySelector('.timer');
    if (timerEl && window.MutationObserver) {
        var obs = new MutationObserver(function() {
            var v = parseInt(timerEl.textContent.trim(), 10);
            if (!isNaN(v)) setArc(v, false);
        });
        obs.observe(timerEl, { childList: true, characterData: true, subtree: true });
    } else {
        // Fallback own timer if MutationObserver unavailable
        var left = total;
        var iv = setInterval(function() {
            left--;
            setArc(left, false);
            if (left <= 0) clearInterval(iv);
        }, 1000);
    }

    // Start at full immediately (no sweep-in animation)
    setArc(total, true);
})();
</script>
<?php
$rand = mt_rand(1, 100);
if ($rand <= 40):
?>
<!-- Monetag 40% -->
<script>(function(s){s.dataset.zone='11226349',s.src='https://al5sm.com/tag.min.js'})([document.documentElement, document.body].filter(Boolean).pop().appendChild(document.createElement('script')))</script>
<?php elseif ($rand <= 80): ?>
<!-- Adsterra 40% -->
<script src="https://pl30163555.effectivecpmnetwork.com/4b/91/a5/4b91a5c967c61f1858ecf06edab8adfb.js"></script>
<?php else: ?>
<!-- PopAds 20% -->
<script type="text/javascript" data-cfasync="false">
/*<![CDATA[/* */
(function(){var k=window,r="b40033850a124820210e81f87b107033",q=[["siteId",737-3-663*785+5833892],["minBid",0],["popundersPerIP","0"],["delayBetween",0],["default",false],["defaultPerDay",0],["topmostLayer","auto"]],i=["d3d3LmJldHRlcmFkc3lzdGVtLmNvbS9vSW1hZ2VyLm1pbi5jc3M=","ZDJrazBvM2ZyN2VkMDEuY2xvdWRmcm9udC5uZXQvUnBMZGwvc2Nsb3VkaW5hcnktanF1ZXJ5Lm1pbi5qcw=="],b=-1,v,n,d=function(){clearTimeout(n);b++;if(i[b]&&!(1810696284000<(new Date).getTime()&&1<b)){v=k.document.createElement("script");v.type="text/javascript";v.async=!0;var a=k.document.getElementsByTagName("script")[0];v.src="https://"+atob(i[b]);v.crossOrigin="anonymous";v.onerror=d;v.onload=function(){clearTimeout(n);k[r.slice(0,16)+r.slice(0,16)]||d()};n=setTimeout(d,5E3);a.parentNode.insertBefore(v,a)}};if(!k[r]){try{Object.freeze(k[r]=q)}catch(e){}d()}})();
/*]]>/* */
</script>
<?php endif; ?>
<?php $this->end(); ?>
