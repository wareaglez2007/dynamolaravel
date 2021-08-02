{{-- This is the main placeholder for the employees management section 07/30/2021 --}}
<div class="card-header">{{ $mod_name }}</div>
<div class="card-body">
    <!--Add New Employee Section-->
    <!-- Button trigger modal -->
    <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#modelId">
        Add New Employee
    </button>
    <!--list the employees below with pagination-->

</div>

<!--Use modals outside the card div-->



<!-- Modal -->
<div class="modal fade" id="modelId" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Employee Basic Information</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <!--Make Sections Here-->
                    <!--Basic Information form setion-->
                    @include('admin.layouts.partials.Mods.Employees.employeebasics')
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save</button>
            </div>
        </div>
    </div>
</div>

<script>
    $('#exampleModal').on('show.bs.modal', event => {
        var button = $(event.relatedTarget);
        var modal = $(this);
        // Use above variables to manipulate the DOM

    });
</script>


<!--Ajax Script section employeesajax.js-->
<script src="{{ asset('js/locationajax.js') }}" defer></script>
