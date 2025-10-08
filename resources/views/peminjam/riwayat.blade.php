  @extends('layouts.dashboard')

  @section('title', 'Riwayat Pinjaman')
  @section('page-title', 'Riwayat Pinjaman')

  @php
      $role = 'Peminjam';
      $nama = 'Andi Wijaya';
      $routePrefix = 'peminjam';
      $showAjukan = true;
      $showRiwayat = true;
  @endphp

  @section('main-content')
      <style>
          .table-responsive {
              background: #f8fafc;
              border-radius: 16px;
              box-shadow: 0 8px 24px rgba(147, 197, 253, 0.12);
              overflow: hidden;
              max-width: 1000px;
              margin: 0 auto;
          }
          .table {
              margin-bottom: 0;
              background: transparent;
          }
          .table-hover tbody tr {
              transition: all 0.3s ease;
          }
          .table-hover tbody tr:hover {
              background: rgba(147, 197, 253, 0.1);
              transform: scale(1.01);
          }
          .table thead tr {
              background: linear-gradient(145deg, #f1f5f9 0%, #f8fafc 100%);
          }
          .table thead th {
              color: #475569;
              font-weight: 600;
              text-transform: uppercase;
              font-size: 0.7rem;
              letter-spacing: 0.05em;
              padding: 0.875rem 1rem;
              border: none;
          }
          .table td {
              padding: 0.875rem 1rem;
              vertical-align: middle;
              border: none;
              background: transparent;
              font-size: 0.875rem;
          }
          .badge {
              padding: 0.5rem 1rem;
              border-radius: 100px;
              font-weight: 500;
              font-size: 0.75rem;
              box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
              display: inline-flex;
              align-items: center;
              gap: 0.5rem;
          }
          .badge::before {
              content: '';
              display: inline-block;
              width: 6px;
              height: 6px;
              border-radius: 50%;
              background: currentColor;
              opacity: 0.8;
          }
          .bg-success {
              background: linear-gradient(145deg, #dcfce7 0%, #bbf7d0 100%) !important;
              color: #166534 !important;
              border: 1px solid rgba(22, 101, 52, 0.1);
          }
          .bg-info {
              background: linear-gradient(145deg, #dbeafe 0%, #bfdbfe 100%) !important;
              color: #1e40af !important;
              border: 1px solid rgba(30, 64, 175, 0.1);
          }
          .bg-warning {
              background: linear-gradient(145deg, #fef9c3 0%, #fef08a 100%) !important;
              color: #854d0e !important;
              border: 1px solid rgba(133, 77, 14, 0.1);
          }
          .table td:first-child {
              font-weight: 600;
              color: #3b82f6;
          }
          .table td:nth-child(3),
          .table td:last-child {
              font-family: 'DM Sans', sans-serif;
              font-weight: 600;
          }
          .table td:nth-child(4) {
              color: #6b7280;
          }
      </style>
      <div class="table-responsive">
          <table class="table table-hover">
                      <thead>
                          <tr>
                              <th>ID</th>
                              <th>Tanggal Pengajuan</th>
                              <th>Jumlah Pinjaman</th>
                              <th>Tenor</th>
                              <th>Status</th>
                              <th>Sisa Pinjaman</th>
                          </tr>
                      </thead>
                      <tbody>
                          @foreach ($riwayat as $r)
                              <tr>
                                  <td>{{ $r['id'] }}</td>
                                  <td>{{ date('d/m/Y', strtotime($r['tanggal'])) }}</td>
                                  <td>Rp {{ number_format($r['jumlah'], 0, ',', '.') }}</td>
                                  <td>{{ $r['tenor'] }}</td>
                                  <td>
                                      @if ($r['status'] == 'Disetujui')
                                          <span class="badge bg-success">{{ $r['status'] }}</span>
                                      @elseif($r['status'] == 'Lunas')
                                          <span class="badge bg-info">{{ $r['status'] }}</span>
                                      @else
                                          <span class="badge bg-warning">{{ $r['status'] }}</span>
                                      @endif
                                  </td>
                                  <td>Rp {{ number_format($r['sisa'], 0, ',', '.') }}</td>
                              </tr>
                          @endforeach
                      </tbody>
          </table>
      </div>
  @endsection