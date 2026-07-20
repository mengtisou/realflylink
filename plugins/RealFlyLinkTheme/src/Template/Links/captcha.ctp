<?php
$this->assign('title', get_option('site_name'));
$this->assign('description', get_option('description'));
$this->assign('content_title', get_option('site_name'));
$this->assign('og_title', $link->title);
$this->assign('og_description', $link->description);
$this->assign('og_image', $link->image);
?>

<?php $this->start('scriptTop'); ?>
<script type="text/javascript">
    if (window.self !== window.top) {
        window.top.location.href = window.location.href;
    }
</script>
<?php $this->end(); ?>

<div class="box-main rf-verify-box">

    <?php if (!empty($ad_captcha_above)) : ?>
        <div class="banner banner-captcha rf-verify-ad">
            <div class="banner-inner">
                <?= $ad_captcha_above; ?>
            </div>
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

    <?php
    $show_split = (get_option('short_link_content', 'no') === 'yes')
        && (!empty($link->image) || !empty($link->title) || !empty($link->description));
    $col_num      = $show_split ? 6  : 12;
    $table_row    = $show_split ? 'is-table-row' : '';
    $hidden_class = $show_split ? '' : 'hidden';
    ?>

    <div class="row <?= $table_row ?>">
        <div class="col-md-<?= $col_num ?> <?= $hidden_class ?>">
            <?php if (get_option('short_link_content', 'no') === 'yes') : ?>
                <div class="link-details">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <img class="link-image" src="<?= h($link->image) ?>"/>
                            <h4 class="link-title"><?= h($link->title) ?></h4>
                            <p class="link-description"><?= h($link->description) ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-<?= $col_num ?>">

            <?= $this->Flash->render() ?>

            <div class="rf-verify-card">
                <?= $this->Form->create(null, ['id' => 'link-view']); ?>
                <?= $this->Form->hidden('action', ['value' => 'captcha']); ?>

                <p class="rf-verify-text">
                    <?= __('Please check the captcha box to proceed to the destination page.') ?>
                </p>

                <?= $this->Form->hidden('f_n', ['value' => 'slc']); ?>

                <div class="form-group text-center">
                    <div id="captchaShortlink" style="display: inline-block;"></div>
                </div>

                <?= $this->Form->button(__('Click here to continue'), [
                    'class' => 'btn btn-primary btn-captcha rf-verify-btn',
                    'id'    => 'invisibleCaptchaShortlink',
                ]); ?>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>

    <?php if (!empty($ad_captcha_below)) : ?>
        <div class="banner banner-captcha rf-verify-ad">
            <div class="banner-inner">
                <?= $ad_captcha_below; ?>
            </div>
        </div>
    <?php endif; ?>

</div>

<div class="rf-verify-info rf-trust-section">

    <p class="rf-trust-why"><?= __('WHY THIS EXTRA STEP') ?></p>
    <h3 class="rf-trust-title"><?= __('A protected redirect, not just a link') ?></h3>
    <div class="rf-trust-divider"></div>

    <div class="rf-trust-cards">
        <div class="rf-trust-card">
            <div class="rf-trust-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
            </div>
            <h4><?= __('Bot-protected') ?></h4>
            <p><?= __('Multi-layer verification blocks bots and scrapers.') ?></p>
        </div>
        <div class="rf-trust-card">
            <div class="rf-trust-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94"/><path d="M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
            </div>
            <h4><?= __('Privacy-first') ?></h4>
            <p><?= __('No-referrer policy keeps your destination anonymous.') ?></p>
        </div>
        <div class="rf-trust-card">
            <div class="rf-trust-icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
            </div>
            <h4><?= __('Encrypted') ?></h4>
            <p><?= __('End-to-end SSL across every step of the flow.') ?></p>
        </div>
    </div>

    <div class="rf-trust-stats">
        <div class="rf-trust-stat">
            <strong><?= __('Real publishers') ?></strong>
            <span><?= __('Get paid on time, every time.') ?></span>
        </div>
        <div class="rf-trust-dot">•</div>
        <div class="rf-trust-stat">
            <strong><?= __('Top CPM rates') ?></strong>
            <span><?= __('Among the highest in the industry.') ?></span>
        </div>
        <div class="rf-trust-dot">•</div>
        <div class="rf-trust-stat">
            <strong><?= __('Global reach') ?></strong>
            <span><?= __('Links work in 190+ countries.') ?></span>
        </div>
    </div>

</div>
