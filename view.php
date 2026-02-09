<?php
require_once 'config.php';
require_once 'includes/header.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$article = getArticleById($_GET['id']);

if (!$article) {
    echo '<div class="row">
        <div class="col-md-6 mx-auto">
            <div class="glass-card p-5 text-center text-white">
                <i class="bi bi-exclamation-circle" style="font-size: 4rem;"></i>
                <h3 class="mt-3">Article Not Found</h3>
                <p class="text-white-50">The requested article does not exist.</p>
                <a href="index.php" class="btn btn-light mt-3">← Back to Articles</a>
            </div>
        </div>
    </div>';
    require_once 'includes/footer.php';
    exit;
}
?>
    <div class="row">
        <div class="col-lg-10 mx-auto">
            <div class="glass-card p-5 text-white fade-in">
                <nav aria-label="breadcrumb" class="mb-4 slide-in">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php" class="text-white text-decoration-none">
                                <i class="bi bi-house"></i> Home
                            </a>
                        </li>
                        <li class="breadcrumb-item active text-white-50" aria-current="page">
                            Article
                        </li>
                    </ol>
                </nav>

                <div class="article-header mb-5">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                    <span class="badge bg-light text-dark px-3 py-2">
                        <i class="bi bi-calendar"></i>
                        <?php echo date('F d, Y', strtotime($article['date'])); ?>
                    </span>

                        <div class="btn-group">
                            <a href="edit.php?id=<?php echo $article['id']; ?>"
                               class="btn btn-outline-light btn-sm pulse-hover"
                               title="Edit">
                                <i class="bi bi-pencil"></i> Edit
                            </a>
                            <a href="delete.php?id=<?php echo $article['id']; ?>"
                               class="btn btn-outline-light btn-sm pulse-hover"
                               title="Delete"
                               onclick="return confirm('Delete this article permanently?')">
                                <i class="bi bi-trash"></i>
                            </a>
                        </div>
                    </div>

                    <h1 class="display-5 fw-bold mb-4 slide-in" style="animation-delay: 0.1s;">
                        <?php echo htmlspecialchars($article['title']); ?>
                    </h1>

                    <div class="author-card glass-card p-3 d-inline-block slide-in" style="animation-delay: 0.2s;">
                        <div class="d-flex align-items-center">
                            <div class="author-avatar rounded-circle bg-light d-flex align-items-center justify-content-center me-3"
                                 style="width: 60px; height: 60px;">
                            <span class="text-dark fw-bold fs-5">
                                <?php echo strtoupper(substr($article['author'], 0, 1)); ?>
                            </span>
                            </div>
                            <div>
                                <p class="mb-0 fw-bold"><?php echo htmlspecialchars($article['author']); ?></p>
                                <small class="text-white-50">Author</small>
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="bg-white my-5" style="opacity: 0.2;">

                <div class="article-content mt-5 slide-in" style="animation-delay: 0.3s;">
                    <div class="content-text" style="line-height: 1.8; font-size: 1.15rem;">
                        <?php
                        $content = htmlspecialchars($article['content']);
                        $paragraphs = explode("\n\n", $content);

                        foreach ($paragraphs as $paragraph) {
                            if (trim($paragraph) !== '') {
                                echo '<p class="mb-4">' . nl2br($paragraph) . '</p>';
                            }
                        }
                        ?>
                    </div>
                </div>

                <div class="article-footer mt-5 pt-5 border-top border-white-25">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="article-meta glass-card p-3">
                                <p class="mb-1"><small class="text-white-50">Article ID:</small></p>
                                <p class="mb-0"><code><?php echo $article['id']; ?></code></p>
                            </div>
                        </div>
                        <div class="col-md-6 text-md-end">
                            <button class="btn btn-outline-light me-2" onclick="window.print()">
                                <i class="bi bi-printer"></i> Print Article
                            </button>
                            <a href="index.php" class="btn btn-light">
                                <i class="bi bi-arrow-left"></i> Back to Articles
                            </a>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="d-flex justify-content-between">
                                <?php if ($prevArticle = getPrevArticle($article['id'])): ?>
                                    <a href="view.php?id=<?php echo $prevArticle['id']; ?>"
                                       class="btn btn-outline-light btn-sm">
                                        <i class="bi bi-chevron-left"></i> Previous Article
                                    </a>
                                <?php else: ?>
                                    <span></span>
                                <?php endif; ?>

                                <?php if ($nextArticle = getNextArticle($article['id'])): ?>
                                    <a href="view.php?id=<?php echo $nextArticle['id']; ?>"
                                       class="btn btn-outline-light btn-sm">
                                        Next Article <i class="bi bi-chevron-right"></i>
                                    </a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const articleContent = document.querySelector('.article-content');

            articleContent.addEventListener('click', function(e) {
                if (e.target.tagName === 'P') {
                    e.target.classList.toggle('highlight');
                }
            });

            const printBtn = document.querySelector('[onclick="window.print()"]');
            printBtn.addEventListener('mouseenter', function() {
                this.innerHTML = '<i class="bi bi-printer-fill"></i> Ready to Print';
            });

            printBtn.addEventListener('mouseleave', function() {
                this.innerHTML = '<i class="bi bi-printer"></i> Print Article';
            });

            const paragraphs = document.querySelectorAll('.content-text p');
            paragraphs.forEach((p, index) => {
                p.style.opacity = '0';
                p.style.transform = 'translateY(20px)';
                p.style.transition = 'all 0.5s ease';

                setTimeout(() => {
                    p.style.opacity = '1';
                    p.style.transform = 'translateY(0)';
                }, 100 + (index * 100));
            });

            const shareBtn = document.createElement('button');
            shareBtn.className = 'btn btn-outline-light btn-sm position-fixed bottom-0 end-0 m-4';
            shareBtn.innerHTML = '<i class="bi bi-share"></i> Share';
            shareBtn.style.zIndex = '1000';
            shareBtn.onclick = function() {
                if (navigator.share) {
                    navigator.share({
                        title: document.title,
                        text: 'Check out this article on GlassBlog',
                        url: window.location.href
                    });
                } else {
                    navigator.clipboard.writeText(window.location.href);
                    this.innerHTML = '<i class="bi bi-check"></i> Copied!';
                    setTimeout(() => {
                        this.innerHTML = '<i class="bi bi-share"></i> Share';
                    }, 2000);
                }
            };
            document.body.appendChild(shareBtn);
        });
    </script>

    <style>
        .author-avatar {
            transition: transform 0.3s ease;
        }

        .author-avatar:hover {
            transform: scale(1.1);
        }

        .content-text p.highlight {
            background: rgba(255, 255, 255, 0.1);
            padding: 10px;
            border-radius: 8px;
            border-left: 3px solid rgba(255, 255, 255, 0.5);
        }

        .content-text p {
            text-align: justify;
            text-justify: inter-word;
        }

        .article-meta {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        code {
            background: rgba(255, 255, 255, 0.1);
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9em;
        }

        @media (max-width: 768px) {
            .article-header h1 {
                font-size: 2rem;
            }

            .author-card {
                width: 100%;
            }

            .article-footer .col-md-6.text-md-end {
                text-align: left !important;
                margin-top: 1rem;
            }
        }

        @media print {
            .glass-navbar,
            .btn,
            .breadcrumb,
            .article-footer .btn,
            button[onclick="window.print()"] {
                display: none !important;
            }

            .glass-card {
                background: white !important;
                color: black !important;
                box-shadow: none !important;
                border: none !important;
            }

            .author-avatar {
                background: #f8f9fa !important;
                border: 1px solid #dee2e6 !important;
            }

            .badge.bg-light {
                background: #f8f9fa !important;
                color: #212529 !important;
                border: 1px solid #dee2e6 !important;
            }
        }
    </style>

<?php
require_once 'includes/footer.php';
?>