@extends('layouts.master')
@section('sidebar')

@parent
@stop

@section('content')

<!--  Modal component creation and editing notes,events,tasks  -->
<x-modal.info-modal id="infoModal"/>

<!--  Calendar related to furtue_log -->
<div id='calendar'></div>

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
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($info[0]['notes'] as $value)
        <tr id="noteItem{{$value['id']}}">
          <td>{{ $value['title'] }}</td>
          <td>{!! $value['description'] !!}</td>
          <td>
            <button type="button" class="btn btn-info futurelogInfoEditModal" data-note-info="{{$value['id']}},{{$value['title']}},{{$value['description']}}" data-bs-toggle="modal" data-bs-target="#infoModal">ویرایش</button>
            <button type="button" class="btn btn-danger futurelogNoteDelete"  data-note-id="{{ $value['id'] }}">حذف</button>
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
              <button type="button" class="btn btn-info futurelogInfoEditModal" data-info="{{$value['id']}},{{$value['title']}},{{$value['start']}},{{$value['end']}}" data-bs-toggle="modal" data-bs-target="#infoModal">ویرایش</button>
              <button type="button" class="btn btn-danger futurelogInfoDelete"  data-event-id="{{ $value['id'] }}">حذف</button>
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
          <th>Action</th>
          <th>Description</th>
        </tr>
      </thead>
      <tbody>
        @foreach($info[0]['tasks'] as $value)
        <tr id="taskItem{{$value['id']}}">
          <td>{{ $value['title'] }}</td>
          <td>{!! $value['description'] !!}</td>
          <td>
            <button type="button" class="btn btn-info futurelogInfoEditModal" data-task-info="{{$value['id']}},{{$value['title']}},{{$value['description']}}" data-bs-toggle="modal" data-bs-target="#infoModal">ویرایش</button>
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

  // Creating info in Modal
  $(document).ready(function() {
    $('.futurelog-event-create-modal').click(function(){
      $("#infoModal .nav-link").removeClass('disabled');
      createCKEditor('#description1',null);//clear ckeditor
      createCKEditor('#description2',null);//clear ckeditor
    });

    //Clear form info in modal
    $('#infoModal').on('hidden.bs.modal', function (e) {
      $(this)
      .find("input,textarea,select")
      .val('')
      .end()
      .find("input[type=checkbox], input[type=radio]")
      .prop("checked", "")
      .end();
      $('#infoModal .nav-link').removeClass('active');
      $('#infoModal .tab-pane').removeClass('active');
    })
  });


  // function fetchInfo()
  // {
    // $.ajax({
    //   type:'GET',
    //   url:'{{route("future_log")}}',
    //   dataType:'JSON',
      // success:function(data){
        // var jsonObj=JSON.parse(JSON.stringify(data.info[0]['events']));
        // var myJsVar = parseInt(document.querySelector("meta[name=myJsVar]").content);
        // document.cookie = "myJavascriptVar = "+ jsonObj ;
        // alert(jsonObj[0].title);
      // }
    // });
    // var x = {!!json_encode($info[0]['events'])!!};
    // alert(x[5]['title']);
  // }

  //
  document.addEventListener('DOMContentLoaded', function() {
    var selectedDate = $(".datetimepicker").pDatepicker({
      format: "YYYY-MM-DD",
    });

    // Getting events from the server
    var data={!!json_encode($data->toArray())!!};

    var calendarEl = document.getElementById('calendar');

    // Calendar to display events
    var calendar = new FullCalendar.Calendar(calendarEl, {
      initialView: 'dayGridMonth',
      locale: 'fa',
      direction: 'rtl',
      firstDay: 6,
      editable: true,
      height: 'auto',
      handleWindowResize: true,
      events: data,
    });
    calendar.render();
  });


  const editors=[];

  function createCKEditor(elementId,val) {
    if (editors[elementId]) { 
      editors[elementId].destroy();
    }
    // if(!editors[elementId]){
      return ClassicEditor
            .create(document.querySelector(elementId) )
            .then((editor) => {
              editors[elementId] = editor;
              if(val==null)
              editors[elementId].setData('');
              else
              editors[elementId].setData(val);
            })
            .catch( error => {
              console.error( error );
             }); 
    // } 
  }
  
  
  //Changing the information of notes , tasks and enents in the modal
  $(document).on('click', '.futurelogInfoEditModal', function(e){
    $('.default-form-class').trigger("reset");
    if($(this).data('info')){
      var modal_data = $(this).data('info').split(',');
      $("#event #event_id").val(modal_data[0]);
      $("#event #title").val(modal_data[1]);
      convertToShamsi(modal_data[2]).done(function(data){
        $('#event #start').val(data.covertMiladiToShansi);
      });
      convertToShamsi(modal_data[3]).done(function(data){
        $('#event #end').val(data.covertMiladiToShansi);
      });
      activaTab('#event');
      return false;
    }
    if($(this).data('note-info')){
      var modalData = $(this).data('note-info').split(',');
      $('#note #note_id').val(modalData[0]);
      $('#note #title').val(modalData[1]);
      $('#note #description1').val(createCKEditor('#description1',modalData[2]));
      activaTab('#note');
      return false;
    }
    if($(this).data('task-info')){
      var modalData = $(this).data('task-info').split(',');
      $('#task #task_id').val(modalData[0]);
      $('#task #title').val(modalData[1]);
      $('#task #description2').val(createCKEditor('#description2',modalData[2]));
      activaTab('#task');
      return false;
    }
  });

  // Activate tab while editing
  function activaTab(tab){
    $("#infoModal .nav-link").addClass('disabled');
    $('#infoModal .nav-tabs button[data-bs-target="'+tab+'"]').tab("show");
    $("#infoModal .nav-link").filter('.active').removeClass('disabled');
    return false;
	}; 

  // conert miladi to shamsi
  function convertToShamsi(date){
      return $.ajax({
      type:'POST',
      data:{date:date},
      url: '{{route("convert_to_shamsi")}}',
      dataType: 'JSON',
      success:function(data){}
    });
  };

$(document).ready(function() {
  var eventDataTable = $('.events-datatable').DataTable();
  var noteDataTable = $('.notes-datatable').DataTable();
  var taskDataTable = $('.tasks-datatable').DataTable();

  //Delete an event
  $(document).on('click', '.futurelogInfoDelete', function(e){
    var eventId = $(this).data("eventId");
    e.preventDefault();
    $.ajax({
      url:'events/'+eventId,
      type: 'DELETE',
      data: eventId,
      success:function (){
        eventDataTable.row('#item'+eventId).remove().draw();
      }
    });
  });
  
  //Edit an event using Async/Await to convert the date and update the eventDataTable
  let collection_id= "{{$info[0]['id']}}";
  
  $(document).on('click', '#saveBtn', function(e){
    var formData = $('.test').serializeArray();
    formData.push({ name: "col_id", value: collection_id });
    e.preventDefault();
    $.ajax({
      url: "{{ route('events.store') }}",
      type: 'POST',
      data: formData,
      dataType: 'json',
      success: eventDataTableUpdate
    });
    async function eventDataTableUpdate(data) {
      let startFromServer = await convertToShamsi(data.events.start);
      let endFromServer = await convertToShamsi(data.events.end);
      var start = startFromServer.covertMiladiToShansi;
      var end = endFromServer.covertMiladiToShansi;
      const arr = [
        data.events.title,
        start,
        end,
        '<button type="button" class="btn btn-info futurelogInfoEditModal" data-info="'+data.events.id+','+data.events.title+','+data.events.start+','+data.events.end+'" data-bs-toggle="modal" data-bs-target="#infoModal">ویرایش</button><span> </span><button type="button" class="btn btn-danger futurelogInfoDelete"  data-event-id="'+data.events.id+'">حذف</button>'
      ];
      if(eventDataTable.row('#item'+data.events.id).id()){
        eventDataTable.row('#item'+data.events.id).data(arr).draw();       
      }
      else{
        eventDataTable.row.add(arr).draw();  
        var rowEvent = eventDataTable.row(':last-child').node();
        $(rowEvent).attr('id','item'+data.events.id);

      }
      $('.default-form-class').trigger("reset");
      $('#infoModal').modal('hide');              
    }
  });  

  //Delete an note
  $(document).on('click', '.futurelogNoteDelete', function(e){
    var noteId = $(this).data("noteId");
    e.preventDefault();
    $.ajax({
      url:'notes/'+noteId,
      type: 'DELETE',
      data: noteId,
      success:function(){
        noteDataTable.row("#noteItem"+noteId).remove().draw();
      },
      error: function(status)
      {
          console.log(status);
      }
    });
  });

  //Create|Edit an note using Async/Await to update the noteDataTable
  $(document).on('click', '#saveNode', function(e){
    var formNode = $('.formNode').serializeArray();
    console.log(formNode);
    //get data of ck editor and change
    var ck__description = editors['#description1'].getData();
    console.log(ck__description);
    $.each(formNode, function(key, data)
    {
      if (this.name == "description") 
        this.value=ck__description;
    });
    //Push field inside serializeArray
    formNode.push({name:"collection_id",value:collection_id});
    console.log(formNode[4].value);
    e.preventDefault();
    //create|edit an note
    $.ajax({
      url:"{{ route('notes.store') }}",
      type: 'POST',
      data:formNode,
      dataType:'json',
      success:noteDataTableUpdate
    });
    async function noteDataTableUpdate(data){
      createCKEditor('#description1',data.note.description)
      const note = [
        data.note.title,
        editors['#description1'].getData(),
        '<button type="button" class="btn btn-info futurelogInfoEditModal" data-note-info="'+data.note.id+','+data.note.title+','+editors['#description1'].getData()+'" data-bs-toggle="modal" data-bs-target="#infoModal">ویرایش</button><span> </span><button type="button" class="btn btn-danger futurelogNoteDelete" data-note-id="'+data.note.id+'" >حذف</button>'
      ];                                                                                      
                                                                                                            
      if(noteDataTable.row('#noteItem'+data.note.id).id()){
        noteDataTable.row('#noteItem'+data.note.id).data(note).draw();       
      }
      else{
        noteDataTable.row.add(note).draw(); 
        var rowNode = noteDataTable.row(':last-child').node();
        $(rowNode).attr('id','noteItem'+data.note.id);

      $('.default-form-class').trigger("reset");
      $('#infoModal').modal('hide'); 
    }   

  });

  //Delete an task
  $(document).on('click','.futurelogTaskDelete',function(e){
    var taskId = $(this).data("taskId");
    e.preventDefault();
    $.ajax({
      url:'tasks/'+taskId,
      type:'DELETE',
      data:taskId,
      success:function(){
        taskDataTable.row("#taskItem"+taskId).remove().draw();
      },
      error: function(status)
      {
        console.log(status);
      }
    });
  });

  //Create|Edit an task using Async/Await to update the taskDataTable
  $(document).on('click','#saveTask',function(e){
  var formTask = $('.formTask').serializeArray();
  console.log(formTask);
  //get data of ck editor and change
  var ck_task = editors['#description2'].getData();
  // console.log(ck_task);
  $.each(formTask, function(key,data){
    if(this.name == "description")
      this.value = ck_task; 
  });
  formTask.push({name:"collection_id",value:collection_id});
  // console.log(formTask[4].value);
  e.preventDefault();
  //create|edit a task
    $.ajax({
      url:"{{route('tasks.store')}}",
      type:'POST',
      data:formTask,
      dataType:'json',
      success:taskDataTableUpadate
    });
    async function taskDataTableUpadate(data){
      createCKEditor('#description2',data.task.description);
      const task = [
        data.task.title,
        editors['#description2'].getData(),
        '<button type="button" class="btn btn-info futurelogInfoEditModal" data-task-info="'+data.task.id+','+data.task.title+','+editors['#description2'].getData()+'" data-bs-toggle="modal" data-bs-target="#infoModal">ویرایش</button><span> <span/><button type="button" class="btn btn-danger futurelogTaskDelete" data-task-id="'+data.task.id+'">حذف</button>'
      ];

      if(taskDataTable.row('#taskItem'+data.task.id).id()){
        taskDataTable.row('#taskItem'+data.task.id).data(task).draw(false);
      } 
      else{
            taskDataTable.row.add(task).draw();
            var rowNodTask = taskDataTable.row(':last-child').node();
            $(rowNodTask).attr('id','taskItem'+data.task.id);
      }  
      $('.default-form-class').trigger('reset');
      $('#infoModal').modal('hide');
    }
  });
});   
</script>
@endpush