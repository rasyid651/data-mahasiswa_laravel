<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Data Mahasiswa</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #dddddd;
        }
    </style>
</head>

<body>
    <h2>Data Mahasiswa</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Prodi</th>
                <th>Jenis Kelamin</th>
                <th>Telepon</th>
                <th>Email</th>
                <th>Alamat</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data_mahasiswa as $mhs)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mhs->nama }}</td>
                    <td>{{ $mhs->prodi }}</td>
                    <td>{{ $mhs->jk }}</td>
                    <td>{{ $mhs->telepon }}</td>
                    <td>{{ $mhs->email }}</td>
                    <td>{{ strip_tags($mhs->alamat ?? '') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
