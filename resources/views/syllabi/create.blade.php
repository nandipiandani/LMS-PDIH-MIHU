@extends('layouts.app')

@section('content')
<div class="row">
    @include('layouts.left-menu')

    <main class="col-lg-10 col-md-9 ms-sm-auto px-4 pt-3">
        <h1 class="display-6 mb-3">
                    <h1 class="display-6 mb-3"><i class="bi bi-journal-text"></i> Buat Silabus</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">Beranda</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Buat Silabus</li>
                        </ol>
                    </nav>
                    @include('session-messages')
                    <div class="p-3 border bg-light shadow-sm">
                        <form action="{{route('syllabus.store')}}" method="POST"  enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="session_id" value="{{$current_school_session_id}}">
                            <div class="mb-3">
                                <p>Tambahkan Silabus ke kelas:</p>
                                <select onchange="getCourses(this);" class="form-select" name="class_id" required>
                                    @isset($school_classes)
                                        <option selected disabled>Pilih kelas</option>
                                        @foreach ($school_classes as $school_class)
                                        <option value="{{$school_class->id}}">{{$school_class->class_name}}</option>
                                        @endforeach
                                    @endisset
                                </select>
                            </div>
                            <div class="mb-3">
                                <p class="mb-2">Pilih mata kuliah:<sup><i class="bi bi-asterisk text-primary"></i></sup></p>
                                <select class="form-select" id="course-select" name="course_id">
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="syllabus-name" class="form-label">Nama Silabus</label>
                                <input type="text" class="form-control" id="syllabus-name" name="syllabus_name" placeholder="Nama Silabus" required>
                            </div>
                            <div class="form-group mb-3">
                                <label for="syllabus-file" class="form-label">File Silabus</label>
                                <input type="file" name="file" class="form-control" id="syllabus-file" accept=".jpg,.jpeg,.bmp,.png,.gif,.doc,.docx,.csv,.rtf,.xlsx,.xls,.txt,.pdf,.zip" required>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-outline-primary"><i class="bi bi-check2"></i> Buat</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            @include('layouts.footer')
        </div>
    </div>
</div>
<script>
    function getCourses(obj) {
        var class_id = obj.options[obj.selectedIndex].value;

        var url = "{{route('get.sections.courses.by.classId')}}?class_id=" + class_id 

        fetch(url)
        .then((resp) => resp.json())
        .then(function(data) {

            var courseSelect = document.getElementById('course-select');
            courseSelect.options.length = 0;
            data.courses.unshift({'id': 0,'course_name': 'Silakan pilih mata kuliah'})
            data.courses.forEach(function(course, key) {
                courseSelect[key] = new Option(course.course_name, course.id);
            });
        })
        .catch(function(error) {
            console.log(error);
        });
    }
</script>
@endsection