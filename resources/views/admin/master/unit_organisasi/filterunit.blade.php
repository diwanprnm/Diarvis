 
<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}">

<link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/data-table/extensions/responsive/css/responsive.dataTables.css') }}">
  

<style>
    table.table-bordered tbody td {
        word-break: break-word;
        vertical-align: top;
    }
</style>
 
                  <table id="dttable" class="table table-striped table-bordered able-responsive">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Provinsi</th>
                                <th>Kota Kabupaten</th>
                                <th>Bidang</th>
                                <th>Kode Unit</th>
                                <th>Nama Unit</th>
                                <!-- <th>Foto</th> -->
                                <th style="min-width: 100px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="bodyJembatan">

                        </tbody>
                    </table>  
  
<script src="{{ asset('assets/vendor/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/vendor/datatables.net/js/dataTables.bootstrap4.min.js') }}"></script>

<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('assets/vendor/data-table/extensions/responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/vendor/jquery/js/jquery.mask.js') }}"></script>
<script type="text/javascript" src="{{ asset('assets/vendor/chosen_v1.8.7/chosen.jquery.js') }}" type="text/javascript"></script>

<script>
    $(document).ready(function() {

        $(".chosen-select").chosen({
            width: '100%'
        });

        $("#filterForm").submit(function(e) {
            $("#resultFilter").empty();
             var form = $(this);
            var actionUrl = form.attr('action');

            $.ajax({
                type: "POST",
                url: actionUrl,
                data: form.serialize(), // serializes the form's elements.
                success: function(data)
                {
                    
                    $("#resultFilter").html(data);
               

                }
            });
            e.preventDefault();
           
        });




        var table = $('#dttable').DataTable({
            processing: true,
            serverSide: true,
            bFilter: false,
            ajax: { 
                url: "{{ url('admin/master-data/unit-organisasi/unit/json') }}",
                data: {
                    "bidang" : "{{  !empty($filter['bidang']) ? $filter['bidang'] : ""  }}",
                "nama_unit" : "{{  !empty($filter['nama_unit']) ? $filter['nama_unit']  : "" }}",
                "kode_unit" : "{{  !empty($filter['kode_unit']) ? $filter['kode_unit']  : "" }}"
                }
            },
           
            columns: [{
                    'mRender': function(data, type, full, meta) {
                        return +meta.row + meta.settings._iDisplayStart + 1;
                    }
                },
                {
                    data: 'nama_provinsi',
                    name: 'nama_provinsi'
                },
                {
                    data: 'nama_kab_kota',
                    name: 'nama_kab_kota'
                },
                {
                    data: 'nama_bidang',
                    name: 'nama_bidang'
                },
                {
                    data: 'kode_unit',
                    name: 'kode_unit'
                },
                {
                    data: 'nama_unit',
                    name: 'nama_unit'
                },

                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    });


    @if(hasAccess(Auth::user()->role_id, "Unit", "Update"))  

    $('#editModal').on('show.bs.modal', function(event) {
        const link = $(event.relatedTarget);
        const id = link.data('id');
        console.log(id);
        const baseUrl = `{{ url('admin/master-data/unit-organisasi/unit/getUnitById/') }}` + '/' + id;
        $.get(baseUrl,
            function(response) {
                const data = response.data;
                showData(data);
            });
    });

    function showData(data) {

        $(".chosen-select").val(data.kode_bidang).trigger('chosen:updated');
        $("#edit_kode_unit").val(data.kode_unit);
        $("#edit_nama_unit").val(data.nama_unit);
        $("#unit_id").val(data.id);
    }

    @endif

    @if(hasAccess(Auth::user()->role_id, "Unit", "Delete"))
    $('#delModal').on('show.bs.modal', function(event) {
        const link = $(event.relatedTarget);
        const id = link.data('id');
        console.log(id);
        const url = `{{ url('admin/master-data/unit-organisasi/unit/delete') }}/` + id;
        console.log(url);
        const modal = $(this);
        modal.find('.modal-footer #delHref').attr('href', url);
    });
    @endif
</script>
 