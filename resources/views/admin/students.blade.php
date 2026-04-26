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
                @if(session('success'))
                    <div class="alert">{{ session('success') }}</div>
                @endif
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

            <div class="page-card">
                <h2>Tambah Siswa Baru</h2>
                <form action="/admin/students" method="POST">
                    @csrf
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
