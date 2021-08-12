<div class="card" style="margin-top: 20px !important">
    <ul class="list-group list-group-flush">

        @if (is_countable($employees) && count($employees) > 0)
            @foreach ($employees as $employee)
                {{-- Loop through the array and show the employee list here --}}
                <li class="list-group-item list-group-item-action">
                    <table class="table table-borderless">
                        <tbody>
                            <tr>
                                <td scope="row">{{ $employee->id }}</td>
                                <td>{{ $employee->fname }}</td>
                                <td>{{ $employee->lname }}</td>
                                <td>{{ $employee->dob }}</td>
                                @foreach ($employee->employee_contacts as $employee_contacts)
                                    <td>{{ $employee_contacts->email }}</td>
                                    <td>{{ $employee_contacts->phone1 }}</td>
                                @endforeach

                            </tr>
                        </tbody>
                    </table>
                </li>
            @endforeach

        @else
            <li class="list-group-item list-group-item-action">
                <p>You have not added any employee information here. </p>
            </li>
        @endif





    </ul>
</div>
