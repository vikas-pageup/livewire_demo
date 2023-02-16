<!-- Modal -->
@props(['id'])
<div wire:ignore.self class="modal fade rounded" id="{{$id}}" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true" >
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="ModalLabel">Add/Update</h5>
          <button type="button" class="btn-close" wire:click="closeModal" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          {{$slot}}
        </div>
      </div>
    </div>
  </div>