<!DOCTYPE html>
<html lang="id">
<head>
    <title><?= $title ?></title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .btn-delete { color: red; text-decoration: none; font-weight: bold; }
        .alert-error { color: white; background: red; padding: 10px; margin-bottom: 10px; }
    </style>
</head>
<body>
    <h1><?= $title ?></h1>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert-error"><?= session()->getFlashdata('error') ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members as $m): ?>
            <tr>
                <td><?= $m['id'] ?></td>
                <td><?= $m['name'] ?></td>
                <td><?= $m['email'] ?></td>
                <td><?= $m['status'] ?></td>
                <td>
                    <a href="/members/delete/<?= $m['id'] ?>" class="btn-delete" onclick="return confirm('Yakin hapus?')">Hapus</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>