<?php
define('ARTICLES_DIR', 'articles/');
define('SITE_TITLE', 'Glassmorph Blog');

function getAllArticles() {
    $articles = [];
    $files = glob(ARTICLES_DIR . '*.txt');

    foreach ($files as $file) {
        $content = file_get_contents($file);
        $lines = explode("\n", $content, 4);

        $articles[] = [
            'id' => basename($file, '.txt'),
            'title' => $lines[0] ?? 'Untitled',
            'author' => $lines[1] ?? 'Anonymous',
            'date' => $lines[2] ?? date('Y-m-d'),
            'content' => $lines[3] ?? '',
            'excerpt' => strlen($lines[3] ?? '') > 150 ? substr($lines[3], 0, 150) . '...' : ($lines[3] ?? '')
        ];
    }

    usort($articles, function($a, $b) {
        return strtotime($b['date']) - strtotime($a['date']);
    });

    return $articles;
}

function getArticleById($id) {
    $file = ARTICLES_DIR . $id . '.txt';

    if (!file_exists($file)) {
        return null;
    }

    $content = file_get_contents($file);
    $lines = explode("\n", $content, 4);

    if (count($lines) < 4) {
        return null;
    }

    return [
        'id' => $id,
        'title' => $lines[0],
        'author' => $lines[1],
        'date' => $lines[2],
        'content' => $lines[3]
    ];
}

function updateArticle($id, $title, $author, $content) {
    $file = ARTICLES_DIR . $id . '.txt';

    if (!file_exists($file)) {
        return false;
    }

    $existingContent = file_get_contents($file);
    $lines = explode("\n", $existingContent, 4);

    if (count($lines) < 4) {
        return false;
    }

    $date = $lines[2];
    $articleData = $title . "\n" . $author . "\n" . $date . "\n" . $content;

    return file_put_contents($file, $articleData) !== false;
}

function getArticleCount() {
    $files = glob(ARTICLES_DIR . '*.txt');
    return count($files);
}

function getPrevArticle($currentId) {
    $articles = getAllArticles();
    $currentIndex = -1;

    foreach ($articles as $index => $article) {
        if ($article['id'] == $currentId) {
            $currentIndex = $index;
            break;
        }
    }

    if ($currentIndex !== -1 && isset($articles[$currentIndex + 1])) {
        return $articles[$currentIndex + 1];
    }

    return null;
}

function getNextArticle($currentId) {
    $articles = getAllArticles();
    $currentIndex = -1;

    foreach ($articles as $index => $article) {
        if ($article['id'] == $currentId) {
            $currentIndex = $index;
            break;
        }
    }

    if ($currentIndex > 0 && isset($articles[$currentIndex - 1])) {
        return $articles[$currentIndex - 1];
    }

    return null;
}