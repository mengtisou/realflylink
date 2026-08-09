<?php
/**
 * RealFlyLink — How To Download guide ("Signal Rail")
 *
 * Rendered by Pages/view.ctp when the page slug is 'how-to-download'.
 * Styles: .rfd-* in webroot/build/css/{realfly-dark,styles.min}.css
 *
 * ------------------------------------------------------------------
 * SCREENSHOTS ARE DYNAMIC. Each step reads an Option:
 *   howto_img_1   howto_img_2   howto_img_3   howto_img_4
 * Set them in admin Settings, or directly in the options table.
 * Empty option -> the 'img' fallback below -> dashed placeholder.
 *
 * You can paste a Google Drive SHARE link and rfd_img_url() converts
 * it to the lh3.googleusercontent.com CDN form automatically.
 * NOTE: drive.google.com/uc?export=view is throttled for hotlinking and
 * often serves nothing, which is why the CDN host is used instead.
 * Self-hosting under webroot/img is still the most reliable option.
 * Normal https URLs pass through untouched.
 * ------------------------------------------------------------------
 */

if (!function_exists('rfd_img_url')) {
    /**
     * Normalise an image URL so it renders inside an <img> tag.
     * Google Drive share links are rewritten to the direct-view form.
     */
    function rfd_img_url($url) {
        $url = trim((string)$url);
        if ($url === '') { return ''; }
        if (stripos($url, 'drive.google.com') === false) { return $url; }
        $id = '';
        if (preg_match('~/file/d/([a-zA-Z0-9_-]{10,})~', $url, $m)) {
            $id = $m[1];
        } elseif (preg_match('~[?&]id=([a-zA-Z0-9_-]{10,})~', $url, $m)) {
            $id = $m[1];
        } elseif (preg_match('~/d/([a-zA-Z0-9_-]{10,})~', $url, $m)) {
            $id = $m[1];
        }
        // lh3.googleusercontent.com is served from Google's image CDN and is
        // not rate-limited for hotlinking the way drive.google.com/uc is.
        // Appending =w1600 caps the delivered width; drop it for full size.
        return $id ? 'https://lh3.googleusercontent.com/d/' . $id . '=w1600' : $url;
    }
}

$rfdSteps = [
    [
        'n'    => '01',
        'lab'  => __('On the post'),
        'h'    => __('Press the download button'),
        'p'    => __('Scroll to the download section of the post and tap the button. A new page opens.'),
        'img'  => '',
    ],
    [
        'n'    => '02',
        'lab'  => __('Countdown'),
        'h'    => __('Wait for the timer, then continue'),
        'p'    => __('A countdown runs at the top of the page. When it reaches zero the button becomes active. Press it. You will do this a couple of times.'),
        'img'  => '',
    ],
    [
        'n'    => '03',
        'lab'  => __('Verification'),
        'h'    => __('Tick the verification box'),
        'p'    => __('Check the box confirming you are human and wait for the green tick. This keeps the files free for everyone.'),
        'img'  => '',
    ],
    [
        'n'    => '04',
        'lab'  => __('Unlocked'),
        'h'    => __('Get your link and save the file'),
        'p'    => __('The real download link is now open. Press it and your file starts downloading.'),
        'img'  => '',
        'done' => true,
    ],
];

$rfdFaq = [
    [__('The button never becomes active.'),
     __('Refresh the page and let the countdown finish without switching to another tab.')],
    [__('The verification box keeps reloading.'),
     __('Turn off any VPN or proxy, then try again in a normal (non-private) browser window.')],
    [__('The download did not start.'),
     __('Press the button a second time. On Android, check your Downloads folder before retrying.')],
    [__('The file is a RAR or ZIP.'),
     __('Extract it first with WinRAR on PC or ZArchiver on Android, then follow the install steps in the post.')],
];

// Site-wide how-to video, if one is set in Settings → Blog
$rfdVideo = '';
if (function_exists('get_option')) {
    $rfdRaw = get_option('blog_howto_video_url');
    if (!empty($rfdRaw)) {
        $rfdVideo = function_exists('extract_video_embed_url')
            ? extract_video_embed_url($rfdRaw)
            : $rfdRaw;
    }
}
?>
<div class="rfd-sec">
    <div class="rfd-wrap">

        <div class="rfd-badge">&#9201; <?= __('Takes about') ?> <b><?= __('20 seconds') ?></b></div>
        <p class="rfd-intro">
            <?= __('Every download here is protected by a short verification step. Follow the four steps below and your file will start downloading.') ?>
        </p>

        <div class="rfd-rail">
            <?php foreach ($rfdSteps as $i => $s): ?>
                <?php
                // Option wins, then the hard-coded fallback, then a placeholder.
                $opt = function_exists('get_option') ? get_option('howto_img_' . ($i + 1)) : '';
                $src = rfd_img_url(!empty($opt) ? $opt : (isset($s['img']) ? $s['img'] : ''));
                ?>
                <div class="rfd-step<?= !empty($s['done']) ? ' rfd-done' : '' ?>">
                    <div class="rfd-node"><?= h($s['n']) ?></div>
                    <p class="rfd-lab"><?= h($s['lab']) ?></p>
                    <h3 class="rfd-h"><?= h($s['h']) ?></h3>
                    <p class="rfd-p"><?= h($s['p']) ?></p>
                    <?php if ($src): ?>
                        <a class="rfd-frame" href="<?= h($src) ?>" target="_blank" rel="noopener">
                            <span class="rfd-bar"><i></i><i></i><i></i><span>realflylink.com</span></span>
                            <img class="rfd-shot" src="<?= h($src) ?>"
                                 alt="<?= h($s['h']) ?>" loading="lazy">
                        </a>
                    <?php else: ?>
                        <div class="rfd-frame">
                            <span class="rfd-bar"><i></i><i></i><i></i><span>realflylink.com</span></span>
                            <div class="rfd-ph"><?= __('Screenshot') ?> <?= h($s['n']) ?></div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

        <?php if ($rfdVideo): ?>
            <h3 class="rfd-sub"><?= __('Watch it instead') ?></h3>
            <div class="rfd-video">
                <iframe src="<?= h($rfdVideo) ?>" title="<?= __('How to download') ?>"
                        allowfullscreen loading="lazy"></iframe>
            </div>
        <?php endif; ?>

        <h3 class="rfd-sub"><?= __('If something goes wrong') ?></h3>
        <div class="rfd-faq">
            <?php foreach ($rfdFaq as $q): ?>
                <p><b><?= h($q[0]) ?></b><?= h($q[1]) ?></p>
            <?php endforeach; ?>
        </div>

    </div>
</div>
