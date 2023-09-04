<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Laravel 10 Ajax DataTables CRUD (Create Read Update and Delete) - Cairocoders</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js"></script>
    <link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
</head>

<body>
    <header>

    </header>
    <main>
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="pull-left">
                    <h2> <span style="color: #f71e0d">Laravel</span> 10 Ajax DataTables CRUD (Create Read Update and
                        Delete) </h2>
                </div>
                <div class="pull-right mb-2">
                    <a class="btn btn-success" onClick="add()" href="javascript:void(0)"> Create Employee</a>
                </div>
            </div>
        </div>
        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif
        <div class="table-responsive-sm">
            <table class="table table-striped-columns table-hover table-borderless  table-primary  align-middle" id="ajax-crud-datatable">
                <thead class="table-light">

                    <tr>
                        <th>Id </th>
                        <th>Name</th>
                        <th>Email </th>
                        <th>Address</th>
                        <th>Created at</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <tr class="table-primary">
                        <td scope="row">Item</td>
                        <td>Item</td>
                        <td>Item</td>
                        <td>Item</td>
                        <td>Item</td>
                        <td>Item</td>
                    </tr>

                </tbody>

            </table>
        </div>
        <div class="modal fade" id="employee-modal" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="javascript:void(0)" id="EmployeeForm" name="EmployeeForm" class="form-horizontal"
                            method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" id="id">
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Name</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="name" name="name"
                                        placeholder="Enter Name" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-sm-2 control-label">Email</label>
                                <div class="col-sm-12">
                                    <input type="email" class="form-control" id="email" name="email"
                                        placeholder="Enter Email" maxlength="50" required="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-2 control-label">Address</label>
                                <div class="col-sm-12">
                                    <input type="text" class="form-control" id="address" name="address"
                                        placeholder="Enter Address" required="">
                                </div>
                            </div>
                            <div class="col-sm-offset-2 col-sm-10"><br />
                                <button type="submit" class="btn btn-primary" id="btn-save">Save changes</button>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer"></div>
                </div>
            </div>
        </div>


    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"
        integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous">
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.min.js"
        integrity="sha384-7VPbUDkoPSGFnVtYi0QogXtr74QeVeeIs99Qfg5YCF+TidwNdjvaKZX19NZ/e6oz" crossorigin="anonymous">
    </script>

    <script type="text/javascript">
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('Meta[name="csrf-token"]').attr('content')
                }
            })

        });
        $('#ajax-crud-datatable').DataTable({
            processing:true,
            serverSide : true ,
            ajax: "{{ url('ajax-crud-datatable')}}",
            columns:[
                {data: 'id' , name: 'id'},
                {data: 'name' , name: 'name'},
                {data: 'email' , name: 'email'},
                {data: 'address' , name: 'address'},
                {data: 'created_at' , name: 'created_at'},
                {data: 'action' , name: 'action',orderable: false},

            ],
            order:[[0,'desc']]


        });
    
    
  

function deleteFunc(id){
    if (confirm("Delete Record?") == true) {
        var id=id;
        $,ajax({
            type:"POST",
            url: "{{url('delete')}}",
            data: {id: id},
            dataType:'json',
            success: function(res){
                var oTable=$('#ajax-crud-datatable').dataTable();
                oTable.fnDraw(false);
            }
        })

}
}

    


        function add() {
            $('#employee-modal').modal('show');
            $('#employeeform').modal("reset");
            $('#employeemodal').modal("Add Employee ");
            $('#id').val('');

        }

        function editFunc(id){
            $.ajax({
                type:"POST",
                url : "{{url('edit')}}",
                data : {id :id},
                datatype: 'json',
                success: function(res){
                    console.log(res);
                    $('#employeeModal').html("Edit Employee");
                    $('#employee-modal').modal('show');
                    $('#id').val(res.id);
                    $('#name').val(res.name);
                    $('#address').val(res.address);
                    $('#email').val(res.email); 
                }

            });

        }

        $('#EmployeeForm').submit(function(e) {
            e.preventDefault();
            var formData = new FormData(this);
            $.ajax({
                type: 'POST',
                url: "{{ url('store') }}",
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: (data) => {
                    $('#employee-modal').modal('hide');
                    var oTable = $('#ajax-crud-datatable').dataTable();
                    oTable.fnDraw(false);
                    $('#btn-save').html('submit');
                    $('#btn-save').attr('disabled', false);
                    console.log(data)
                },
                error: function(data) {
                    console.log(data);
                }
            });
        });
    </script>
</body>

</html>
