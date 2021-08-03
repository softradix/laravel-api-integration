@extends('layouts.app')
@section('contents')
<div class="container rounded">
    <div class="padding">
        <div class="row">
            <div class="col-sm-7">
                <div class="card">
                    <div class="card-header">
                        <strong>Credit/Debit Card</strong>
                        <small>Please enter your details</small>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="list-style-none">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('payment') }}">
                            @csrf
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">First Name</label>
                                        <input class="form-control" name="first_name" id="fname" type="text" placeholder="Enter your first name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="name">Last Name</label>
                                        <input class="form-control" name="last_name" id="lname" type="text" placeholder="Enter your last name">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="ccnumber">Email</label>
                                        <input class="form-control" name="shopper_email" id="shopper_email" type="email" placeholder="Enter your email">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-sm-12">
                                    <label for="country_code">Country code</label>
                                    <select class="form-control" name="country_code" id="country_code">
                                        <option>-Select country code-</option>
                                        <option value="56">Chile</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="phone">Phone</label>
                                        <input class="form-control" name="shopper_phone" id="shopper_phone" type="text" placeholder="999999999">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="type_doc_identi">Identification document type</label>
                                        <select class="form-control" name="type_doc_identi" id="type_doc_identi">
                                            <option>-Select Indentification Doc Type-</option>
                                            <option value="RUT">RUT</option>
                                            <option value="DNI">DNI</option>
                                            <option value="CI">CI</option>
                                            <option value="ID">ID</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="ccnumber">Identification Doc Number</label>
                                        <input class="form-control" name="num_doc_identi" id="num_doc_identi" type="email" placeholder="Identification Doc Number">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="phone">Payable Amount</label>
                                        <input class="form-control" name="amount" id="amount" type="number" placeholder="1000.00" required>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <button class="btn btn-sm btn-success float-right" type="submit"><i class="mdi mdi-gamepad-circle"></i> Continue</button>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection