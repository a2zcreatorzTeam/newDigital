    <form action="#" method="POST">
        @csrf
        <h2 class="profile-section-title">Address Information</h2>
        <div class="box-form-login">
            <h5 class="mb-4 text-primary"><i class="fas fa-map-marker-alt"></i> Permanent Address (مستقل پتہ)</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>Province (صوبہ)</label>
                        <input type="text" class="form-control" name="p_province">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>District (ضلع)</label>
                        <input type="text" class="form-control" name="p_district">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>City (شہر)</label>
                        <input type="text" class="form-control" name="p_city">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label>Address Line (مکمل پتہ)</label>
                        <input type="text" class="form-control" name="p_address">
                    </div>
                </div>
            </div>
            <h5 class="mb-4 text-primary"><i class="fas fa-map-marker-alt"></i> Correspondence Address (رابطے کا پتہ)</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>Province (صوبہ)</label>
                        <input type="text" class="form-control" name="p_province">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>District (ضلع)</label>
                        <input type="text" class="form-control" name="p_district">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>City (شہر)</label>
                        <input type="text" class="form-control" name="p_city">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label>Address Line (مکمل پتہ)</label>
                        <input type="text" class="form-control" name="p_address">
                    </div>
                </div>
            </div>
            <h5 class="mb-4 text-primary"><i class="fas fa-map-marker-alt"></i> Temporary Address (عارضی پتہ)</h5>
            <div class="row">
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>Province (صوبہ)</label>
                        <input type="text" class="form-control" name="p_province">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>District (ضلع)</label>
                        <input type="text" class="form-control" name="p_district">
                    </div>
                </div>
                <div class="col-md-4 mb-3">
                    <div class="form-group">
                        <label>City (شہر)</label>
                        <input type="text" class="form-control" name="p_city">
                    </div>
                </div>
                <div class="col-md-12 mb-3">
                    <div class="form-group">
                        <label>Address Line (مکمل پتہ)</label>
                        <input type="text" class="form-control" name="p_address">
                    </div>
                </div>
            </div>

            <div class="update-btn-container">
                <button type="submit" class="btn-update">Update Addresses</button>
            </div>
        </div>
    </form>

  