<!-- admin.blade.php -->

@extends('header')

@section('content')
<div class="container mt-5 text-center">
    <div class="mb-5">
        <h2>Admin Page - URL List</h2>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($url->isEmpty())
        <p>No URLs found.</p>
    @else
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Original URL</th>
                        <th>Shortened URL</th>
                        <th>Code</th>
                        <th>Created At</th>
                        <th>Created By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($url as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td style="word-break: break-all;">{{ $item->url }}</td>
                            <td><a href="{{ url('/short-url/' . $item->code ) }}" target="_blank">{{ url('/short-url/' . $item->code) }}</a></td>
                            <td>
                                <form action="{{ route('short-url-update', ['id' => $item->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="text" name="code" value="{{ $item->code }}" class="form-control form-control-sm" required>
                                    <button type="submit" class="btn btn-success btn-sm mt-1">Update</button>
                                </form>
                            </td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->userCreate->name }}</td>
                            <td>
                                <form action="{{ route('short-url-delete', ['id' => $item->id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this URL?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif

</div>

@endsection
