<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
#full_calendar_events {
    background: #fff;
    border-radius: 16px;
    padding: 18px;
    box-shadow: 0 12px 30px rgba(220,38,38,.15);
}
.fc-center h2 {
    font-weight: 700;
    color: #7c2d12;
}
.fc button {
    border-radius: 10px;
    border: 1px solid #fde68a;
    background: #fff;
    color: #92400e;
}
.fc button:hover,
.fc-state-active {
    background: linear-gradient(135deg,#dc2626,#f59e0b);
    color: #fff;
}
.fc-event {
    border: none !important;
    border-radius: 10px;
    background: linear-gradient(135deg,#dc2626,#f59e0b);
    color: #fff !important;
    font-weight: 600;
}
</style>

<div id="full_calendar_events"></div>

<div class="modal fade" id="createEventModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-warning text-dark">
        <h5 class="modal-title">Tambah Event</h5>
        <button class="btn-close" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="create_event_start">
        <input type="hidden" id="create_event_end">

        <div class="mb-3">
          <label>Judul Event</label>
          <input id="create_event_title" class="form-control">
        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button id="saveCreateEventBtn" class="btn btn-warning">Simpan</button>
      </div>

    </div>
  </div>
</div>

<!-- MODAL EDIT -->
<div class="modal fade" id="editEventModal" tabindex="-1">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">

      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title">Edit Event</h5>
        <button class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>

      <div class="modal-body">
        <input type="hidden" id="edit_event_id">

        <div class="mb-3">
          <label>Judul</label>
          <input id="edit_event_title" class="form-control">
        </div>

        <div class="mb-3">
          <label>Mulai</label>
          <input id="edit_event_start" type="date" class="form-control">
        </div>

        <div class="mb-3">
          <label>Selesai</label>
          <input id="edit_event_end" type="date" class="form-control">
        </div>
      </div>

      <div class="modal-footer">
        <button id="deleteEventBtn" class="btn btn-danger">Hapus</button>
        <button id="updateEventBtn" class="btn btn-warning">Simpan</button>
      </div>

    </div>
  </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
$(document).ready(function () {

    var SITEURL = "{{ url('/') }}";

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') }
    });

    /* ================= CALENDAR INIT ================= */
    var calendar = $('#full_calendar_events').fullCalendar({
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },

        height: {{ ($editable=='true') ? 500 : 'parent' }},
        selectable: {{ $selectable }},
        editable: {{ $editable }},
        eventLimit: true,
        events: SITEURL + '/calendar-event',

        displayEventTime: false,

        /* ========== CREATE ========== */
        select: function (start) {

            $('#create_event_title').val('');
            $('#create_event_start').val(moment(start).format('YYYY-MM-DD'));

            $('#createEventModal').modal('show');
            calendar.fullCalendar('unselect');
        },

        /* ========== EDIT ========== */
        eventClick: function (event) {

            $('#edit_event_id').val(event.id);
            $('#edit_event_title').val(event.title);

            $('#edit_event_start').val(
                moment(event.start).format('YYYY-MM-DD')
            );

            $('#edit_event_end').val(
                event.end
                    ? moment(event.end).subtract(1,'days').format('YYYY-MM-DD')
                    : moment(event.start).format('YYYY-MM-DD')
            );

            $('#editEventModal').modal('show');
        }
    });

    /* ================= CREATE SAVE ================= */
    $('#saveCreateEventBtn').on('click', function () {

    let title = $('#create_event_title').val();
    let start = $('#create_event_start').val();

    if (!title) {
        alert('Judul wajib diisi');
        return;
    }

    $('#createEventModal').modal('hide');

    $.post(SITEURL + '/calendar-crud-ajax', {
        title: title,
        start: start,
        end: moment(start).add(1,'days').format('YYYY-MM-DD'),
        allDay: true,
        type: 'create'
    }, function () {

        calendar.fullCalendar('removeEventSources');
        calendar.fullCalendar('addEventSource', SITEURL + '/calendar-event');

        toastr.success('Event ditambahkan');
    });
});


    /* ================= UPDATE ================= */
    $('#updateEventBtn').on('click', function () {

    let start = $('#edit_event_start').val();
    let end   = $('#edit_event_end').val() || start;

    $('#editEventModal').modal('hide');

    $.post(SITEURL + '/calendar-crud-ajax', {
        id: $('#edit_event_id').val(),
        title: $('#edit_event_title').val(),
        start: start,
        end: moment(end).add(1,'days').format('YYYY-MM-DD'),
        allDay: true,
        type: 'edit'
    }, function () {

        calendar.fullCalendar('removeEventSources');
        calendar.fullCalendar('addEventSource', SITEURL + '/calendar-event');

        toastr.success('Event diperbarui');
    });
});


    /* ================= DELETE ================= */
    $('#deleteEventBtn').on('click', function () {

    if (!confirm('Hapus event ini?')) return;

    $('#editEventModal').modal('hide');

    $.post(SITEURL + '/calendar-crud-ajax', {
        id: $('#edit_event_id').val(),
        type: 'delete'
    }, function () {

        calendar.fullCalendar('removeEventSources');
        calendar.fullCalendar('addEventSource', SITEURL + '/calendar-event');

        toastr.success('Event dihapus');
    });
});

});
</script>



