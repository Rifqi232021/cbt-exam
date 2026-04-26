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
            <h1>KELOLA SISWA</h1>
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
                <?php if(session('success')): ?>
                    <div class="alert"><?php echo e(session('success')); ?></div>
                <?php endif; ?>
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

            <div class="page-card">
                <h2>Tambah Siswa Baru</h2>
                <form action="/admin/students" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="name" required>
                    </div>

                    <div class="form-group">
                        <label>Sekolah</label>
                        <input type="text" name="school" required>
                    </div>
                    <div class="form-group">
                        <label>Jenis Ujian</label>
                        <select name="exam_type" required>
                            <option value="uts">UTS</option>
                            <option value="uas">UAS</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Token</label>
                        <input type="text" name="token" required>
                    </div>
                    <button type="submit" class="btn-primary">Tambah Siswa</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
<?php /**PATH C:\Users\rifqi\Documents\coding tubes\resources\views/admin/students.blade.php ENDPATH**/ ?>