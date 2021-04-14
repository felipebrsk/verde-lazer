@extends('backend.layouts.master')
@section('title', '| Todas as notificações')

@section('content')
    <div class="card">
        <div class="row">
            <div class="col-md-12">
                @include('backend.layouts.notification')
            </div>
        </div>
        <h5 class="card-header">Notificações</h5>
        <div class="card-body">
            @if (count(Auth::user()->Notifications) > 0)
                <table class="table  table-hover admin-table" id="notification-dataTable">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Data/tempo</th>
                            <th scope="col">Título</th>
                            <th scope="col">Visto às</th>
                            <th scope="col">Visualizado</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Auth::user()->Notifications as $notification)

                            <tr class="@if ($notification->unread()) border-left-success
                            @else bg-light
                                border-left-light @endif">
                                <td scope="row">{{ $loop->index + 1 }}</td>
                                <td>{{ $notification->created_at->format('d/F/Y, h:i A') }}</td>
                                <td>{{ $notification->data['title'] }}</td>
                                <td>
                                  @if ($notification->read_at)
                                      {{ date('d/m/Y', strtotime($notification->read_at)) }}, às
                                  {{ date('H:i:s', strtotime($notification->read_at)) }} @else Não lida @endif
                              </td>
                              <td>
                                  @if ($notification->read_at) <i
                                      class="fas fa-check-double text-success"></i> @else <i
                                          class="fas fa-exclamation-triangle text-danger"></i> @endif
                              </td>
                                <td>
                                    <a href="{{ route('admin.notification', $notification->id) }}"
                                        class="btn btn-primary btn-sm float-left mr-1"
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view"
                                        data-placement="bottom"><i class="fas fa-eye"></i></a>
                                    <form method="POST" action="{{ route('notification.destroy', $notification->id) }}">
                                        @csrf
                                        @method('delete')
                                        <button class="btn btn-danger btn-sm dltBtn" data-id={{ $notification->id }}
                                            style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                            data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            @else
                <h2>Suas notificações estão vazias!</h2>
            @endif
        </div>
    </div>
@endsection
@push('styles')
    <link href="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />

@endpush
@push('scripts')
    <script src="{{ asset('backend/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('backend/js/demo/datatables-demo.js') }}"></script>
    <script>
        $('#notification-dataTable').DataTable({
            "columnDefs": [{
                "orderable": false,
                "targets": [3]
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
