<div class="modal fade {{ $class ?? '' }}" id="{{ $id }}" tabindex="-1">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Event</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <x-form.body class="eventModal">
        <x-form.text-field type="hidden" name="event_id" id="event_id"/>
          <x-form.text-field name="title" required />
          <x-form.submit id="saveEventBtn" />
        </x-form.body>
      </div>
    </div>
  </div>
</div>