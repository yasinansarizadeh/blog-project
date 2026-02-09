<?php
require_once 'config.php';
require_once 'includes/header.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $author = trim($_POST['author'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if (empty($title) || empty($author) || empty($content)) {
        $error = 'All fields are required!';
    } else {
        $id = time();
        $date = date('Y-m-d');

        $articleData = $title . "\n" . $author . "\n" . $date . "\n" . $content;

        $filePath = ARTICLES_DIR . $id . '.txt';

        if (file_put_contents($filePath, $articleData)) {
            $success = 'Article created successfully!';
            $_POST = array();
        } else {
            $error = 'Failed to save article. Check folder permissions.';
        }
    }
}
?>
    <div class="row">
        <div class="col-lg-8 mx-auto">
            <div class="glass-card p-5 text-white">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="fw-bold">Create New Article</h2>
                    <a href="index.php" class="btn btn-outline-light btn-sm">
                        ← Back to Articles
                    </a>
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
                            <a href="view.php?id=<?php echo $id ?? ''; ?>" class="btn btn-light btn-sm me-2">View Article</a>
                            <a href="create.php" class="btn btn-outline-light btn-sm">Create Another</a>
                        </div>
                    </div>
                <?php endif; ?>

                <form method="POST" action="create.php" class="mt-3">
                    <div class="mb-4">
                        <label class="form-label fw-bold">Article Title</label>
                        <input type="text"
                               class="form-control glass-input"
                               name="title"
                               value="<?php echo htmlspecialchars($_POST['title'] ?? ''); ?>"
                               placeholder="Enter article title"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Author Name</label>
                        <input type="text"
                               class="form-control glass-input"
                               name="author"
                               value="<?php echo htmlspecialchars($_POST['author'] ?? ''); ?>"
                               placeholder="Your name"
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Content</label>
                        <textarea class="form-control glass-input"
                                  name="content"
                                  rows="10"
                                  placeholder="Write your article content here..."
                                  required><?php echo htmlspecialchars($_POST['content'] ?? ''); ?></textarea>
                    </div>

                    <div class="d-flex justify-content-between mt-4 pt-3 border-top border-white-25">
                        <button type="reset" class="btn btn-outline-light">Reset Form</button>
                        <button type="submit" class="btn btn-light px-4">Publish Article</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

<?php require_once 'includes/footer.php'; ?>