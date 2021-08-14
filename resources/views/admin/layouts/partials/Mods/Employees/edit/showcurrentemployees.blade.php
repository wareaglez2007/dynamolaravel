<div class="col-md-12" style="margin-top: 20px !important">

    @if (is_countable($employees) && count($employees) > 0)
        <table class="table table-striped table-inverse table-hover">
            <thead class="thead-inverse">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>DOB</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td scope="row">{{ $employee->id }}</td>
                        <td>{{ $employee->fname }} {{ $employee->mname }} {{ $employee->lname }}</td>
                        <td>{{ $employee->dob }}</td>
                        @foreach ($employee->employee_contacts as $employee_contacts)
                            <td>{{ $employee_contacts->email }}</td>
                            <td>{{ $employee_contacts->phone1 }}</td>

                        @endforeach
                        <td>
                            <div class="dropdown show">
                                <a class="btn btn-sm dropdown-toggle" href="#" role="button"
                                    id="dropdownMenuLink{{ $employee->id }}" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false">
                                    <i class="bi bi-list"></i>

                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $employee->id }}">
                                    <a class="dropdown-item" href="#" onclick="DeleteEmployee({{ $employee->id }});"><i class="bi bi-trash"></i> Delete</a>
                                    <a class="dropdown-item" href="{{ route('admin.employee.edit', ['id' => $employee->id]) }}"><i class="bi bi-pencil"></i> Edit</a>
                                </div>
                            </div>


                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @else

        <p>You have not added any employee information here. </p>

    @endif
</div>
