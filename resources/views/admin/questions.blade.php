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
                @if(session('success'))
                    <div class="alert">{{ session('success') }}</div>
                @endif
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Pertanyaan</th>
                            <th>Jawaban Benar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $question)
                        <tr>
                            <td>{{ $question->id }}</td>
                            <td>{{ Str::limit($question->question_text, 80) }}</td>
                            <td>{{ $question->correct_answer }}</td>
                            <td><a href="#">Edit</a> | <a href="#">Hapus</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="page-card">
                <h2>Tambah Soal Baru</h2>
                <form action="/admin/questions" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <textarea name="question_text" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Opsi (pisahkan dengan koma atau gunakan JSON)</label>
                        <input type="text" name="options" placeholder="A, B, C, D" required>
                    </div>
                    <div class="form-group">
                        <label>Jawaban Benar</label>
                        <input type="text" name="correct_answer" placeholder="A" required>
                    </div>
                    <div class="form-group">
                        <label>Subjek (opsional)</label>
                        <input type="text" name="subject" placeholder="Matematika">
                    </div>
                    <div class="form-group">
                        <label>Tingkat Kesulitan (opsional)</label>
                        <input type="text" name="difficulty" placeholder="Mudah / Sedang / Sulit">
                    </div>
                    <button type="submit" class="btn-primary">Tambah Soal</button>
                </form>
            </div>
        </main>
    </div>
</body>
</html>
