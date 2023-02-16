<x-modal id='add'>
    <form wire:submit.prevent="storeProduct">
        <div class="form-group mb-3">
            <label for="title">Title:</label>
            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                placeholder="Enter Title" wire:model="title">
            @error('title')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group mb-3">
            <label for="image">Upload Image:</label>
            <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                wire:model="image">
            <div wire:loading wire:target="image">
                <div class="spinner-border text-primary mt-2" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror
            <h6 class="mt-2"> Image Preview:</h6>
            @if ($image)
                <img src="{{ $image->temporaryUrl() }}" class="w-full" height="50px">
            @endif
        </div>
        <div class="form-group mb-3">
            <label for="description">Description:</label>
            <textarea class="form-control @error('description') is-invalid @enderror" rows="5" id="description"
                wire:model="description" placeholder="Enter Description"></textarea>
            @error('description')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="d-inline-block float-end">
            <button type="submit" class="btn btn-success rounded-pill btn-block">Save</button>
            <button type="button" wire:click="closeModal" class="btn btn-secondary rounded-pill"
                data-bs-dismiss="modal">Cancel</button>
        </div>
    </form>

</x-modal>
