@extends('layouts.app')
{{-- @section('title')
    Dashboard
@endsection --}}
@section('content')
    <div class="container-xl client">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>{{ config('app.name', 'Laravel') }} <b>Employees</b></h2>
                        </div>
                        <div class="col-sm-6">
                            <a href="#addEmployeeModal" class="btn btn-success" data-toggle="modal"><i
                                    class="material-icons">&#xE147;</i> <span>Add New Employee</span></a>
                        </div>
                    </div>
                </div>
                <form id="filter-form" action="" method="GET" class="flex justify-start gap-2 items-center fadeInUp"
                    data-wow-delay="0.05s">
                    <select name="filter" id="filter"
                        class="border-none text-sm font-light rounded-md bg-slate-100 py-1.5 px-2 focus:outline focus:outline-primary"style="width: 200px; text-align:center ">
                        <option value="">All</option>
                        <option value="last_name" {{ Request::get('filter') == 'last_name' ? 'selected' : '' }}>
                            last_name</option>
                        
                    </select>
                </form>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>first_Name</th>
                            <th>last_Name</th>
                            <th>Email</th>
                            <th>date profiled</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <style>
                            table.table td:last-child i {
                                margin: 0 0px !important;
                            }
                        </style>
                        @forelse ($client as $item)
                            <tr>
                                <td>{{ $item->first_name }}</td>
                                <td>{{ $item->last_name }}</td>
                                <td>{{ $item->email }}</td>
                                <td>{{ $item->date_profiled }}</td>
                                <td>
                                    <a href="{{ url('get_client/' . $item->id) }}" class="edit">
                                        <i class="material-icons" data-toggle="tooltip" title="Edit">&#xE254;</i></a>
                                    <a href="#showEmployeeModal{{ $item->id }}" class="show" data-toggle="modal"><i
                                            class="material-icons" data-toggle="tooltip" title="show"><i
                                                class="fa-regular fa-eye"></i></i></a>
                                </td>
                            </tr>

                            <!-- show Modal HTML -->
                            <div id="showEmployeeModal{{ $item->id }}" class="modal fade">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form enctype="multipart/form-data">
                                            <div class="modal-header">
                                                <h3> Client profile</h3>
                                            </div>
                                            <div class="modal-body">
                                                <div class="form-group">
                                                    <label>First_Name</label>
                                                    <input type="text" class="form-control first_Name" readonly
                                                        value="{{ $item->first_name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Last_Name</label>
                                                    <input type="text" class="form-control last_Name" readonly
                                                        value="{{ $item->last_name }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control email" readonly
                                                        value="{{ $item->email }}" name="email" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>primary_legal_counsel</label>
                                                    <textarea class="form-control primary_legal_counsel" readonly required>{{ $item->primary_legal_counsel }}</textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label>date_of_birth</label>
                                                    <input type="date" class="form-control date_of_birth" readonly
                                                        value="{{ $item->date_of_birth }}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label>date_profiled</label>
                                                    <input type="date" class="form-control date_profiled" readonly
                                                        value="{{ $item->date_profiled }}" required>
                                                </div>

                                                @if ($item->profile_image)
                                                    <label>profile_image</label>
                                                    <img src="{{ asset("$item->profile_image") }}"
                                                        style="width: 70px;height:70px;" class="me-4 border"
                                                        alt="img" />
                                                @endif

                                                {{-- <div class="form-group">
                                                    <label>profile_image</label>
                                                    <input type="file" class="form-control image" required>
                                                </div> --}}

                                                <div class="form-group">
                                                    <label>case_details</label>
                                                    <textarea class="form-control case_details" readonly required>{{ $item->case_details }}</textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <style>
                                                    .cancel {
                                                        background-color: #f80101 !important;
                                                    }
                                                </style>
                                                <button type="button"
                                                    class="btn btn-md btn-default bg-dark cart-button text-white w-100 cancel"
                                                    data-dismiss="modal">Cancel
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        @empty
                            <p>No client</p>
                        @endforelse


                    </tbody>
                </table>
                <div class="clearfix">
                    {{ $client->links() }}
                </div>
            </div>
        </div>
    </div>
    <!-- add Modal HTML -->
    <div id="addEmployeeModal" class="modal fade product_data ">
        <div class="modal-dialog">
            <div class="modal-content">
                <form>
                    <div class="modal-header">
                        <h4 class="modal-title">Add potential Client</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>First_Name</label>
                            <input type="text" class="form-control first_Name" required>
                        </div>
                        <div class="form-group">
                            <label>Last_Name</label>
                            <input type="text" class="form-control last_Name" required>
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control email" name="email" required>
                        </div>
                        <div class="form-group">
                            <label>primary_legal_counsel</label>
                            <textarea class="form-control primary_legal_counsel" required></textarea>
                        </div>
                        <div class="form-group">
                            <label>date_of_birth</label>
                            <input type="date" class="form-control date_of_birth" required>
                        </div>
                        <div class="form-group">
                            <label>date_profiled</label>
                            <input type="date" class="form-control date_profiled" required>
                        </div>
                        <div class="form-group">
                            <label>profile_image</label>
                            <input type="file" class="form-control image1"
                                accept="image/jpeg, image/png, image/jpg, image/gif" required>

                        </div>
                        <div class="form-group">
                            <label>case_details</label>
                            <textarea class="form-control case_details" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button"
                            class="btn btn-md bg-dark cart-button text-white w-100 addTorewviewBtns">Submit
                        </button>
                        <style>
                            .cancel {
                                background-color: #f80101 !important;
                            }
                        </style>
                        <button type="button" class="btn btn-md btn-default bg-dark cart-button text-white w-100 cancel"
                            data-dismiss="modal">Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
