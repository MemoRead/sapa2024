<!-- Modal -->
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        
        <h5 class="modal-title" id="uploadModalLabel">Upload Users Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      
      <div class="modal-body">
        <form action="{{ route('admin.users.upload') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="mb-3">
            <label for="file" class="form-label">Choose CSV File</label>
            <input class="form-control" type="file" id="file" name="file" required>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Upload</button>
          </div>

        </form>
      </div>
      
    </div>
  </div>
</div>

<!-- Modal Students -->
<div class="modal fade" id="uploadModalStudent" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
  
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        
        <h5 class="modal-title" id="uploadModalLabel">Upload Students Data</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

      </div>
      
      <div class="modal-body">
        <form action="{{ route('admin.student.upload') }}" method="POST" enctype="multipart/form-data">
          @csrf
          
          <div class="mb-3">
            <label for="file" class="form-label">Choose CSV File</label>
            <input class="form-control" type="file" id="file" name="file" required>
          </div>
          
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Upload</button>
          </div>

        </form>
      </div>
      
    </div>
  </div>
</div>
