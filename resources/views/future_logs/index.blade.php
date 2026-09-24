@extends('layouts.master')
@section('sidebar')

@parent
@stop

@section('content')

<!--  Modal component creation and editing notes,events,tasks  -->
<x-modal.info-modal id="infoModal" />

<!--  Calendar related to furtue_log -->
<div id="calendar"></div>

<!-- Using the modal component to create and edit notes and events and tasks  -->
<button type="button" class="btn btn-primary futurelog-event-create-modal" data-bs-toggle="modal" data-bs-target="#infoModal">بنویس</button>

<!-- <div>
  <input id="collectionId" type="hidden" value="{{$info[0]['id']}}"/>
</div> -->

<!-- Tabs containing datatables grouped by tasks and notes and events  -->
<ul class="nav nav-tabs" id="datatableTab" role="tablist">
  <li>
    <button class="nav-link active" id="note-datatable-tab" data-bs-toggle="tab" data-bs-target="#note-datatable" type="button" role="tab" aria-controls="note-datatable" aria-selected="false">یادداشت ها</button>
  </li>
  <li>
    <button class="nav-link" id="event-datatable-tab" data-bs-toggle="tab" data-bs-target="#event-datatable" type="button" role="tab" aria-controls="event-datatable" aria-selected="false">رویداد ها</button>
  </li>
  <li>
    <button class="nav-link" id="task-datatable-tab" data-bs-toggle="tab" data-bs-target="#task-datatable" type="button" role="tab" aria-controls="task-datatable" aria-selected="false">تسک ها</button>
  </li>
</ul>

<div class="tab-content" id=datatableTabContent>
  <div class="tab-pane fade show active" id="note-datatable" role="tabpanel" aria-labelledby="note-datatable-tab">
    @if($info[0]['notes']->isNotEmpty())
    <table class="table table-bordered notes-datatable">
      <thead>
        <tr>
          <th>Title</th>
          <th>Description</th>
          <th>log_date</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($info[0]['notes'] as $value)
        <tr id="noteItem{{$value['id']}}">
          <td>{{ $value['title'] }}</td>
          <td>{!! $value['description'] !!}</td>
          <td>{{ Carbon\Carbon::shamsi($value['log_date']) }}</td>
          <td>
            <button type="button" class="btn btn-info futurelogInfoEditModal" data-note-info="{{ urlencode(json_encode(['id' => $value['id'],'title' => $value['title'],'description' => $value['description'],'log_date' => $value['log_date'],])) }}" data-bs-toggle="modal" data-bs-target="#infoModal">ویرایش</button>
            <button type="button" class="btn btn-danger futurelogNoteDelete" data-note-id="{{ $value['id'] }}">حذف</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>

  <div class="tab-pane fade" id="event-datatable" role="tabpanel" aria-labelledby="event-datatable-tab">

    @php
    $eventObj = $info[0]['events'];
    @endphp

    @if($eventObj)
    <table class="table table-bordered events-datatable">
      <thead>
        <tr>
          <th>Title</th>
          <th>Start</th>
          <th>End</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($eventObj as $value)
        <tr id="item{{$value['id']}}">
          <td>{{ $value['title'] }}</td>
          <td>{{ Carbon\Carbon::shamsi($value['start']) }}</td>
          <td>{{ Carbon\Carbon::shamsi($value['end']) }}</td>
          <td>
            <button
                type="button"
                class="btn btn-info futurelogInfoEditModal"
                data-event-info="{{ urlencode(json_encode([
                    'id' => $value['id'],
                    'title' => $value['title'],
                    'start' => $value['start'],
                    'end' => $value['end'],
                ])) }}"
                data-bs-toggle="modal"
                data-bs-target="#infoModal">
                ویرایش
            </button>
            <button type="button" class="btn btn-danger futurelogInfoDelete" data-event-id="{{ $value['id'] }}">حذف</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>

  <div class="tab-pane fade" id="task-datatable" role="tabpanel" aria-labelledby="task-datatable-tab">
      @if($info[0]['tasks']->isNotEmpty())
      <table class="table table-bordered tasks-datatable">
        <thead>
          <tr>
            <th>Title</th>
            <th>Description</th>
            <th>log_date</th>
            <th>Action</th>
          </tr>
      </thead>
      <tbody>
        @foreach($info[0]['tasks'] as $value)
        <tr id="taskItem{{$value['id']}}">
          <td>{{ $value['title'] }}</td>
          <td>{!! $value['description'] !!}</td>
          <td>{{ Carbon\Carbon::shamsi($value['log_date']) }}</td>
          <td>
            <button type="button" class="btn btn-info futurelogInfoEditModal" data-task-info="{{urlencode(json_encode(['id' => $value['id'],'title' => $value['title'],'description' => $value['description'],'log_date' => $value['log_date'],])) }}" data-bs-toggle="modal" data-bs-target="#infoModal">ویرایش</button>
            <button type="button" class="btn btn-danger futurelogTaskDelete" data-task-id="{{ $value['id'] }}">حذف</button>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
    @endif
  </div>
</div>
@stop

@push('scripts')
<script src="https://unpkg.com/jalali-moment/dist/jalali-moment.browser.js"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/jalaali-js/dist/jalaali.js"></script> -->
<!-- <script src="https://cdn.jsdelivr.net/npm/jalaali-js/dist/jalaali.min.js"></script> -->
<script type="text/javascript">
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(document).ready(function() {

    let collection_id = "{{$info[0]['id']}}";

    initJalaliDatePicker();

    createCKEditor('#description1');
    createCKEditor('#description2');

    $('#infoModal').on('hidden.bs.modal', function () {
      resetInfoModal();
    });
    
    // Getting events from the server
    var data = @json($data); // safe and proper JSON

    var calendarEl = document.getElementById("calendar");
    // Calendar to display events
    window.calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'fa',
      direction: 'rtl',
      firstDay: 6,
      editable: true,
      height: 'auto',
      handleWindowResize: true,
      selectable: true,
      events: data,
      select: function(info) {
        // پاک کردن مقادیر قبلی
        $('#event #start').val('');
        $('#event #end').val('');

        // گرفتن تاریخ شروع و پایان از FullCalendar (میلادی)
        let startDate = info.startStr;
        let endDate = info.endStr;

        // تبدیل به شمسی و ست کردن داخل inputهای مدال
        convertToShamsi(startDate).done(function(data) {
          $('#event #start').val(data.covertMiladiToShansi);
        });

        convertToShamsi(endDate).done(function(data) {
          $('#event #end').val(data.covertMiladiToShansi);
        });

        // باز کردن مدال
        $('#infoModal').modal('show');

        // غیر فعال کردن تب‌های دیگر و فعال کردن Event
        $('#myTab button').removeClass('disabled').attr('disabled', false);
        $('#myTab button:not(#event-tab)').addClass('disabled').attr('disabled', true);
        $('#myTabContent .tab-pane').removeClass('show active');
        $('#event').addClass('show active');
      },
      eventClick: function(info) {
        var id = info.event.id;

        if (confirm("از حذف رویداد مطمئن هستید؟")) {
          $.ajax({
            url: 'events/' + id,
            type: "DELETE",
            dataType: 'json',
            success: function(response) {
              var event = window.calendar.getEventById(id);
              if (event) event.remove();
              alert("رویداد حذف شد");
              var table = $('.events-datatable').DataTable();

              // پیدا کردن ردیف بر اساس attribute
              table.rows().every(function() {
                var $btn = $(this.node()).find('.futurelogInfoDelete');
                if ($btn.data('event-id') == id) {
                  this.remove();
                }
              });
              table.draw();
            },
            error: function(error) {}
          });
        }
      }
    });
    window.calendar.render();


    var eventDataTable = $('.events-datatable').DataTable();
    var noteDataTable = $('.notes-datatable').DataTable();            
    var taskDataTable = $('.tasks-datatable').DataTable();

    //Delete an event
    $(document).on('click', '.futurelogInfoDelete', function(e) {
      e.preventDefault();
      var eventId = $(this).data("eventId");
      deleteEvent(eventId)
      .done(function(response) {
        if (eventDataTable.row('#item' + eventId).id()) {
              eventDataTable.row('#item' + eventId).remove().draw();
        }
        if (window.calendar) {
          var event = window.calendar.getEventById(eventId);
          if (event) {
            event.remove();
          }
        }
      }).fail(function(xhr, status, error) {
          console.error("خطا در حذف رویداد:", error);
      });
    });    

    //Create|Edit an event using Async/Await to convert the date and update the eventDataTable

    $(document).on('click', '#saveBtn', function(e) {
      var formData = $('.test').serializeArray();
      formData.push({
        name: "col_id",
        value: collection_id
      });
      console.log(formData); // ببین event_id چی اومده
      e.preventDefault();
      saveEvent(formData)
      .done(eventDataTableUpdate)
      .fail(function(xhr, status, error) {
          console.error("خطا در ذخیره رویداد:", error);
      });
      async function eventDataTableUpdate(data) {
        let startFromServer = await convertToShamsi(data.events.start);
        let endFromServer = await convertToShamsi(data.events.end);
        var start = startFromServer.covertMiladiToShansi;
        var end = endFromServer.covertMiladiToShansi;
         // اطلاعات Event برای ویرایش
        const eventInfo = JSON.stringify({
            id: data.events.id,
            title: data.events.title,
            start: data.events.start,
            end: data.events.end
        });
        const arr = [
          data.events.title,
          start,
          end,
          '<button type="button" ' +
          'class="btn btn-info futurelogInfoEditModal" ' +
          'data-event-info="' +
          encodeURIComponent(eventInfo) +
          '" ' +
          'data-bs-toggle="modal" ' +
          'data-bs-target="#infoModal">' +
          'ویرایش' +
          '</button>' +

          '<span> </span>' +

          '<button type="button" ' +
          'class="btn btn-danger futurelogInfoDelete" ' +
          'data-event-id="' +
          data.events.id +
          '">' +
          'حذف' +
          '</button>'
        ];
        if (eventDataTable.row('#item' + data.events.id).any()) {
          // ویرایش
          eventDataTable.row('#item' + data.events.id).data(arr).draw(false);
        } else {
          // اضافه کردن جدید
          var rowNode = eventDataTable.row.add(arr).draw(false).node();
          $(rowNode).attr('id', 'item' + data.events.id);
        }
        $('#infoModal').modal('hide');
        if (window.calendar) {
          let event = window.calendar.getEventById(String(data.events.id));
          if (event) {
            event.setProp('title', data.events.title);
            event.setStart(data.events.start);
            event.setEnd(data.events.end);
          } else {
            window.calendar.addEvent({
              id: String(data.events.id),
              title: data.events.title,
              start: data.events.start,
              end: data.events.end
            });
          }
        }
      }
    });

    //Delete an note
    $(document).on('click', '.futurelogNoteDelete', function(e) {
      var noteId = $(this).data("noteId");
      e.preventDefault();
      deleteNote(noteId)
      .done(function(response) {
          if (noteDataTable.row('#noteItem' + noteId).id()) {
              noteDataTable.row('#noteItem' + noteId).remove().draw();
          }
      })
      .fail(function(xhr, status, error) {
          console.error("خطا در حذف یادداشت:", error);
      });
    });


    //Create|Edit an note using Async/Await to update the noteDataTable
    $(document).on('click', '#saveNode', function(e) {
      e.preventDefault();

      const formNode = $('.formNode').serializeArray();

      // ======================================
      // CKEditor
      // ======================================

      const description = getCKEditorData('#description1');

      $.each(formNode, function () {

        if (this.name === 'description') {
            this.value = description;
        }

      });

      // ======================================
      // Collection
      // ======================================

      formNode.push({
          name: "collection_id",
          value: collection_id
      });

      // ======================================
      // Save Note
      // ======================================

      saveNote(formNode)
      .done(noteDataTableUpdate)
      .fail(function(xhr, status, error) {
          console.error("خطا در ذخیره یادداشت:", error);
      });
      async function noteDataTableUpdate(data) {
        let log_date = '';
        if (data.note.log_date) {
          let log_dateFromServer = await convertToShamsi(data.note.log_date);
          log_date = log_dateFromServer.covertMiladiToShansi;
        }

        // ==================================
        // CKEditor data
        // ==================================

        const noteDescription = data.note.description || '';
        
        // ==================================
        // اطلاعات دکمه Edit
        // ==================================

        const noteInfo = JSON.stringify({
          id: data.note.id,
          title: data.note.title,
          description: noteDescription,
          log_date: data.note.log_date
        });


        // ==================================
        // DataTable row
        // ==================================

        const note = [
          data.note.title,
          noteDescription,
          log_date,
          '<button type="button" class="btn btn-info futurelogInfoEditModal" ' +
          'data-note-info="' + encodeURIComponent(noteInfo) + '" ' +
          'data-bs-toggle="modal" data-bs-target="#infoModal">ویرایش</button>' +
          '<span> </span>' +
          '<button type="button" class="btn btn-danger futurelogNoteDelete" ' +
          'data-note-id="' + data.note.id + '">حذف</button>'
        ];

       // ==================================
       // Update / Insert
       // ==================================

        if (noteDataTable.row('#noteItem' + data.note.id).any()) {
          // ویرایش
          noteDataTable.row('#noteItem' + data.note.id).data(note).draw(false);
        } else {
          // اضافه کردن جدید
          var rowNode = noteDataTable.row.add(note).draw(false).node();
          $(rowNode).attr('id', 'noteItem' + data.note.id);
        }

        // ==================================
        // Reset
        // ==================================

        $('.default-form-class').trigger("reset");
        $('#infoModal').modal('hide');
      }
    });

    //Delete an task
    $(document).on('click', '.futurelogTaskDelete', function(e) {
      var taskId = $(this).data("taskId");
      e.preventDefault();
      deleteTask(taskId)
      .done(function(response) {
          if (taskDataTable.row('#taskItem' + taskId).id()) {
              taskDataTable.row('#taskItem' + taskId).remove().draw();
          }
      })
      .fail(function(xhr, status, error) {
          console.error("خطا در حذف تسک:", error);
      });
    });

    //Create|Edit an task using Async/Await to update the taskDataTable
    $(document).on('click', '#saveTask', function(e) {
      e.preventDefault();
      var formTask = $('.formTask').serializeArray();
      //get data of ck editor and change
      const ck_task = getCKEditorData('#description2');
      $.each(formTask, function(key, data) {
      if (this.name == "description")
          this.value = ck_task;
      });
      formTask.push({
        name: "collection_id",
        value: collection_id
      });

      //create|edit a task

      saveTask(formTask)
      .done(taskDataTableUpdate)
      .fail(function(xhr, status, error) {
          console.error("خطا در ذخیره تسک:", error);
      });
      async function taskDataTableUpdate(data) {
        let log_date = '';
        if (data.task.log_date) {
            let log_dateFromServer = await convertToShamsi(data.task.log_date);
            log_date = log_dateFromServer.covertMiladiToShansi;
        }

        const taskDescription = data.task.description || '';


        const taskInfo = JSON.stringify({
          id: data.task.id,
          title: data.task.title,
          description: taskDescription,
          log_date: data.task.log_date
        });
        
        const task = [
          data.task.title,
          taskDescription,
          log_date,
          '<button type="button" class="btn btn-info futurelogInfoEditModal" ' +
          'data-task-info="' + encodeURIComponent(taskInfo) + '" ' +
          'data-bs-toggle="modal" data-bs-target="#infoModal">ویرایش</button>' +
          '<span> </span>' +
          '<button type="button" class="btn btn-danger futurelogTaskDelete" ' +
          'data-task-id="' + data.task.id + '">حذف</button>'
        ];

        if (taskDataTable.row('#taskItem' + data.task.id).any()) {
          // ویرایش
          taskDataTable.row('#taskItem' + data.task.id).data(task).draw(false);
        } else {
          // اضافه کردن جدید
          var rowNode = taskDataTable.row.add(task).draw(false).node();
          $(rowNode).attr('id', 'taskItem' + data.task.id);
        }

        $('.default-form-class').trigger('reset');
        $('#infoModal').modal('hide');
      }
    });
  });
</script>
@endpush