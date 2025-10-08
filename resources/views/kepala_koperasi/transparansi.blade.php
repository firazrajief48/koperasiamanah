 @extends('layouts.dashboard')

 @section('title', 'Transparansi Keuangan')
 @section('page-title', 'Transparansi Keuangan')

 @php
     $role = 'Kepala Koperasi';
     $nama = 'Budi Santoso';
     $routePrefix = 'kepala_koperasi';
     $showLaporan = true;
 @endphp

 @section('main-content')
     <div class="card">
         <div class="card-body">
             <div class="table-responsive">
                 <table class="table table-striped">
                     <thead>
                         <tr>
                             <th>Nama</th>
                             <th>NIP</th>
                             <th>Jumlah Pinjaman</th>
                             <th>Sisa Pinjaman</th>
                             <th>Status</th>
                         </tr>
                     </thead>
                     <tbody>
                         @foreach ($pinjaman as $p)
                             <tr>
                                 <td>{{ $p['nama'] }}</td>
                                 <td>{{ $p['nip'] }}</td>
                                 <td>Rp {{ number_format($p['jumlah'], 0, ',', '.') }}</td>
                                 <td>Rp {{ number_format($p['sisa'], 0, ',', '.') }}</td>
                                 <td>
                                     @if ($p['status'] == 'Lunas')
                                         <span class="badge bg-success">{{ $p['status'] }}</span>
                                     @else
                                         <span class="badge bg-warning">{{ $p['status'] }}</span>
                                     @endif
                                 </td>
                             </tr>
                         @endforeach
                     </tbody>
                 </table>
             </div>
         </div>
     </div>
 @endsection
