<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Plan $plan
 *
 * Styles: .rfs-* in webroot/css/app.css and webroot/build/css/dashboard.min.css
 *
 * NOTE: the form id (#shorten), the .btn-submit class on the button and the
 * .add-link-result container are all kept exactly as they were — the AJAX
 * handler binds to them. Only the markup around them has changed.
 */

// Are there any optional fields to show under "More options"?
$hasAlias      = (bool)$plan->alias;
$hasDomains    = (bool)$plan->multi_domains && count(get_multi_domains_list());
$hasExpiration = (bool)$plan->link_expiration;
$adsOptions    = get_allowed_ads();
/**
 * Advertising type is fixed: shown to the user, but read-only.
 *
 * Banner is preferred. We find it by matching the option LABEL rather than
 * assuming a key, because the numeric ids differ between installs — here
 * key 1 is Interstitial, so hard-coding a number would silently pick wrong.
 * Falls back to member_default_advert, then to the first available option.
 */
$forcedAd = null;
foreach ($adsOptions as $adKey => $adLabel) {
    if (stripos((string)$adLabel, 'banner') !== false) {
        $forcedAd = $adKey;
        break;
    }
}
if ($forcedAd === null) {
    $forcedAd = get_option('member_default_advert', 1);
}
if (!array_key_exists($forcedAd, $adsOptions)) {
    $forcedAd = array_key_first($adsOptions);
}
$forcedAdLabel = isset($adsOptions[$forcedAd]) ? $adsOptions[$forcedAd] : '';

// the ad type field is always shown, so there is always something to expand
$hasAdvanced   = true;
?>
<?=
$this->Form->create(null, [
    'url' => ['controller' => 'Links', 'action' => 'shorten', 'prefix' => false],
    'id' => 'shorten',
]);
?>

<?php
$this->Form->setTemplates([
    'inputContainer' => '{{content}}',
    'error' => '{{content}}',
    'inputContainerError' => '{{content}}',
]);
?>

<div class="rfs-card">

    <div class="rfs-title"><i class="fa fa-paper-plane"></i><?= __('Shorten a new link') ?></div>

    <div class="input-group rfs-group">
        <?=
        $this->Form->control('url', [
            'label' => false,
            'type' => 'text',
            'placeholder' => __('Paste your long URL here'),
            'required' => 'required',
            'class' => 'form-control rfs-url',
            'autocomplete' => 'off',
            'spellcheck' => 'false',
        ]);
        ?>
        <span class="input-group-btn">
            <?= $this->Form->button(__('Shorten'), [
                'class' => 'btn btn-submit rfs-go',
            ]); ?>
        </span>
    </div>

    <?php if ($hasAdvanced) : ?>
        <button type="button" class="rfs-more" data-toggle="collapse" data-target="#rfsAdvanced"
                aria-expanded="false" aria-controls="rfsAdvanced">
            <?= __('More options') ?><i class="fa fa-chevron-down"></i>
        </button>

        <div class="collapse rfs-adv" id="rfsAdvanced">
            <div class="row">

                <?php if ($hasAlias) : ?>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <?=
                            $this->Form->control('alias', [
                                'label' => __('Alias'),
                                'type' => 'text',
                                'placeholder' => __('Custom alias'),
                                'class' => 'form-control input-sm',
                            ]);
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($hasDomains) : ?>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <?=
                            $this->Form->control('domain', [
                                'label' => __('Domain'),
                                'options' => get_multi_domains_list(),
                                'default' => '',
                                'empty' => get_default_short_domain(),
                                'class' => 'form-control input-sm',
                            ]);
                            ?>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ($hasExpiration) : ?>
                    <div class="col-sm-3 link-expiration">
                        <div class="form-group">
                            <div class="rfs-date">
                            <?=
                            $this->Form->control('expiration', [
                                'label' => __('Expiration date'),
                                'class' => 'form-control input-sm',
                                'type' => 'datetime',
                                'default' => null,
                                'empty' => true,
                                'value' => null,
                                'minYear' => date('Y'),
                                'maxYear' => date('Y') + 10,
                                'orderYear' => 'asc',
                            ]);
                            ?>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="col-sm-3">
                    <div class="form-group">
                        <label><?= __('Advertising Type') ?></label>
                        <div class="rfs-locked">
                            <input type="text" class="form-control input-sm"
                                   value="<?= h($forcedAdLabel) ?>" readonly disabled
                                   tabindex="-1" aria-readonly="true">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    <?php endif; ?>

    <?= $this->Form->hidden('ad_type', ['value' => $forcedAd]); ?>

</div>

<?= $this->Form->end(); ?>

<div class="shorten add-link-result"></div>
