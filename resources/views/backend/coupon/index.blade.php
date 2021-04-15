@extends('backend.layouts.master')
@section('title', '| Todos os cupons')

@section('content')
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Lista de cupons</h6>
            <a href="#" class="btn btn-primary btn-sm float-right" data-toggle="tooltip"
                data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Adicionar novo cupom</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (count($coupons) > 0)
                    <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Código do cupom</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Expira em</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Código do cupom</th>
                                <th>Tipo</th>
                                <th>Valor</th>
                                <th>Status</th>
                                <th>Expira em</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($coupons as $coupon)
                                <tr>
                                    <td>{{ $coupon->id }}</td>
                                    <td>{{ $coupon->code }}</td>
                                    <td>
                                        @if ($coupon->type == 'fixed')
                                            <span class="badge badge-primary">{{ $coupon->type }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ $coupon->type }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($coupon->type == 'fixed')
                                            R${{ number_format($coupon->value, 2) }}
                                        @else
                                            {{ number_format($coupon->value) }}%
                                        @endif
                                    </td>
                                    <td>
                                        @if ($coupon->status == 'active')
                                            <span class="badge badge-success">{{ $coupon->status }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ $coupon->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ date('d/m/Y', strtotime($coupon->expiry_date)) }}
                                    </td>
                                    <td>
                                        <a href="#"
                                            class="btn btn-primary btn-sm float-left mr-1"
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="#">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $coupon->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{ $coupons->links() }}</span>
                @else
                    <h6 class="text-center">Nenhum cupom encontrado. Por favor, adicione um cupom clicando <a
                            href="#">aqui</a>.</h6>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/css/dataTables.bootstrap4.min.css"
        integrity="sha512-PT0RvABaDhDQugEbpNMwgYBCnGCiTZMh9yOzUsJHDgl/dMhD9yjHAwoumnUk3JydV3QTcIkNDuN40CJxik5+WQ=="
        crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
    <style>
        div.dataTables_wrapper div.dataTables_paginate {
            display: none;
        }

        .zoom {
            transition: transform .2s;
            /* Animation */
        }

        .zoom:hover {
            transform: scale(3.2);
        }

    </style>
@endpush

@push('scripts')

    <!-- Page level plugins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
        integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"
        integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"
        integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA=="
        crossorigin="anonymous"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/datatables-demo.js') }}"></script>
    <script>
        $('#banner-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [4, 5]
            }]
        });

        // Sweet alert

        function deleteData(id) {

        }

    </script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $('.dltBtn').click(function(e) {
                var form = $(this).closest('form');
                var dataID = $(this).data('id');
                // alert(dataID);
                e.preventDefault();
                swal({
                        title: "Você tem certeza?",
                        text: "Uma vez deletado, os dados não poderão ser recuperados!",
                        icon: "warning",
                        buttons: true,
                        dangerMode: true,
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            form.submit();
                        } else {
                            swal("Os seus dados estão seguros.");
                        }
                    });
            })
        })

    </script>
@endpush
