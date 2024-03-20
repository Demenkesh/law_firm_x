@extends('layouts.app')
@section('content')
    <div class="container-xl client">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">
                    <form id="update-form" action="{{ route('update_client', ['id' => $client->id]) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-header">
                            <h3>Update Client profile</h3>
                        </div>
                        <input type="text" hidden class="form-control id" name="id" value="{{ $client->id }}"
                            required>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>First_Name</label>
                                <input type="text" class="form-control first_Name" name="first_Name"
                                    value="{{ $client->first_name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Last_Name</label>
                                <input type="text" class="form-control last_Name" name="last_Name"
                                    value="{{ $client->last_name }}" required>
                            </div>
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" class="form-control email" value="{{ $client->email }}" name="email"
                                    required>
                            </div>
                            <div class="form-group">
                                <label>primary_legal_counsel</label>
                                <textarea class="form-control primary_legal_counsel" name="primary_legal_counsel" required>{{ $client->primary_legal_counsel }}</textarea>
                            </div>
                            <div class="form-group">
                                <label>date_of_birth</label>
                                <input type="date" class="form-control date_of_birth" name="date_of_birth"
                                    value="{{ $client->date_of_birth }}" required>
                            </div>
                            <div class="form-group">
                                <label>date_profiled</label>
                                <input type="date" class="form-control date_profiled" name="date_profiled"
                                    value="{{ $client->date_profiled }}" required>
                            </div>

                            @if ($client->profile_image)
                                <img src="{{ asset("$client->profile_image") }}" style="width: 70px;height:70px;"
                                    class="me-4 border" alt="img" />
                            @endif

                            <div class="form-group">
                                <label>profile_image</label>
                                <input type="file" class="form-control image" name="image"
                                    accept="image/jpeg, image/png, image/jpg, image/gif" >
                            </div>

                            <div class="form-group">
                                <label>case_details</label>
                                <textarea class="form-control case_details" name="case_details">{{ $client->case_details }}</textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit"
                                class="btn btn-md bg-dark cart-button text-white w-100 addTorewviewBtn{{ $client->id }}">Submit
                            </button>
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
    </div>
@endsection
