@extends('admin.templates.default')
@section('content')
<h1>INSTANSI</h1>
 <!-- /.box-header -->
 <div class="box">
        <div class="box-header">
              <h3 class="box-title">DATA INSTANSI</h3><br><br>
              <a class="btn btn-success" href="javascript:void(0)" id="createNewInstansi">Tambah Data</a>
         </div>
         <div class="box-body table-responsive">
            <table id="dataTable" class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center">
                            <th style="text-align: center">ID</th>
                            <th style="text-align: center">NAMA INSTANSI</th>
                            <th style="text-align: center">DESKRIPSI</th>
                            <th style="text-align: center" width="180px">ACTION</th>
                        </tr>
                    </thead>
                    {{-- <tbody>
                    </tbody> --}}
            </table>
        </div>
</div>

{{-- create ajax --}}
<div class="modal fade" id="ajaxModel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modelHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="instansiForm" name="instansiForm" class="form-horizontal">
                   <input type="hidden" name="instansi_id" id="instansi_id">
                   <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">NAMA INSTANSI</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" 
                            placeholder="Enter Nama instansi" value="" maxlength="50" required>
                        </div>
                    </div>               
                    <div class="form-group">
                        <label class="col-sm-2 control-label">DESKRIPSI</label>
                        <div class="col-sm-12">
                            <textarea id="deskripsi" name="deskripsi" required
                            placeholder="Enter Keterangan" class="form-control">
                        </textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            <button type="submit" class="btn btn-primary" id="saveBtn" value="create">Simpan</button>
                            <button type="button" class="btn btn-info" data-dismiss="modal">
								<i class="fa fa-times"></i> Closee
							</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
        
{{-- editajax  --}}
<div class="modal fade" id="ajaxModelEdit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="modHeading"></h4>
            </div>
            <div class="modal-body">
                <form id="updateinstansiForm" name="instansiForm" class="form-horizontal">
                   <input type="hidden" name="instansi_id" id="instansi_id">
                   <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">Nama Instansi</label>
                        <div class="col-sm-12">
                            <input type="text" class="form-control" id="instansi" name="nama_instansi" 
                            placeholder="Enter Nama instansi" value="" maxlength="50" required>
                        </div>
                    </div>               
                    <div class="form-group">
                        <label class="col-sm-2 control-label">DESKRIPSI</label>
                        <div class="col-sm-12">
                            <textarea id="deskripsi-edit" name="deskripsi" required 
                            placeholder="Enter deskripsi" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-4 col-sm-8">
                            {{ method_field('PUT') }}
                            <input type="hidden" name="id" value="" id="instansi_id_edit">
                            <button type="submit" class="btn btn-primary"value="create">Update</button>
                            <button type="button" class="btn btn-info" data-dismiss="modal">
								<i class="fa fa-times"></i> Closee
							</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">
@endpush

@push('scripts')
    <script src="{{ asset('assets/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/plugins/bs.notify.min.js')}}"></script>

    @include('admin.templates.partials.alerts')
    <!-- //jquery -->
    
    <script type="text/javascript">
        $(function ()
        {

                $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
                    });
                        // Index
                        var table = $('#dataTable').DataTable({
                            "pageLength": 10,
                            processing: true,
                            serverSide: true,
                            ajax: '{{ route('admin.instansi.index') }}',
                            columns: [
                                { data: 'DT_RowIndex', orderable: false, searchable : false}, 
                                // {data: 'provinsi_id', name: 'provinsi_id'},
                                {data: 'nama_instansi', name: 'nama_instansi'},
                                {data: 'deskripsi', name: 'deskripsi'},
                                {data: 'action', name: 'action', orderable: false, searchable: false},
                            ]
                        }); 

                        // create 
                        $('#createNewInstansi').click(function () {
                            $('#saveBtn').val("create-instansi");
                            $('#instansi_id').val('');
                            $('#instansiForm').trigger("reset");
                            $('#modelHeading').html("Tambah Data Instansi");
                            $('#ajaxModel').modal('show');
                        });

                        //create
                        $('#saveBtn').click(function (e) {
                            e.preventDefault();
                            $(this).html('Save');
                                $.ajax({
                                    data: $('#instansiForm').serialize(),
                                    url: "{{ route('admin.instansi.store') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    success: function (data) {
                                        $('#instansiForm').trigger("reset");
                                        $('#ajaxModel').modal('hide');
                                        table.draw();
                                    },
                                    error: function (data) {
                                        console.log('Error:', data);
                                        $('#saveBtn').html('Save Changes');
                                    }
                                });
                        });

                        // edit
                        $('body').on('click', '.edit', function () {
                            $('#instansi').val($(this).data('title'));
                            $('#deskripsi-edit').val($(this).data('deskripsi'));
                            $('#instansi_id_edit').val($(this).data('id'));
                            $('#modHeading').html("Edit Data instansi");
                            $('#ajaxModelEdit').modal('show');
                            return false;
                        });
                        
                        //updateprovinsiForm
                        $('#updateinstansiForm').submit(function (e) {
                            e.preventDefault();
                            //$(this).html('Save');
                                $.ajax({
                                    data: $('#updateinstansiForm').serialize(),
                                    url: "{{ route('admin.instansi.update') }}",
                                    type: "POST",
                                    dataType: 'json',
                                    success: function (data) {
                                        $('#ajaxModelEdit').modal('hide');
                                       
                                        table.draw();
                                    },
                                    error: function (data) {
                                        console.log('Error:', data);
                                        $('#updateinstansiForm').html('Save Changes');
                                    }
                                });
                        });

                       //delete
                        $('body').on('click', '.deleteInstansi', function () {
                            var instansi_id = $(this).data("instansi_id");
                            $confirm = confirm("Yakin data anda ingin di hapus !!!");
                            if($confirm == true ){
                                $.ajax({
                                    type: "DELETE",
                                    url: "{{ route('admin.instansi.destroy') }}",
                                    data: {id:instansi_id,_method:'delete'},
                                    function (data) {
                                       
                                        $('#dataTable').DataTable().fnDestroy();
                                        datatable();
                                    },
                                    error: function (data) {
                                        console.log('Error:', data);
                                    }

                                });
                                table.draw();
                            }
                        });
        }); 
    </script>
@endpush





