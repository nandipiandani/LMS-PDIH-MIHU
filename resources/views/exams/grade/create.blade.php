@extends('layouts.app')

@section('content')
<div class="row">
    @include('layouts.left-menu')

    <main class="col-lg-10 col-md-9 ms-sm-auto px-4 pt-3">
        <h1 class="display-6 mb-3">
                    <h1 class="display-6 mb-3"><i class="bi bi-file-plus"></i> Buat Sistem Penilaian</h1>
                    @include('session-messages')
                    <div class="row">
                        <div class="col-md-5 mb-4">
                            <div class="p-3 border shadow-sm bg-light">
                                <form action="{{route('exam.grade.system.store')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                                    <div>
                                        <p class="mt-2">Pilih kelas:<sup><i class="bi bi-asterisk text-primary"></i></sup></p>
                                        <select class="form-select" name="class_id" required>
                                            @isset($school_classes)
                                                @foreach ($school_classes as $school_class)
                                                <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                    <div>
                                        <p class="mt-2">Pilih semester:<sup><i class="bi bi-asterisk text-primary"></i></sup></p>
                                        <select class="form-select" aria-label=".form-select-sm" name="semester_id" required>
                                            @isset($semesters)
                                                @foreach ($semesters as $semester)
                                                <option value="{{$semester->id}}" {{($semester->id === request()->query('semester_id'))?'selected':''}}>{{$semester->semester_name}}</option>
                                                @endforeach
                                            @endisset
                                        </select>
                                    </div>
                                    <div class="mt-2">
                                        <p>Nama Sistem Penilaian<sup><i class="bi bi-asterisk text-primary"></i></sup></p>
                                        <input type="text" class="form-control" placeholder="Sistem Penilaian 1" aria-label="Sistem Penilaian 1" name="system_name" required>
                                    </div>
                                    <button type="submit" class="mt-3 btn btn-sm btn-outline-primary"><i class="bi bi-check2"></i> Buat</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
@endsection
