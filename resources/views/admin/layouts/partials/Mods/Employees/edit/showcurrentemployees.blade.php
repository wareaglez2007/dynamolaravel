<div class="col-md-12" style="margin-top: 20px !important">

    @if (is_countable($employees) && count($employees) > 0)
        <table class="table table-striped table-inverse table-hover">
            <thead class="thead-inverse">
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Middle</th>
                    <th>Last</th>
                    <th>Dob</th>
                    <th>Email</th>
                    <th>Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $employee)
                    <tr>
                        <td scope="row">{{ $employee->id }}</td>
                        <td>{{ $employee->fname }}</td>
                        <td>{{ $employee->mname }}</td>
                        <td>{{ $employee->lname }}</td>
                        <td>{{ $employee->dob }}</td>
                        @foreach ($employee->employee_contacts as $employee_contacts)
                            <td>{{ $employee_contacts->email }}</td>
                            <td>{{ $employee_contacts->phone1 }}</td>
                        @endforeach
                    </tr>
                @endforeach

            </tbody>
        </table>
    @else

        <p>You have not added any employee information here. </p>

    @endif
</div>
