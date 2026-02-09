<?php
require_once 'config.php';
require_once 'includes/header.php';

$articles = getAllArticles();
?>
    <div class="row animate-cards">
        <div class="col-12 mb-4">
            <div class="glass-card p-5 text-center text-white mb-4 slide-in">
                <h1 class="display-5 fw-bold">GlassBlog</h1>
                <p class="lead">A modern glassmorphism blog with pure PHP</p>
                <p class="badge bg-light text-dark mb-3"><?php echo getArticleCount(); ?> Articles</p>
                <a href="create.php" class="btn btn-light px-4 pulse-hover">
                    <i class="bi bi-plus-circle"></i> Create New Article
                </a>
            </div>
        </div>

        <?php if (empty($articles)): ?>
            <div class="col-md-6 mx-auto">
                <div class="glass-card p-5 text-center text-white fade-in">
                    <div class="empty-state">
                        <i class="bi bi-file-text" style="font-size: 4rem; opacity: 0.5;"></i>
                        <h3 class="mt-3">No Articles Yet</h3>
                        <p class="text-white-50">Be the first to create an amazing article!</p>
                        <a href="create.php" class="btn btn-light mt-3">Create First Article</a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($articles as $index => $article): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="glass-card p-4 text-white h-100 glass-shine">
                        <div class="article-card-inner">
                    <span class="badge bg-light text-dark mb-2">
                        <i class="bi bi-calendar"></i> <?php echo date('M d, Y', strtotime($article['date'])); ?>
                    </span>
                            <h4 class="fw-bold mb-2"><?php echo htmlspecialchars($article['title']); ?></h4>
                            <p class="text-white-50 mb-3">
                                <i class="bi bi-person"></i> <?php echo htmlspecialchars($article['author']); ?>
                            </p>
                            <p class="article-excerpt"><?php echo htmlspecialchars($article['excerpt']); ?></p>
                            <div class="mt-3">
                                <a href="view.php?id=<?php echo $article['id']; ?>" class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-eye"></i> Read More
                                </a>
                                <div class="float-end">
                                    <a href="edit.php?id=<?php echo $article['id']; ?>" class="btn btn-outline-light btn-sm me-1" title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <a href="delete.php?id=<?php echo $article['id']; ?>" class="btn btn-outline-light btn-sm" title="Delete" onclick="return confirm('Delete this article?')">
                                        <i class="bi bi-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

<?php require_once 'includes/footer.php'; ?>