<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />



    <div class="container mt-5">
        <div class="row">
          <div class="col-md-4">
            
            <h5 class="modal-title" id="profileModalLabel">Profile information</h5>

            <div class="text-center">
              <img src="path-to-image" alt="Profile Photo" class="rounded mb-3" style="width: 150px; height: 150px;">
              <div>
                <button class="btn btn-sm btn-primary me-2">Update</button>
                <button class="btn btn-sm btn-danger">Remove</button>
              </div>
            </div>
          </div>
          <div class="col-md-8">
            <form>
              <div class="mb-3">
                <label for="name" class="form-label">Name*</label>
                <input type="text" class="form-control" id="name" aria-describedby="nameHelp" maxlength="50" value="Aini">
                <div id="nameHelp" class="form-text">Appears on your Profile page, as your byline, and in your responses.</div>
              </div>
              <div class="mb-3">
                <label for="bio" class="form-label">Bio</label>
                <textarea class="form-control" id="bio" rows="3" maxlength="160"></textarea>
                <div class="form-text">Appears on your Profile and next to your stories.</div>
              </div>
              <div class="d-flex justify-content-end">
                <button type="button" class="btn btn-secondary me-2">Cancel</button>
                <button type="submit" class="btn btn-primary">Save</button>
              </div>
            </form>
          </div>
        </div>
      </div>
      
      