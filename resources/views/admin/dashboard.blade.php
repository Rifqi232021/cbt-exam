<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="/style-admin.css">
</head>
<body>
    <div class="admin-container">
        <header>
            <h1>ADMIN DASHBOARD - CBT SYSTEM</h1>
            <nav>
                <a href="/admin/dashboard">Dashboard</a>
                <a href="/admin/questions">Kelola Soal</a>
                <a href="/admin/students">Kelola Siswa</a>
                <a href="/admin/results">Hasil Ujian</a>
                <a href="/index.html">Logout</a>
            </nav>
        </header>

        <main>
            <h2>Statistik Sistem</h2>
            <div class="stats">
                <div class="stat-card">
                    <h3>Jumlah Soal</h3>
                    <p>{{ $questionsCount }}</p>
                </div>
                <div class="stat-card">
                    <h3>Jumlah Siswa</h3>
                    <p>{{ $studentsCount }}</p>
                </div>
                <div class="stat-card">
                    <h3>Jumlah Hasil</h3>
                    <p>{{ $resultsCount }}</p>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
