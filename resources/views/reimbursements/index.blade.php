@extends('layouts.adminlte')

@section('title', 'Reimbursements '.ucwords(auth()->user()->name))

@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('AdminLTE/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
@endsection

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Expenses Claims</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">Reimbursements</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-5 col-md-6 col-12">
                  <div class="card">
                      <div class="card-body">
                          <p>Reimburse total</p>
                          <h3 class="text-right">Rp. {{ number_format($totalReimburse, 0, ".", ".") }}</h3>
      
                      </div>
                  </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                          <div class="d-flex justify-content-between">
                            <h3 class="card-title">Reimburse History</h3>
                            <a href="{{ route('reimbursements.create') }}" class="btn btn-sm btn-success"><i class="fa fa-plus" aria-hidden="true"></i> Create new record</a>

                          </div>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <table id="example1" class="table table-hover">
                            <thead>
                            <tr>
                              <th style="width: 10%">Date</th>
                              <th style="width:10%">ID</th>
                              <th style="width: 30%">Title</th>
                              <th style="width: 20%">Category</th>
                              <th style="width: 20%">Amount</th>
                              <th style="width: 10%">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($reimbursements as $reimbursement)
                                <tr>
                                    <td>{{ $reimbursement->created_at->format('d/m/Y H:i') }}</td>
                                    <td>{{ $reimbursement->id }}</td>
                                    <td>{{ $reimbursement->title }}</td>
                                    <td>{{ $reimbursement->category }}</td>
                                    <td>Rp. {{ number_format($reimbursement->amount, 0, ".", ".") }}</td>
                                    @if ($reimbursement->status == 'Pending')
                                        <td><span class="badge badge-warning">{{ $reimbursement->status }}</span></td>
                                    @elseif($reimbursement->status == 'Approved')
                                        <td><span class="badge badge-success">{{ $reimbursement->status }}</span></td>
                                    @else
                                        <td><span class="badge badge-danger">{{ $reimbursement->status }}</span></td>
                                    @endif
                                </tr>
                            @endforeach
                          </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Main Content --}}
    

@endsection

@section('js')
    <!-- DataTables  & Plugins -->
    <script src="{{ asset('AdminLTE/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('AdminLTE/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <!-- SweetAlert2 -->
    <script src="{{ asset('AdminLTE/plugins/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(function () {
            $("#example1").DataTable({
                "order" : [[0, "desc"]],
                "responsive": true, "lengthChange": false, "autoWidth": false,
                "buttons": ["excel", "pdf", "print"]
            }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

            const Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            });
            
            @if (session('storeSuccess'))
              Toast.fire({
                icon: 'success',
                title: '{{ session('storeSuccess') }}.'
              });
            @endif
        });
    </script>
@endsection