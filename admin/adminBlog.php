<?php
$loadedByController = isset($blogs);
$errors = $errors ?? [];
$old = $old ?? [];
$editBlogId = $editBlogId ?? 0;
$successMessage = $successMessage ?? '';

if (!$loadedByController) {
    require_once __DIR__ . '/../autoloader.php';

    $blogService = new \adminServices\AdminBlogsService();
    $blogThemes = $blogService->getBlogThemes();

    if (($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST') {
        $action = $_POST['blog_action'] ?? 'create';

        if ($action === 'delete') {
            $deleted = $blogService->deleteBlog((int) ($_POST['blog_id'] ?? 0));
            header('Location: /admin/adminblog.php?' . ($deleted ? 'deleted=1' : 'error=delete'));
            die();
        }

        if ($action === 'update') {
            $editBlogId = (int) ($_POST['blog_id'] ?? 0);
            $result = $blogService->updateBlog($editBlogId, $_POST);

            if ($result['success']) {
                header('Location: /admin/adminblog.php?updated=1');
                die();
            }

            $errors = $result['errors'];
            $old = $result['data'];
        } else {
            $result = $blogService->createBlog($_POST);

            if ($result['success']) {
                header('Location: /admin/adminblog.php?created=1');
                die();
            }

            $errors = $result['errors'];
            $old = $result['data'];
        }
    } elseif (isset($_GET['edit'])) {
        $editBlogId = (int) $_GET['edit'];
        $old = $blogService->getBlogForEdit($editBlogId) ?? [];
    }

    $blogs = $blogService->getAllBlogs();
    if (isset($_GET['created'])) {
        $successMessage = 'Blog is toegevoegd.';
    } elseif (isset($_GET['updated'])) {
        $successMessage = 'Blog is bijgewerkt.';
    } elseif (isset($_GET['deleted'])) {
        $successMessage = 'Blog is verwijderd.';
    } elseif (($_GET['error'] ?? '') === 'delete') {
        $errors[] = 'Blog kon niet worden verwijderd.';
    }
}

$blogs = $blogs ?? [];
$blogThemes = $blogThemes ?? [
    'Algemeen',
    'Buitenplaatsen',
    'Composiet',
    'Graniet',
    'Hardsteen',
    'Marmer',
    'Onze Merken',
];
$isEditing = $editBlogId > 0 && !empty($old);

function adminBlogValue(array $old, string $key): string
{
    return htmlspecialchars($old[$key] ?? '', ENT_QUOTES, 'UTF-8');
}

function adminBlogDate(?string $date): string
{
    $timestamp = strtotime($date ?? '');

    return $timestamp ? date('d-m-Y H:i', $timestamp) : htmlspecialchars($date ?? '', ENT_QUOTES, 'UTF-8');
}

function adminBlogSelectedThemes(array $old): array
{
    if (isset($old['tags']) && is_array($old['tags'])) {
        return $old['tags'];
    }

    if (!empty($old['tag'])) {
        return [$old['tag']];
    }

    return [];
}
?>
<!doctype html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Admin - Blog</title>
    <link rel="icon" href="/public/assets/logo_icon.png" type="image/png">
    <link rel="stylesheet" href="/admin/css/adminMain.css">
    <link rel="stylesheet" href="/admin/css/adminHeader.css">
    <link rel="stylesheet" href="/admin/css/adminBlog.css">
</head>
<body>
<?php require_once __DIR__ . '/../adminComponent/adminSidebar.php'; ?>

<div class="main">
    <?php require_once __DIR__ . '/../adminComponent/adminHeader.php'; ?>

    <main class="content">
        <div class="page-heading blog-heading">
            <div>
                <h1>Blog</h1>
                <p>Overzicht van alle blogs die nu online staan</p>
            </div>
            <a class="add-blog-button" href="#blog-toevoegen">Blog toevoegen</a>
        </div>

        <?php if ($successMessage): ?>
            <div class="alert success"><?php echo htmlspecialchars($successMessage); ?></div>
        <?php endif; ?>

        <?php if (!empty($errors)): ?>
            <div class="alert error">
                <?php foreach ($errors as $error): ?>
                    <p><?php echo htmlspecialchars($error); ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <section class="blog-panel">
            <div class="panel-title">
                <h2>Blogs online</h2>
                <span><?php echo count($blogs); ?> blogs</span>
            </div>

            <?php if (!empty($blogs)): ?>
                <div class="blog-table-wrap">
                    <table class="blog-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titel</th>
                                <th>Auteur</th>
                                <th>Thema's</th>
                                <th>Datum</th>
                                <th>Acties</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($blogs as $blog): ?>
                                <tr>
                                    <td><?php echo (int) $blog['blog_id']; ?></td>
                                    <td>
                                        <strong><?php echo htmlspecialchars($blog['title']); ?></strong>
                                        <span><?php echo htmlspecialchars($blog['excerpt'] ?: substr($blog['article'], 0, 90)); ?></span>
                                    </td>
                                    <td><?php echo htmlspecialchars($blog['arthor']); ?></td>
                                    <td><span class="tag"><?php echo htmlspecialchars($blog['tag']); ?></span></td>
                                    <td><?php echo adminBlogDate($blog['date']); ?></td>
                                    <td class="actions-cell">
                                        <a class="view-link" href="/blog/<?php echo (int) $blog['blog_id']; ?>" target="_blank">Bekijken</a>
                                        <a class="edit-link" href="/admin/adminblog.php?edit=<?php echo (int) $blog['blog_id']; ?>#blog-toevoegen">Bewerken</a>
                                        <form action="/admin/adminblog.php" method="post" onsubmit="return confirm('Weet je zeker dat je deze blog wilt verwijderen?');">
                                            <input type="hidden" name="blog_action" value="delete">
                                            <input type="hidden" name="blog_id" value="<?php echo (int) $blog['blog_id']; ?>">
                                            <button class="delete-link" type="submit">Verwijderen</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty-state">
                    <h2>Nog geen blogs gevonden</h2>
                    <p>Voeg hieronder de eerste blog toe voor de webshop.</p>
                </div>
            <?php endif; ?>
        </section>

        <section id="blog-toevoegen" class="blog-panel blog-form-panel">
            <div class="panel-title">
                <h2><?php echo $isEditing ? 'Blog bewerken' : 'Blog toevoegen'; ?></h2>
                <span><?php echo $isEditing ? 'Bestaande publicatie' : 'Nieuwe publicatie'; ?></span>
            </div>

            <form class="blog-form" action="/admin/adminblog.php" method="post">
                <input type="hidden" name="blog_action" value="<?php echo $isEditing ? 'update' : 'create'; ?>">
                <?php if ($isEditing): ?>
                    <input type="hidden" name="blog_id" value="<?php echo (int) $editBlogId; ?>">
                <?php endif; ?>

                <label>
                    Titel
                    <input type="text" name="title" maxlength="45" value="<?php echo adminBlogValue($old, 'title'); ?>" required>
                </label>

                <label>
                    Auteur
                    <input type="text" name="arthor" maxlength="45" value="<?php echo adminBlogValue($old, 'arthor'); ?>" required>
                </label>

                <label>
                    Thema's
                    <select name="tags[]" multiple required>
                        <?php $selectedThemes = adminBlogSelectedThemes($old); ?>
                        <?php foreach ($blogThemes as $theme): ?>
                            <option value="<?php echo htmlspecialchars($theme, ENT_QUOTES, 'UTF-8'); ?>" <?php echo in_array($theme, $selectedThemes, true) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($theme); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </label>

                <label>
                    Datum
                    <input type="text" name="date" placeholder="2026-06-17 12:00:00" value="<?php echo adminBlogValue($old, 'date'); ?>">
                </label>

                <label>
                    Afbeelding URL
                    <input type="text" name="image" placeholder="/public/assets/schone_tegel.png" value="<?php echo adminBlogValue($old, 'image'); ?>">
                </label>

                <label>
                    Korte samenvatting
                    <input type="text" name="excerpt" maxlength="255" value="<?php echo adminBlogValue($old, 'excerpt'); ?>">
                </label>

                <label class="full">
                    Artikel
                    <textarea name="article" rows="8" required><?php echo adminBlogValue($old, 'article'); ?></textarea>
                </label>

                <div class="form-actions">
                    <?php if ($isEditing): ?>
                        <a class="cancel-edit" href="/admin/adminblog.php">Annuleren</a>
                    <?php endif; ?>
                    <button type="submit"><?php echo $isEditing ? 'Blog bijwerken' : 'Blog toevoegen'; ?></button>
                </div>
            </form>
        </section>
    </main>
</div>

</body>
</html>
