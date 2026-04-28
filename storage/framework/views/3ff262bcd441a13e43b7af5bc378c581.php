<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Siswa</title>
    <link rel="stylesheet" href="/style-admin.css">
</head>
<body>
    <div class="admin-container">
        <header>
            <div style="display: flex; align-items: center; gap: 15px;">
                <img src="/logo.png" alt="Logo" style="height: 50px; width: auto;">
                <h1>KELOLA SISWA</h1>
            </div>
            <nav>
                <a href="/admin/dashboard">Dashboard</a>
                <a href="/admin/questions">Kelola Soal</a>
                <a href="/admin/students" class="active">Kelola Siswa</a>
                <a href="/admin/results">Hasil Ujian</a>
                <a href="/index.html">Logout</a>
            </nav>
        </header>

        <main>
            <div class="page-card">
                <h2>Daftar Siswa</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Sekolah</th>
                            <th>Jenis Ujian</th>
                            <th>Token</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($student->id); ?></td>
                                <td><?php echo e($student->name); ?></td>
                                <td><?php echo e($student->school); ?></td>
                                <td><?php echo e(strtoupper($student->exam_type)); ?></td>
                                <td><?php echo e($student->token); ?></td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH C:\Users\rifqi\Documents\coding tubes\resources\views/admin/students.blade.php ENDPATH**/ ?>