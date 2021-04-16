@extends('backend.layouts.master')
@section('title', '| Avaliações')

@section('content')
    <div class="card shadow mb-4">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary float-left">Lista de avaliações</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                @if (count($reviews) > 0)
                    <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Avaliado por</th>
                                <th>Nome do local</th>
                                <th>Avaliação</th>
                                <th>Rate</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Avaliado por</th>
                                <th>Nome do local</th>
                                <th>Avaliação</th>
                                <th>Rate</th>
                                <th>Data</th>
                                <th>Status</th>
                                <th>Ações</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($reviews as $review)
                                @php
                                    $title = DB::table('products')
                                        ->select('title')
                                        ->where('id', $review->product_id)
                                        ->get();
                                @endphp
                                <tr>
                                    <td>{{ $review->id }}</td>
                                    <td>{{ $review->user_info['name'] }}</td>
                                    <td>
                                        @foreach ($title as $data)
                                            {{ $data->title }}
                                        @endforeach
                                    </td>
                                    <td>{{ $review->review }}</td>
                                    <td>
                                        <ul style="list-style:none">
                                            @for ($i = 1; $i <= 5; $i++)
                                                @if ($review->rate >= $i) <li
                                                style="float:left;color:#F7941D;"><i class="fa
                                                fa-star"></i></li>
                                            @else
                                                <li style="float:left;color:#F7941D;"><i class="far
                                                fa-star"></i></li> @endif
                                            @endfor
                                        </ul>
                                    </td>
                                    <td>{{ $review->created_at->format('D, d/m/Y, H:i:s') }}</td>
                                    <td>
                                        @if ($review->status == 'active')
                                            <span class="badge badge-success">{{ $review->status }}</span>
                                        @else
                                            <span class="badge badge-warning">{{ $review->status }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        <a href="{{ route('reviews.edit', $review->id) }}"
                                            class="btn btn-primary btn-sm float-left mr-1"
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                                        <form method="POST" action="{{ route('reviews.destroy', [$review->id]) }}">
                                            @csrf
                                            @method('delete')
                                            <button class="btn btn-danger btn-sm dltBtn" data-id={{ $review->id }}
                                                style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                                data-placement="bottom" title="Delete"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <span style="float:right">{{ $reviews->links() }}</span>
                @else
                    <h6 class="text-center">Nenhum review encontrado!</h6>
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
        $('#order-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [5, 6]
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
                            swal("Os seus dados estão seguros!");
                        }
                    });
            })
        })

    </script>
@endpush
