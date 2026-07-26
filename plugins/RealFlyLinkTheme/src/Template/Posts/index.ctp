<?php
$this->assign('title', __('Blog') . ' — ' . get_option('site_name'));
$this->assign('description', get_option('description'));
$this->assign('content_title', __('Blog'));

// Get current search term from URL — AdLinkFly uses ?search= or ?q=
$searchTerm = $this->request->getQuery('search') ?? $this->request->getQuery('q') ?? '';
$activeTag = $this->request->getQuery('tag') ?? '';
?>

<!-- Blog Hero + Search -->
<div class="rf-blog-hero">
    <div class="container">
        <div class="rf-blog-hero-inner">
            <div class="rf-blog-hero-text">
                <p class="rf-blog-eyebrow"><?= __('Latest Updates') ?></p>
                <h1 class="rf-blog-hero-title"><?= h(get_option('site_name')) ?> <?= __('Blog') ?></h1>
                <p class="rf-blog-hero-sub"><?= __('Guides, news and tips to help you earn more from your links.') ?></p>
            </div>
            <div class="rf-blog-search-wrap">
                <form action="<?= build_main_domain_url('/blog') ?>" method="GET" class="rf-blog-search-form">
                    <div class="rf-blog-search-box">
                        <svg class="rf-search-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="M21 21l-4.35-4.35"/></svg>
                        <input
                            type="text"
                            name="search"
                            class="rf-search-input"
                            placeholder="<?= __('Search posts...') ?>"
                            value="<?= h($searchTerm) ?>"
                            autocomplete="off"
                        />
                        <?php if ($searchTerm): ?>
                        <a href="<?= build_main_domain_url('/blog') ?>" class="rf-search-clear" title="Clear">✕</a>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="rf-search-btn"><?= __('Search') ?></button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Blog Grid -->
<div class="rf-blog-wrap">
    <div class="container">

        <?php if ($activeTag): ?>
        <p class="rf-blog-search-label">
            <?= __('Showing posts tagged') ?>: <strong>#<?= h($activeTag) ?></strong>
            <a href="<?= build_main_domain_url('/blog') ?>" style="color:#c9a8ec;margin-left:10px;font-size:12px;">✕ <?= __('Clear') ?></a>
            <?php if (empty($posts)): ?>— <?= __('no posts found') ?><?php endif; ?>
        </p>
        <?php elseif ($searchTerm): ?>
        <p class="rf-blog-search-label">
            <?= __('Results for') ?> "<strong><?= h($searchTerm) ?></strong>"
            <?php if (empty($posts)): ?>— <?= __('no posts found') ?><?php endif; ?>
        </p>
        <?php endif; ?>

        <?php if (empty($posts)): ?>
            <p class="rf-blog-empty">
                <?php if ($activeTag): ?>
                    <?= __('No posts tagged') ?> "<?= h($activeTag) ?>" <?= __('yet.') ?>
                <?php elseif ($searchTerm): ?>
                    <?= __('No posts matched your search. Try different keywords.') ?>
                <?php else: ?>
                    <?= __('No posts yet. Check back soon!') ?>
                <?php endif; ?>
            </p>
        <?php else: ?>
            <div class="rf-blog-grid">
                <?php foreach ($posts as $post): ?>
                    <article class="rf-blog-card">
                        <?php
                        $thumb = isset($post->image) && !empty($post->image)
                            ? h($post->image) : null;
                        ?>
                        <a href="<?= build_main_domain_url('/blog/' . $post->id . '-' . $post->slug) ?>" class="rf-blog-thumb-link">
                            <div class="rf-blog-thumb <?= $thumb ? '' : 'rf-blog-thumb-placeholder' ?>"
                                 <?= $thumb ? 'style="background-image:url(\'' . $thumb . '\')"' : '' ?>>
                                <?php if (!$thumb): ?>
                                <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                <?php endif; ?>
                            </div>
                        </a>
                        <div class="rf-blog-card-body">
                            <div class="rf-blog-meta">
                                <span class="rf-blog-author"><?= h(get_option('site_name')) ?></span>
                                <span class="rf-blog-dot">•</span>
                                <span><?= $post->created->format('M j, Y') ?></span>
                            </div>
                            <h2 class="rf-blog-card-title">
                                <a href="<?= build_main_domain_url('/blog/' . $post->id . '-' . $post->slug) ?>">
                                    <?= h($post->title) ?>
                                </a>
                            </h2>
                            <p class="rf-blog-card-desc"><?= h($post->short_description) ?></p>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>

            <!-- Pagination -->
            <?php
            $hasPrev = $this->Paginator->hasPrev();
            $hasNext = $this->Paginator->hasNext();
            $hasPages = $hasPrev || $hasNext || $this->Paginator->hasPage(2);
            ?>
            <?php if ($hasPages): ?>
            <div class="rf-blog-pagination">
                <?php if ($hasPrev): ?>
                    <?= $this->Paginator->prev('←') ?>
                <?php endif; ?>
                <?= $this->Paginator->numbers(['modulus' => 5]) ?>
                <?php if ($hasNext): ?>
                    <?= $this->Paginator->next('→') ?>
                <?php endif; ?>
            </div>
            <?php endif; ?>

        <?php endif; ?>
    </div>
</div>