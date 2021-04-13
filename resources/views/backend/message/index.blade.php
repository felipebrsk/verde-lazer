@extends('backend.layouts.master')
@section('title', '| Centro de mensagens')

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <h5 class="card-header">Mensagens</h5>
        <div class="card-body">
            @if (count($messages) > 0)
                <table class="table message-table" id="message-dataTable">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Remetente</th>
                            <th scope="col">Assunto</th>
                            <th scope="col">Data</th>
                            <th scope="col">Lido em</th>
                            <th scope="col">Visualizado</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($messages as $message)

                            <tr class="@if ($message->read_at) bg-light
                            border-left-warning @else
                                border-left-success @endif">
                                <td scope="row">{{ $loop->index + 1 }}</td>
                                <td>{{ $message->name }}</td>
                                <td>{{ $message->subject }}</td>
                                <td>{{ $message->created_at->format('d/F/Y, h:i A') }}</td>
                                <td>
                                    @if ($message->read_at)
                                        {{ date('d/m/Y', strtotime($message->read_at)) }}, às
                                    {{ date('H:i:s', strtotime($message->read_at)) }} @else Não lida @endif
                                </td>
                                <td>
                                    @if ($message->read_at) <i
                                        class="fas fa-check-double text-success"></i> @else <i
                                            class="fas fa-exclamation-triangle text-danger"></i> @endif
                                </td>
                                <td>
                                    <a href="{{ route('message.show', $message->id) }}"
                                        class="btn btn-primary btn-sm float-left mr-1"
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view"
                                        data-placement="bottom"><i class="fas fa-eye"></i></a>
                                    <form method="POST" action="{{ route('message.destroy', [$message->id]) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id={{ $message->id }}
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
                <nav class="blog-pagination justify-content-center d-flex">
                    {{ $messages->links() }}
                </nav>
            @else
                <h2>Nenhuma mensagem encontrada!</h2>
            @endif
        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css"
        integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/jquery.dataTables.min.js"
        integrity="sha512-BkpSL20WETFylMrcirBahHfSnY++H2O1W+UnEEO4yNIl+jI2+zowyoGJpbtk6bx97fBXf++WJHSSK2MV4ghPcg=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/datatables/1.10.21/js/dataTables.bootstrap4.min.js"
        integrity="sha512-OQlawZneA7zzfI6B1n1tjUuo3C5mtYuAWpQdg+iI9mkDoo7iFzTqnQHf+K5ThOWNJ9AbXL4+ZDwH7ykySPQc+A=="
        crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/datatables-demo.js') }}"></script>
    <script>
        $('#message-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [4]
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
