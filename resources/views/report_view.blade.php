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
    <table style="width: 100%; margin-bottom: 30px">
        <td style="width: 20%">
            <img src="logo.png" alt="Logo" style="width: 120px;">
        </td>
        <td style="width: 80%">
            <div style="text-align: center;">
                <div style="font-size: 24px; font-weight: bold; border: 2px solid black;">Rekap Kartu Rencana Studi Siswa
                </div>
                <div style="font-size: 24px; border: 2px solid black; background-color: black; color:white">SMA Negeri 1
                    Tayu</div>
            </div>
        </td>
    </table>
    {{-- <div style="display: flex; flex-direction: column; flex-direction: row; justify-content: space-evenly;"> --}}
    @if (DB::table('picks')->first())
        <div style="display: flex; justify-content: space-evenly; margin-bottom: 20px;">
            <table style="font-size: 12px; width: 100%; border-collapse: collapse; border: 1px solid black;">
                <thead>
                    <tr>
                        <th scope="col" style="padding: 10px; background-color: #f2f2f2; border: 1px solid black;">No
                        </th>
                        <th scope="col" style="padding: 10px; background-color: #f2f2f2; border: 1px solid black;">
                            Nama</th>
                        <th scope="col" style="padding: 10px; background-color: #f2f2f2; border: 1px solid black;">
                            NISN</th>
                        <th scope="col" style="padding: 10px; background-color: #f2f2f2; border: 1px solid black;">
                            Kelas</th>
                        <th scope="col" style="padding: 10px; background-color: #f2f2f2; border: 1px solid black;">
                            Paket</th>
                    </tr>
                </thead>
                @if ($data)
                    <tbody>
                        @php
                            $i = 0;
                        @endphp
                        @foreach ($packagesJoin as $package)
                            @php
                                $i++;
                            @endphp
                            <tr>
                                <th scope="row" style="padding: 10px; border: 1px solid black;">
                                    {{ $i }}
                                </th>
                                <td style="padding: 10px; border: 1px solid black;">{{ $package->name }}</td>
                                <td style="padding: 10px; border: 1px solid black;">{{ $package->nisn }}</td>
                                <td style="padding: 10px; border: 1px solid black;">{{ $package->class }}</td>
                                <td style="padding: 10px; border: 1px solid black;">{{ $package->title }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                @else
                    <tbody>
                        <tr>
                            <td colspan="2" style="padding: 10px; text-align: center; border: 1px solid black;">
                                {{ __('menu.general.empty') }}
                            </td>
                        </tr>
                    </tbody>
                @endif
            </table>
        </div>
    @endif
    {{-- </div> --}}
</body>

</html>
