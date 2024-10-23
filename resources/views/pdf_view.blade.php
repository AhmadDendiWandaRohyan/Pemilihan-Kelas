<!DOCTYPE html>
<html>

<head>
    <title>{{ $title }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
    </style>
</head>

<body>
    <table style="width: 95%; margin-bottom: 20px">
        <td style="width: 20%">
            <img src="logo.png" alt="Logo" style="width: 120px;">
        </td>
        <td style="width: 80%">
            <div style="text-align: center;">
                <div style="font-size: 24px; font-weight: bold; border: 2px solid black;">
                    Kartu
                    Rencana Studi Siswa</div>
                <div style="font-size: 24px; border: 2px solid black; background-color: black; color:white">SMA Negeri 1
                    Tayu</div>
            </div>
        </td>
    </table>
    @foreach ($data as $package)
        <table style="width: 100%; margin-bottom: 20px; margin-left: 30;font-size: 12px">
            <tbody>
                <tr>
                    <td>NISN</td>
                    <td>: {{ auth()->user()->nisn }}</td>
                    <td>Agama</td>
                    <td>: {{ auth()->user()->religion }}</td>
                </tr>
                <tr>
                    <td>Nama</td>
                    <td>: {{ auth()->user()->name }}</td>
                    <td>Email</td>
                    <td>: {{ auth()->user()->email }}</td>
                </tr>
                <tr>
                    <td>Kelas</td>
                    <td>: {{ auth()->user()->class }}</td>
                    <td>Tahun Ajaran</td>
                    <td>: {{ auth()->user()->school_year }}</td>
                </tr>
                <tr>
                    <td>No. Telepon</td>
                    <td>: {{ auth()->user()->phone }}</td>
                    <td>Paket</td>
                    <td>:
                        {{ DB::table('list_packages')->where(['package_number' => $package->package_number])->first()->title }}
                    </td>
                </tr>
            </tbody>
        </table>
       
        <table
            style="font-size: 12px; width: 90%; border-collapse: collapse; border: 1px solid black; margin-left: 5%">
            <thead>
                <tr>
                    <th scope="col" style="padding: 10px; background-color: #f2f2f2; border: 1px solid black;">No
                    </th>
                    <th scope="col" style="padding: 10px; background-color: #f2f2f2; border: 1px solid black;">
                        Mata Pelajaran Umum</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $x = 0;
                @endphp
                @foreach ($packagesJoin as $item)
                    @if ($item->type == 'general' && $package->package_number == $item->package_number)
                        @php
                            $x++;
                        @endphp
                        <tr>
                            <th scope="row" style="padding: 10px; border: 1px solid black;">{{ $x }}
                            </th>
                            <td style="padding: 10px; border: 1px solid black;">{{ $item->study }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        {{-- specialization --}}
        
        <table
            style="font-size: 12px; width: 90%; border-collapse: collapse; border: 1px solid black;margin-top:20px; margin-left: 5%">
            <thead>
                <tr>
                    <th scope="col" style="padding: 10px; background-color: #f2f2f2; border: 1px solid black;">No
                    </th>
                    <th scope="col" style="padding: 10px; background-color: #f2f2f2; border: 1px solid black;">
                        Mata Pelajaran Umum</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $x = 0;
                @endphp
                @foreach ($packagesJoin as $item)
                    @if ($item->type == 'specialization' && $package->package_number == $item->package_number)
                        @php
                            $x++;
                        @endphp
                        <tr>
                            <th scope="row" style="padding: 10px; border: 1px solid black;">{{ $x }}
                            </th>
                            <td style="padding: 10px; border: 1px solid black;">{{ $item->study }}</td>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        {{-- </div> --}}
    @endforeach
    {{-- </div> --}}


    <table style="width: 100%;">
        <tbody>
            <tr>
                <td style="width: 50%"></td>
                <td style="height: 60px"></td>
                <td style="font-size: 12px; text-align: center">Pati, {{ $date->isoFormat('D MMMM YYYY') }}</td>
            </tr>
            <tr>
                <td style="width: 50%"></td>
                <td style="height: 60px"></td>
                <td style="font-size: 12px; text-align: center">{{ auth()->user()->name }}</td>
            </tr>
        </tbody>
    </table>
</body>

</html>
