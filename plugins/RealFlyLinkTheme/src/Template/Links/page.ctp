<?php
/**
 * @var \App\View\AppView $this
 */
?>
<?php
$this->assign('title', get_option('site_name'));
$this->assign('description', get_option('description'));
$this->assign('content_title', get_option('site_name'));
$this->assign('og_title', $link->title);
$this->assign('og_description', $link->description);
$this->assign('og_image', $link->image);

// All logic hoisted to top — no mid-HTML PHP blocks
$totalPages   = (int)get_option('continue_pages_number', 3);
$currentPage  = (int)$page;

$show_split   = (get_option('short_link_content', 'no') === 'yes')
                && (!empty($link->image) || !empty($link->title) || !empty($link->description));
$col_num      = $show_split ? 6  : 12;
$table_row    = $show_split ? 'is-table-row' : '';
$hidden_class = $show_split ? '' : 'hidden';
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
                    </small> <?= h($post->title) ?></h3>
            </div>
            <div class="blog-content"><?= $post->description ?></div>
        </div>
    <?php endif; ?>

    <!-- Progress indicator -->
    <div style="text-align:center; margin: 14px auto 18px; max-width:340px;">
        <div style="font-size:13px; color:rgba(255,255,255,0.5); margin-bottom:8px; letter-spacing:1px; text-transform:uppercase;">
            <?= __('Step {0} of {1}', $currentPage, $totalPages) ?>
        </div>
        <div style="display:flex; gap:6px; justify-content:center; align-items:center;">
            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                <div style="
                    height:6px;
                    border-radius:3px;
                    flex:1;
                    max-width:80px;
                    background: <?= $i <= $currentPage ? 'linear-gradient(90deg,#9054D8,#CC30C0)' : 'rgba(255,255,255,0.15)' ?>;
                    transition: background 0.3s;
                "></div>
            <?php endfor; ?>
        </div>
    </div>

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

            <?= $this->Form->create(null, ['id' => 'form-continue']); ?>
            <?= $this->Form->hidden('action', ['value' => 'continue']); ?>
            <?= $this->Form->hidden('page', ['value' => $page + 1]); ?>
            <?= $this->Form->button(
                $page >= $totalPages
                    ? __('Continue to Verification →')
                    : __('Click here to continue ({0}/{1}) →', $page, $totalPages),
                ['class' => 'btn btn-primary btn-captcha rf-verify-btn']
            ); ?>
            <?= $this->Form->end() ?>
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

<div class="text-left rf-verify-info">

    <h3><?= __('What is {0}?', h(get_option('site_name'))) ?></h3>
    <p><?= __(
            '{0} is a completely free tool where you can create short links, which apart from being free, ' .
            'you get paid! So, now you can make money from home, when managing and protecting your links. ' .
            'Register now!',
            h(get_option('site_name'))
        ) ?></p>

    <h3><?= __('Shorten URLs and earn money') ?></h3>
    <p><?= __("Signup for an account in just 2 minutes. Once you've completed your registration just start " .
            "creating short URLs and sharing the links with your family and friends.") ?></p>

</div>
