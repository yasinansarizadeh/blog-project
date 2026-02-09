<?php
require_once 'config.php';
require_once 'includes/header.php';

$articles = getAllArticles();
?>
    <div class="row">
        <div class="col-12 mb-4">
            <div class="glass-card p-4 text-center text-white mb-4">
                <h1 class="display-5 fw-bold">GlassBlog</h1>
                <p class="lead">A modern glassmorphism blog with pure PHP</p>
                <a href="create.php" class="btn btn-light px-4">
                    <i class="bi bi-plus-circle"></i> Create New Article
                </a>
            </div>
        </div>

        <?php if (empty($articles)): ?>
            <div class="col-md-6 mx-auto">
                <div class="glass-card p-5 text-center text-white">
                    <h3>No Articles Yet</h3>
                    <p>Be the first to create an amazing article!</p>
                    <a href="create.php" class="btn btn-light">Create First Article</a>
                </div>
            </div>
        <?php else: ?>
            <?php foreach ($articles as $article): ?>
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="glass-card p-4 text-white h-100">
                        <div class="article-card-inner">
                    <span class="badge bg-light text-dark mb-2">
                        <?php echo date('M d, Y', strtotime($article['date'])); ?>
                    </span>
                            <h4 class="fw-bold"><?php echo htmlspecialchars($article['title']); ?></h4>
                            <p class="text-muted">By <?php echo htmlspecialchars($article['author']); ?></p>
                            <p><?php echo htmlspecialchars($article['excerpt']); ?></p>
                            <div class="mt-3">
                                <a href="view.php?id=<?php echo $article['id']; ?>" class="btn btn-outline-light btn-sm">
                                    Read More
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