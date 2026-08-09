<?php
/**
 * Account activation email.
 *
 * @var \App\View\AppView $this
 * @var string $activation_key
 * @var string $username
 *
 * Email-HTML rules apply here, not web rules: tables for layout, inline
 * styles only, no flexbox/grid, no CSS variables, no <style> block.
 * Outlook and Gmail strip those. The wrapping <html>/<body> comes from
 * Layout/Email/html/default.ctp, so this file emits body content only.
 */

$siteName = get_option('site_name');
$baseUrl  = $this->Url->build('/', true);

/**
 * Two-tone wordmark: "RealFly" dark + "Link" violet + ".com" magenta.
 * Splits site_name at the last occurrence of "link" so it keeps working
 * if the site is renamed; falls back to the plain name if there is none.
 * The TLD is read from the site URL rather than hard-coded.
 */
$logoHead = $siteName;
$logoTail = '';
$pos = strripos($siteName, 'link');
if ($pos !== false) {
    $logoHead = substr($siteName, 0, $pos);
    $logoTail = substr($siteName, $pos);
}
$host = parse_url($baseUrl, PHP_URL_HOST);
$tld  = ($host && strpos($host, '.') !== false) ? substr($host, strrpos($host, '.')) : '';
$link     = $baseUrl . 'auth/users/activate-account/' . rawurlencode($username) . '/' . rawurlencode($activation_key);
?>
<!-- preheader: shown as the preview line in the inbox, hidden in the body -->
<div style="display:none;max-height:0;overflow:hidden;mso-hide:all;font-size:1px;line-height:1px;color:#f4f4f7;">
    <?= __('Activate your {0} account to start shortening links.', h($siteName)) ?>
</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
       style="background-color:#f4f4f7;margin:0;padding:0;width:100%;">
    <tr>
        <td align="center" style="padding:32px 12px;">

            <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0"
                   style="width:600px;max-width:600px;background-color:#ffffff;border-radius:16px;
                          overflow:hidden;box-shadow:0 2px 8px rgba(16,12,32,0.06);">

                <tr>
                    <td style="height:4px;line-height:4px;font-size:0;background-color:#B57CE8;
                               background-image:linear-gradient(90deg,#B57CE8,#E448C0);">&nbsp;</td>
                </tr>

                <tr>
                    <td align="left" style="padding:34px 40px 0 40px;">
                        <span style="font-family:Helvetica,Arial,sans-serif;font-size:23px;font-weight:bold;
                                     color:#16121f;letter-spacing:-0.3px;"><?= h($logoHead) ?></span><span
                              style="font-family:Helvetica,Arial,sans-serif;font-size:23px;font-weight:bold;
                                     color:#9054D8;letter-spacing:-0.3px;"><?= h($logoTail) ?></span><span
                              style="font-family:Helvetica,Arial,sans-serif;font-size:13px;
                                     color:#E448C0;"><?= h($tld) ?></span>
                    </td>
                </tr>

                <tr>
                    <td style="padding:26px 40px 0 40px;">
                        <h1 style="margin:0 0 14px 0;font-family:Helvetica,Arial,sans-serif;font-size:24px;
                                   line-height:1.3;font-weight:bold;color:#16121f;">
                            <?= __('Hi {0},', h($username)) ?>
                        </h1>
                        <p style="margin:0;font-family:Helvetica,Arial,sans-serif;font-size:16px;
                                  line-height:1.6;color:#4a4458;">
                            <?= __('Welcome to {0}. Your account has been created and just needs activating before you can start shortening links and earning.', h($siteName)) ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td align="center" style="padding:28px 40px 6px 40px;">
                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <td align="center" bgcolor="#9054D8"
                                    style="border-radius:999px;background-color:#9054D8;
                                           background-image:linear-gradient(135deg,#B57CE8,#E448C0);">
                                    <a href="<?= h($link) ?>"
                                       style="display:inline-block;padding:16px 42px;font-family:Helvetica,Arial,sans-serif;
                                              font-size:16px;font-weight:bold;color:#ffffff;text-decoration:none;
                                              border-radius:999px;">
                                        <?= __('Activate My Account') ?>
                                    </a>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:18px 40px 0 40px;">
                        <p style="margin:0 0 6px 0;font-family:Helvetica,Arial,sans-serif;font-size:13px;
                                  line-height:1.5;color:#8b8398;">
                            <?= __("If the button doesn't work, copy and paste this into your browser:") ?>
                        </p>
                        <p style="margin:0;font-family:Helvetica,Arial,sans-serif;font-size:13px;
                                  line-height:1.6;word-break:break-all;">
                            <a href="<?= h($link) ?>" style="color:#9054D8;text-decoration:underline;"><?= h($link) ?></a>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:26px 40px 0 40px;">
                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr><td style="height:1px;line-height:1px;font-size:0;background-color:#ececf1;">&nbsp;</td></tr>
                        </table>
                    </td>
                </tr>

                <tr>
                    <td style="padding:18px 40px 30px 40px;">
                        <p style="margin:0;font-family:Helvetica,Arial,sans-serif;font-size:13px;
                                  line-height:1.6;color:#8b8398;">
                            <?= __("If you didn't create a {0} account, you can safely ignore this email.", h($siteName)) ?>
                        </p>
                    </td>
                </tr>

                <tr>
                    <td align="center" bgcolor="#faf9fc"
                        style="background-color:#faf9fc;padding:22px 40px;border-top:1px solid #ececf1;">
                        <p style="margin:0 0 6px 0;font-family:Helvetica,Arial,sans-serif;font-size:14px;
                                  font-weight:bold;color:#16121f;"><?= h($siteName) ?></p>
                        <p style="margin:0;font-family:Helvetica,Arial,sans-serif;font-size:12px;
                                  line-height:1.6;color:#8b8398;">
                            &copy; <?= date('Y') ?> <?= h($siteName) ?> &nbsp;&middot;&nbsp;
                            <a href="<?= h($baseUrl) ?>page/privacy-policy" style="color:#8b8398;text-decoration:underline;"><?= __('Privacy') ?></a>
                            &nbsp;&middot;&nbsp;
                            <a href="<?= h($baseUrl) ?>page/terms" style="color:#8b8398;text-decoration:underline;"><?= __('Terms') ?></a>
                        </p>
                    </td>
                </tr>

            </table>

        </td>
    </tr>
</table>
