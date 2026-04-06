<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        th { background-color: #f4f4f4; }
        .error { color: white; background-color: #dc3545; padding: 15px; border-radius: 5px; }
        .badge { background: #28a745; color: white; padding: 4px 8px; border-radius: 4px; font-size: 12px; }
    </style>
</head>
<body>
    <h1><?= $title ?></h1>

    <?php if ($error): ?>
        <div class="error">
            <strong>Error:</strong> <?= $error ?>
        </div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Judul Buku</th>
                <th>Penulis</th>
                <th>ISBN</th>
                <th>Kategori</th>
                <th>Stok</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($books)): ?>
                <?php foreach ($books as $book): ?>
                <tr>
                    <td><?= $book['id'] ?></td>
                    <td><strong><?= $book['title'] ?></strong></td>
                    <td><?= $book['author'] ?></td>
                    <td><?= $book['isbn'] ?></td>
                    <td><span class="badge"><?= $book['category'] ?></span></td>
                    <td><?= $book['stock'] ?></td>
                </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="text-align: center;">Tidak ada data buku yang ditemukan.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <p><small>Sumber Data: Laravel API (Port 8000)</small></p>
</body>
</html>