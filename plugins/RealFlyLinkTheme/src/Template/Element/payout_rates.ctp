<?php
/**
 * RealFlyLinkTheme — payout_rates Element (styled override)
 * Same data/logic as the core default — only visual layer changed.
 * @var \App\View\AppView $this
 */
$lang = locale_get_default();
$countries = get_countries(true);
?>
<link rel="stylesheet" href="https://fastly.jsdelivr.net/gh/lipis/flag-icon-css@3.3.0/css/flag-icon.min.css"/>

<style>
.rf-rates-wrap{ font-family:inherit }
.rf-rates-wrap .nav-tabs{
    display:flex; gap:8px; border-bottom:1px solid var(--border) !important;
    margin-bottom:0; padding:0 0 12px; list-style:none;
}
.rf-rates-wrap .nav-tabs > li{ float:none; margin:0 }
.rf-rates-wrap .nav-tabs > li > a{
    display:block; padding:10px 20px !important; border-radius:9px !important;
    background:var(--card) !important; border:1px solid var(--border) !important;
    color:var(--muted) !important; font-weight:700; font-size:14px;
    text-decoration:none !important; transition:all .2s;
}
.rf-rates-wrap .nav-tabs > li > a:hover{
    color:var(--cyan) !important; border-color:var(--cyan) !important; background:var(--card) !important;
}
.rf-rates-wrap .nav-tabs > li.active > a{
    background:var(--grad) !important; color:#070d14 !important; border-color:transparent !important;
}

.rf-rates-wrap .tab-content{
    background:var(--card); border:1px solid var(--border); border-radius:14px;
    margin-top:16px; overflow:hidden;
}
.rf-rates-wrap .tab-pane{ display:none }
.rf-rates-wrap .tab-pane.active{ display:block }

.rf-rates-wrap table{
    width:100%; border-collapse:collapse; margin:0 !important; background:transparent !important;
}
.rf-rates-wrap table tr:first-child{
    background:rgba(0,212,255,.08) !important;
}
.rf-rates-wrap table th, .rf-rates-wrap table td{
    padding:14px 18px; border-bottom:1px solid var(--border) !important;
    color:var(--text) !important; font-size:14px; background:transparent !important;
}
.rf-rates-wrap table th{
    color:var(--cyan) !important; font-weight:700; text-transform:uppercase;
    font-size:11px; letter-spacing:.5px;
}
.rf-rates-wrap table tr:nth-child(even):not(:first-child):not(:nth-child(2)){
    background:rgba(255,255,255,.02) !important;
}
.rf-rates-wrap table tr:hover:not(:first-child):not(:nth-child(2)){
    background:rgba(0,212,255,.05) !important;
}
.rf-rates-wrap table tr:last-child td{ border-bottom:none !important }
.rf-rates-wrap .flag-icon{
    margin-right:8px; border-radius:3px; box-shadow:0 0 0 1px rgba(255,255,255,.1);
}
@media(max-width:600px){
    .rf-rates-wrap .nav-tabs{ flex-wrap:wrap }
    .rf-rates-wrap table th, .rf-rates-wrap table td{ padding:10px 12px; font-size:12px }
}
</style>

<div class="rf-rates-wrap">

<?php if (get_option('earning_mode') === 'simple') : ?>
    <div class="payout-rates">
        <ul class="nav nav-tabs" role="tablist">
            <?php if (get_option('enable_banner', 'yes') === 'yes') : ?>
                <li role="presentation" class="active"><a href="#ban-ner-ads" aria-controls="ban-ner-ads" role="tab" data-toggle="tab"><?= __('Banner') ?></a></li>
            <?php endif; ?>
            <?php if (get_option('enable_interstitial', 'yes') === 'yes') : ?>
                <li role="presentation"><a href="#interstitial" aria-controls="interstitial" role="tab" data-toggle="tab"><?= __('Interstitial') ?></a></li>
            <?php endif; ?>
            <?php if (get_option('enable_popup', 'yes') === 'yes') : ?>
                <li role="presentation"><a href="#popup-ads" aria-controls="popup-ads" role="tab" data-toggle="tab"><?= __('Popup') ?></a></li>
            <?php endif; ?>
        </ul>

        <div class="tab-content">
            <?php if (get_option('enable_banner', 'yes') === 'yes') : ?>
                <div role="tabpanel" class="tab-pane active" id="ban-ner-ads">
                    <table>
                        <tr>
                            <th rowspan="2"><?= __('Package Description / Country') ?></th>
                            <th colspan="2"><?= __('Earnings per 1000 Views') ?></th>
                        </tr>
                        <tr>
                            <td style="text-align:center;font-weight:bold"><?= __("Desktop") ?></td>
                            <td style="text-align:center;font-weight:bold"><?= __("Mobile / Tablet") ?></td>
                        </tr>
                        <?php
                        $banner_price = get_option('payout_rates_banner', []);
                        uasort($banner_price, function ($a, $b) {
                            if (!isset($a[3]) || !isset($b[3])) return 0;
                            if ($a[3] === $b[3]) return 0;
                            return ($a[3] < $b[3]) ? 1 : -1;
                        });
                        ?>
                        <?php foreach ($banner_price as $key => $value) : ?>
                            <?php if (empty($value[2]) && empty($value[3])) continue; ?>
                            <tr>
                                <td><span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span> <?= $countries[$key] ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[2]) ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[3]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
            <?php if (get_option('enable_interstitial', 'yes') === 'yes') : ?>
                <div role="tabpanel" class="tab-pane" id="interstitial">
                    <table>
                        <tr>
                            <th rowspan="2"><?= __('Package Description / Country') ?></th>
                            <th colspan="2"><?= __('Earnings per 1000 Views') ?></th>
                        </tr>
                        <tr>
                            <td style="text-align:center;font-weight:bold"><?= __("Desktop") ?></td>
                            <td style="text-align:center;font-weight:bold"><?= __("Mobile / Tablet") ?></td>
                        </tr>
                        <?php
                        $interstitial_price = get_option('payout_rates_interstitial', []);
                        uasort($interstitial_price, function ($a, $b) {
                            if (!isset($a[3]) || !isset($b[3])) return 0;
                            if ($a[3] === $b[3]) return 0;
                            return ($a[3] < $b[3]) ? 1 : -1;
                        });
                        ?>
                        <?php foreach ($interstitial_price as $key => $value) : ?>
                            <?php if (empty($value[2]) && empty($value[3])) continue; ?>
                            <tr>
                                <td><span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span> <?= $countries[$key] ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[2]) ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[3]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
            <?php if (get_option('enable_popup', 'yes') === 'yes') : ?>
                <div role="tabpanel" class="tab-pane" id="popup-ads">
                    <table>
                        <tr>
                            <th rowspan="2"><?= __('Package Description / Country') ?></th>
                            <th colspan="2"><?= __('Earnings per 1000 Views') ?></th>
                        </tr>
                        <tr>
                            <td style="text-align:center;font-weight:bold"><?= __("Desktop") ?></td>
                            <td style="text-align:center;font-weight:bold"><?= __("Mobile / Tablet") ?></td>
                        </tr>
                        <?php
                        $popup_price = get_option('payout_rates_popup', []);
                        uasort($popup_price, function ($a, $b) {
                            if (!isset($a[3]) || !isset($b[3])) return 0;
                            if ($a[3] === $b[3]) return 0;
                            return ($a[3] < $b[3]) ? 1 : -1;
                        });
                        ?>
                        <?php foreach ($popup_price as $key => $value) : ?>
                            <?php if (empty($value[2]) && empty($value[3])) continue; ?>
                            <tr>
                                <td><span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span> <?= $countries[$key] ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[2]) ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[3]) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

<?php if (get_option('earning_mode') === 'campaign') : ?>
    <div class="payout-rates">
        <ul class="nav nav-tabs" role="tablist">
            <?php if (get_option('enable_banner', 'yes') === 'yes') : ?>
                <li role="presentation" class="active"><a href="#ban-ner-ads" aria-controls="ban-ner-ads" role="tab" data-toggle="tab"><?= __('Banner') ?></a></li>
            <?php endif; ?>
            <?php if (get_option('enable_interstitial', 'yes') === 'yes') : ?>
                <li role="presentation"><a href="#interstitial" aria-controls="interstitial" role="tab" data-toggle="tab"><?= __('Interstitial') ?></a></li>
            <?php endif; ?>
            <?php if (get_option('enable_popup', 'yes') === 'yes') : ?>
                <li role="presentation"><a href="#popup-ads" aria-controls="popup-ads" role="tab" data-toggle="tab"><?= __('Popup') ?></a></li>
            <?php endif; ?>
        </ul>

        <div class="tab-content">
            <?php if (get_option('enable_banner', 'yes') === 'yes') : ?>
                <div role="tabpanel" class="tab-pane active" id="ban-ner-ads">
                    <table>
                        <tr>
                            <th rowspan="2"><?= __('Package Description / Country') ?></th>
                            <th colspan="2"><?= __('Earnings per 1000 Views') ?></th>
                        </tr>
                        <tr>
                            <td style="text-align:center;font-weight:bold"><?= __("Desktop") ?></td>
                            <td style="text-align:center;font-weight:bold"><?= __("Mobile / Tablet") ?></td>
                        </tr>
                        <?php
                        $banner_price = get_option('banner_price');
                        uasort($banner_price, function ($a, $b) {
                            if (!isset($a[3]['publisher']) || !isset($b[3]['publisher'])) return 0;
                            if ($a[3]['publisher'] == $b[3]['publisher']) return 0;
                            return ($a[3]['publisher'] < $b[3]['publisher']) ? 1 : -1;
                        });
                        ?>
                        <?php foreach ($banner_price as $key => $value) : ?>
                            <?php if (empty($value[2]['publisher']) && empty($value[3]['publisher'])) continue; ?>
                            <tr>
                                <td><span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span> <?= $countries[$key] ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[2]['publisher']) ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[3]['publisher']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
            <?php if (get_option('enable_interstitial', 'yes') === 'yes') : ?>
                <div role="tabpanel" class="tab-pane" id="interstitial">
                    <table>
                        <tr>
                            <th rowspan="2"><?= __('Package Description / Country') ?></th>
                            <th colspan="2"><?= __('Earnings per 1000 Views') ?></th>
                        </tr>
                        <tr>
                            <td style="text-align:center;font-weight:bold"><?= __("Desktop") ?></td>
                            <td style="text-align:center;font-weight:bold"><?= __("Mobile / Tablet") ?></td>
                        </tr>
                        <?php
                        $interstitial_price = get_option('interstitial_price', []);
                        uasort($interstitial_price, function ($a, $b) {
                            if (!isset($a[3]['publisher']) || !isset($b[3]['publisher'])) return 0;
                            if ($a[3]['publisher'] == $b[3]['publisher']) return 0;
                            return ($a[3]['publisher'] < $b[3]['publisher']) ? 1 : -1;
                        });
                        ?>
                        <?php foreach ($interstitial_price as $key => $value) : ?>
                            <?php if (empty($value[2]['publisher']) && empty($value[3]['publisher'])) continue; ?>
                            <tr>
                                <td><span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span> <?= $countries[$key] ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[2]['publisher']) ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[3]['publisher']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
            <?php if (get_option('enable_popup', 'yes') === 'yes') : ?>
                <div role="tabpanel" class="tab-pane" id="popup-ads">
                    <table>
                        <tr>
                            <th rowspan="2"><?= __('Package Description / Country') ?></th>
                            <th colspan="2"><?= __('Earnings per 1000 Views') ?></th>
                        </tr>
                        <tr>
                            <td style="text-align:center;font-weight:bold"><?= __("Desktop") ?></td>
                            <td style="text-align:center;font-weight:bold"><?= __("Mobile / Tablet") ?></td>
                        </tr>
                        <?php
                        $popup_price = get_option('popup_price');
                        uasort($popup_price, function ($a, $b) {
                            if (!isset($a[3]['publisher']) || !isset($b[3]['publisher'])) return 0;
                            if ($a[3]['publisher'] == $b[3]['publisher']) return 0;
                            return ($a[3]['publisher'] < $b[3]['publisher']) ? 1 : -1;
                        });
                        ?>
                        <?php foreach ($popup_price as $key => $value) : ?>
                            <?php if (empty($value[2]['publisher']) && empty($value[3]['publisher'])) continue; ?>
                            <tr>
                                <td><span class="flag-icon flag-icon-<?= strtolower($key) ?>"></span> <?= $countries[$key] ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[2]['publisher']) ?></td>
                                <td style="text-align:center"><?= display_price_currency($value[3]['publisher']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>

</div>

