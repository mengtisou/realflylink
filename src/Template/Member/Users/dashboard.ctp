<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $logged_user
 * @var \App\Model\Entity\Plan $logged_user_plan
 * @var \App\Model\Entity\Link $link
 * @var \App\Model\Entity\Announcement[]|\Cake\Collection\CollectionInterface $announcements
 * @var mixed $CurrentMonthDays
 * @var mixed $referral_earnings
 * @var mixed $total_earnings
 * @var mixed $total_views
 * @var mixed $year_month
 * @var mixed $popularLinks
 * @var mixed $topCountries
 * @var mixed $topSources
 */

function rf_flag_icon($code)
{
    $code = strtolower(trim((string)$code));
    if (strlen($code) !== 2 || !ctype_alpha($code)) {
        return '<i class="fa fa-globe" style="margin-right:4px;color:#9054D8;"></i>';
    }
    return '<span class="flag-icon flag-icon-' . h($code) . '" style="margin-right:6px;border-radius:2px;width:16px;height:12px;display:inline-block;vertical-align:middle;"></span>';
}

$maxCountryViews = 1;
foreach ($topCountries as $c) {
    if ($c->views > $maxCountryViews) {
        $maxCountryViews = $c->views;
    }
}
$maxSourceViews = 1;
foreach ($topSources as $s) {
    if ($s->views > $maxSourceViews) {
        $maxSourceViews = $s->views;
    }
}
?>
<?php
$this->assign('title', __('Dashboard'));
$this->assign('description', '');
$this->assign('content_title', __('Dashboard'));
?>

<style>
    .rf-dash { color: #1a1226; }
    .rf-dash .box, .rf-dash .small-box {
        background: #ffffff;
        border: 1px solid #e8e2f5;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(123,60,190,.06);
    }
    .rf-dash .box-header { border-bottom: 1px solid #e8e2f5; }
    .rf-dash .box-title, .rf-dash .box-header i { color: #1a1226; }
    .rf-dash .table { color: #3a3145; }
    .rf-dash .table > thead > tr > th {
        color: rgba(26,18,38,.45);
        border-bottom: 1px solid #e8e2f5;
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .5px;
        font-weight: 700;
    }
    .rf-dash .table > tbody > tr > td { border-top: 1px solid #f0ecf8; }
    .rf-dash .table-hover > tbody > tr:hover { background: #faf8fd; }
    .rf-dash .table-striped > tbody > tr:nth-of-type(odd) { background: #fbf9fe; }
    .rf-dash a { color: #9054D8; }
    .rf-dash a:hover { color: #CC30C0; }

    .rf-stat-card {
        border-radius: 14px;
        padding: 20px 22px;
        background: #ffffff;
        border: 1px solid #e8e2f5;
        box-shadow: 0 2px 10px rgba(123,60,190,.06);
        margin-bottom: 20px;
    }
    .rf-stat-head {
        display: flex; align-items: center; gap: 8px;
        margin-bottom: 12px;
        color: rgba(26,18,38,.45);
        font-size: 11px; text-transform: uppercase; letter-spacing: .5px; font-weight: 700;
    }
    .rf-stat-head i { font-size: 13px; }
    .rf-stat-num { font-size: 26px; font-weight: 800; color: #1a1226; line-height: 1.2; }
    .rf-stat-num.rf-money { color: #16a34a; }
    .rf-stat-num.rf-money-alt { color: #0891b2; }

    .rf-month-select select {
        background: #ffffff !important;
        color: #1a1226 !important;
        border: 1px solid #e0d8f0 !important;
        border-radius: 24px !important;
        padding: 10px 20px !important;
        font-weight: 600;
    }

    .rf-sidebar-item {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid #f0ecf8;
    }
    .rf-sidebar-item:last-child { border-bottom: none; }
    .rf-sidebar-rank {
        width: 22px; height: 22px; border-radius: 6px;
        background: rgba(144,84,216,.12);
        color: #9054D8;
        font-size: 11px; font-weight: 700;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .rf-sidebar-body { flex: 1; min-width: 0; }
    .rf-sidebar-top-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 4px; }
    .rf-sidebar-name { font-size: 13px; font-weight: 600; color: #1a1226; overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 140px; }
    .rf-sidebar-earn { font-size: 12px; font-weight: 700; color: #CC30C0; white-space: nowrap; }
    .rf-sidebar-bar-track { height: 5px; border-radius: 3px; background: #f0ecf8; overflow: hidden; }
    .rf-sidebar-bar-fill { height: 100%; border-radius: 3px; background: linear-gradient(90deg, #9054D8, #CC30C0); }
    .rf-sidebar-views { font-size: 11px; color: rgba(26,18,38,.4); margin-top: 3px; }

    .rf-announce .item { border-bottom: 1px solid #f0ecf8; padding: 10px 0; }
    .rf-announce .item:last-child { border-bottom: none; }

    #chart_div { background: transparent; }
</style>

<div class="rf-dash">

    <div class="text-center">
        <div class="rf-month-select" style="display: inline-block;">
            <?=
                $this->Form->create(null, [
                    'type' => 'get',
                    'url' => ['controller' => 'Users', 'action' => 'dashboard'],
                ]);
            ?>

            <?=
                $this->Form->control('month', [
                    'label' => false,
                    'options' => $year_month,
                    'value' => ($this->request->getQuery('month')) ? h($this->request->getQuery('month')) : '',
                    'class' => 'form-control input-lg',
                    'onchange' => 'this.form.submit();',
                    'style' => 'width: 300px;',
                ]);
            ?>

            <?= $this->Form->button(__('Submit'), ['class' => 'hidden']); ?>

            <?= $this->Form->end(); ?>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <div class="rf-stat-card">
                <div class="rf-stat-head"><i class="fa fa-bar-chart"></i> <?= __('Total Views') ?></div>
                <div class="rf-stat-num"><?= $total_views ?></div>
            </div>
        </div>

        <div class="col-lg-3 col-xs-6">
            <div class="rf-stat-card">
                <div class="rf-stat-head"><i class="fa fa-shopping-bag"></i> <?= __('Total Earnings') ?></div>
                <div class="rf-stat-num rf-money"><?= display_price_currency($total_earnings); ?></div>
            </div>
        </div>

        <?php if ((bool) get_option('enable_referrals', 1)): ?>
            <div class="col-lg-3 col-xs-6">
                <div class="rf-stat-card">
                    <div class="rf-stat-head"><i class="fa fa-exchange"></i> <?= __('Referral Earnings') ?></div>
                    <div class="rf-stat-num rf-money-alt"><?= display_price_currency($referral_earnings); ?></div>
                </div>
            </div>
        <?php endif; ?>

        <div class="col-lg-3 col-xs-6">
            <div class="rf-stat-card">
                <div class="rf-stat-head"><i class="fa fa-usd"></i> <?= __('Average CPM') ?></div>
                <div class="rf-stat-num">
                    <?= (!empty($total_views)) ? display_price_currency($total_earnings / $total_views * 1000) : 0 ?>
                </div>
            </div>
        </div>
    </div>

    <?php if (count($announcements) > 0): ?>
        <div class="box box-primary">
            <div class="box-header with-border">
                <i class="fa fa-bullhorn"></i>
                <h3 class="box-title"><?= __("Announcements") ?></h3>
            </div>
            <div class="box-body chat rf-announce">
                <?php foreach ($announcements as $announcement): ?>
                    <div class="item">
                        <p class="announcement">
                            <span>
                                <small class="text-muted pull-right"><i class="fa fa-clock-o"></i>
                                    <?= h($announcement->created); ?></small>
                                <i class="fa fa-angle-double-right"></i> <b><?= h($announcement->title); ?></b>
                            </span>
                            <?= $announcement->content; ?>
                        </p>
                    </div>
                <?php endforeach; ?>
                <?php unset($announcement) ?>
            </div>
        </div>
    <?php endif; ?>

    <div class="row">
        <div class="col-md-8">

            <div class="box box-primary">
                <div class="box-header with-border">
                    <i class="fa fa-bar-chart"></i>
                    <h3 class="box-title"><?= __('Statistics') ?></h3>
                </div>
                <div class="box-body no-padding">
                    <div id="chart_div" style="position: relative; height: 300px; width: 100%;"></div>
                    <div class="small text-right" style="padding-right: 10px; color: rgba(255,255,255,.4);">
                        <?= __('Data is reported in {0} timezone', get_option('timezone', 'UTC')) ?>
                    </div>
                    <div style="height: 300px;overflow: auto;">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th><?= __('Date') ?></th>
                                    <th><?= __('Views') ?></th>
                                    <th><?= __('Link Earnings') ?></th>
                                    <th><?= __('Daily CPM') ?></th>
                                    <th><?= __('Referral Earnings') ?></th>
                                </tr>
                            </thead>
                            <?php foreach ($CurrentMonthDays as $key => $value): ?>
                                <tr>
                                    <td><?= $key ?></td>
                                    <td><?= $value['view'] ?></td>
                                    <td><?= display_price_currency($value['publisher_earnings']); ?></td>
                                    <td>
                                        <?= (!empty($value['view'])) ? display_price_currency(($value['publisher_earnings'] / $value['view']) * 1000) : 0 ?>
                                    </td>
                                    <td><?= display_price_currency($value['referral_earnings']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>
            </div>

            <div class="box box-success">
                <div class="box-header with-border">
                    <i class="fa fa-fire"></i>
                    <h3 class="box-title"><?= __("Top 10 Links") ?></h3>
                </div>
                <div class="box-body">
                    <table class="table table-hover table-striped">
                        <thead>
                            <tr>
                                <th><?= __('Alias') ?></th>
                                <th><?= __('Views') ?></th>
                                <th><?= __('Link Earnings') ?></th>
                            </tr>
                        </thead>
                        <?php foreach ($popularLinks as $link): ?>
                            <?php
                            if (!$link->views) {
                                continue;
                            }
                            ?>
                            <?php
                            $short_url = get_short_url($link->link->alias, $link->link->domain);

                            $title = $link->link->alias;
                            if (!empty($link->link->title)) {
                                $title = $link->link->title;
                            }
                            ?>
                            <tr>
                                <td><a href="<?= $short_url ?>" target="_blank" rel="nofollow noopener noreferrer">
                                        <span class="glyphicon glyphicon-link"></span> <?= h($title) ?></a></td>
                                <td><?= $link->views ?></td>
                                <td><?= display_price_currency($link->publisher_earnings); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php unset($link) ?>
                    </table>
                </div>
            </div>

        </div>

        <div class="col-md-4">

            <div class="box box-info">
                <div class="box-header with-border">
                    <i class="fa fa-globe"></i>
                    <h3 class="box-title"><?= __("Top Countries") ?></h3>
                </div>
                <div class="box-body">
                    <?php $rank = 1; ?>
                    <?php foreach ($topCountries as $row): ?>
                        <?php if (!$row->views)
                            continue; ?>
                        <div class="rf-sidebar-item">
                            <div class="rf-sidebar-rank"><?= $rank++ ?></div>
                            <div class="rf-sidebar-body">
                                <div class="rf-sidebar-top-row">
                                    <span class="rf-sidebar-name">
                                        <?= rf_flag_icon($row->country) ?>
                                        <?= h(get_countries()[$row->country] ?? $row->country) ?>
                                    </span>
                                    <span
                                        class="rf-sidebar-earn"><?= display_price_currency($row->publisher_earnings); ?></span>
                                </div>
                                <div class="rf-sidebar-bar-track">
                                    <div class="rf-sidebar-bar-fill"
                                        style="width: <?= round(($row->views / $maxCountryViews) * 100) ?>%;"></div>
                                </div>
                                <div class="rf-sidebar-views"><?= number_format($row->views) ?>     <?= __('views') ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php unset($row) ?>
                    <?php if ($rank === 1): ?>
                        <p class="text-muted" style="margin:0;"><?= __('No data yet for this month.') ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <div class="box box-warning">
                <div class="box-header with-border">
                    <i class="fa fa-external-link"></i>
                    <h3 class="box-title"><?= __("Top Sources") ?></h3>
                </div>
                <div class="box-body">
                    <?php $rank = 1; ?>
                    <?php foreach ($topSources as $row): ?>
                        <?php if (!$row->views)
                            continue; ?>
                        <div class="rf-sidebar-item">
                            <div class="rf-sidebar-rank"><?= $rank++ ?></div>
                            <div class="rf-sidebar-body">
                                <div class="rf-sidebar-top-row">
                                    <span class="rf-sidebar-name"><?= h($row->referer_domain ?: __('Direct')) ?></span>
                                    <span
                                        class="rf-sidebar-earn"><?= display_price_currency($row->publisher_earnings); ?></span>
                                </div>
                                <div class="rf-sidebar-bar-track">
                                    <div class="rf-sidebar-bar-fill"
                                        style="width: <?= round(($row->views / $maxSourceViews) * 100) ?>%;"></div>
                                </div>
                                <div class="rf-sidebar-views"><?= number_format($row->views) ?>     <?= __('views') ?></div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    <?php unset($row) ?>
                    <?php if ($rank === 1): ?>
                        <p class="text-muted" style="margin:0;"><?= __('No data yet for this month.') ?></p>
                    <?php endif; ?>
                </div>
            </div>

        </div>
    </div>

</div>

<?php $this->start('scriptBottom'); ?>

<link rel="stylesheet" href="https://fastly.jsdelivr.net/gh/lipis/flag-icon-css@3.3.0/css/flag-icon.min.css">
<link rel="stylesheet" href="https://fastly.jsdelivr.net/gh/almasaeed2010/AdminLTE@v2.3.11/plugins/morris/morris.css">
<script src="https://fastly.jsdelivr.net/gh/DmitryBaranovskiy/raphael@v2.1.0/raphael-min.js"></script>
<script src="https://fastly.jsdelivr.net/gh/almasaeed2010/AdminLTE@v2.3.11/plugins/morris/morris.min.js"
    type="text/javascript"></script>

<script>
    jQuery(document).ready(function () {
        new Morris.Line({
            element: 'chart_div',
            resize: true,
            data: [
                <?php
                foreach ($CurrentMonthDays as $key => $value) {
                    echo '{date: "' . $key . '", views: ' . $value['view'] . '},';
                }
                ?>
            ],
            xkey: 'date',
            xLabels: 'day',
            ykeys: ['views'],
            labels: ['<?= __('Views') ?>'],
            lineColors: ['#E04898'],
            gridLineColor: 'rgba(255,255,255,.08)',
            gridTextColor: 'rgba(255,255,255,.4)',
            lineWidth: 2,
            pointSize: 3,
            hideHover: 'auto',
            smooth: true,
        });
    });
</script>

<?php $this->end(); ?>