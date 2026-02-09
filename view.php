<?php
require_once 'config.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$article = getArticleById($_GET['id']);

if (!$article) {
    header('Location: index.php');
    exit;
}
?>
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="glass-card p-5 text-white">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">Article</li>
                    </ol>
                </nav>

                <div class="article-header mb-4">
                <span class="badge bg-light text-dark mb-2">
                    <?php echo date('F d, Y', strtotime($article['date'])); ?>
                </span>
                    <h1 class="display-5 fw-bold mb-3"><?php echo htmlspecialchars($article['title']); ?></h1>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <span class="text-dark fw-bold"><?php echo strtoupper(substr($article['author'], 0, 1)); ?></span>
                        </div>
                        <div>
                            <p class="mb-0 fw-bold"><?php echo htmlspecialchars($article['author']); ?></p>
                            <small class="text-white-50">Author</small>
                        </div>
                    </div>
                </div>

                <hr class="bg-white">

                <div class="article-content mt-4">
                    <div class="content-text" style="line-height: 1.8; font-size: 1.1rem;">
                        <?php echo nl2br(htmlspecialchars($article['content'])); ?>
                    </div>
                </div>

                <div class="mt-5 pt-4 border-top border-white-25">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="index.php" class="btn btn-outline-light">
                                ← Back to Articles
                            </a>
                        </div>
                        <div>
                            <a href="edit.php?id=<?php echo $article['id']; ?>" class="btn btn-light me-2">
                                Edit Article
                            </a>
                            <a href="delete.php?id=<?php echo $article['id']; ?>" class="btn btn-outline-light" onclick="return confirm('Delete this article?')">
                                Delete
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const contentText = document.querySelector('.content-text');
            const paragraphs = contentText.innerHTML.split('\n\n');
            contentText.innerHTML = paragraphs.map(p => `<p class="mb-3">${p}</p>`).join('');
        });
    </script>

<?php require_once 'includes/footer.php'; ?>