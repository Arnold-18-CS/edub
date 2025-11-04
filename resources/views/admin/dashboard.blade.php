@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    {{-- ✅ Flash Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    {{-- ✅ Flash Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h1 class="mb-4 text-center fw-bold">Admin Dashboard</h1>

    <div class="row">
        {{-- ✅ Organizations Table --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white fw-semibold">
                    Registered Organizations
                </div>
                <div class="card-body">
                    @if($organizations->isEmpty())
                        <p class="text-muted text-center">No organizations found.</p>
                    @else
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($organizations as $index => $org)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $org->name }}</td>
                                        <td>{{ $org->email }}</td>
                                        <td>
                                            @if($org->verified)
                                                <span class="badge bg-success">Verified</span>
                                            @else
                                                <span class="badge bg-warning text-dark">Pending</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            @if(!$org->verified)
                                                {{-- Verify --}}
                                                <form action="{{ route('admin.verifyOrg', $org->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success">
                                                        <i class="bi bi-check-circle"></i> Verify
                                                    </button>
                                                </form>
                                            @else
                                                {{-- Revoke --}}
                                                <form action="{{ route('admin.revokeOrg', $org->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-danger">
                                                        <i class="bi bi-x-circle"></i> Revoke
                                                    </button>
                                                </form>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>

        {{-- ✅ Youth Table --}}
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-secondary text-white fw-semibold">
                    Registered Youth
                </div>
                <div class="card-body">
                    @if($youth->isEmpty())
                        <p class="text-muted text-center">No youth registered yet.</p>
                    @else
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($youth as $index => $user)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $user->name }}</td>
                                        <td>{{ $user->email }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Optional: Quick Refresh Button --}}
    <div class="text-center mt-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-primary">
            Refresh Dashboard
        </a>
    </div>
</div>
@endsection
