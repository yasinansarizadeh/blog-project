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

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (empty($title) || empty($author) || empty($content)) {
        $error = 'All fields are required!';
    } else {
        if (updateArticle($id, $title, $author, $content)) {
            $success = 'Article updated successfully!';
            $article = getArticleById($id);
        } else {
            $error = 'Failed to update article.';
        }
    }
}
?>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="glass-card p-5 text-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Edit Article</h2>
                    <div>
                        <a href="view.php?id=<?php echo $id; ?>" class="btn btn-outline-light btn-sm me-2">
                            <i class="bi bi-eye"></i> View
                        </a>
                        <a href="index.php" class="btn btn-outline-light btn-sm">
                            ← Back to Articles
                        </a>
                    </div>
                </div>

                <div class="article-info mb-4 p-3 glass-card" style="background: rgba(255,255,255,0.05);">
                    <div class="row">
                        <div class="col-md-6">
                            <small class="text-white-50">Article ID:</small>
                            <p class="mb-0"><?php echo $id; ?></p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-white-50">Created Date:</small>
                            <p class="mb-0"><?php echo date('F d, Y', strtotime($article['date'])); ?></p>
                        </div>
                    </div>
                </div>

                <?php if ($error): ?>
                    <div class="alert alert-danger glass-card border-danger">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if ($success): ?>
                    <div class="alert alert-success glass-card border-success">
                        <?php echo htmlspecialchars($success); ?>
                        <div class="mt-2">
                            <a href="view.php?id=<?php echo $id; ?>" class="btn btn-light btn-sm">View Updated Article</a>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" action="edit.php?id=<?php echo $id; ?>" class="mt-3">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Article Title</label>
                        <input type="text"
                               class="form-control glass-input"
                               name="title"
                               value="<?php echo htmlspecialchars($article['title']); ?>"
                               placeholder="Enter article title"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Author Name</label>
                        <input type="text"
                               class="form-control glass-input"
                               name="author"
                               value="<?php echo htmlspecialchars($article['author']); ?>"
                               placeholder="Your name"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Content</label>
                        <textarea class="form-control glass-input"
                                  name="content"
                                  rows="12"
                                  placeholder="Write your article content here..."
                                  required><?php echo htmlspecialchars($article['content']); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-4 pt-3 border-top border-white-25">
                        <div>
                            <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-outline-danger" onclick="return confirm('Delete this article permanently?')">
                                <i class="bi bi-trash"></i> Delete Article
                            </a>
                        </div>
                        <div>
                            <a href="view.php?id=<?php echo $id; ?>" class="btn btn-outline-light me-2">Cancel</a>
                            <button type="submit" class="btn btn-light px-4">
                                <i class="bi bi-check-circle"></i> Update Article
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.querySelector('textarea[name="content"]');

            textarea.addEventListener('keydown', function(e) {
                if (e.key === 'Tab') {
                    e.preventDefault();
                    const start = this.selectionStart;
                    const end = this.selectionEnd;

                    this.value = this.value.substring(0, start) + '    ' + this.value.substring(end);

                    this.selectionStart = this.selectionEnd = start + 4;
                }
            });
        });
    </script>

<?php require_once 'includes/footer.php'; ?>