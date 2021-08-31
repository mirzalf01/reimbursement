@extends('layouts.adminlte')

@section('title', 'Create New Record')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-6">
              <h1>Create New Record</h1>
            </div>
            <div class="col-sm-6">
              <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('reimbursements.index') }}">Reimbursements</a></li>
                <li class="breadcrumb-item active">Create</li>
              </ol>
            </div>
          </div>
        </div><!-- /.container-fluid -->
    </section>
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                {{-- Validation Error --}}
                <div class="col-12">
                    @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>


                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                          <h3 class="card-title">Reimburse Detail</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                          <form action="{{ route('reimbursements.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-lg-6 col-12">
                                    <div class="form-group">
                                        <label for="inputTitle">Title</label>
                                        <input value="{{ old('title') }}" type="text" class="form-control" name="title" id="inputTitle" placeholder="Medical bills . . .">
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="inputCategory">Category</label>
                                        <select name="category" class="form-control" id="inputCategory">
                                            <option {{ old('category') == 'Travel' ? 'selected' : '' }}  value="Travel">Travel</option>
                                            <option {{ old('category') == 'Fuel' ? 'selected' : '' }} value="Fuel">Fuel</option>
                                            <option {{ old('category') == 'Acoomodation' ? 'selected' : '' }} value="Accomodation">Accomodation</option>
                                            <option {{ old('category') == 'Medical' ? 'selected' : '' }} value="Medical">Medical</option>
                                            <option {{ old('category') == 'Other' ? 'selected' : '' }} value="Other">Other</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-sm-6 col-12">
                                    <div class="form-group">
                                        <label for="inputAmount">Amount <span class="text-secondary">(IDR)</span></label>
                                        <input value="{{ old('amount') }}" type="number" class="form-control text-right" name="amount" id="inputAmount" placeholder="120000">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="inputDescription">Description <span class="text-secondary">(Optional)</span></label>
                                        <textarea name="description" id="inputDescription" rows="3" placeholder="Doctor fee . . ." class="form-control">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-lg-8 col-12">
                                    <div class="form-group" id="image-group">
                                        <label for="exampleInputFile">Receipt</label>
                                        <div class="row" id="image-0">
                                            <div class="col-10">
                                                <div class="input-group">
                                                  <div class="custom-file">
                                                    <input type="file" name="images[]" accept="image/*" onchange="changeImage(event, 0)" class="custom-file-input" id="input-image-0">
                                                    <label id="image-label-0" class="custom-file-label" for="exampleInputFile">Choose file</label>
                                                  </div>
                                                </div>
                                            </div>
                                            <div class="col-2">
                                                <button id="add-receipt" class="btn btn-success"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="btn btn-info" type="submit">Submit</button>
                          </form>
                        </div>
                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Main Content --}}
    

@endsection

@section('js')
    <script>
        let index = 1;

        $('#add-receipt').click((e) => {
            e.preventDefault();
            $('#image-group').append(
                `<div class="row mt-2" id="image-${index}">
                    <div class="col-10">
                        <div class="input-group">
                            <div class="custom-file">
                            <input type="file" name="images[]" accept="image/*" class="custom-file-input" onchange="changeImage(event,${index})" id="input-image-${index}">
                            <label id="image-label-${index}" class="custom-file-label" for="exampleInputFile">Choose file</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-2">
                        <button onClick="deleteRow(${index})" class="btn btn-danger"><i class="fas fa-trash"></i></button>
                    </div>
                </div>`
            );
            index++;
        });

        const deleteRow = (key) => $('#image-'+key).remove();

        const changeImage = (event, key) => {
            $('#image-label-'+key).text(event.target.files[0].name);
        }
    </script>
@endsection