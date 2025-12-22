@extends('layouts.app')

@section('content')
<div class="row">
    @include('layouts.left-menu')

    <main class="col-lg-10 col-md-9 ms-sm-auto px-4 pt-3">
        <h1 class="display-6 mb-3">
                    <h1 class="display-6 mb-3"><i class="bi bi-megaphone"></i> Buat Pemberitahuan</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Buat Pemberitahuan</li>
                        </ol>
                    </nav>
                    @include('session-messages')
                    <div class="row">
                        <form action="{{route('notice.store')}}" method="POST">
                            @csrf
                            <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                            @include('components.ckeditor.editor', ['name' => 'notice'])
                            <button type="submit" class="btn btn-outline-primary"><i class="bi bi-check2"></i> Simpan</button>
                        </form>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection