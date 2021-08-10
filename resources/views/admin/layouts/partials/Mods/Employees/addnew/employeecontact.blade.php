{{-- Employee Contact Information Section --}}

{{-- Phone & Email --}}
<div id="add_employee_step_3" style="display: none;">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Phone:<i class="bi bi-asterisk text-danger"
                        style="font-size: 8px;vertical-align: top;"></i></label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="bi bi-telephone-inbound"></i></div>
                    </div>
                    <input type="phone" name="phone" id="phone" class="form-control" placeholder="800-996-9009"
                        aria-describedby="helpId" value="">
                </div>
            </div>

        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="">Secondary Phone:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text"><i class="bi bi-telephone-inbound"></i></div>
                    </div>
                    <input type="phone" name="sec_phone" id="sec_phone" class="form-control" placeholder="800-996-9009"
                        aria-describedby="helpId" value="">
                </div>
            </div>

        </div>

    </div>
    <div class="row">

        <div class="col-md-12">
            <div class="form-group">
                <label for="">Secondary Email:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">@</div>
                    </div>
                    <input type="email" name="sec_email" id="sec_email" class="form-control required"
                        placeholder="yourside@yourdomain.com" aria-describedby="helpId" value="">
                </div>
            </div>
        </div>
    </div>
</div>
