<?php
/**
 * RealFlyLink — payment_proof.ctp
 * Dark themed, overrides all Bootstrap table styles
 */

$flags = [
    'KH'=>'🇰🇭','US'=>'🇺🇸','GB'=>'🇬🇧','IN'=>'🇮🇳','BD'=>'🇧🇩',
    'PH'=>'🇵🇭','RU'=>'🇷🇺','CA'=>'🇨🇦','AU'=>'🇦🇺','DE'=>'🇩🇪',
    'SA'=>'🇸🇦','PK'=>'🇵🇰','NG'=>'🇳🇬','ID'=>'🇮🇩','MY'=>'🇲🇾',
    'VN'=>'🇻🇳','TH'=>'🇹🇭','SG'=>'🇸🇬','BR'=>'🇧🇷','TR'=>'🇹🇷',
];

function rf_mask_name($n){
    $l=mb_strlen($n);
    if($l<=3) return mb_substr($n,0,1).'***';
    return mb_substr($n,0,3).'***'.mb_substr($n,-2);
}

try {
    $conn      = \Cake\ORM\TableRegistry::getTableLocator()->get('Withdraws')->getConnection();
    $thisMonth = date('Y-m-01');
    $r1 = $conn->execute('SELECT COALESCE(SUM(amount),0) AS t FROM withdraws WHERE status=3')->fetch('assoc');
    $r2 = $conn->execute('SELECT COALESCE(SUM(amount),0) AS t FROM withdraws WHERE status=3 AND created>=?',[$thisMonth])->fetch('assoc');
    $r3 = $conn->execute('SELECT COUNT(DISTINCT user_id) AS c FROM withdraws WHERE status=3')->fetch('assoc');
    $r4 = $conn->execute('SELECT COUNT(*) AS c FROM withdraws WHERE status=3')->fetch('assoc');
    $tAll=$r1?(float)$r1['t']:0; $tMon=$r2?(float)$r2['t']:0;
    $tPub=$r3?(int)$r3['c']:0;   $tPay=$r4?(int)$r4['c']:0;
} catch(\Exception $e){ $tAll=$tMon=$tPub=$tPay=0; }
?>

<style>
/* ── PAYMENT PROOF — force dark on everything ─── */
#pf-wrap *{ box-sizing:border-box; font-family:'Inter',-apple-system,sans-serif }

/* Summary cards */
#pf-wrap .pf-cards{
    display:grid;
    grid-template-columns:repeat(4,1fr);
    gap:14px;
    margin-bottom:32px;
}
#pf-wrap .pf-card{
    background:#111e2e !important;
    border:1px solid rgba(0,212,255,.15) !important;
    border-radius:14px;
    padding:22px 16px;
    text-align:center;
}
#pf-wrap .pf-ico{ font-size:28px; margin-bottom:10px; display:block }
#pf-wrap .pf-val{
    font-size:24px; font-weight:900; display:block; margin-bottom:5px;
    background:linear-gradient(135deg,#00D4FF,#00FF88);
    -webkit-background-clip:text; -webkit-text-fill-color:transparent;
    background-clip:text;
}
#pf-wrap .pf-lbl{
    font-size:10px; font-weight:700; color:rgba(255,255,255,.45);
    text-transform:uppercase; letter-spacing:1.5px;
}

/* Table wrapper */
#pf-wrap .pf-tbl{
    background:#111e2e !important;
    border:1px solid rgba(0,212,255,.15) !important;
    border-radius:14px !important;
    overflow:hidden;
    margin-bottom:20px;
}

/* Header row */
#pf-wrap .pf-hd{
    display:grid !important;
    grid-template-columns:1fr 150px 140px 100px;
    padding:12px 20px;
    background:rgba(0,212,255,.08) !important;
    border-bottom:1px solid rgba(0,212,255,.15) !important;
    font-size:10px; font-weight:700;
    color:#00D4FF !important;
    text-transform:uppercase; letter-spacing:1px;
}

/* Data rows */
#pf-wrap .pf-row{
    display:grid !important;
    grid-template-columns:1fr 150px 140px 100px;
    padding:14px 20px;
    border-bottom:1px solid rgba(0,212,255,.07) !important;
    align-items:center;
    background:#111e2e !important;
    transition:background .2s;
}
#pf-wrap .pf-row:last-child{ border-bottom:none !important }
#pf-wrap .pf-row:hover{ background:#162436 !important }
#pf-wrap .pf-row:nth-child(even){ background:#0d1b2a !important }
#pf-wrap .pf-row:nth-child(even):hover{ background:#162436 !important }

/* Cell styles */
#pf-wrap .pf-user{ font-size:14px; color:#fff; font-weight:600 }
#pf-wrap .pf-amt { font-size:15px; font-weight:900; color:#00FF88 }
#pf-wrap .pf-mth { font-size:12px; color:rgba(255,255,255,.5) }
#pf-wrap .pf-dt  { font-size:11px; color:rgba(255,255,255,.4) }

/* Pagination */
#pf-wrap .pf-pager{ display:flex; justify-content:center; margin-top:16px }
#pf-wrap .pf-pager ul.pagination{
    display:flex !important; gap:5px; list-style:none; padding:0; margin:0;
}
#pf-wrap .pf-pager .pagination>li>a,
#pf-wrap .pf-pager .pagination>li>span{
    display:flex !important; align-items:center !important; justify-content:center !important;
    min-width:36px; height:36px; padding:0 10px;
    background:#111e2e !important;
    border:1px solid rgba(0,212,255,.2) !important;
    border-radius:8px !important;
    font-size:13px; font-weight:600;
    color:rgba(255,255,255,.55) !important;
    text-decoration:none !important;
    transition:all .2s;
}
#pf-wrap .pf-pager .pagination>li>a:hover{
    border-color:#00D4FF !important;
    color:#00D4FF !important;
    background:#162436 !important;
}
#pf-wrap .pf-pager .pagination>.active>a,
#pf-wrap .pf-pager .pagination>.active>span{
    background:linear-gradient(135deg,#00D4FF,#00FF88) !important;
    border-color:transparent !important;
    color:#070d14 !important;
}
#pf-wrap .pf-pager .pagination>.disabled>span{
    opacity:.3; cursor:default; background:#111e2e !important;
}

/* Note */
#pf-wrap .pf-note{
    font-size:12px; color:rgba(255,255,255,.35);
    text-align:center; margin-top:12px;
}

/* Mobile */
@media(max-width:767px){
    #pf-wrap .pf-cards{ grid-template-columns:1fr 1fr; gap:10px }
    #pf-wrap .pf-card{ padding:14px 10px }
    #pf-wrap .pf-val{ font-size:18px }
    #pf-wrap .pf-hd,#pf-wrap .pf-row{ grid-template-columns:1fr 90px 95px }
    #pf-wrap .pf-dt{ display:none }
    #pf-wrap .pf-hd{ font-size:9px }
}
@media(max-width:479px){
    #pf-wrap .pf-cards{ grid-template-columns:1fr 1fr }
    #pf-wrap .pf-hd,#pf-wrap .pf-row{ grid-template-columns:1fr 80px }
    #pf-wrap .pf-mth{ display:none }
}
</style>

<div id="pf-wrap">

    <!-- Summary cards -->
    <div class="pf-cards">
        <div class="pf-card">
            <span class="pf-ico">💵</span>
            <span class="pf-val">$<?= number_format($tAll,2) ?></span>
            <span class="pf-lbl"><?= __('Total Paid Out') ?></span>
        </div>
        <div class="pf-card">
            <span class="pf-ico">📅</span>
            <span class="pf-val">$<?= number_format($tMon,2) ?></span>
            <span class="pf-lbl"><?= __('Paid This Month') ?></span>
        </div>
        <div class="pf-card">
            <span class="pf-ico">👥</span>
            <span class="pf-val"><?= number_format($tPub) ?>+</span>
            <span class="pf-lbl"><?= __('Publishers Paid') ?></span>
        </div>
        <div class="pf-card">
            <span class="pf-ico">✅</span>
            <span class="pf-val"><?= number_format($tPay) ?>+</span>
            <span class="pf-lbl"><?= __('Total Payments') ?></span>
        </div>
    </div>

    <!-- Table -->
    <div class="pf-tbl">
        <div class="pf-hd">
            <span><?= __('Publisher') ?></span>
            <span><?= __('Amount') ?></span>
            <span><?= __('Method') ?></span>
            <span><?= __('Date') ?></span>
        </div>

        <?php if (!empty($withdraws) && count($withdraws) > 0): ?>
            <?php foreach ($withdraws as $w): ?>
            <?php
                $uname  = isset($w->user->username) ? $w->user->username : 'user';
                $cntry  = isset($w->user->country)  ? $w->user->country  : '';
                $flag   = isset($flags[$cntry]) ? $flags[$cntry] : '🌍';
                $masked = rf_mask_name($uname);
                $amt    = '$'.number_format((float)$w->amount, 2);
                $mth    = h($w->method);
                $dt     = $w->created ? $w->created->format('M d, Y') : '';
            ?>
            <div class="pf-row">
                <span class="pf-user"><?= $flag ?> <?= h($masked) ?></span>
                <span class="pf-amt"><?= $amt ?></span>
                <span class="pf-mth"><?= $mth ?></span>
                <span class="pf-dt"><?= $dt ?></span>
            </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div style="padding:48px;text-align:center;color:rgba(255,255,255,.4);font-size:14px">
                <?= __('No payments yet — be the first to get paid!') ?><br><br>
                <a href="<?= build_main_domain_url('/register') ?>"
                   style="display:inline-block;background:linear-gradient(135deg,#00D4FF,#00FF88);color:#070d14;font-weight:800;padding:11px 28px;border-radius:9px;text-decoration:none;font-size:14px">
                    <?= __('Start Earning Free →') ?>
                </a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <div class="pf-pager">
        <?php
        $this->Paginator->setTemplates(['ellipsis'=>'<li><a href="javascript:void(0)">...</a></li>']);
        echo '<ul class="pagination">';
        if($this->Paginator->hasPrev()) echo $this->Paginator->prev('«');
        echo $this->Paginator->numbers(['modulus'=>4,'first'=>2,'last'=>2]);
        if($this->Paginator->hasNext()) echo $this->Paginator->next('»');
        echo '</ul>';
        ?>
    </div>

    <p class="pf-note">
        <?= __('Usernames partially masked for privacy · All payments are real and verified') ?>
    </p>

</div>
