<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" />

<style>
/* ===============================
   FULLCALENDAR v3 – MODERN UI
   LMS MIHU (Red–Yellow Theme)
================================ */

/* Container */
#full_calendar_events {
    background: #ffffff;
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 15px 35px rgba(220, 38, 38, 0.08);
}

/* Header */
.fc-toolbar {
    margin-bottom: 20px;
}

.fc-center h2 {
    font-size: 1.6rem;
    font-weight: 700;
    color: #111827;
}

/* Buttons */
.fc button {
    background: #ffffff;
    border: 1px solid #fde68a;
    color: #9a3412;
    border-radius: 12px;
    padding: 6px 16px;
    font-weight: 500;
    transition: all 0.25s ease;
}

.fc button:hover,
.fc-state-active {
    background: linear-gradient(135deg, #dc2626, #f59e0b);
    color: #ffffff;
    box-shadow: 0 6px 15px rgba(220, 38, 38, 0.35);
}

/* Calendar Grid */
.fc-view-container {
    border-radius: 14px;
    overflow: hidden;
    border: 1px solid #fee2e2;
}

/* Day header */
.fc th {
    background: #fff7ed;
    color: #9a3412;
    font-weight: 600;
    padding: 10px 0;
    border: none;
}

/* Day cells */
.fc td {
    border-color: #f3f4f6;
}

.fc-day:hover {
    background: #fff7ed;
}

/* Today */
.fc-today {
    background: linear-gradient(
        135deg,
        rgba(220, 38, 38, 0.12),
        rgba(245, 158, 11, 0.12)
    ) !important;
    border-radius: 12px;
}

/* Date number */
.fc-day-number {
    font-weight: 600;
    color: #374151;
    padding: 6px;
}

/* Events */
.fc-event {
    border: none !important;
    border-radius: 12px;
    padding: 4px 8px;
    font-size: 0.78rem;
    font-weight: 500;
    background: linear-gradient(135deg, #dc2626, #f59e0b);
    color: #ffffff !important;
    box-shadow: 0 6px 15px rgba(220, 38, 38, 0.3);
}

/* Event hover */
.fc-event:hover {
    transform: scale(1.04);
    box-shadow: 0 10px 25px rgba(220, 38, 38, 0.45);
}

/* More link */
.fc-more {
    color: #dc2626;
    font-weight: 600;
}

/* Week / Day view */
.fc-agenda-view .fc-axis {
    color: #9ca3af;
}

.fc-agenda-slots tr {
    height: 48px;
}

/* Selection */
.fc-highlight {
    background: rgba(245, 158, 11, 0.25);
}

/* Responsive */
@media (max-width: 768px) {
    #full_calendar_events {
        padding: 14px;
    }

    .fc-toolbar {
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .fc-center h2 {
        font-size: 1.3rem;
    }
}
</style>

<div id='full_calendar_events'></div>

<div class="modal fade" id="eventModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4">

            <div class="modal-header"
                 style="background:linear-gradient(135deg,#dc2626,#f59e0b)">
                <h5 class="text-white mb-0">Detail Acara</h5>
                <button class="btn-close btn-close-white"
                        data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="modal_event_id">

                <label>Judul</label>
                <input id="modal_event_title" class="form-control mb-2">

                <label>Deskripsi</label>
                <textarea id="modal_event_description"
                          class="form-control mb-2"></textarea>

                <label>Mulai</label>
                <input id="modal_event_start" class="form-control mb-2" disabled>

                <label>Selesai</label>
                <input id="modal_event_end" class="form-control" disabled>
            </div>

            <div class="modal-footer">
                <button class="btn btn-danger" id="deleteEventBtn">Hapus</button>
                <button class="btn btn-warning" id="saveEventBtn">Simpan</button>
            </div>

        </div>
    </div>
</div>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function () {

    var SITEURL = "{{ url('/') }}";

    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });

    $('#full_calendar_events').fullCalendar({
        header: {
            left: 'prev,next',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: SITEURL + '/calendar-event',

        eventClick: function (event) {
            $('#modal_event_id').val(event.id);
            $('#modal_event_title').val(event.title);
            $('#modal_event_description').val(event.description || '');
            $('#modal_event_start').val(moment(event.start).format('DD MMM YYYY HH:mm'));
            $('#modal_event_end').val(moment(event.end).format('DD MMM YYYY HH:mm'));
            $('#eventModal').modal('show');
        }
    });

    $('#saveEventBtn').click(function () {
        $.post(SITEURL + '/calendar-crud-ajax', {
            id: $('#modal_event_id').val(),
            title: $('#modal_event_title').val(),
            description: $('#modal_event_description').val(),
            type: $('#modal_event_id').val() ? 'edit' : 'create'
        }, function () {
            $('#full_calendar_events').fullCalendar('refetchEvents');
            toastr.success('Acara disimpan');
            $('#eventModal').modal('hide');
        });
    });

    $('#deleteEventBtn').click(function () {
        $.post(SITEURL + '/calendar-crud-ajax', {
            id: $('#modal_event_id').val(),
            type: 'delete'
        }, function () {
            $('#full_calendar_events').fullCalendar('removeEvents', $('#modal_event_id').val());
            toastr.success('Acara dihapus');
            $('#eventModal').modal('hide');
        });
    });

});
</script>
