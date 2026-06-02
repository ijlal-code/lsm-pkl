<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        .text-center { text-align: center; }
        .bold { font-weight: bold; }
        table.nilai, table.absen { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table.nilai th, table.nilai td, table.absen th, table.absen td { border: 1px solid black; padding: 6px; }
        .signature { width: 100%; margin-top: 40px; }
        .signature td { text-align: center; }
    </style>
</head>
<body>
    <div class="text-center bold" style="margin-bottom: 20px;">
        DAFTAR NILAI MURID<br>
        MATA PELAJARAN PKL<br>
        {{ $pengaturan['nama_sekolah'] ?? 'UPTD SMKN 1 MAJENE' }}<br>
        TAHUN PELAJARAN {{ $pengaturan['tahun_pelajaran'] ?? '2025/2026' }}
    </div>

    <!-- Info Siswa -->
    <table style="margin-bottom: 15px;">
        <tr><td width="150">Nama Murid</td><td>: {{ $siswa->name }}</td></tr>
        <tr><td>Kelas</td><td>: {{ $siswa->kelas ?? '...' }}</td></tr>
        <tr><td>Program Keahlian</td><td>: {{ $siswa->jurusan ?? '...' }}</td></tr>
        <tr><td>Tempat PKL</td><td>: {{ $siswa->perusahaan->nama_perusahaan ?? '...' }}</td></tr>
        <tr><td>Tanggal Observasi</td><td>: .......................................</td></tr>
        <tr><td>Nama Instruktur</td><td>: {{ $siswa->instruktur->name ?? '...' }}</td></tr>
        <tr><td>Nama Pembimbing</td><td>: {{ $siswa->guru->name ?? '...' }}</td></tr>
    </table>

    <table class="nilai">
        <thead>
            <tr>
                <th width="60%">Tujuan Pembelajaran</th>
                <th width="10%">Skor</th>
                <th width="30%">Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>1. Internalisasi dan Penerapan Soft Skills</td><td></td><td></td></tr>
            <tr><td>2. Penerapan Hard Skills</td><td></td><td></td></tr>
            <tr><td>3. Peningkatan & Pengembangan Hard Skills</td><td></td><td></td></tr>
            <tr><td>4. Penyiapan kemandirian kewirausahaan</td><td></td><td></td></tr>
        </tbody>
    </table>

    <br>

    <table class="absen" style="width: 50%;">
        <tr><th colspan="2" style="text-align: left;">Kehadiran :</th></tr>
        <tr><td width="30%">Sakit</td><td>: .................... Hari</td></tr>
        <tr><td>Ijin</td><td>: .................... Hari</td></tr>
        <tr><td>Tanpa Keterangan</td><td>: .................... Hari</td></tr>
    </table>

    <table class="signature">
        <tr>
            <td width="50%">Instruktur<br><br><br><br><br>(...........................................)</td>
            <td width="50%" style="text-align: right; padding-right: 20px;">
                ..............................., {{ date('Y') }}<br>
                <div style="text-align: center; display: inline-block;">
                    Guru Pembimbing<br><br><br><br><br>(...........................................)
                </div>
            </td>
        </tr>
    </table>
</body>
</html>