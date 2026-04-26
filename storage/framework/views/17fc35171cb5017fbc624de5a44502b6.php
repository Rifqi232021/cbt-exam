<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Ujian</title>
    <link rel="stylesheet" href="/style-admin.css">
</head>
<body>
    <div class="admin-container">
        <header>
            <h1>HASIL UJIAN</h1>
            <nav>
                <a href="/admin/dashboard">Dashboard</a>
                <a href="/admin/questions">Kelola Soal</a>
                <a href="/admin/students">Kelola Siswa</a>
                <a href="/admin/results" class="active">Hasil Ujian</a>
                <a href="/index.html">Logout</a>
            </nav>
        </header>

        <main>
            <div class="page-card">
                <h2>Daftar Hasil</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Siswa</th>
                            <th>Score</th>
                            <th>Total Soal</th>
                            <th>Waktu (detik)</th>
                            <th>Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $results; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $result): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($result->id); ?></td>
                                <td><?php echo e($result->student->name ?? '-'); ?></td>
                                <td><?php echo e($result->score); ?></td>
                                <td><?php echo e($result->total_questions); ?></td>
                                <td><?php echo e($result->time_taken); ?></td>
                                <td><?php echo e($result->created_at->format('d M Y H:i')); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH C:\Users\rifqi\Documents\coding tubes\resources\views/admin/results.blade.php ENDPATH**/ ?>