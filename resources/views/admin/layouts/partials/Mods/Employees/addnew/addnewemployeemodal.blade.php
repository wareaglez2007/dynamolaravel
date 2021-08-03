<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="add_employee_mt">{{ $modal_title }}</h5>

                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!--Modal body starts-->
            <div class="modal-body">
                <div class="container-fluid">

                    <div class="progress" style="height: 10px; margin-bottom:20px;">
                        <div class="progress-bar bg-primary" role="progressbar" style="width: 25%;" aria-valuenow="25"
                            aria-valuemin="0" aria-valuemax="100" id="new_employee_progress_bar"></div>
                    </div>
                    <!--Make Sections Here-->
                    <form method="POST" name="add_employee_form" id="add_employee_form">
                        @csrf
                        <div id="add_new_employee_modal_body">
                            {{-- Basic Information form setion --}}
                            @include('admin.layouts.partials.Mods.Employees.addnew.employeebasics')
                        </div>
                    </form>

                </div>
            </div>
            <!--Modal body ends-->
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"
                    id="cancel_add">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="AddEmployeePrevSteps(1)"
                    style="display: none;" id="go_back">
                    <i class="bi bi-arrow-left-square"
                        style="vertical-align: text-bottom !important;"></i>&nbsp;Back</button>
                <button type="button" class="btn btn-primary" onclick="AddEmployeeNextSteps(2)"
                    id="go_forward">Next Step <i class="bi bi-arrow-right-square"
                    style="vertical-align: text-bottom !important;"></i>&nbsp;</button>
            </div>
        </div>
    </div>
</div>
