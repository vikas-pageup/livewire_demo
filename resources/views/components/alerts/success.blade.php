@if (session()->has('success'))
    <div class="alert alert-success alert-dismissible shadow-lg p-3">
      <i class="fa-regular fa-thumbs-up"></i>
        <button type="button" class="btn-close text-bold" data-bs-dismiss="alert"></button>
        <span class="ml-1 me-4">{{ session()->get('success') }}</span>
      </div>
@endif
