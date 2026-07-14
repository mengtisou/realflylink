<?php
/**
 * RealFlyLinkTheme — payment_proof Element
 * Uses the same rf-proof-* classes already styled in realfly-dark.css
 * (loaded sitewide via front_head.ctp) — matches the homepage design exactly.
 *
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Withdraw[]|\Cake\Collection\CollectionInterface $withdraws
 */

$flags = [
    'KH'=>'🇰🇭','US'=>'🇺🇸','GB'=>'🇬🇧','IN'=>'🇮🇳','BD'=>'🇧🇩',
    'PH'=>'🇵🇭','RU'=>'🇷🇺','CA'=>'🇨🇦','AU'=>'🇦🇺','DE'=>'🇩🇪',
    'SA'=>'🇸🇦','PK'=>'🇵🇰','NG'=>'🇳🇬','ID'=>'🇮🇩','MY'=>'🇲🇾',
    'VN'=>'🇻🇳','TH'=>'🇹🇭','EG'=>'🇪🇬','TR'=>'🇹🇷','BR'=>'🇧🇷',
];

$withdrawal_methods = array_column_polyfill(get_withdrawal_methods(), 'name', 'id');

function rf_mask_user($name) {
    $len = mb_strlen($name);
    if ($len <= 3) {
        return mb_substr($name, 0, 1) . '***';
    }
    return mb_substr($name, 0, 3) . '***' . mb_substr($name, -2);
}
?>

<style>
.rf-proof-pager{ display:flex; justify-content:center; margin-top:16px }
.rf-proof-pager ul.pagination{ display:flex !important; gap:5px; list-style:none; padding:0; margin:0; flex-wrap:wrap }
.rf-proof-pager .pagination>li>a,
.rf-proof-pager .pagination>li>span{
    display:flex !important; align-items:center !important; justify-content:center !important;
    min-width:36px; height:36px; padding:0 10px;
    background:var(--card) !important; border:1px solid var(--border) !important;
    border-radius:8px !important; font-size:13px; font-weight:600;
    color:var(--muted) !important; text-decoration:none !important; transition:all .2s;
}
.rf-proof-pager .pagination>li>a:hover{ border-color:var(--cyan) !important; color:var(--cyan) !important }
.rf-proof-pager .pagination>.active>a,
.rf-proof-pager .pagination>.active>span{
    background:var(--grad) !important; border-color:transparent !important; color:#070d14 !important;
}
.rf-proof-pager .pagination>.disabled>span{ opacity:.3; cursor:default }

/* Column width fix for this full-page listing — the shared homepage-preview
   widths (1fr 90px 120px 76px) are too cramped here since Method/Date text
   can be much longer on this page. Scoped to .rf-proof-full only. */
.rf-proof-full .rf-proof-hd,
.rf-proof-full .rf-proof-row{
    grid-template-columns: 1fr 100px 250px 170px !important;
}
@media(max-width:767px){
    .rf-proof-full .rf-proof-hd,
    .rf-proof-full .rf-proof-row{
        grid-template-columns: 1fr 80px 130px !important;
    }
    .rf-proof-full .rf-proof-date{ display:none !important }
}
@media(max-width:479px){
    .rf-proof-full .rf-proof-hd,
    .rf-proof-full .rf-proof-row{
        grid-template-columns: 1fr 90px !important;
    }
    .rf-proof-full .rf-proof-method{ display:none !important }
}
.rf-proof-full .rf-proof-user,
.rf-proof-full .rf-proof-method,
.rf-proof-full .rf-proof-date{
    overflow:hidden; text-overflow:ellipsis; white-space:nowrap;
}
</style>

<div class="rf-proof-tbl rf-proof-full">
    <div class="rf-proof-hd">
        <span><?= __('Publisher') ?></span>
        <span><?= __('Amount') ?></span>
        <span><?= __('Method') ?></span>
        <span><?= __('Date') ?></span>
    </div>

    <?php if (!empty($withdraws) && count($withdraws) > 0) : ?>
        <?php foreach ($withdraws as $i => $w) : ?>
            <?php
            $username = isset($w->user->username) ? $w->user->username : 'user';
            $country  = isset($w->user->country) ? $w->user->country : '';
            $flag     = isset($flags[$country]) ? $flags[$country] : '🌍';
            $masked   = rf_mask_user($username);
            $amount   = '$' . number_format((float)$w->amount, 2);
            $method   = isset($withdrawal_methods[$w->method]) ? $withdrawal_methods[$w->method] : h($w->method);
            $date     = $w->created ? $w->created->format('M d, Y, g:i A') : '';
            ?>
            <div class="rf-proof-row<?= $i === 0 ? ' rf-active' : '' ?>">
                <span class="rf-proof-user"><?= $flag ?> <?= h($masked) ?></span>
                <span class="rf-proof-amount"><?= $amount ?></span>
                <span class="rf-proof-method"><?= h($method) ?></span>
                <span class="rf-proof-date"><?= h($date) ?></span>
            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <div style="padding:48px;text-align:center;color:var(--muted);font-size:14px">
            <?= __('No payments yet — be the first to get paid!') ?><br><br>
            <a href="<?= build_main_domain_url('/register') ?>"
               style="display:inline-block;background:var(--grad);color:#070d14;font-weight:800;padding:11px 28px;border-radius:9px;text-decoration:none;font-size:14px">
                <?= __('Start Earning Free →') ?>
            </a>
        </div>
    <?php endif; ?>
</div>

<div class="rf-proof-pager">
    <?php
    $this->Paginator->setTemplates(['ellipsis' => '<li><a href="javascript:void(0)">...</a></li>']);
    echo '<ul class="pagination">';
    if ($this->Paginator->hasPrev()) {
        echo $this->Paginator->prev('«');
    }
    echo $this->Paginator->numbers(['modulus' => 4, 'first' => 2, 'last' => 2]);
    if ($this->Paginator->hasNext()) {
        echo $this->Paginator->next('»');
    }
    echo '</ul>';
    ?>
</div>

<p class="rf-proof-note">
    <?= __('Usernames partially masked for privacy · All payments are real and verified') ?>
</p>
