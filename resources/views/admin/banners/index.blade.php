@extends('admin.layouts.master')

@section('title')
    Danh sách Banner
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Danh sách Banner</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Danh sách Banner</li>
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
                    <h5 class="card-title mb-0 flex-grow-1">Danh sách banner</h5>
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-primary">Thêm mới</a>
                </div>
                <div class="card-body">
                    <table id="example"
                        class="table table-bordered dt-responsive nowrap table-striped align-middle text-center"
                        style="width:100%">

                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Link</th>
                                <th>Position</th>
                                <th>Start_date</th>
                                <th>End_date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach ($banners as $banner)
                                <tr>
                                    <td>{{ $banner->id }}</td>
                                    <td>{{ $banner->title }}</td>
                                    <td>
                                        <img src="{{ Storage::url($banner->image) }}" alt="" width="50px">
                                    </td>
                                    <td>{{ $banner->link }}</td>
                                    <td>{{ $banner->position }}</td>
                                    <td>{{ $banner->start_date }}</td>
                                    <td>{{ $banner->end_date }}</td>
                                    <td>{!! $banner->status === 1
                                        ? '<span class="badge bg-success">YES</span>'
                                        : '<span class="badge bg-danger">NO</span>' !!}</td>
                                    <td class="d-flex gap-1">
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                            data-bs-target="#bannerDetail"
                                            data-details="{{ json_encode($banner) }}">Show</button>
                                        <a href="{{ route('admin.banners.edit', $banner) }}"
                                            class="btn btn-warning">Edit</a>
                                        <form action="{{ route('admin.banners.destroy', $banner) }}" method="post"
                                            class="delete-form">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger"
                                                onclick="confirmDelete(event, this.closest('form'), 'Bạn có chắc chắn muốn xóa banner này?','Hành động này không thể hoàn tác!')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div><!--end col-->
    </div>

    <div class="modal fade" id="bannerDetail" tabindex="-1" aria-labelledby="categoryDetailLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailModalLabel">Chi tiết danh mục</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="modalCover" src="" class="img-fluid" alt="Product Image">
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
            const modalElement = document.getElementById('bannerDetail');
            modalElement.addEventListener('show.bs.modal', function(event) {
                const button = event.relatedTarget;
                const details = JSON.parse(button.getAttribute('data-details'));

                let imageUrl = details.image;
                if (!imageUrl) {
                    imageUrl = '';
                } else if (!imageUrl.includes('http')) {
                    imageUrl = '{{ Storage::url('') }}' + imageUrl;
                }

                const fields = [{
                        label: 'Title',
                        value: details.title
                    },
                    {
                        label: 'Link',
                        value: details.link
                    },
                    {
                        label: 'position',
                        value: details.position
                    },
                    {
                        label: 'Start Date',
                        value: details.start_date
                    },
                    {
                        label: 'End Date',
                        value: details.end_date
                    },
                    {
                        label: 'Description',
                        value: details.description
                    },
                    {
                        label: 'Priority',
                        value: details.priority
                    },
                    {
                        label: 'Status',
                        value: details.status === "active" ?
                            '<span class="badge bg-success">YES</span>' :
                            '<span class="badge bg-danger">NO</span>'
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
                    `<p><strong>${field.label}:</strong> ${field.value}</p>`).join('');
                modalElement.querySelector('#modalCover').src = imageUrl;
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
