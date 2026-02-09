<?php
require_once 'config.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$article = getArticleById($id);

if (!$article) {
    header('Location: index.php');
    exit;
}

$deleted = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = ARTICLES_DIR . $id . '.txt';

    if (file_exists($file) && unlink($file)) {
        $deleted = true;
    }
}
?>
    <div class="row">
        <div class="col-lg-6 mx-auto">
            <div class="glass-card p-5 text-white text-center">
                <?php if ($deleted): ?>
                    <div class="deleted-animation">
                        <i class="bi bi-trash-fill text-danger" style="font-size: 4rem;"></i>
                        <h2 class="fw-bold mt-4">Article Deleted</h2>
                        <p class="lead">The article has been permanently removed.</p>

                        <div class="mt-5">
                            <a href="index.php" class="btn btn-light px-4 me-2">
                                <i class="bi bi-house"></i> Back to Home
                            </a>
                            <a href="create.php" class="btn btn-outline-light px-4">
                                <i class="bi bi-plus-circle"></i> Create New
                            </a>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="delete-warning">
                        <i class="bi bi-exclamation-triangle text-warning" style="font-size: 4rem;"></i>
                        <h2 class="fw-bold mt-4">Delete Article</h2>

                        <div class="article-preview glass-card p-4 mt-4 mb-4 text-start">
                            <h5><?php echo htmlspecialchars($article['title']); ?></h5>
                            <p class="mb-2"><small>By <?php echo htmlspecialchars($article['author']); ?></small></p>
                            <p class="mb-0 text-white-50">
                                <?php
                                $excerpt = strlen($article['content']) > 100 ? substr($article['content'], 0, 100) . '...' : $article['content'];
                                echo htmlspecialchars($excerpt);
                                ?>
                            </p>
                        </div>

                        <div class="alert alert-warning glass-card border-warning">
                            <i class="bi bi-info-circle"></i> This action cannot be undone!
                        </div>

                        <form method="POST" action="delete.php?id=<?php echo $id; ?>">
                            <div class="d-flex justify-content-center mt-4 pt-3">
                                <a href="view.php?id=<?php echo $id; ?>" class="btn btn-outline-light me-3 px-4">
                                    <i class="bi bi-x-circle"></i> Cancel
                                </a>
                                <button type="submit" class="btn btn-danger px-4">
                                    <i class="bi bi-trash"></i> Delete Permanently
                                </button>
                            </div>
                        </form>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

<?php require_once 'includes/footer.php'; ?>