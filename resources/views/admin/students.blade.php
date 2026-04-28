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
                        @foreach($students as $student)
                            <tr>
                                <td>{{ $student->id }}</td>
                                <td>{{ $student->name }}</td>
                                <td>{{ $student->school }}</td>
                                <td>{{ strtoupper($student->exam_type) }}</td>
                                <td>{{ $student->token }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
