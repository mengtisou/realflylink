<?php
$this->assign('title', ($post->meta_title ?: $post->title) . ' — ' . get_option('site_name'));
$this->assign('description', $post->meta_description ?: $post->short_description);
$this->assign('content_title', $post->title);
$thumb = isset($post->image) && !empty($post->image) ? h($post->image) : null;

// Fetch recent posts directly — don't rely on $related_posts (often empty)
try {
    $PostsTable = \Cake\ORM\TableRegistry::getTableLocator()->get('Posts');
    $recentPosts = $PostsTable->find()
        ->where(['published' => 1, 'Posts.id !=' => $post->id])
        ->order(['Posts.created' => 'DESC'])
        ->limit(6)
        ->all();
} catch (\Exception $e) {
    $recentPosts = [];
}
?>

<div class="rf-post-wrap">
    <div class="container">
        <div class="row">

            <!-- ── Main Content ── -->
            <div class="col-md-8 rf-post-main">

                <!-- Hero thumbnail -->
                <?php if ($thumb): ?>
                <div class="rf-post-hero-img">
                    <img src="<?= $thumb ?>" alt="<?= h($post->title) ?>"/>
                </div>
                <?php endif; ?>

                <!-- Breadcrumb -->
                <div class="rf-post-breadcrumb">
                    <a href="<?= build_main_domain_url('/blog') ?>"><?= __('Blog') ?></a>
                    <span>›</span>
                    <span><?= h(get_option('site_name')) ?></span>
                </div>

                <!-- Title + meta -->
                <h1 class="rf-post-title"><?= h($post->title) ?></h1>
                <div class="rf-post-meta-row">
                    <span class="rf-post-author"><?= h(get_option('site_name')) ?></span>
                    <span class="rf-post-meta-dot">•</span>
                    <span class="rf-post-date"><?= $post->created->format('d M Y') ?></span>
                </div>

                <!-- Post body -->
                <div class="rf-post-body">
                    <?= $post->description ?>
                </div>

                <script>
                (function(){
                document.querySelectorAll('.rf-dl-btn').forEach(function(btn){
                    var key = 'rf_dl_' + btn.getAttribute('href');
                    function markDone(){
                    btn.style.background = 'rgba(255,255,255,.08)';
                    btn.style.color = 'rgba(255,255,255,.55)';
                    btn.style.boxShadow = 'none';
                    btn.textContent = 'Downloaded ✓';
                    }
                    if (localStorage.getItem(key)) {
                    markDone();
                    }
                    btn.addEventListener('click', function(){
                    localStorage.setItem(key, '1');
                    markDone();
                    });
                });
                })();
                </script>
                
                <!-- Share -->
                <div class="rf-post-footer">
                    <div class="rf-post-share">
                        <span><?= __('Share now :') ?></span>
                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode(\Cake\Routing\Router::url(null, true)) ?>"
                           target="_blank" rel="noopener" class="rf-share-pill">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                        </a>
                        <a href="https://twitter.com/intent/tweet?url=<?= urlencode(\Cake\Routing\Router::url(null, true)) ?>&text=<?= urlencode($post->title) ?>"
                           target="_blank" rel="noopener" class="rf-share-pill">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                        </a>
                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?= urlencode(\Cake\Routing\Router::url(null, true)) ?>"
                           target="_blank" rel="noopener" class="rf-share-pill">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"/><rect x="2" y="9" width="4" height="12"/><circle cx="4" cy="4" r="2"/></svg>
                        </a>
                    </div>
                </div>

            </div>

            <!-- ── Sidebar ── -->
            <div class="col-md-4 rf-post-sidebar-col">
                <div class="rf-post-sidebar">

                    <!-- Search -->
                    <div class="rf-sidebar-search">
                        <form action="<?= build_main_domain_url('/blog') ?>" method="GET">
                            <div class="rf-sidebar-search-box">
                                <input type="text" name="search"
                                       placeholder="<?= __('Type to start searching...') ?>"
                                       class="rf-sidebar-search-input"/>
                                <button type="submit" class="rf-sidebar-search-btn"><?= __('Search') ?></button>
                            </div>
                        </form>
                    </div>

                    <!-- Signup promo banner -->
                    <div class="rf-sidebar-promo">
                        <div class="rf-sidebar-promo-icon">
                            <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
                        </div>
                        <h4 class="rf-sidebar-promo-title"><?= __('Shorten URLs and Earn Money') ?></h4>
                        <p class="rf-sidebar-promo-sub"><?= __('Create short links and get paid for every click. Free to join.') ?></p>
                        <a href="<?= build_main_domain_url('/auth/signup') ?>" class="rf-sidebar-promo-btn">
                            <?= __('Get started') ?> →
                        </a>
                    </div>

                    <!-- Recent posts -->
                    <?php if (!empty($recentPosts)): ?>
                    <div class="rf-sidebar-recent">
                        <h4 class="rf-sidebar-title"><?= __('Recent Post') ?></h4>
                        <?php foreach ($recentPosts as $r): ?>
                        <?php $rThumb = isset($r->image) && !empty($r->image) ? h($r->image) : null; ?>
                        <a href="<?= build_main_domain_url('/blog/' . $r->id . '-' . $r->slug) ?>" class="rf-sidebar-item">
                            <div class="rf-sidebar-thumb <?= $rThumb ? '' : 'rf-sidebar-thumb-ph' ?>"
                                 <?= $rThumb ? 'style="background-image:url(\'' . $rThumb . '\')"' : '' ?>></div>
                            <div class="rf-sidebar-info">
                                <span class="rf-sidebar-date"><?= $r->created->format('d M Y') ?></span>
                                <p class="rf-sidebar-ttl"><?= h($r->title) ?></p>
                            </div>
                        </a>
                        <?php endforeach; ?>
                    </div>
                    <?php endif; ?>

                </div>
            </div>

        </div>
    </div>
</div>
