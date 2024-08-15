@extends('admin.layouts.master')

@section('title')
    Danh sách Sản phẩm
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Danh sách Sản phẩm</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Danh sách Sản phẩm</li>
                    </ol>
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h5 class="card-title mb-0 flex-grow-1">Danh sách sản phẩm</h5>
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary">Thêm mới</a>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Img Thumbnail</th>
                                <th>Name</th>
                                <th>Catelogues</th>
                                <th>Price Regular</th>
                                <th>Price Sale</th>
                                <th>Is Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $item->id }}</td>
                                    <td>
                                        @php
                                            $url = $item->image_thumbnail;
                                            if (!\Str::contains($url, 'http')) {
                                                $url = Storage::url($url);
                                            }
                                        @endphp
                                        <img src="{{ $url }}" alt="" width="100px" height="100px">
                                    </td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category->name }}</td>
                                    <td>{{ $item->price_regular }}</td>
                                    <td>{{ $item->price_sale }}</td>
                                    <td>
                                        {!! $item->status === 1
                                            ? '<span class="badge bg-success">Yes</span>'
                                            : '<span class="badge bg-danger">No</span>' !!}
                                    </td>
                                    <td class="text-center">
                                        <div class="btn-group gap-1">
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#productDetail"
                                                data-details="{{ json_encode($item) }}">Show</button>
                                            <a href="{{ route('admin.products.edit', $item) }}"
                                                class="btn btn-warning">EDIT</a>
                                            <form action="{{ route('admin.products.destroy', $item) }}" method="post">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    onclick="confirmDelete(event, this.closest('form'), 'Bạn có chắc chắn muốn xóa sản phẩm này không?')"
                                                    type="submit" class="btn btn-danger">DELETE</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="productDetail" tabindex="-1" aria-labelledby="productDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailLabel">Chi tiết sản phẩm</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="modalImage" src="" class="img-fluid" alt="Product Image">
                        </div>
                        <div class="col-md-8" id="modalDetails">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalElement = document.getElementById('productDetail');
            modalElement.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const details = JSON.parse(button.getAttribute('data-details'));

                let ImageUrl = details.image_thumbnail;
                if (!ImageUrl) {
                    ImageUrl = '';
                } else if (!ImageUrl.includes('http')) {
                    ImageUrl = '{{ Storage::url('') }}' + ImageUrl;
                }

                const fields = [{
                        label: 'Name',
                        value: details.name
                    },
                    {
                        label: 'SKU',
                        value: details.sku
                    },
                    {
                        label: 'Slug',
                        value: details.slug
                    },
                    {
                        label: 'Catelogues',
                        value: details.category.name
                    },
                    {
                        label: 'Price Regular',
                        value: details.price_regular
                    },
                    {
                        label: 'Price Sale',
                        value: details.price_sale
                    },
                    {
                        label: 'Description',
                        value: details.description
                    },
                    {
                        label: 'Content',
                        value: details.content
                    },
                    {
                        label: 'Material',
                        value: details.material
                    },
                    {
                        label: 'Is Active',
                        value: details.is_active === 0 ? '<span class="badge bg-danger">No</span>' :
                            '<span class="badge bg-success">Yes</span>'
                    },
                    {
                        label: 'Is Hot Deal',
                        value: details.is_hot_deal === 0 ? '<span class="badge bg-danger">No</span>' :
                            '<span class="badge bg-success">Yes</span>'
                    },
                    {
                        label: 'Is Good Deal',
                        value: details.is_good_deal === 0 ? '<span class="badge bg-danger">No</span>' :
                            '<span class="badge bg-success">Yes</span>'
                    },
                    {
                        label: 'Is New',
                        value: details.is_new === 0 ? '<span class="badge bg-danger">No</span>' :
                            '<span class="badge bg-success">Yes</span>'
                    },
                    {
                        label: 'Is Show Home',
                        value: details.is_show_home === 0 ? '<span class="badge bg-danger">No</span>' :
                            '<span class="badge bg-success">Yes</span>'
                    },
                    {
                        label: 'Created At',
                        value: details.created_at
                    },
                    {
                        label: 'Updated At',
                        value: details.updated_at
                    },
                ];

                const modalDetails = modalElement.querySelector('#modalDetails');
                modalDetails.innerHTML = fields.map(field =>
                    `<p><strong>${field.label}:</strong> ${field.value}</p>`
                ).join('');
                modalElement.querySelector('#modalImage').src = ImageUrl;
            });
        });
    </script>
@endsection

@section('style-libs')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script-libs')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

    <script>
        new DataTable("#example", {
            order: [
                [0, 'desc']
            ]
        });
    </script>
@endsection
