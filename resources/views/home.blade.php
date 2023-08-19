@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Indexed DB') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h2>Employee Registration</h2>
                    <form id="employeeForm">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name *</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email *</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="telephone_number" class="form-label">Telephone Number *</label>
                            <input type="tel" class="form-control" id="telephone_number" name="telephone_number" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                    <br>
                    <h2>Employees</h2>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Telephone Number</th>
                            </tr>
                        </thead>
                        <tbody id="dataBody">
                            <!-- Data rows will be added here dynamically -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            var db = new Dexie("phpSpotTest4");
            db.version(1).stores({
                employees: "++id,name,email,telephone_number"
            });
            
            db.employees.orderBy('id').reverse().toArray()
            .then(results => {
                console.log("All records:", results);

                const dataBody = document.getElementById("dataBody");

                results.forEach(item => {
                    const row = document.createElement("tr");
                    row.innerHTML = `
                        <td>${item.name}</td>
                        <td>${item.email}</td>
                        <td>${item.telephone_number}</td>
                    `;
                    dataBody.appendChild(row);
                });
            })
        });

        $("#employeeForm").submit(function(event) {
            // Prevent the default form submission behavior
            event.preventDefault();
            const form = document.getElementById("employeeForm");
            const name = form.querySelector("#name").value;
            const email = form.querySelector("#email").value;
            const telephoneNumber = form.querySelector("#telephone_number").value;

            var db = new Dexie("phpSpotTest4");

            db.version(1).stores({
                employees: "++id,name,email,telephone_number"
            });

            //
            // Manipulate and Query Database
            //
            db.employees.add({name: name, email: email,telephone_number:telephoneNumber})
            .then(function() {
                alert("Employee is added successfully.");
                location.reload();
            }).catch(function (e) {
                alert ("Error: " + (e.stack || e));
            });
        });
    </script>
@endsection
