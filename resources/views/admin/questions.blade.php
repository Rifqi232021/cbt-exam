<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Soal</title>
    <link rel="stylesheet" href="/style-admin.css">
</head>
<body>
    <div class="admin-container">
        <header>
            <div style="display: flex; align-items: center; gap: 15px;">
                <img src="/logo.png" alt="Logo" style="height: 50px; width: auto;">
                <h1>KELOLA SOAL</h1>
            </div>
            <nav>
                <a href="/admin/dashboard">Dashboard</a>
                <a href="/admin/questions">Kelola Soal</a>
                <a href="/admin/students">Kelola Siswa</a>
                <a href="/admin/results">Hasil Ujian</a>
                <a href="/index.html">Logout</a>
            </nav>
        </header>

        <main>
            <div class="page-card">
                <h2>Daftar Soal</h2>
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban Benar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $question)
                        <tr>
                            <td>{{ $question->id }}</td>
                            <td>{{ Str::limit($question->question_text, 80) }}</td>
                            <td>{{ $question->correct_answer }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </main>
    </div>
</body>
</html>
