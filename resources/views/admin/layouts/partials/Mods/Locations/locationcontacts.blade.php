<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Phone:<i class="bi bi-asterisk text-danger" style="font-size: 8px;vertical-align: top;"></i></label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="bi bi-telephone-inbound"></i></div>
                </div>
                <input type="phone" name="phone" id="phone_{{ $location->id }}" class="form-control"
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
                <input type="email" name="email" id="email_{{ $location->id }}"
                    class="form-control required" placeholder="yourside@yourdomain.com"
                    aria-describedby="helpId" value="">
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group">
            <label for="">Fax:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="bi bi-printer"></i></div>
                </div>
                <input type="text" name="fax" id="fax_{{ $location->id }}" class="form-control"
                    placeholder="fax#" aria-describedby="helpId"
                    value="">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label for="">Maps URL:</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <div class="input-group-text"><i class="bi bi-pin"></i></div>
                </div>
                <input type="text" name="maps" id="maps_{{ $location->id }}" class="form-control"
                    placeholder="google maps url" aria-describedby="helpId"
                    value="">
            </div>
        </div>
    </div>
</div>