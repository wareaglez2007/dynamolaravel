{{-- Employee address section --}}

<div class="row">
    <div class="col-md-6">
        <div class="form-group">
          <label for="">Address 1:<i class="bi bi-asterisk text-danger"
            style="font-size: 8px;vertical-align: top;"></i></label>
          <input type="text" name="add1" id="add1" class="form-control" placeholder="" aria-describedby="helpId">
          <small id="helpId" class="text-muted">Street Address</small>
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
          <label for="">Address 2:</label>
          <input type="text" name="add2" id="add2" class="form-control" placeholder="" aria-describedby="helpId">
          <small id="helpId" class="text-muted">(optional)</small>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <div class="form-group">
            <label for="">City:<i class="bi bi-asterisk text-danger"
                    style="font-size: 8px;vertical-align: top;"></i></label>
            <input type="text" name="city" id="city" class="form-control" placeholder="Los Angeles"
                aria-describedby="helpId">
        </div>

    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">State:<i class="bi bi-asterisk text-danger"
                    style="font-size: 8px;vertical-align: top;"></i></label>

            <select class="form-control" name="state" id="state">
                @foreach ($states as $state)
                    <option value="{{ $state->state }}">{{ $state->state_name }}</option>
                @endforeach
            </select>

        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <label for="">Zip/Postal Code:<i class="bi bi-asterisk text-danger"
                    style="font-size: 8px;vertical-align: top;"></i></label>
            <input type="text" name="postal" id="postal" class="form-control" placeholder="91234"
                aria-describedby="helpId">
        </div>
    </div>
</div>