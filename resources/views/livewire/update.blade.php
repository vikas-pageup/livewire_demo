<x-modal id='update'>
        <form wire:submit.prevent="updateProduct() "  wire:loading.class="text-success">
            <div class="form-group mb-3">
                <label for="title">Title:</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" placeholder="Enter Title" wire:model="title">
                @error('title')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="description">Description:</label>
                <textarea class="form-control @error('description') is-invalid @enderror" rows="5" id="description" wire:model="description" placeholder="Enter Description"></textarea>
                @error('description')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group mb-3">
                <label for="image">Change Image:</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image"
                    wire:model="image" >
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
                    <img src="{{ $image->temporaryUrl() }}" class="w-full" height="100px">
                @else
                   @if ($path)
                   <img src="{{str_contains($path, 'http')?$path:asset('storage/'.$path)}}" alt="" class="w-full" height="100px">
                   @endif     
                @endif
            </div>
            <div class="d-inline-block float-end">
                <button type="submit" class="btn btn-success  rounded-pill" >Update</button>
                <button type="button" wire:click="closeModal" class="btn btn-secondary  rounded-pill" data-bs-dismiss="modal">Cancel</button>
            </div>
        </form>
</x-modal>