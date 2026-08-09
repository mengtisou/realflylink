<?php
/**
 * RealFlyLink — Pages view.ctp
 * Used for all /pages/* routes (payment-proof, terms, privacy, etc.)
 */
$this->assign('title', ($page->meta_title) ?: $page->title);
$this->assign('description', $page->meta_description);
$this->assign('content_title', $page->title);
?>

<!-- Page Header — dark themed -->
<div class="rf-page-header">
    <div class="container text-center">
        <h1 class="rf-page-title"><?= h($page->title) ?></h1>
    </div>
</div>

<!-- Page Content -->
<?php
/**
 * Pages whose body is rendered from a theme element instead of the DB.
 * Keeps complex markup in code so CKEditor can never mangle it.
 * Key = page slug, value = element name.
 */
$rfElementPages = [
    'earn-money'      => 'earn_money_flow',
    'how-to-download' => 'howto_download',
];
$rfSlug    = isset($page->slug) ? (string)$page->slug : '';
$rfElement = isset($rfElementPages[$rfSlug]) ? $rfElementPages[$rfSlug] : null;
?>
<?php if ($rfElement): ?>
    <div class="rf-bg-alt">
        <?= $this->element($rfElement) ?>
    </div>
<?php else: ?>
    <div class="rf-bg-alt">
        <div class="container" style="padding-top: 20px; padding-bottom: 40px; min-height: 400px">
            <?= $page->content ?>
        </div>
    </div>
<?php endif; ?>

<style>
/* Page header bar */
.rf-page-header {
    background: radial-gradient(ellipse at 50% 0%, rgba(144,84,216,.20), transparent 70%), var(--bg);
    border-bottom: 1px solid var(--border);
    padding: 20px 10px 20px;
    text-align: center;
}
.rf-page-title {
    font-size: 26px;
    font-weight: 900;
    letter-spacing: -1.5px;
    color: var(--text);
    margin: 0;
}

/* Style plain page content (terms, privacy etc.) */
.rf-bg-alt h2, .rf-bg-alt h3 {
    color: var(--text);
    font-weight: 700;
    margin: 24px 0 10px;
}
.rf-bg-alt p {
    color: var(--muted);
    line-height: 1.7;
    margin-bottom: 14px;
}
.rf-bg-alt ul, .rf-bg-alt ol {
    color: var(--muted);
    padding-left: 22px;
    margin-bottom: 14px;
    line-height: 1.8;
}
.rf-bg-alt a {
    color: var(--cyan);
}

/* Pagination from old CloudTheme — restyle */
.rf-bg-alt .pagination > li > a,
.rf-bg-alt .pagination > li > span {
    background: var(--card) !important;
    border-color: var(--border) !important;
    color: var(--muted) !important;
    border-radius: 8px !important;
    margin: 0 2px !important;
    transition: all .2s;
}
.rf-bg-alt .pagination > li > a:hover {
    background: rgba(0,212,255,.1) !important;
    color: var(--cyan) !important;
    border-color: var(--cyan) !important;
}
.rf-bg-alt .pagination > .active > a,
.rf-bg-alt .pagination > .active > span {
    background: var(--grad) !important;
    border-color: transparent !important;
    color: #070d14 !important;
}
.rf-bg-alt .pagination > .disabled > span {
    background: var(--card2) !important;
    border-color: var(--border) !important;
    opacity: .4;
}
</style>
