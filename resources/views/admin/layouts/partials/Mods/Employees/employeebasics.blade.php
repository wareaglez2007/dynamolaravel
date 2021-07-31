{{-- This template will serve as the section for employee basic informtion
    employee name, middle, last name *
    employee address *
    employee phone number *
    employee image (if the have) (optional)
    emplouee emergancy contact information *
    employee marital informatio (married, single, divorced, choose not to answer, etc.) optional
    employee gender (male, female, no answer) --}}

<!--Basic forms goes here-->
<div class="row">
    <div class="col-md-5">
        <div class="form-group">
            <label for="">Name:<i class="bi bi-asterisk text-danger"
                style="font-size: 8px;vertical-align: top;"></i></label>
            <input type="text" name="fname" id="fname" class="form-control" placeholder="" aria-describedby="helpId">
        </div>

    </div>
    <div class="col-md-2">
        <div class="form-group">
            <label for="">Middle:</label>
            <input type="text" name="mname" id="mname" class="form-control" placeholder="" aria-describedby="helpId">
        </div>

    </div>
    <div class="col-md-5">
        <div class="form-group">
            <label for="">Last Name:<i class="bi bi-asterisk text-danger"
                style="font-size: 8px;vertical-align: top;"></i></label>
            <input type="text" name="lname" id="lname" class="form-control" placeholder="" aria-describedby="helpId">
        </div>

    </div>
</div>
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
<!--Phone & Email-->
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Phone:<i class="bi bi-asterisk text-danger" style="font-size: 8px;vertical-align: top;"></i></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="bi bi-telephone-inbound"></i></div>
                </div>
                <input type="phone" name="phone" id="phone" class="form-control"
                    placeholder="800-996-9009" aria-describedby="helpId"
                    value="">
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Email:<i class="bi bi-asterisk text-danger" style="font-size: 8px;vertical-align: top;"></i></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text">@</div>
                </div>
                <input type="email" name="email" id="email"
                    class="form-control required" placeholder="yourside@yourdomain.com"
                    aria-describedby="helpId" value="">
            </div>
        </div>
    </div>
</div>