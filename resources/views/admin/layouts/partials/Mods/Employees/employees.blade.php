{{-- This is the main placeholder for the employees management section 07/30/2021 --}}
<div class="card-header">{{ $mod_name }}</div>
<div class="card-body">
    <!--Add New Employee Section-->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modelId">
        Add New Employee
    </button>
    <!--list the employees below with pagination-->
    @include('admin.layouts.partials.Mods.Employees.edit.showcurrentemployees')
</div>

<!--Use modals outside the card div-->
<!--This is the add new employee modal-->
@include('admin.layouts.partials.Mods.Employees.addnew.addnewemployeemodal')
<!--End of add new employee modal-->


<script>
    $(document).ready(function() {
        $('#modelId').on('show.bs.modal', event => {
            var button = $(event.relatedTarget);
            var modal = $(this);

        });
        $('#modelId').on('hide.bs.modal', function(e) {

        });
    });
</script>

<div class="position-fixed bottom-0 right-0 p-3" style="z-index: 9999999; right: 0; bottom: 0;" id="bottom_toast">
</div>
<!--Ajax Script section employeesajax.js-->
<script src="{{ asset('js/employeesajax.js') }}" defer></script>
