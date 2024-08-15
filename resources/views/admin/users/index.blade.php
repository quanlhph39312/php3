@extends('admin.layouts.master')

@section('title')
    Danh sách Tài Khoản
@endsection

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Danh sách tài khoản</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Tables</a></li>
                        <li class="breadcrumb-item active">Danh sách tài khoản</li>
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
                    <h5 class="card-title mb-0 flex-grow-1">Danh sách tài khoản</h5>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">Thêm mới</a>
                </div>
                <div class="card-body">
                    <table id="example" class="table table-bordered dt-responsive nowrap table-striped align-middle"
                        style="width:100%">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Avatar</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th>Phone</th>
                                <th>Birthday</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>
                                        @php
                                            $url = $user->avatar;
                                            if (!\Str::contains($url, 'http')) {
                                                $url = Storage::url($url);
                                            }
                                        @endphp
                                        <img src="{{ $url }}" alt="" width="100px">
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->address }}</td>
                                    <td>{{ $user->phone }}</td>
                                    <td>{{ $user->birthday }}</td>
                                    <td>{{ $user->role }}</td>
                                    <td>
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#productDetailModal"
                                                data-details="{{ json_encode($user) }}">Show</button>
                                            <a href="{{ route('admin.users.edit', $user) }}"
                                                class="btn btn-warning">Edit</a>
                                            <button type="submit"
                                                onclick="confirmDelete(event,this.closest('form'),'Bạn có chắc chắn muốn khóa tài khoản không')"
                                                class="btn btn-danger">
                                                Block
                                            </button>
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

    <!-- Modal -->
    <div class="modal fade" id="productDetailModal" tabindex="-1" aria-labelledby="productDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="productDetailModalLabel">Thông tin người dùng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img id="modalAvatar" src="" class="img-fluid" alt="Product Image">
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modalElement = document.getElementById('productDetailModal');
        modalElement.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const details = JSON.parse(button.getAttribute('data-details'));

            let avatarUrl = details.avatar;
            if (!avatarUrl) {
                avatarUrl = '';
            } else if (!avatarUrl.includes('http')) {
                avatarUrl = '{{ Storage::url('') }}' + avatarUrl;
            }

            const fields = [{
                    label: 'Name',
                    value: details.name
                },
                {
                    label: 'Email',
                    value: details.email
                },
                {
                    label: 'Phone',
                    value: details.phone
                },
                {
                    label: 'Address',
                    value: details.address
                },
                {
                    label: 'Birthday',
                    value: details.birthday
                },
                {
                    label: 'Role',
                    value: details.role
                },
                {
                    label: 'Status',
                    value: details.status == 1 ? 'active' : 'block'
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
            modalElement.querySelector('#modalAvatar').src = avatarUrl;
        });
    });
</script>
@endsection
