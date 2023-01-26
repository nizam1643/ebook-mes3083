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

<div class="col-lg-12">
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
</div>
<div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Update Profile Form</h5>
      </div>
      <div class="card-body">
            <form action="{{ route('author.updateForm') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                <label for="phone_number">Phone Number *</label> 
                <input id="phone_number" name="phone_number" type="text" class="form-control" required="required" value="{{ $profile->phone_number }}">
                @error('phone_number')
                    <span id="phone_numberHelpBlock" class="form-text text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="form-group">
                <label for="address">Address *</label> 
                <textarea id="address" name="address" cols="40" rows="5" class="form-control" required="required">{{ $profile->address }}</textarea>
                @error('address')
                    <span id="addressHelpBlock" class="form-text text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="form-group">
                <label for="income_id">Household Income *</label> 
                <div>
                    <select id="income_id" name="income_id" class="custom-select" aria-describedby="income_idHelpBlock" required="required" value="{{ $profile->householdIncome->name }}}">
                    <option value="">Select...</option>
                    @forelse ($incomes as $income)
                        <option value="{{ $income->id }}" {{ $income->id == $profile->income_id ? 'selected' : '' }}>{{ $income->name }}</option>
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
                <input id="subsidy_number" name="subsidy_number" type="text" class="form-control" value="{{ $profile->subsidy_number }}">
                @error('subsidy_number')
                    <span id="subsidy_numberHelpBlock" class="form-text text-danger">{{ $message }}</span>
                @enderror
                </div> 
                <div class="form-group">
                <button name="submit" type="submit" class="btn btn-success float-right">Update</button>
                </div>
            </form>
      </div>
    </div>
</div>

<div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h5 class="m-0">Update Account Form</h5>
      </div>
      <div class="card-body">
            <form action="{{ route('author.updateUser') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                <label for="name">Fullname *</label> 
                <input id="name" name="name" type="text" class="form-control" required="required" value="{{ $user->name }}">
                @error('name')
                    <span id="nameHelpBlock" class="form-text text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="form-group">
                <label for="email">Email *</label> 
                <input id="email" name="email" type="email" class="form-control" required="required" value="{{ $user->email }}" readonly>
                @error('email')
                    <span id="emailHelpBlock" class="form-text text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="form-group">
                <label for="phone_number">Password</label> 
                <input id="password" name="password" type="password" class="form-control">
                @error('password')
                    <span id="passwordHelpBlock" class="form-text text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="form-group">
                <label for="passwordconfirmation">Change Password</label> 
                <input id="password_confirmation" name="password_confirmation" type="password" class="form-control">
                @error('password_confirmation')
                    <span id="passwordconfirmationHelpBlock" class="form-text text-danger">{{ $message }}</span>
                @enderror
                </div>
                <div class="form-group">
                <button name="submit" type="submit" class="btn btn-success float-right">Update</button>
                </div>
            </form>
      </div>
    </div>
</div>
@endsection