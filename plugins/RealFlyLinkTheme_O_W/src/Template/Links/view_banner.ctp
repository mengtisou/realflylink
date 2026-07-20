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
?>

<?php $this->start('scriptTop'); ?>
<script type="text/javascript">
    if (window.self !== window.top) {
        window.top.location.href = window.location.href;
    }
</script>
<?php $this->end(); ?>

<div class="box-main">
    <?php if (!empty($banner_728x90)) : ?>
        <div class="banner banner-728x90">
            <div class="banner-inner">
                <?= $banner_728x90; ?>
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

    <h4><?= __('Your link is almost ready.') ?></h4>

    <span id="countdown" class="countdown">
        <span id="timer" class="timer">
            <?= $link_user_plan->timer ?? 5 ?>
        </span><br><?= __('Seconds') ?>
    </span>

    <?php if (!empty($banner_468x60)) : ?>
        <div class="banner banner-468x60">
            <div class="banner-inner">
                <?= $banner_468x60; ?>
            </div>
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

    <div style="margin-bottom: 10px;">
        <a href="javascript: void(0)" class="btn btn-success btn-lg get-link disabled">
            <?= __('Please wait...') ?>
        </a>
    </div>

    <?php if (!empty($banner_336x280)) : ?>
        <div class="banner banner-336x280">
            <div class="banner-inner">
                <?= $banner_336x280; ?>
            </div>
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
