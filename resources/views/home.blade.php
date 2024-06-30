<!-- short-url.blade.php -->

@extends('header')

@section('content')
<div class="container mt-5 text-center">
    <div class="mb-5">
        <h2>Short URL</h2>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('url_path'))
        <div class="alert alert-info">
            Shortened URL:
            <div class="input-group mb-3">
                <input id="shortened-url" type="text" class="form-control" value="{{ session('url_path') }}" readonly>
                <button class="btn btn-outline-secondary" type="button" onclick="copyUrl()">Copy</button>
            </div>
        </div>
    @endif

    <form method="POST" action="{{ route('short-url') }}">
        @csrf
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <label for="url" class="col-md-4 col-form-label text-md-right">{{ __('URL') }}</label>
                            <div class="col-md-8">
                                <input id="url" type="text" class="form-control @error('url') is-invalid @enderror" name="url" value="{{ old('url') }}" required autocomplete="url" autofocus>
                                @error('url')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-12">
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Shorten URL') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </form>

</div>

<script>
    function copyUrl() {
        var copyText = document.getElementById("shortened-url");
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        alert("Copied the URL: " + copyText.value);
    }
</script>

@endsection
