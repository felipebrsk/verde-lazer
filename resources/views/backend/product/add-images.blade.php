@extends('backend.layouts.master')
@section('title', '| Adicionar imagens')

@section('content')
    <div class="card">
        <h5 class="card-header">Adicionar imagens para: {{ $product->title }} <i class="fas fa-file"></i></h5>
        <div class="card-body">
            <img width="400" height="200" alt="Produto" src="{{ asset('frontend/products/' . $product->photo) }}">
            <form method="POST" action="{{ route('galleries.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Pode adicionar múltiplas imagens <span
                            class="text-danger">*</span></label>
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="file" name="image[]" class="form-control" multiple="multiple" required>
                    @error('image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <button type="submit" class="btn btn-success mt-4">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
    <div class="p-4">
        <div> <span class="icon"><i class="icon-time"></i></span>
            <h5>Lista de imagens na galeria</h5>
        </div>
        <div>
            <table class="table table-striped table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Imagem</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($imageGalleries as $imageGallery)
                        <tr>
                            <td class="taskDesc" style="text-align: center;vertical-align: middle;">
                                {{ $i++ }}</td>
                            <td class="taskOptions" style="text-align: center;vertical-align: middle;"><img
                                    src="{{ asset('frontend/products/small/' . $imageGallery->image) }}"
                                    class="img-responsive" alt="Image" width="60"></td>
                            <td style="text-align: center; vertical-align: middle;">
                                <form method="POST" action="{{ route('galleries.destroy', [$imageGallery->id]) }}">
                                    @csrf
                                    @method('delete')
                                    <button class="btn btn-danger btn-sm dltBtn" data-id={{ $imageGallery->id }}
                                        style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip"
                                        data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
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
            transform: scale(5);
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
        $('#product-dataTable').DataTable({
            "scrollX": false "columnDefs": [{
                "orderable": false,
                "targets": [10, 11, 12]
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
