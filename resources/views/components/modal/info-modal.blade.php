<div class="modal fade {{ $class ?? '' }}" tabindex="-1" id="{{ $id }}"  role="dialog" aria-hidden="true" aria-labelledby="{{ $id }}-Label">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <h5 class="modal-title" id="infoModalLabel">اطلاعات</h5>
      </div>
      <div id="tabs" class="modal-body">


        <ul class="nav nav-tabs mb-3" id="myTab" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="note-tab" data-bs-toggle="tab" data-bs-target="#note" type="button" role="tab">یادداشت</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="event-tab" data-bs-toggle="tab" data-bs-target="#event" type="button" role="tab">رویداد</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link" id="task-tab" data-bs-toggle="tab" data-bs-target="#task" type="button" role="tab">تسک</button>
          </li>
        </ul>
       
        <div class="tab-content" id="myTabContent">
          <div class="tab-pane fade" id="note" role="tabpanel" aria-labelledby="note-tab">
            <x-form.body class="formNode">
              <x-form.text-field type="hidden" name="note_id" id="note_id"/>
              <x-form.text-field name="title" required/>
              <x-form.textarea name="description" class="form-control w-100 description" id="description1" rows="4" cols="52" required/>
              <x-form.text-field  data-jdp data-jdp-only-date name="log_date" id="note_log_date" class="datetimepicker" required>
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </x-form.text-field>
              <x-form.submit id="saveNode"/>
            </x-form.body> 
          </div>
          <div class="tab-pane fade" id="event" role="tabpanel" aria-labelledby="event-tab">
            <x-form.body class="test">
              <x-form.text-field type="hidden" name="event_id" id="event_id"/>
              <x-form.text-field name="title" required />
              <x-form.text-field   data-jdp data-jdp-only-date name="start" class="datetimepicker" required>
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </x-form.text-field>
              <x-form.text-field   data-jdp data-jdp-only-date name="end" class="datetimepicker" required>
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </x-form.text-field>
              <x-form.submit id="saveBtn"/>
            </x-form.body>
          </div>
          <div class="tab-pane fade" id="task" role="tabpanel" aria-labelledby="task-tab">
            <x-form.body class="formTask">
              <x-form.text-field type="hidden" name="task_id" id="task_id"/>
              <x-form.text-field name="title" required/>
              <x-form.textarea name="description" class="form-control w-100 description" id="description2" rows="4" cols="57" required/>
              <x-form.text-field  data-jdp data-jdp-only-date name="log_date" id="task_log_date" class="datetimepicker" required>
                <span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
                </span>
              </x-form.text-field>
              <x-form.submit id="saveTask"/>
            </x-form.body>
          </div>
        </div>
      </div>
      <!-- <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div> -->
    </div>
  </div>
</div>

