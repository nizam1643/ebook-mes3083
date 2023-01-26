@extends('layouts.template')

@section('style')

@endsection

@section('script')
    
@endsection

@section('header')
<div class="row mb-2">
    <div class="col-sm-6">
      <h1 class="m-0">Author Dashboard</h1>
    </div><!-- /.col -->
    <div class="col-sm-6">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        <li class="breadcrumb-item active">Author Dashboard</li>
      </ol>
    </div><!-- /.col -->
</div>
@endsection

@section('content')
<!-- /.col-md-6 -->
<div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">New Profile Form</h5>
      </div>
      <div class="card-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <form action="{{ route('author.storeForm') }}" method="POST">
                @csrf
                <div class="form-group">
                <label for="phone_number">Phone Number *</label> 
                <input id="phone_number" name="phone_number" type="text" class="form-control" required="required" value="{{ old('phone_number') }}">
                @error('phone_number')
                    <span id="phone_numberHelpBlock" class="form-text text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="form-group">
                <label for="address">Address *</label> 
                <textarea id="address" name="address" cols="40" rows="5" class="form-control" required="required">{{ old('address') }}</textarea>
                @error('address')
                    <span id="addressHelpBlock" class="form-text text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="form-group">
                <label for="income_id">Household Income *</label> 
                <div>
                    <select id="income_id" name="income_id" class="custom-select" aria-describedby="income_idHelpBlock" required="required" value="{{ old('income_id') }}">
                    <option value="">Select...</option>
                    @forelse ($incomes as $income)
                        <option value="{{ $income->id }}" {{ $income->id == old('income_id') ? 'selected' : '' }}>{{ $income->name }}</option>
                    @empty
                        
                    @endforelse
                    </select> 
                    @error('income_id')
                        <span id="income_idHelpBlock" class="form-text text-danger">{{ $message }}</span>
                    @enderror
                </div>
                </div>
                <div class="form-group">
                <label for="subsidy_number">Subsidy Number</label> 
                <input id="subsidy_number" name="subsidy_number" type="text" class="form-control" value="{{ old('subsidy_number') }}">
                @error('subsidy_number')
                    <span id="subsidy_numberHelpBlock" class="form-text text-danger">{{ $message }}</span>
                @enderror
                </div> 
                <div class="form-group">
                <button name="submit" type="submit" class="btn btn-primary float-right">Submit</button>
                </div>
            </form>
      </div>
    </div>
</div>
<!-- /.col-md-6 -->
@endsection